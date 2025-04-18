<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Request as ServiceRequest;
use App\Services\PaymongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class PaymentController extends Controller
{
    protected $paymongoService;

    public function __construct(PaymongoService $paymongoService)
    {
        $this->paymongoService = $paymongoService;
    }

    /**
     * Show the payment page
     */
    public function show(ServiceRequest $request)
    {
        // Check if the request belongs to the logged-in user
        if ($request->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if payment is required
        if ($request->status !== 'payment_required') {
            return redirect()->route('requests.show', $request)
                ->with('error', 'No payment is required for this request at this time.');
        }

        $request->load(['service']);
        return view('payments.show', compact('request'));
    }

    /**
     * Initiate payment process
     */
/**
 * Initiate payment process
 */
public function process(Request $httpRequest, ServiceRequest $request)
{
    // Check if the request belongs to the logged-in user
    if ($request->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    // Validate the payment method
    $validated = $httpRequest->validate([
        'payment_method' => 'required|in:gcash,paymaya',
    ]);

    try {
        DB::beginTransaction();

        // Check if there is an existing payment for this request (pending or failed)
        $payment = Payment::where('request_id', $request->id)
            ->whereIn('status', ['pending', 'failed'])
            ->first();

        if ($payment) {
            // Update the existing payment record
            $payment->update([
                'payment_method' => $validated['payment_method'],
                'status' => 'pending', // Reset status to pending
                'payment_details' => array_merge($payment->payment_details ?? [], [
                    'updated_at' => now()->toIso8601String(),
                    'user_ip' => $httpRequest->ip(),
                    'user_agent' => $httpRequest->userAgent(),
                ])
            ]);
        } else {
            // Create a new payment record if no existing payment exists
            $payment = Payment::create([
                'request_id' => $request->id,
                'reference_number' => 'PAY-' . strtoupper(Str::random(10)),
                'amount' => $request->service->fee,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'payment_details' => [
                    'initiated_at' => now()->toIso8601String(),
                    'user_ip' => $httpRequest->ip(),
                    'user_agent' => $httpRequest->userAgent(),
                ]
            ]);
        }

        // Create a source in Paymongo for the selected payment method
        $source = $this->paymongoService->createSource(
            $validated['payment_method'],
            $request->service->fee,
            [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->mobile_number ?? ''
            ]
        );

        if (!$source) {
            throw new \Exception('Failed to create payment source.');
        }

        // Log the source creation
        Log::info('Payment source created', [
            'source_id' => $source['id'],
            'payment_id' => $payment->id,
            'method' => $validated['payment_method']
        ]);

        // Update payment with Paymongo source details
        $payment->update([
            'payment_details' => array_merge($payment->payment_details ?? [], [
                'source_id' => $source['id'],
                'source_type' => $source['attributes']['type'],
                'checkout_url' => $source['attributes']['redirect']['checkout_url'],
                'success_url' => $source['attributes']['redirect']['success'],
                'failed_url' => $source['attributes']['redirect']['failed']
            ])
        ]);

        // Store the checkout URL in session to help with recovery if callback fails
        session(['last_payment_checkout' => $source['attributes']['redirect']['checkout_url']]);
        session(['last_payment_id' => $payment->id]);

        DB::commit();

        // Redirect user to the payment provider's checkout page
        return redirect($source['attributes']['redirect']['checkout_url']);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Payment Processing Error', [
            'message' => $e->getMessage(),
            'request_id' => $request->id,
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()->with('error', 'There was an error processing your payment. Please try again later.');
    }
}

    /**
     * Handle successful payment callback
     */
/**
 * Handle successful payment callback
 */
public function success(Request $httpRequest)
{
    // Paymongo may send the ID in different ways, so we need to check multiple possibilities
    $sourceId = $httpRequest->source_id ?? $httpRequest->source ?? $httpRequest->id ?? $httpRequest->query('source_id');

    // If still no source ID, check if it's in the entire request payload
    if (!$sourceId && $httpRequest->has('data')) {
        $data = $httpRequest->input('data');
        $sourceId = is_array($data) && isset($data['id']) ? $data['id'] : null;
    }

    // Log what we're receiving for debugging
    Log::info('Payment Success Callback received', [
        'query' => $httpRequest->query(),
        'request' => $httpRequest->all(),
        'source_id_found' => $sourceId
    ]);

    if (!$sourceId) {
        // Try to find the most recent pending payment for the logged-in user
        $payment = Payment::where('status', 'pending')
            ->whereHas('request', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->first();

        if ($payment) {
            // If we found a pending payment, use its source ID from payment details
            $sourceId = $payment->payment_details['source_id'] ?? null;

            if (!$sourceId) {
                return redirect()->route('dashboard')
                    ->with('error', 'Payment verification failed. Please contact support with your transaction details.');
            }
        } else {
            return redirect()->route('dashboard')
                ->with('error', 'Invalid payment response received. Could not verify your payment.');
        }
    }

    try {
        // Retrieve the source to check payment status
        $source = $this->paymongoService->retrieveSource($sourceId);

        if (!$source) {
            throw new \Exception('Failed to retrieve payment source.');
        }

        // Find the payment by source ID
        $payment = Payment::whereJsonContains('payment_details->source_id', $sourceId)->first();

        if (!$payment) {
            throw new \Exception('Payment record not found.');
        }

        // Check if source status is chargeable/paid
        if ($source['attributes']['status'] === 'chargeable' || $source['attributes']['status'] === 'paid') {
            // Update payment status
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
                'payment_details' => array_merge($payment->payment_details ?? [], [
                    'source_status' => $source['attributes']['status'],
                    'completed_at' => now()->toIso8601String()
                ])
            ]);

            // Update request status
            $request = $payment->request;
            $request->update([
                'status' => 'processing',
            ]);

                        // Clear session data related to payment
                        session()->forget(['last_payment_id', 'last_payment_checkout']);

            // Create notification
            \App\Models\Notification::create([
                'user_id' => Auth::id(),
                'request_id' => $request->id,
                'title' => 'Payment Successful',
                'message' => "Your payment of ₱" . number_format($payment->amount, 2) . " for {$request->service->name} has been received. Your request is now being processed.",
                'notification_type' => 'system',
                'is_sent' => true,
                'sent_at' => now(),
            ]);

            return redirect()->route('requests.show', $request)
                ->with('success', 'Payment successful! Your request is now being processed.');
        } else {
            $payment->update([
                'status' => 'failed',
                'payment_details' => array_merge($payment->payment_details ?? [], [
                    'source_status' => $source['attributes']['status'],
                    'failed_at' => now()->toIso8601String(),
                    'failure_reason' => 'Source status not chargeable: ' . $source['attributes']['status']
                ])
            ]);

            throw new \Exception('Payment was not completed successfully. Status: ' . $source['attributes']['status']);
        }
    } catch (\Exception $e) {
        Log::error('Payment Success Callback Error', [
            'message' => $e->getMessage(),
            'source_id' => $sourceId
        ]);

        return redirect()->route('dashboard')
            ->with('error', 'There was an error processing your payment. Please contact support.');
    }
}

 /**
 * Handle failed payment callback
 */
public function failed(Request $httpRequest)
{
    // Similar improvements as in the success method
    $sourceId = $httpRequest->source_id ?? $httpRequest->source ?? $httpRequest->id ?? $httpRequest->query('source_id');

    // Log what we're receiving for debugging
    Log::info('Payment Failed Callback received', [
        'query' => $httpRequest->query(),
        'request' => $httpRequest->all(),
        'source_id_found' => $sourceId
    ]);

    if ($sourceId) {
        // Find the payment by source ID
        $payment = Payment::whereJsonContains('payment_details->source_id', $sourceId)->first();

        if ($payment) {
            $payment->update([
                'status' => 'failed',
                'payment_details' => array_merge($payment->payment_details ?? [], [
                    'failed_at' => now()->toIso8601String(),
                    'failure_reason' => $httpRequest->has('error') ? $httpRequest->error : 'Payment failed or was canceled by user',
                    'callback_data' => $httpRequest->all()
                ])
            ]);

            return redirect()->route('requests.show', $payment->request)
                ->with('error', 'Your payment was not completed. Please try again or contact support for assistance.');
        }
    } else {
        // Try to find the most recent pending payment for the logged-in user
        $payment = Payment::where('status', 'pending')
            ->whereHas('request', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->first();

        if ($payment) {
            $payment->update([
                'status' => 'failed',
                'payment_details' => array_merge($payment->payment_details ?? [], [
                    'failed_at' => now()->toIso8601String(),
                    'failure_reason' => 'Payment canceled or failed - no source ID returned',
                    'callback_data' => $httpRequest->all()
                ])
            ]);

            return redirect()->route('requests.show', $payment->request)
                ->with('error', 'Your payment was not completed. Please try again.');
        }
    }

    return redirect()->route('dashboard')
        ->with('error', 'Your payment was not completed. Please try again later.');
}

    /**
     * Check payment status via AJAX (for polling)
     */
    public function checkStatus(Request $httpRequest)
    {
        $paymentId = $httpRequest->payment_id;
        $payment = Payment::find($paymentId);

        if (!$payment || $payment->request->user_id !== Auth::id()) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        return response()->json([
            'status' => $payment->status,
            'paid' => $payment->status === 'paid',
            'redirect_url' => $payment->status === 'paid'
                ? route('requests.show', $payment->request)
                : null
        ]);
    }

    /**
     * Webhook endpoint for Paymongo callbacks
     * Note: This needs to be configured in your Paymongo dashboard
     */
    public function webhook(Request $httpRequest)
    {
        // Verify webhook signature (highly recommended in production)

        $payload = $httpRequest->all();
        Log::info('Paymongo Webhook Received', $payload);

        // Process webhook based on event type
        // This is just a simplified example
        if (isset($payload['data']['attributes']['type']) && $payload['data']['attributes']['type'] === 'source.chargeable') {
            $sourceId = $payload['data']['attributes']['data']['id'] ?? null;

            if ($sourceId) {
                $payment = Payment::whereJsonContains('payment_details->source_id', $sourceId)->first();

                if ($payment) {
                    // Update payment status
                    $payment->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                        'payment_details' => array_merge($payment->payment_details ?? [], [
                            'source_status' => 'chargeable',
                            'completed_at' => now()->toIso8601String(),
                            'webhook_received' => true
                        ])
                    ]);

                    // Update request status
                    $payment->request->update(['status' => 'processing']);
                }
            }
        }

        return response()->json(['success' => true]);
    }

    /**
 * Recover from a payment where callback didn't work
 */
public function recoverPayment(Request $request)
{
    // Check if we have session data about the last payment
    $paymentId = session('last_payment_id');

    if (!$paymentId) {
        return redirect()->route('dashboard')
            ->with('error', 'No payment information found to recover.');
    }

    $payment = Payment::find($paymentId);

    if (!$payment || $payment->request->user_id !== Auth::id()) {
        return redirect()->route('dashboard')
            ->with('error', 'Invalid payment recovery attempt.');
    }

    // If the payment is still pending, let's check its status
    if ($payment->status === 'pending' && isset($payment->payment_details['source_id'])) {
        $sourceId = $payment->payment_details['source_id'];

        try {
            $source = $this->paymongoService->retrieveSource($sourceId);

            if (!$source) {
                throw new \Exception('Failed to retrieve payment source.');
            }

            // Check if source status indicates payment was completed
            if ($source['attributes']['status'] === 'chargeable' || $source['attributes']['status'] === 'paid') {
                // Update payment status
                $payment->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'payment_details' => array_merge($payment->payment_details ?? [], [
                        'source_status' => $source['attributes']['status'],
                        'completed_at' => now()->toIso8601String(),
                        'recovered' => true
                    ])
                ]);

                // Update request status
                $request = $payment->request;
                $request->update([
                    'status' => 'processing',
                ]);

                // Create notification
                \App\Models\Notification::create([
                    'user_id' => Auth::id(),
                    'request_id' => $request->id,
                    'title' => 'Payment Successful',
                    'message' => "Your payment of ₱" . number_format($payment->amount, 2) . " for {$request->service->name} has been verified. Your request is now being processed.",
                    'notification_type' => 'system',
                    'is_sent' => true,
                    'sent_at' => now(),
                ]);

                // Clear session data
                session()->forget(['last_payment_id', 'last_payment_checkout']);

                return redirect()->route('requests.show', $request)
                    ->with('success', 'Payment verified! Your request is now being processed.');
            } else {
                // Still not paid
                return redirect()->route('requests.show', $payment->request)
                    ->with('info', 'Your payment has not been completed yet. Please try again or contact support if you believe this is an error.');
            }
        } catch (\Exception $e) {
            Log::error('Payment Recovery Error', [
                'message' => $e->getMessage(),
                'payment_id' => $paymentId
            ]);

            return redirect()->route('requests.show', $payment->request)
                ->with('error', 'There was an error verifying your payment. Please contact support.');
        }
    } elseif ($payment->status === 'paid') {
        // Already paid, redirect to the request page
        return redirect()->route('requests.show', $payment->request)
            ->with('info', 'Your payment has already been processed successfully.');
    } else {
        // Payment failed or canceled
        return redirect()->route('requests.show', $payment->request)
            ->with('info', 'Your payment was not completed. Please try again.');
    }
}
}
