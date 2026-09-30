<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Questionnaire;
use App\Models\CounselingSession;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::where('status', 'aktif')->count();
        $activeQuestionnaires = Questionnaire::where('is_active', true)->count();
        $pendingCounseling = CounselingSession::where('status', 'menunggu')->count();
        $completedCounseling = CounselingSession::where('status', 'selesai')->count();

        $recentCounselings = CounselingSession::with('student')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $todayDate = date('Y-m-d');
        $todayEvents = CalendarEvent::whereDate('event_date', $todayDate)
            ->orderBy('start_time', 'asc')
            ->get();

        $upcomingEvents = CalendarEvent::whereDate('event_date', '>=', $todayDate)
            ->orderBy('event_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->take(4)
            ->get();

        $allEvents = CalendarEvent::orderBy('event_date', 'asc')->get();

        return view('guru.dashboard', compact(
            'totalStudents',
            'activeQuestionnaires',
            'pendingCounseling',
            'completedCounseling',
            'recentCounselings',
            'todayEvents',
            'upcomingEvents',
            'allEvents'
        ));
    }
}
