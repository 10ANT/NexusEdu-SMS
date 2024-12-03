<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleClassroom extends Model
{
    protected $fillable = [
        'class_id', 
        'course_id', 
        'course_name', 
        'course_link', 
        'section', 
        'room', 
        'created_by'
    ];
}