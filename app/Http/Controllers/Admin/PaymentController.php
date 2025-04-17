<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Request as ServiceRequest;
use App\Models\Service;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments
     */
    public function index(Request $request)
    {
        $query = Payment::with(['request.user', 'request.service']);
        
        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Filter by method if provided
        if ($request->has('method') && !empty($request->method)) {
            $query->where('payment_method', $request->method);
        }
        
        // Order by date desc
        $query->orderBy('created_at', 'desc');
        
        $payments = $query->paginate(10);
        
        return view('admin.payments.index', compact('payments'));
    }
    
    /**
     * Verify a payment manually
     */
    public function verify(Payment $payment)
    {
        // Check if the user has admin/staff privileges
        if (!Auth::user()->isAdmin() && !Auth::user()->isStaff()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Update payment status
        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_details' => array_merge($payment->payment_details ?? [], [
                'manually_verified' => true,
                'verified_by' => Auth::user()->id,
                'verified_at' => now()->toIso8601String()
            ])
        ]);
        
        // Update request status
        $request = $payment->request;
        $request->update(['status' => 'processing']);
        
        // Create notification for the user
        Notification::create([
            'user_id' => $request->user_id,
            'request_id' => $request->id,
            'title' => 'Payment Verified',
            'message' => "Your payment for {$request->service->name} has been verified. Your request is now being processed.",
            'notification_type' => 'system',
            'is_sent' => true,
            'sent_at' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Payment has been verified and marked as paid.');
    }
    
    /**
     * Waive payment for a request
     */
    public function waive(ServiceRequest $request)
    {
        // Check if the user has admin/staff privileges
        if (!Auth::user()->isAdmin() && !Auth::user()->isStaff()) {
            abort(403, 'Unauthorized action.');
        }
        
        // If payment already exists, mark it as waived
        if ($request->payment) {
            $request->payment->update([
                'status' => 'waived',
                'payment_details' => array_merge($request->payment->payment_details ?? [], [
                    'waived_by' => Auth::user()->id,
                    'waived_at' => now()->toIso8601String()
                ])
            ]);
        } else {
            // Create a waived payment record
            Payment::create([
                'request_id' => $request->id,
                'reference_number' => 'WAIVED-' . strtoupper(\Illuminate\Support\Str::random(8)),
                'amount' => $request->service->fee,
                'payment_method' => 'waived',
                'status' => 'waived',
                'payment_details' => [
                    'waived_by' => Auth::user()->id,
                    'waived_at' => now()->toIso8601String(),
                    'reason' => 'Administrative decision'
                ]
            ]);
        }
        
        // Update request status to processing
        $request->update(['status' => 'processing']);
        
        // Create notification for the user
        Notification::create([
            'user_id' => $request->user_id,
            'request_id' => $request->id,
            'title' => 'Payment Waived',
            'message' => "The payment for your {$request->service->name} request has been waived. Your request is now being processed.",
            'notification_type' => 'system',
            'is_sent' => true,
            'sent_at' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Payment has been waived for this request.');
    }
}