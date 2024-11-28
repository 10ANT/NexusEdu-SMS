<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Parishes extends Controller
{
    //
    public function create(){
        $parishes = Parishes::all();

        return view('pages.support_team.students.add', compact('parishes')); // Pass the data to the view
    }
}
