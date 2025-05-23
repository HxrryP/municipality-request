<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use App\Http\Middleware\RedirectBasedOnRole;
use App\Http\Middleware\RedirectIfAuthenticated;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        // Check if the user's email is verified
        if (!Auth::user()->hasVerifiedEmail()) {
            Auth::logout(); // Log the user out
            return redirect()->route('login')->withErrors([
                'email' => 'You must verify your email address before logging in.',
            ]);
        }

        $request->session()->regenerate();

        // Redirect based on user role
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'staff') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
