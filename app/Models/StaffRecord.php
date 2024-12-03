<?php

namespace App\Models;

use App\Models\User;
use Eloquent;

class StaffRecord extends Eloquent
{
    protected $fillable = ['code', 'emp_date', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
