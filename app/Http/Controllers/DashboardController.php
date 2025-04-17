<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pendingRequests = Request::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing', 'payment_required'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $completedRequests = Request::where('user_id', $user->id)
            ->whereIn('status', ['ready_for_pickup', 'completed'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $notifications = $user->notifications()
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboard', compact('pendingRequests', 'completedRequests', 'notifications'));
    }
}