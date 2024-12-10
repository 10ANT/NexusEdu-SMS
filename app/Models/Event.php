<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes; // Add this trait

    protected $fillable = [
        'title', 
        'start', 
        'end', 
        'description', 
        'color',
        'user_id'
    ];

    protected $dates = [
        'start', 
        'end',
        'deleted_at' // Add this
    ];
}