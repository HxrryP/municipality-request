<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // User exists, log them in
                Auth::login($user);
            } else {
                // Register the new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'mobile_number' => $googleUser->user['phoneNumbers'][0]['value'] ?? null,
                    'address' => $googleUser->user['addresses'][0]['formatted'] ?? null,
                    'birthdate' => $googleUser->user['birthdays'][0]['date']['birthDate'] ?? null,
                    'password' => bcrypt(uniqid()), // Generate a random password
                ]);

                Auth::login($user);
            }

            return redirect()->route('dashboard')->with('success', 'Logged in successfully using Google!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to authenticate with Google. Please try again.');
        }
    }
}
