<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parishes extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural of the model name
    protected $table = 'parishes';

    // Define the fillable properties for mass assignment
    protected $fillable = ['name', 'region_id'];
}
