<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruCalendarController extends Controller
{
    public function index(Request $request)
    {
        $events = CalendarEvent::orderBy('event_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $todayDate = date('Y-m-d');
        $todayEvents = $events->filter(function ($e) use ($todayDate) {
            return $e->event_date->format('Y-m-d') === $todayDate;
        });

        $upcomingEvents = $events->filter(function ($e) use ($todayDate) {
            return $e->event_date->format('Y-m-d') >= $todayDate;
        })->take(5);

        return view('guru.calendar.index', compact('events', 'todayEvents', 'upcomingEvents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);

        CalendarEvent::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'event_date' => $request->event_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        return redirect()->route('guru.calendar.index')->with('success', 'Agenda kegiatan BK berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $event = CalendarEvent::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $event->update([
            'title' => $request->title,
            'event_date' => $request->event_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        return redirect()->route('guru.calendar.index')->with('success', 'Agenda kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = CalendarEvent::findOrFail($id);
        $event->delete();

        return redirect()->route('guru.calendar.index')->with('success', 'Agenda kegiatan berhasil dihapus!');
    }
}
