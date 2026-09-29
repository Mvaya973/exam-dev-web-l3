<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_date')->get();

        return view('events.index', [
            'events' => $events,
        ]);
    }

    public function create()
    {
        return view('events.form', [
            'event' => new Event(),
        ]);
    }

    public function store(Request $request)
    {
        $event = Event::create($this->validatedData($request));

        return redirect()
            ->route('events.edit', $event)
            ->with('success', 'L’événement a été créé.');
    }

    public function show(Event $event)
    {
        return view('events.show', [
            'event' => $event,
        ]);
    }

    public function edit(Event $event)
    {
        return view('events.form', [
            'event' => $event,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($this->validatedData($request));

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'L’événement a été modifié.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'L’événement a été supprimé.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:150'],
        ]);
    }
}
