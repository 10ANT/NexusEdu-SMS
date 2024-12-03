<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use App\Models\GoogleCredential;
use App\Models\GoogleClassroom;  // Ensure this import is correct
use App\Models\ClassDriveFolder;  // Ensure this import is correct
use Illuminate\Support\Facades\Auth;

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
        return redirect($this->client->createAuthUrl());
    }

    public function callback(Request $request)
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($request->get('code'));

        GoogleCredential::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'access_token' => $token['access_token'],
                'refresh_token' => $token['refresh_token'] ?? null,
                'expires_at' => now()->addSeconds($token['expires_in'])
            ]
        );

        return redirect()->route('google.dashboard');
    }

    public function dashboard()
    {
        $classrooms = GoogleClassroom::where('created_by', Auth::id())->get();
        $driveFolders = ClassDriveFolder::where('created_by', Auth::id())->get();

        return view('google.integration.index', compact('classrooms', 'driveFolders'));
    }
}