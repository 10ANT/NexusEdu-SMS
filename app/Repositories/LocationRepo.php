<?php

namespace App\Repositories;

use App\Models\Nationality;
use App\Models\Parishes;
//use App\Models;

class LocationRepo
{
    public function getParishes()
    {
        return Parishes::all();
    }

    public function getAllParishes()
    {
        return Parishes::orderBy('name', 'asc')->get();
    }

    public function getAllNationals()
    {
        return Nationality::orderBy('name', 'asc')->get();
    }



}