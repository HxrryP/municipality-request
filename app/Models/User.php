<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Request;
use App\Models\Notification;


class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
        'address',
        'birthdate',
        'role',
        'profile_photo',
        'google_id',
        'last_active_at',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthdate' => 'date',
        'last_active_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

/**
 * Check if the user is an admin
 *
 * @return bool
 */
public function isAdmin(): bool
{
    return $this->role === 'admin';
}

/**
 * Check if the user is a staff member
 *
 * @return bool
 */
public function isStaff(): bool
{
    return $this->role === 'staff';
}

public function hasAdminAccess(): bool
{
    return in_array($this->role, ['admin', 'staff']);
}



/**
 * Get all payments by this user (through requests)
 */
public function payments()
{
    return $this->hasManyThrough(Payment::class, Request::class);
}

public function isActive()
{
    return $this->status;
}

}
