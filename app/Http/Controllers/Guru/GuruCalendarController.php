<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\CounselingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruCalendarController extends Controller
{
    public function index(Request $request)
    {
        $rawEvents = CalendarEvent::where('category', '!=', 'Konseling Individu')
            ->orderBy('event_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $counselings = CounselingSession::with('student')
            ->whereIn('status', ['disetujui', 'dijadwalkan ulang'])
            ->orderBy('preferred_date', 'asc')
            ->get();

        $formattedEvents = collect();

        foreach ($rawEvents as $e) {
            $dateStr = is_string($e->event_date) ? $e->event_date : $e->event_date->format('Y-m-d');
            $formattedEvents->push((object)[
                'id' => 'event-' . $e->id,
                'source_id' => $e->id,
                'source_type' => 'event',
                'title' => $e->title,
                'event_date' => $e->event_date,
                'date' => $dateStr,
                'start_time' => $e->start_time,
                'end_time' => $e->end_time,
                'location' => $e->location,
                'category' => $e->category,
                'description' => $e->description,
            ]);
        }

        foreach ($counselings as $c) {
            $dateStr = $c->preferred_date ? $c->preferred_date->format('Y-m-d') : null;
            $studentName = $c->student ? $c->student->nama : 'Siswa';
            $statusLabel = $c->status === 'dijadwalkan ulang' ? ' (Jadwal Ulang)' : '';
            $desc = "Siswa: {$studentName}" . ($c->student ? " (Kelas {$c->student->kelas})" : "") . "\nTopik: {$c->topic}";
            if ($c->rescheduled_reason) {
                $desc .= "\nCatatan Jadwal Ulang: {$c->rescheduled_reason}";
            }

            $formattedEvents->push((object)[
                'id' => 'counseling-' . $c->id,
                'source_id' => $c->id,
                'source_type' => 'counseling',
                'title' => "Konseling: {$studentName}{$statusLabel}",
                'event_date' => $c->preferred_date,
                'date' => $dateStr,
                'start_time' => $c->preferred_time,
                'end_time' => null,
                'location' => $c->room_or_media ?? 'Ruang BK',
                'category' => 'Konseling',
                'description' => $desc,
            ]);
        }

        $events = $formattedEvents->sortBy('date')->values();

        $todayDate = date('Y-m-d');
        $todayEvents = $events->filter(function ($e) use ($todayDate) {
            return $e->date === $todayDate;
        });

        $upcomingEvents = $events->filter(function ($e) use ($todayDate) {
            return $e->date >= $todayDate;
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

        if ($request->filled('start_time')) {
            $conflict = \App\Services\ScheduleConflictService::checkConflict(
                $request->event_date,
                $request->start_time,
                $request->end_time
            );

            if ($conflict) {
                return back()->withInput()->with('error', "Peringatan Jadwal Bentrok! {$conflict['message']} Silakan pilih jam atau tanggal yang berbeda.");
            }
        }

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

        if ($request->filled('start_time')) {
            $conflict = \App\Services\ScheduleConflictService::checkConflict(
                $request->event_date,
                $request->start_time,
                $request->end_time,
                ['event_id' => $event->id]
            );

            if ($conflict) {
                return back()->withInput()->with('error', "Peringatan Jadwal Bentrok! {$conflict['message']} Silakan pilih jam atau tanggal yang berbeda.");
            }
        }

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

    public function checkConflictApi(Request $request)
    {
        $date = $request->get('date');
        $startTime = $request->get('start_time');
        $endTime = $request->get('end_time');
        $excludeEventId = $request->get('exclude_event_id');
        $excludeCounselingId = $request->get('exclude_counseling_id');

        if (!$date || !$startTime) {
            return response()->json(['has_conflict' => false]);
        }

        $conflict = \App\Services\ScheduleConflictService::checkConflict(
            $date,
            $startTime,
            $endTime,
            [
                'event_id' => $excludeEventId,
                'counseling_id' => $excludeCounselingId,
            ]
        );

        if ($conflict) {
            return response()->json([
                'has_conflict' => true,
                'conflict' => $conflict,
                'message' => $conflict['message'],
            ]);
        }

        return response()->json([
            'has_conflict' => false,
            'conflict' => null,
            'message' => null,
        ]);
    }

    public function destroy($id)
    {
        $event = CalendarEvent::findOrFail($id);
        $event->delete();

        return redirect()->route('guru.calendar.index')->with('success', 'Agenda kegiatan berhasil dihapus!');
    }
}
