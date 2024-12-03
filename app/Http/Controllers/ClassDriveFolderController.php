<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ClassDriveFolder;
use Illuminate\Http\Request;


class ClassDriveFolderController extends Controller
{
    public function index()
    {
        $driveFolders = ClassDriveFolder::where('created_by', Auth::id())->get();
        return view('drive-folders.index', compact('driveFolders'));
    }

    public function create(Request $request)
    {
        // Implement drive folder creation logic
    }

    public function show($folder)
    {
        $driveFolder = ClassDriveFolder::findOrFail($folder);
        return view('drive-folders.show', compact('driveFolder'));
    }

    public function destroy($folder)
    {
        $driveFolder = ClassDriveFolder::findOrFail($folder);
        $driveFolder->delete();
        return redirect()->route('drive-folders.index');
    }
}