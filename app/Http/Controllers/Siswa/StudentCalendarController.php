<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\CounselingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentCalendarController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->route('login');
        }

        // 1. Jadwal sesi konseling milik siswa ini (hanya yang sudah disetujui / dijadwalkan ulang)
        $myCounselings = CounselingSession::where('student_id', $student->id)
            ->whereIn('status', ['disetujui', 'dijadwalkan ulang'])
            ->orderBy('preferred_date', 'asc')
            ->get();

        // 2. Agenda & Kegiatan umum BK / Sekolah yang dipublikasikan (bukan konseling individu siswa lain)
        $generalEvents = CalendarEvent::where('category', '!=', 'Konseling Individu')
            ->orderBy('event_date', 'asc')
            ->get();

        // Format data gabungan untuk kalender siswa
        $calendarItems = [];

        foreach ($myCounselings as $c) {
            $statusText = $c->status === 'dijadwalkan ulang' ? 'Jadwal Ulang' : 'Terjadwal';
            $calendarItems[] = [
                'id' => 'counseling-' . $c->id,
                'title' => 'Sesi Konseling: ' . $c->category . ' (' . $statusText . ')',
                'date' => $c->preferred_date ? $c->preferred_date->format('Y-m-d') : null,
                'time' => $c->preferred_time ?? '-',
                'location' => $c->room_or_media ?? 'Ruang BK',
                'category' => 'Konseling',
                'type' => 'counseling',
                'status' => $c->status,
                'description' => $c->topic,
                'note' => $c->rescheduled_reason ?? $c->counselor_notes,
            ];
        }

        foreach ($generalEvents as $ev) {
            $calendarItems[] = [
                'id' => 'event-' . $ev->id,
                'title' => $ev->title,
                'date' => is_string($ev->event_date) ? $ev->event_date : $ev->event_date->format('Y-m-d'),
                'time' => $ev->start_time . ($ev->end_time ? ' - ' . $ev->end_time : ''),
                'location' => $ev->location ?? 'Sekolah',
                'category' => $ev->category ?? 'Agenda Umum',
                'type' => 'event',
                'status' => 'kegiatan',
                'description' => $ev->description,
                'note' => null,
            ];
        }

        return view('siswa.calendar.index', compact('student', 'calendarItems', 'myCounselings', 'generalEvents'));
    }
}
