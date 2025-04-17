<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->update([
                'status' => true, // Mark user as active
                'last_active_at' => now(),
            ]);

            // Schedule status update to false after 5 minutes of inactivity
            cache()->put("user-{$user->id}-last-active", now(), 300); // 5 minutes
        }

        return $next($request);
    }
}
