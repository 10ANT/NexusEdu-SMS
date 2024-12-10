<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use App\Models\GoogleCredential;
use App\Models\GoogleClassroom;
use App\Models\ClassDriveFolder;
use Illuminate\Support\Facades\Auth;
use Google_Service_Classroom;
use Google_Service_Drive;

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
        $client->setRedirectUri(route('google.callback'));
        $client->addScope([
            Google_Service_Classroom::CLASSROOM_COURSES,
            Google_Service_Drive::DRIVE, // Add full Google Drive access
        ]);
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
            $client->addScope([
                Google_Service_Classroom::CLASSROOM_COURSES,
                Google_Service_Drive::DRIVE,
            ]);
            $client->setAccessType('offline');
            $client->setPrompt('consent');

            $token = $client->fetchAccessTokenWithAuthCode($request->code);

            // Debugging info
            \Log::info('Google Token:', $token);

            // Save credentials
            GoogleCredential::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'access_token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'] ?? null,
                    'expires_at' => now()->addSeconds($token['expires_in']),
                ]
            );

            return redirect()->route('google.dashboard')->with('success', 'Google account connected successfully!');

        } catch (\Exception $e) {
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

    public function createDriveFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            // Get Google credentials
            $credentials = GoogleCredential::where('user_id', Auth::id())->first();
            if (!$credentials) {
                return response()->json(['success' => false, 'message' => 'Google authentication required'], 401);
            }

            $client = new Google_Client();
            $client->setAccessToken($credentials->access_token);

            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($credentials->refresh_token);
                $credentials->update([
                    'access_token' => $client->getAccessToken()['access_token'],
                    'expires_at' => now()->addSeconds($client->getAccessToken()['expires_in']),
                ]);
            }

            $service = new Google_Service_Drive($client);

            $folderMetadata = new \Google_Service_Drive_DriveFile([
                'name' => $request->folder_name,
                'mimeType' => 'application/vnd.google-apps.folder',
            ]);

            $folder = $service->files->create($folderMetadata, ['fields' => 'id']);

            // Save folder details to the database
            $driveFolder = ClassDriveFolder::create([
                'folder_name' => $request->folder_name,
                'folder_id' => $folder->id,
                'description' => $request->description,
                'folder_link' => "https://drive.google.com/drive/folders/{$folder->id}",
                'created_by' => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Drive folder created successfully', 'data' => $driveFolder]);

        } catch (\Exception $e) {
            \Log::error('Google Drive Folder Error: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to create Drive folder: ' . $e->getMessage()], 500);
        }
    }


    public function getAccessToken()
{
    try {
        $credentials = GoogleCredential::where('user_id', Auth::id())->first();

        if (!$credentials) {
            return response()->json(['success' => false, 'message' => 'Google authentication required'], 401);
        }

        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(route('google.callback'));
        $client->setAccessToken($credentials->access_token);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($credentials->refresh_token);
            $credentials->update([
                'access_token' => $client->getAccessToken()['access_token'],
                'expires_at' => now()->addSeconds($client->getAccessToken()['expires_in']),
            ]);
        }

        return response()->json(['success' => true, 'access_token' => $client->getAccessToken()['access_token']]);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error fetching access token: ' . $e->getMessage()], 500);
    }
}

}
