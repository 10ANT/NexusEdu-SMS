<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassDriveFolder extends Model
{

    protected $fillable = [
        'class_id', 
        'folder_name', 
        'folder_id', 
        'folder_link', 
        'created_by'
    ];
}