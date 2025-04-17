<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as ServiceRequest;
use App\Models\Notification;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the requests.
     */
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['user', 'service', 'payment']);
        
        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Filter by service if provided
        if ($request->has('service_id') && !empty($request->service_id)) {
            $query->where('service_id', $request->service_id);
        }
        
        // Filter by user if provided
        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by tracking number if provided
        if ($request->has('tracking_number') && !empty($request->tracking_number)) {
            $query->where('tracking_number', 'like', '%' . $request->tracking_number . '%');
        }
        
        // Filter by date range if provided
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Order by
        $query->orderBy('created_at', 'desc');
        
        $requests = $query->paginate(10);
        
        // Get services and users for filter dropdowns
        $services = Service::all();
        $users = User::where('role', 'user')->get();
        
        return view('admin.requests.index', compact('requests', 'services', 'users'));
    }

    /**
     * Display the specified request.
     */
    public function show(ServiceRequest $request)
    {
        $request->load(['user', 'service', 'payment']);
        return view('admin.requests.show', compact('request'));
    }

    /**
     * Update the status of the request.
     */
    public function updateStatus(Request $httpRequest, ServiceRequest $request)
    {
        $validated = $httpRequest->validate([
            'status' => 'required|in:pending,processing,payment_required,ready_for_pickup,completed,rejected',
            'remarks' => 'nullable|string|max:255',
        ]);
        
        $oldStatus = $request->status;
        
        // Update the request
        $request->update([
            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? $request->remarks,
        ]);
        
        // Create notification for the user
        Notification::create([
            'user_id' => $request->user_id,
            'request_id' => $request->id,
            'title' => 'Request Status Updated',
            'message' => "Your request for {$request->service->name} has been updated to " . ucfirst(str_replace('_', ' ', $validated['status'])) . "." . (!empty($validated['remarks']) ? " Remarks: {$validated['remarks']}" : ""),
            'notification_type' => 'system',
            'is_sent' => true,
            'sent_at' => now(),
        ]);
        
        // If status changed to completed, record the completion date
        if ($validated['status'] === 'completed' && $oldStatus !== 'completed') {
            $request->update([
                'completed_at' => now(),
            ]);
        }
        
        return redirect()->route('admin.requests.show', $request)
            ->with('success', 'Request status updated successfully.');
    }
}