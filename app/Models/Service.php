<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 
        'name', 
        'slug', 
        'description', 
        'fee', 
        'processing_days',
        'requires_approval',
        'requirements',
        'payment_required', // New field to explicitly set if payment is needed
        'payment_description', // Description for the payment
    ];

    protected $casts = [
        'requirements' => 'array',
        'requires_approval' => 'boolean',
        'payment_required' => 'boolean', // Cast to boolean
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    /**
     * Determine if the service requires payment
     */
    public function requiresPayment(): bool
    {
        return $this->fee > 0 && $this->payment_required;
    }

    /**
     * Get payment description or a default one
     */
    public function getPaymentDescription(): string
    {
        if (!empty($this->payment_description)) {
            return $this->payment_description;
        }
        
        return "Payment for {$this->name}";
    }
}