<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilePhotoUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    /**
     * Update the user's profile photo.
     */
    public function update(ProfilePhotoUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            
            // Store new photo
            $path = $request->file('photo')->store('profile-photos', 'public');
            
            // Update user with new photo path
            $user->update(['profile_photo' => $path]);
        }
        
        return back()->with('status', 'profile-photo-updated');
    }
    
    /**
     * Delete the user's profile photo.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // Delete photo from storage
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            
            // Update user to remove photo reference
            $user->update(['profile_photo' => null]);
        }
        
        return back()->with('status', 'profile-photo-deleted');
    }
}