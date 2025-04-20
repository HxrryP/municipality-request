<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequestRequest;
use App\Models\Request;
use App\Models\Service;
use App\Models\Notification as Notificationmodel;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Notification;


class RequestController extends Controller
{
    /**
     * Display a listing of the user's requests.
     *
     * @param \Illuminate\Http\Request $httpRequest
     * @return \Illuminate\Http\Response
     */
    public function index(HttpRequest $httpRequest)
    {
        $query = Request::where('user_id', Auth::id())->with(['service', 'service.category']);

        // Apply filters
        if ($httpRequest->has('status') && !empty($httpRequest->status)) {
            $query->where('status', $httpRequest->status);
        }

        if ($httpRequest->has('service') && !empty($httpRequest->service)) {
            $query->where('service_id', $httpRequest->service);
        }

        if ($httpRequest->has('date_from') && !empty($httpRequest->date_from)) {
            $query->whereDate('created_at', '>=', $httpRequest->date_from);
        }

        if ($httpRequest->has('date_to') && !empty($httpRequest->date_to)) {
            $query->whereDate('created_at', '<=', $httpRequest->date_to);
        }

        // Sort by most recent
        $requests = $query->latest()->paginate(10);

        return view('requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new request.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function create(Service $service)
    {
        return view('requests.create', compact('service'));
    }

    /**
     * Store a newly created request in storage.
     *
     * @param \App\Http\Requests\StoreServiceRequestRequest $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequestRequest $request, Service $service)
    {
        try {
            DB::beginTransaction();

            // Get validated data
            $validated = $request->validated();

            // Handle file uploads with duplicate prevention
            $documentUrls = [];
            $documentHashes = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $key => $file) {
                    // Calculate file hash to prevent duplicates
                    $fileHash = hash_file('sha256', $file->getRealPath());

                    // Check if the file is already uploaded
                    if (in_array($fileHash, $documentHashes)) {
                        DB::rollBack();
                        return back()->withInput()->with('error', 'Duplicate document detected. Please remove duplicates and try again.');
                    }

                    $documentHashes[] = $fileHash;

                    // Store the file
                    $path = $file->store('documents/' . Str::slug($service->name), 'public');
                    $documentUrls[$key] = $path;
                }
            }

            // Determine if this is a renewal
            $isRenewal = false;
            $previousRequestId = null;

            if (Str::contains($service->slug, 'renewal')) {
                $isRenewal = true;

                // Try to find the previous request for renewal
                if (!empty($validated['form_data']['previous_request_id'])) {
                    $previousRequestId = $validated['form_data']['previous_request_id'];
                } else {
                    // Try to find the most recent completed request of the same service type
                    $baseSlug = Str::beforeLast($service->slug, '-renewal');
                    $baseService = Service::where('slug', $baseSlug)->first();

                    if ($baseService) {
                        $previousRequest = Request::where('user_id', Auth::id())
                            ->where('service_id', $baseService->id)
                            ->where('status', 'completed')
                            ->latest()
                            ->first();

                        if ($previousRequest) {
                            $previousRequestId = $previousRequest->id;
                        }
                    }
                }
            }

            // Determine the initial status of the request
            $initialStatus = 'pending';

            if ($service->requiresPayment()) {
                $initialStatus = 'payment_required';
            } elseif (!$service->requires_approval) {
                $initialStatus = 'processing';
            }

            // Create a new request
            $newRequest = Request::create([
                'user_id' => Auth::id(),
                'service_id' => $service->id,
                'tracking_number' => 'REQ-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'status' => $initialStatus,
                'form_data' => $validated['form_data'],
                'document_urls' => $documentUrls,
                'is_renewal' => $isRenewal,
                'previous_request_id' => $previousRequestId,
            ]);

            // Create a notification for the user
            Notificationmodel::create([
                'user_id' => Auth::id(),
                'request_id' => $newRequest->id,
                'title' => 'Request Submitted',
                'message' => "Your request for {$service->name} has been submitted successfully. Your tracking number is {$newRequest->tracking_number}.",
                'notification_type' => 'system',
                'is_sent' => true,
                'sent_at' => now(),
            ]);

                    // === Add the provided notification and email logic here ===

        // Send a notification using UserNotification
        $user = auth()->user(); // Get the logged-in user
        $subject = 'Request Submitted Successfully';
        $message = 'Your request for the service has been successfully submitted. You can track it in your account.';
        Notification::send($user, new UserNotification($subject, $message));

        // Send an email notification to the user
        try {
            Auth::user()->notify(new \App\Notifications\RequestSubmitted($newRequest));
        } catch (\Exception $e) {
            Log::error('Failed to send email notification: ' . $e->getMessage());
        }

            DB::commit();

            // Redirect based on the initial status
            if ($initialStatus === 'payment_required') {
                return redirect()->route('payments.show', $newRequest)
                    ->with('success', 'Your request has been submitted successfully. Please complete the payment to proceed.');
            }

            return redirect()->route('requests.show', $newRequest)
                ->with('success', 'Your request has been submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating request: ' . $e->getMessage());
            return back()->withInput()->with('error', 'There was a problem submitting your request. Please try again.');
        }
    }

    /**
     * Display the specified request.
     *
     * @param \App\Models\Request $request
     * @return \Illuminate\Http\Response
     */
/**
 * Display the specified request.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function show($id)
{
    try {
        // Find the request by ID
        $request = Request::findOrFail($id);

        // Basic permission check
        if (Auth::id() !== $request->user_id && !in_array(Auth::user()->role, ['admin', 'staff'])) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to view this request.');
        }

        // Load only the essential relationships
        $request->load('service');

        // Simplify view data
        return view('requests.show', ['request' => $request]);
    } catch (\Exception $e) {
        // Log the error and return a helpful message
        Log::error('Request view error: ' . $e->getMessage());
        return redirect()->route('requests.index')
            ->with('error', 'Error viewing request: ' . $e->getMessage());
    }
}

    /**
     * Show the tracking view for a request.
     *
     * @param \App\Models\Request $request
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request)
    {
        // Check if the request belongs to the logged-in user
        if ($request->user_id !== Auth::id() && !Auth::user()->isAdmin() && !Auth::user()->isStaff()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to track this request.');
        }

        $request->load(['service', 'payment']);
        return view('requests.track', compact('request'));
    }

    /**
     * Cancel a request that is in pending status.
     *
     * @param \App\Models\Request $request
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
        // Check if the request belongs to the logged-in user
        if ($request->user_id !== Auth::id()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to cancel this request.');
        }

        // Check if the request can be cancelled
        if (!in_array($request->status, ['pending', 'payment_required'])) {
            return back()->with('error', 'This request cannot be cancelled because it is already being processed.');
        }

        try {
            DB::beginTransaction();

            // Update the request status
            $request->update([
                'status' => 'cancelled',
                'remarks' => 'Cancelled by user on ' . now()->format('F d, Y h:i A')
            ]);

            // If there's a pending payment, mark it as cancelled
            if ($request->payment && $request->payment->status === 'pending') {
                $request->payment->update([
                    'status' => 'cancelled',
                    'payment_details' => array_merge($request->payment->payment_details ?? [], [
                        'cancelled_at' => now()->toIso8601String(),
                        'cancelled_by' => 'user',
                        'cancellation_reason' => 'Request cancelled by user'
                    ])
                ]);
            }

            // Create notification
            Notification::create([
                'user_id' => Auth::id(),
                'request_id' => $request->id,
                'title' => 'Request Cancelled',
                'message' => "Your request for {$request->service->name} has been cancelled.",
                'notification_type' => 'system',
                'is_sent' => true,
                'sent_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('requests.show', $request)
                ->with('success', 'Your request has been cancelled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelling request: ' . $e->getMessage());
            return back()->with('error', 'There was a problem cancelling your request. Please try again.');
        }
    }

    /**
     * Track a request by tracking number.
     *
     * @param \Illuminate\Http\Request $httpRequest
     * @return \Illuminate\Http\Response
     */
    public function trackByNumber(HttpRequest $httpRequest)
    {
        $validated = $httpRequest->validate([
            'tracking_number' => 'required|string'
        ]);

        $request = Request::where('tracking_number', $validated['tracking_number'])->first();

        if (!$request) {
            return back()->with('error', 'No request found with the provided tracking number.');
        }

        // If the request belongs to the logged-in user, show the detailed tracking view
        if (Auth::check() && $request->user_id === Auth::id()) {
            return redirect()->route('requests.track', $request);
        }

        // For non-logged in users or different users, show a public tracking view with limited information
        return view('requests.public-track', compact('request'));
    }

    /**
     * Mark a request as requiring payment (admin or staff action).
     *
     * @param \App\Models\Request $request
     * @return \Illuminate\Http\Response
     */
    public function requirePayment(Request $request)
    {
        // Only admin or staff can mark a request as requiring payment
        if (!Auth::user()->isAdmin() && !Auth::user()->isStaff()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            // Update the request status
            $request->update(['status' => 'payment_required']);

            // Create notification for the user
            Notification::create([
                'user_id' => $request->user_id,
                'request_id' => $request->id,
                'title' => 'Payment Required',
                'message' => "Your request for {$request->service->name} requires payment to proceed. Please complete the payment.",
                'notification_type' => 'system',
                'is_sent' => true,
                'sent_at' => now(),
            ]);

            DB::commit();

            // Notify the user via email
            try {
                $request->user->notify(new \App\Notifications\PaymentRequired($request));
            } catch (\Exception $e) {
                Log::error('Failed to send payment required email: ' . $e->getMessage());
            }

            return redirect()->route('admin.requests.show', $request)
                ->with('success', 'Request has been marked as requiring payment.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error requiring payment: ' . $e->getMessage());
            return back()->with('error', 'There was a problem updating the request status.');
        }
    }

    /**
     * Add a comment to a request.
     *
     * @param \Illuminate\Http\Request $httpRequest
     * @param \App\Models\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addComment(HttpRequest $httpRequest, Request $request)
    {
        // Check if the user is allowed to comment on this request
        if ($request->user_id !== Auth::id() && !Auth::user()->isAdmin() && !Auth::user()->isStaff()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to comment on this request.');
        }

        $validated = $httpRequest->validate([
            'comment' => 'required|string|max:1000',
        ]);

        try {
            // Get current comments or initialize empty array
            $comments = $request->comments ?? [];

            // Add new comment
            $comments[] = [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'user_role' => Auth::user()->role,
                'content' => $validated['comment'],
                'created_at' => now()->toIso8601String()
            ];

            // Update the request
            $request->update(['comments' => $comments]);

            // If comment is from staff/admin and not the requester, add a notification
            if (Auth::id() !== $request->user_id && (Auth::user()->isAdmin() || Auth::user()->isStaff())) {
                Notification::create([
                    'user_id' => $request->user_id,
                    'request_id' => $request->id,
                    'title' => 'New Comment on Your Request',
                    'message' => "A staff member has added a comment to your request for {$request->service->name}.",
                    'notification_type' => 'system',
                    'is_sent' => true,
                    'sent_at' => now(),
                ]);
            }

            return back()->with('success', 'Comment added successfully.');
        } catch (\Exception $e) {
            Log::error('Error adding comment: ' . $e->getMessage());
            return back()->with('error', 'There was a problem adding your comment. Please try again.');
        }
    }

    /**
     * Get requests that require attention for the dashboard.
     *
     * @return array
     */
    public function getRequestsForDashboard()
    {
        // Get pending requests for the user
        $pendingRequests = Request::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'processing', 'payment_required', 'ready_for_pickup'])
            ->with(['service', 'payment'])
            ->latest()
            ->get();

        // Get completed requests
        $completedRequests = Request::where('user_id', Auth::id())
            ->whereIn('status', ['completed'])
            ->with(['service'])
            ->latest()
            ->take(5)
            ->get();

        return [
            'pendingRequests' => $pendingRequests,
            'completedRequests' => $completedRequests
        ];
    }

    /**
     * Download a document attached to a request.
     *
     * @param \App\Models\Request $request
     * @param int $index
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function downloadDocument(Request $request, $index)
    {
        // Check if the user has permission to download
        $canDownload = Auth::user()->isAdmin() ||
                      Auth::user()->isStaff() ||
                      $request->user_id === Auth::id();

        if (!$canDownload) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to download this document.');
        }

        // Check if the document exists
        if (!isset($request->document_urls[$index])) {
            return back()->with('error', 'Document not found.');
        }

        $path = $request->document_urls[$index];
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            return back()->with('error', 'Document file not found.');
        }

        return response()->download($fullPath);
    }
}
