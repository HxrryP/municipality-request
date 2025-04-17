<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'tracking_number',
        'status',
        'remarks',
        'form_data',
        'document_urls',
        'is_renewal',
        'previous_request_id'
    ];

    protected $casts = [
        'form_data' => 'array',
        'document_urls' => 'array',
        'is_renewal' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function previousRequest()
    {
        return $this->belongsTo(Request::class, 'previous_request_id');
    }

    public function renewals()
    {
        return $this->hasMany(Request::class, 'previous_request_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
