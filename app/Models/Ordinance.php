<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'content',
        'ordinance_number',
        'date_approved',
        'file_url'
    ];

    protected $casts = [
        'date_approved' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(OrdinanceCategory::class);
    }
}