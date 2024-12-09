<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
                'editable' => Gate::allows('update', $event)
            ];
        });
     
        if ($request->wantsJson()) {
            return response()->json($events);
        }
        return view('calendar', compact('events','users'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

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
        $this->authorize('update', $event);

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
        $event = Event::findOrFail($id);
        $this->authorize('delete', $event);

        $event->delete();

        return response()->json(['message' => 'Event deleted']);
    }
}