<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        
        $events = Event::all()->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'description' => $event->description,
                'color' => $event->color,
                'editable' => $this->canModifyEvent($event)
            ];
        });
    
        if ($request->wantsJson()) {
            return response()->json($events);
        }
    
        return view('calendar', compact('events', 'users'));
    }
    
    private function canModifyEvent($event)
    {
        $user = Auth::user();
        return in_array($user->user_type, ['super_admin', 'admin']) || 
               $event->user_id === $user->id;
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->user_type, ['super_admin', 'admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $event = Event::create([
            'title' => $validatedData['title'],
            'start' => $validatedData['start'],
            'end' => $validatedData['end'],
            'description' => $validatedData['description'] ?? null,
            'color' => $validatedData['color'] ?? '#3788d8',
            'user_id' => auth()->id(),
        ]);

        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if (!$this->canModifyEvent($event)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'start' => 'sometimes|required|date',
            'end' => 'sometimes|required|date|after:start',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $event->update($validatedData);

        return response()->json($event);
    }
    public function destroy($id)
    {
        try {
            // Find the event by ID
            $event = Event::findOrFail($id);
    
            // Check if the user has permission to modify the event
            if (!$this->canModifyEvent($event)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
    
            // Delete the event
            $event->delete();
    
            return response()->json(['message' => 'Event deleted successfully']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Event not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting event', 'error' => $e->getMessage()], 500);
        }
    }
    

}
