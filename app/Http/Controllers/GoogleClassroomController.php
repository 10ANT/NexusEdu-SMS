<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\GoogleClassroom;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Classroom;
use App\Models\ClassDriveFolder;
use App\Models\GoogleCredential;


class GoogleClassroomController extends Controller
{
    public function index()
    {
        $classrooms = GoogleClassroom::where('created_by', Auth::id())->get();
        $driveFolders = ClassDriveFolder::where('created_by', Auth::id())->get();
        return view('google.integration.index', compact('classrooms', 'driveFolders'));
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'course_name' => 'required|string|max:255',
                'section' => 'nullable|string|max:255',
                'room' => 'nullable|string|max:255',
            ]);
    
            // Initialize Google Client
            $client = new Google_Client();
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
            $client->addScope(Google_Service_Classroom::CLASSROOM_COURSES);
    
            // Get user's Google credentials from database
            $credentials = GoogleCredential::where('user_id', Auth::id())->first();
            if (!$credentials) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google authentication required'
                ], 401);
            }
    
            // Set the access token
            $client->setAccessToken([
                'access_token' => $credentials->access_token,
                'refresh_token' => $credentials->refresh_token,
                'expires_in' => $credentials->expires_at->diffInSeconds(now()),
                'created' => strtotime($credentials->created_at)
            ]);
    
            // Auto-refresh token if expired
            if ($client->isAccessTokenExpired()) {
                try {
                    $client->fetchAccessTokenWithRefreshToken($credentials->refresh_token);
                    
                    // Get the new access token
                    $newToken = $client->getAccessToken();
                    
                    // Update the credentials in the database
                    $credentials->update([
                        'access_token' => $newToken['access_token'],
                        'expires_at' => now()->addSeconds($newToken['expires_in'])
                    ]);
                } catch (\Exception $refreshException) {
                    // If refresh fails, force re-authentication
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to refresh token. Please re-authenticate.',
                        'redirect' => route('google.redirect')
                    ], 401);
                }
            }
    
            // Create Google Classroom Service
            $service = new Google_Service_Classroom($client);
    
            // Create course
            $course = new \Google_Service_Classroom_Course([
                'name' => $request->course_name,
                'section' => $request->section,
                'room' => $request->room,
                'ownerId' => 'me'
            ]);
    
            $createdCourse = $service->courses->create($course);
    
            // Save to database
            $classroom = GoogleClassroom::create([
                'course_id' => $createdCourse->getId(),
                'name' => $request->course_name,
                'section' => $request->section,
                'room' => $request->room,
                'created_by' => Auth::id()
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Classroom created successfully',
                'data' => $classroom
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating classroom: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy($courseId)
{
    try {
        // Find the classroom
        $classroom = GoogleClassroom::where('course_id', $courseId)
            ->where('created_by', Auth::id())
            ->firstOrFail();

        // Check user's Google credentials
        $credentials = GoogleCredential::where('user_id', Auth::id())->first();
        
        if (!$credentials) {
            return response()->json([
                'success' => false,
                'message' => 'Google authentication required',
                'debug' => 'No credentials found for user'
            ], 401);
        }

        // Initialize Google Client
        $client = new Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));

        // Set access token
        try {
            $client->setAccessToken([
                'access_token' => $credentials->access_token,
                'refresh_token' => $credentials->refresh_token
            ]);
        } catch (\Exception $tokenSetError) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to set access token',
                'debug' => $tokenSetError->getMessage()
            ], 500);
        }

        // Check and refresh token if expired
        try {
            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($credentials->refresh_token);
                
                // Update tokens
                $credentials->update([
                    'access_token' => $client->getAccessToken()['access_token']
                ]);
            }
        } catch (\Exception $refreshError) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to refresh token',
                'debug' => $refreshError->getMessage()
            ], 401);
        }

        // Create Google Classroom Service
        try {
            $service = new Google_Service_Classroom($client);
        } catch (\Exception $serviceError) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Google Classroom service',
                'debug' => $serviceError->getMessage()
            ], 500);
        }

        // Delete course from Google Classroom
        try {
            $service->courses->delete($courseId);
        } catch (\Exception $deleteError) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete classroom from Google',
                'debug' => $deleteError->getMessage()
            ], 500);
        }

        // Delete from local database
        try {
            $classroom->delete();
        } catch (\Exception $dbError) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete classroom from local database',
                'debug' => $dbError->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Classroom deleted successfully'
        ]);

    } catch (\Exception $generalError) {
        return response()->json([
            'success' => false,
            'message' => 'An unexpected error occurred',
            'debug' => $generalError->getMessage()
        ], 500);
    }
}


}