<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleCredential extends Model
{
    protected $fillable = [
        'user_id',
        'access_token',
        'refresh_token',
        'expires_at'
    ];

    protected $dates = [
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}