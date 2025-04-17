<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Request as ServiceRequest;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Get basic statistics
        $pendingRequests = ServiceRequest::where('status', 'pending')->count();
        $processingRequests = ServiceRequest::where('status', 'processing')->count();
        $completedRequests = ServiceRequest::whereIn('status', ['ready_for_pickup', 'completed'])->count();
        $paymentRequiredCount = ServiceRequest::where('status', 'payment_required')->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalServices = Service::count();
        
        // Get payment statistics
        $totalPayments = Payment::where('status', 'paid')->sum('amount');
        $totalPaymentsCount = Payment::where('status', 'paid')->count();
        $recentPayments = Payment::with(['request.user', 'request.service'])
            ->whereIn('status', ['paid', 'waived'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
        
        $paymentsByMethod = Payment::where('status', 'paid')
            ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get();
        
        // Get recent requests
        $recentRequests = ServiceRequest::with(['user', 'service'])
            ->latest()
            ->take(5)
            ->get();
        
        // Get activity trends for the past 7 days
        $startDate = Carbon::now()->subDays(7)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        $requestTrends = ServiceRequest::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        
        $paymentTrends = Payment::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(amount) as amount, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        
        $dates = [];
        $requestCounts = [];
        $paymentAmounts = [];
        
        for ($date = clone $startDate; $date <= $endDate; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $dates[] = $date->format('M d');
            $requestCounts[] = $requestTrends->get($dateStr)->count ?? 0;
            $paymentAmounts[] = $paymentTrends->get($dateStr)->amount ?? 0;
        }
        
        // Get top services
        $topServices = ServiceRequest::selectRaw('service_id, COUNT(*) as request_count')
            ->with('service')
            ->groupBy('service_id')
            ->orderByDesc('request_count')
            ->take(5)
            ->get();
        
        // Get user registration trend
        $userTrend = User::where('role', 'user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        
        $userCounts = [];
        for ($date = clone $startDate; $date <= $endDate; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $userCounts[] = $userTrend->get($dateStr)->count ?? 0;
        }
        
        return view('admin.dashboard', compact(
            'pendingRequests',
            'processingRequests',
            'completedRequests',
            'paymentRequiredCount',
            'totalUsers',
            'totalServices',
            'totalPayments',
            'totalPaymentsCount',
            'recentPayments',
            'paymentsByMethod',
            'recentRequests',
            'dates',
            'requestCounts',
            'paymentAmounts',
            'topServices',
            'userCounts'
        ));
    }

    /**
     * Show detailed analytics
     */
    public function analytics(Request $request)
    {
        // Get date range filters
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date'))->startOfDay() 
            : Carbon::now()->subDays(30)->startOfDay();
            
        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfDay();
        
        // Calculate key statistics
        $totalRequests = ServiceRequest::whereBetween('created_at', [$startDate, $endDate])->count();
        $completedRequests = ServiceRequest::whereIn('status', ['ready_for_pickup', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $totalPayments = Payment::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');
        
        // Get requests by category
        $requestsByCategory = ServiceRequest::join('services', 'requests.service_id', '=', 'services.id')
            ->join('service_categories', 'services.category_id', '=', 'service_categories.id')
            ->whereBetween('requests.created_at', [$startDate, $endDate])
            ->selectRaw('service_categories.name, COUNT(*) as count')
            ->groupBy('service_categories.name')
            ->orderByDesc('count')
            ->get();
        
        // Get requests by status
        $requestsByStatus = ServiceRequest::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->orderByDesc('count')
            ->get();
        
        // Get payment trends by day
        $paymentByDay = Payment::where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(amount) as amount')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Detailed data for each service
        $serviceStats = ServiceRequest::join('services', 'requests.service_id', '=', 'services.id')
            ->whereBetween('requests.created_at', [$startDate, $endDate])
            ->selectRaw('services.name, COUNT(*) as request_count, 
                        SUM(CASE WHEN requests.status = "completed" THEN 1 ELSE 0 END) as completed_count,
                        AVG(TIMESTAMPDIFF(HOUR, requests.created_at, requests.updated_at)) as avg_processing_hours')
            ->groupBy('services.name')
            ->orderByDesc('request_count')
            ->get();
        
        return view('admin.analytics', compact(
            'startDate',
            'endDate',
            'totalRequests',
            'completedRequests',
            'totalPayments',
            'requestsByCategory',
            'requestsByStatus',
            'paymentByDay',
            'serviceStats'
        ));
    }
}