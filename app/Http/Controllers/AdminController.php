<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\Payment;
use Illuminate\Http\Request as HttpRequest;

class AdminController extends Controller
{
    public function index()
    {
        $pendingRequests = Request::where('status', 'pending')->count();
        $processingRequests = Request::where('status', 'processing')->count();
        $completedRequests = Request::whereIn('status', ['ready_for_pickup', 'completed'])->count();
        $totalUsers = User::where('role', 'user')->count();
        $recentPayments = Payment::where('status', 'paid')->orderBy('paid_at', 'desc')->take(5)->get();
        
        return view('admin.dashboard', compact(
            'pendingRequests', 
            'processingRequests', 
            'completedRequests', 
            'totalUsers',
            'recentPayments'
        ));
    }
    
    public function requests()
    {
        $requests = Request::with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.requests.index', compact('requests'));
    }
    
    public function showRequest(Request $request)
    {
        $request->load(['user', 'service', 'payment']);
        return view('admin.requests.show', compact('request'));
    }
    
    public function updateRequestStatus(HttpRequest $httpRequest, Request $request)
    {
        $validated = $httpRequest->validate([
            'status' => 'required|in:pending,processing,payment_required,ready_for_pickup,completed,rejected',
            'remarks' => 'nullable|string|max:500',
        ]);
        
        $request->update([
            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? $request->remarks,
        ]);
        
        // Create notification for the user
        Notification::create([
            'user_id' => $request->user_id,
            'request_id' => $request->id,
            'title' => 'Request Status Updated',
            'message' => "Your request for {$request->service->name} has been updated to: " . ucfirst($validated['status']),
            'notification_type' => 'system',
            'is_sent' => true,
            'sent_at' => now(),
        ]);
        
        return redirect()->route('admin.requests.show', $request)
            ->with('success', 'Request status updated successfully.');
    }
    
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }
    
    public function showUser(User $user)
    {
        $requests = Request::where('user_id', $user->id)
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        return view('admin.users.show', compact('user', 'requests'));
    }
    
    public function updateUser(HttpRequest $httpRequest, User $user)
    {
        $validated = $httpRequest->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:user,staff,admin',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }
    
    public function reports()
    {
        $monthlyRequests = Request::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();
            
        $serviceStats = Request::selectRaw('service_id, COUNT(*) as total')
            ->with('service')
            ->groupBy('service_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
            
        $paymentStats = Payment::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(amount) as total')
            ->where('status', 'paid')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();
            
        return view('admin.reports', compact('monthlyRequests', 'serviceStats', 'paymentStats'));
    }
}