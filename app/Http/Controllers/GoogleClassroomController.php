<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\GoogleClassroom;
use Illuminate\Http\Request;


class GoogleClassroomController extends Controller
{
    public function index()
    {
        $classrooms = GoogleClassroom::where('created_by', Auth::id())->get();
        return view('classrooms.index', compact('classrooms'));
    }

    public function create(Request $request)
    {
        // Implement classroom creation logic
    }

    public function show($course)
    {
        $classroom = GoogleClassroom::findOrFail($course);
        return view('classrooms.show', compact('classroom'));
    }

    public function destroy($course)
    {
        $classroom = GoogleClassroom::findOrFail($course);
        $classroom->delete();
        return redirect()->route('classroom.index');
    }
}