<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notifications.index');
    }
    
    public function markAsRead()
    {
        Auth::user()->notifications()->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }
}