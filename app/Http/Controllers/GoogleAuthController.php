<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use App\Models\GoogleCredential;
use App\Models\GoogleClassroom;  // Ensure this import is correct
use App\Models\ClassDriveFolder;  // Ensure this import is correct
use Illuminate\Support\Facades\Auth;
use Google_Service_Classroom;

class GoogleAuthController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(config('google.client_id'));
        $this->client->setClientSecret(config('google.client_secret'));
        $this->client->setRedirectUri(config('google.redirect_uri'));
        $this->client->setScopes(config('google.scopes'));
    }

    public function redirect()
    {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(route('google.callback')); // Update this!
        $client->addScope(Google_Service_Classroom::CLASSROOM_COURSES);
        $client->setAccessType('offline');
        $client->setPrompt('consent');
    
        return redirect($client->createAuthUrl());
    }
    
 public function callback(Request $request)
{
    try {
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(route('google.callback'));
        
        // Important: Add these scopes
        $client->addScope(Google_Service_Classroom::CLASSROOM_COURSES);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        // Debug line - add this temporarily
        \Log::info('Google Token:', $token);

        // Save the credentials
        GoogleCredential::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'access_token' => $token['access_token'],
                'refresh_token' => $token['refresh_token'] ?? null,
                'expires_at' => now()->addSeconds($token['expires_in'])
            ]
        );

        return redirect()->route('google.dashboard')->with('success', 'Google account connected successfully!');

    } catch (\Exception $e) {
        // Debug line - add this temporarily
        \Log::error('Google Auth Error: ' . $e->getMessage());
        
        return redirect()->back()->with('error', 'Failed to connect Google account: ' . $e->getMessage());
    }
}






    public function dashboard()
    {
        $classrooms = GoogleClassroom::where('created_by', Auth::id())->get();
        $driveFolders = ClassDriveFolder::where('created_by', Auth::id())->get();

        return view('google.integration.index', compact('classrooms', 'driveFolders'));
    }


    
}



