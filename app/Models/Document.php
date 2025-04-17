<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'request_id',
        'file_url',
        'hash',
    ];

    /**
     * Get the request associated with the document.
     */
    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
