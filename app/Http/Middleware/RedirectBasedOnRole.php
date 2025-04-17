<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            // Check if user is admin or staff and trying to access regular dashboard
            if (in_array(Auth::user()->role, ['admin', 'staff']) && $request->routeIs('dashboard')) {
                return redirect()->route('admin.dashboard');
            }
            
            // Check if user is a regular user trying to access admin dashboard
            if (Auth::user()->role === 'user' && $request->routeIs('admin.*')) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}