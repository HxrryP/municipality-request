<?php

namespace App\Policies;

use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if user can view the request.
     */
    public function view(User $user, Request $request)
    {
        // Admin or staff can view any request
        if ($user->role === 'admin' || $user->role === 'staff') {
            return true;
        }
        
        // Users can only view their own requests
        return $user->id === $request->user_id;
    }
    
    /**
     * Determine if user can update the request.
     */
    public function update(User $user, Request $request)
    {
        // Only admin or staff can update requests
        return in_array($user->role, ['admin', 'staff']);
    }
    
    /**
     * Determine if user can delete the request.
     */
    public function delete(User $user, Request $request)
    {
        // Only admin can delete requests
        return $user->role === 'admin';
    }
}