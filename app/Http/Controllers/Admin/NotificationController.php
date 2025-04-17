<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display all admin notifications
     */
    public function index()
    {
        // Get admin notifications - filter by admin role
        $notifications = Notification::where('notification_type', 'admin')
            ->orWhere(function($query) {
                $query->where('notification_type', 'system')
                      ->whereNull('user_id');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        // Mark all as read
        Notification::where('notification_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
        
        return view('admin.notifications.index', compact('notifications'));
    }
    
    /**
     * Get unread notifications count for navbar (AJAX)
     */
    public function getUnread()
    {
        $count = Notification::where('notification_type', 'admin')
            ->where('is_read', false)
            ->count();
        
        $recentNotifications = Notification::where('notification_type', 'admin')
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return response()->json([
            'count' => $count,
            'notifications' => $recentNotifications
        ]);
    }
    
    /**
     * Create a system-wide notification
     */
    public function create()
    {
        return view('admin.notifications.create');
    }
    
    /**
     * Store a new notification
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'notification_type' => 'required|in:admin,user,system',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id'
        ]);
        
        if ($validated['notification_type'] === 'user' && empty($validated['users'])) {
            return back()->withErrors(['users' => 'You must select at least one user for user notifications.']);
        }
        
        if ($validated['notification_type'] === 'admin' || $validated['notification_type'] === 'system') {
            // Create single notification for all admins or system
            Notification::create([
                'user_id' => null,
                'title' => $validated['title'],
                'message' => $validated['message'],
                'notification_type' => $validated['notification_type'],
                'is_sent' => true,
                'sent_at' => now(),
            ]);
        } else {
            // Create individual notifications for selected users
            foreach ($validated['users'] as $userId) {
                Notification::create([
                    'user_id' => $userId,
                    'title' => $validated['title'],
                    'message' => $validated['message'],
                    'notification_type' => 'user',
                    'is_sent' => true,
                    'sent_at' => now(),
                ]);
            }
        }
        
        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification sent successfully.');
    }
}