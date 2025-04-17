<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Request as ServiceRequest;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    /**
     * Display the main reports page
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * Display requests report
     */
    public function requests(Request $request)
    {
        $query = ServiceRequest::with(['user', 'service', 'payment']);
        
        // Apply filters if provided
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('service_id') && !empty($request->service_id)) {
            $query->where('service_id', $request->service_id);
        }
        
        $requests = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Calculate statistics
        $stats = [
            'total' => $query->count(),
            'pending' => $query->where('status', 'pending')->count(),
            'processing' => $query->where('status', 'processing')->count(),
            'completed' => $query->whereIn('status', ['completed', 'ready_for_pickup'])->count(),
            'rejected' => $query->where('status', 'rejected')->count(),
            'payment_required' => $query->where('status', 'payment_required')->count(),
            'avg_processing_time' => ServiceRequest::whereNotNull('completed_at')
                ->selectRaw('AVG(DATEDIFF(completed_at, created_at)) as avg_time')
                ->first()->avg_time ?? 0
        ];
        
        $services = Service::all();
        
        return view('admin.reports.requests', compact('requests', 'stats', 'services'));
    }

    /**
     * Display payments report
     */
    public function payments(Request $request)
    {
        $query = Payment::with(['request.user', 'request.service']);
        
        // Apply filters if provided
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('payment_method') && !empty($request->payment_method)) {
            $query->where('payment_method', $request->payment_method);
        }
        
        $payments = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Calculate statistics
        $stats = [
            'total_payments' => $query->count(),
            'total_amount' => $query->where('status', 'paid')->sum('amount'),
            'payment_methods' => Payment::where('status', 'paid')
                ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
                ->groupBy('payment_method')
                ->get(),
            'daily_totals' => Payment::where('status', 'paid')
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
        ];
        
        return view('admin.reports.payments', compact('payments', 'stats'));
    }

    /**
     * Display users report
     */
    public function users(Request $request)
    {
        $query = User::withCount('requests');
        
        // Apply filters if provided
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Calculate statistics
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', now()->toDateString())->count(),
            'new_users_this_week' => User::whereDate('created_at', '>=', now()->subDays(7))->count(),
            'new_users_this_month' => User::whereDate('created_at', '>=', now()->startOfMonth())->count(),
            'active_users' => ServiceRequest::select('user_id')
                ->whereDate('created_at', '>=', now()->subDays(30))
                ->distinct()
                ->count(),
        ];
        
        return view('admin.reports.users', compact('users', 'stats'));
    }

    /**
     * Export reports as CSV
     */
    public function export(string $type)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $type . '-report-' . date('Y-m-d') . '.csv"',
        ];
        
        $callback = function() use ($type) {
            $file = fopen('php://output', 'w');
            
            // Different exports based on report type
            if ($type === 'requests') {
                // Headers
                fputcsv($file, ['ID', 'Tracking Number', 'Service', 'User', 'Status', 'Created At', 'Updated At', 'Fee']);
                
                // Data
                ServiceRequest::with(['user', 'service'])->chunk(100, function($requests) use ($file) {
                    foreach ($requests as $request) {
                        fputcsv($file, [
                            $request->id,
                            $request->tracking_number,
                            $request->service->name,
                            $request->user->name,
                            $request->status,
                            $request->created_at,
                            $request->updated_at,
                            $request->service->fee
                        ]);
                    }
                });
            } elseif ($type === 'payments') {
                // Headers
                fputcsv($file, ['ID', 'Reference Number', 'Request ID', 'User', 'Service', 'Amount', 'Method', 'Status', 'Created At', 'Paid At']);
                
                // Data
                Payment::with(['request.user', 'request.service'])->chunk(100, function($payments) use ($file) {
                    foreach ($payments as $payment) {
                        fputcsv($file, [
                            $payment->id,
                            $payment->reference_number,
                            $payment->request_id,
                            $payment->request->user->name ?? 'N/A',
                            $payment->request->service->name ?? 'N/A',
                            $payment->amount,
                            $payment->payment_method,
                            $payment->status,
                            $payment->created_at,
                            $payment->paid_at
                        ]);
                    }
                });
            } elseif ($type === 'users') {
                // Headers
                fputcsv($file, ['ID', 'Name', 'Email', 'Mobile', 'Address', 'Role', 'Requests Count', 'Created At']);
                
                // Data
                User::withCount('requests')->chunk(100, function($users) use ($file) {
                    foreach ($users as $user) {
                        fputcsv($file, [
                            $user->id,
                            $user->name,
                            $user->email,
                            $user->mobile_number,
                            $user->address,
                            $user->role,
                            $user->requests_count,
                            $user->created_at
                        ]);
                    }
                });
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}