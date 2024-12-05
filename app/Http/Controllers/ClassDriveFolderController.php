<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ClassDriveFolder;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;
use App\Models\GoogleCredential;

class ClassDriveFolderController extends Controller
{
    public function create(Request $request)
{
    try {
        $request->validate([
            'folder_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000'
        ]);

        // Get user's Google credentials
        $credentials = GoogleCredential::where('user_id', Auth::id())->first();
        
        if (!$credentials) {
            return response()->json([
                'success' => false,
                'message' => 'Google authentication required'
            ], 401);
        }

        // Initialize Google Client
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope([
            Google_Service_Drive::DRIVE,  // Full access to Drive
            Google_Service_Drive::DRIVE_FILE // Access to files created or opened by the app
        ]);
        $client->setAccessToken([
            'access_token' => $credentials->access_token,
            'refresh_token' => $credentials->refresh_token,
            'expires_in' => $credentials->expires_at->diffInSeconds(now()),
            'created' => strtotime($credentials->created_at)
        ]);

        // Refresh token if expired
        if ($client->isAccessTokenExpired()) {
            try {
                $client->fetchAccessTokenWithRefreshToken($credentials->refresh_token);
                
                // Update tokens
                $credentials->update([
                    'access_token' => $client->getAccessToken()['access_token'],
                    'expires_at' => now()->addSeconds($client->getAccessToken()['expires_in'])
                ]);
            } catch (\Exception $refreshException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to refresh token. Please re-authenticate.',
                    'redirect' => route('google.redirect')
                ], 401);
            }
        }

        // Create Google Drive Service
        $service = new Google_Service_Drive($client);

        // Create folder metadata
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $request->folder_name,
            'mimeType' => 'application/vnd.google-apps.folder'
        ]);

        // Create the folder in Google Drive
        $folder = $service->files->create($fileMetadata, [
            'fields' => 'id'
        ]);

        // Save to local database
        $driveFolder = ClassDriveFolder::create([
            'folder_name' => $request->folder_name,
            'folder_id' => $folder->id,
            'description' => $request->description,
            'folder_link' => "https://drive.google.com/drive/folders/{$folder->id}",
            'created_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Drive folder created successfully',
            'data' => $driveFolder
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to create drive folder: ' . $e->getMessage(),
            'redirect' => route('google.redirect')
        ], 500);
    }
}

public function redirect(Request $request)
{
    $client = new Google_Client();
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
    $client->addScope([
        Google_Service_Drive::DRIVE,
        Google_Service_Drive::DRIVE_FILE
    ]);

    if ($request->has('code')) {
        $client->authenticate($request->input('code'));
        $token = $client->getAccessToken();
        GoogleCredential::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'access_token' => $token['access_token'],
                'refresh_token' => $token['refresh_token'],
                'expires_at' => now()->addSeconds($token['expires_in']),
                'created_at' => now(),
            ]
        );
        return redirect()->route('google-integration'); // Replace with your target route
    } else {
        $authUrl = $client->createAuthUrl();
        return redirect()->away($authUrl);
    }
}


}



