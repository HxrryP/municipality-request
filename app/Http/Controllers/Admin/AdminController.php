<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Request;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Request statistics
        $pendingRequests = Request::where('status', 'pending')->count();
        $processingRequests = Request::where('status', 'processing')->count();
        $completedRequests = Request::whereIn('status', ['ready_for_pickup', 'completed'])->count();
        $paymentRequiredCount = Request::where('status', 'payment_required')->count();
        
        // User statistics
        $totalUsers = User::where('role', 'user')->count();
        
        // Payment statistics
        $totalPayments = Payment::whereIn('status', ['paid'])->sum('amount');
        $recentPayments = Payment::with(['request.user', 'request.service'])
            ->whereIn('status', ['paid', 'waived'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
        
        // Get recent activity (mix of requests and payments)
        $recentRequests = Request::with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'request',
                    'data' => $item,
                    'created_at' => $item->created_at
                ];
            });
            
        $recentPaymentsActivity = Payment::with(['request.user', 'request.service'])
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'payment',
                    'data' => $item,
                    'created_at' => $item->created_at ?? $item->updated_at
                ];
            });
            
        $recentActivity = $recentRequests->concat($recentPaymentsActivity)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();
        
        // Popular services
        $popularServices = Service::withCount('requests')
            ->orderByDesc('requests_count')
            ->take(5)
            ->get();
            
        // Payment methods statistics
        $paymentsByMethod = Payment::where('status', 'paid')
            ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get();
        
        return view('admin.dashboard', compact(
            'pendingRequests', 
            'processingRequests', 
            'completedRequests',
            'paymentRequiredCount',
            'totalUsers',
            'totalPayments',
            'recentPayments',
            'recentActivity',
            'popularServices',
            'paymentsByMethod'
        ));
    }
}