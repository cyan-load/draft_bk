<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\StudentAnswer;
use App\Models\CounselingSession;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('login');
        }

        // Ambil ID kuisioner yang sudah pernah dijawab oleh siswa ini
        $answeredQuestionnaireIds = StudentAnswer::where('student_id', $student->id)
            ->pluck('questionnaire_id')
            ->unique()
            ->toArray();

        // Kuisioner aktif yang belum diisi siswa
        $pendingQuestionnaires = Questionnaire::where('is_active', true)
            ->whereNotIn('id', $answeredQuestionnaireIds)
            ->withCount('questions')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $totalActiveQuestionnaires = Questionnaire::where('is_active', true)->count();
        $totalAnswered = count($answeredQuestionnaireIds);

        // Sesi konseling siswa
        $counselingSessions = CounselingSession::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $pendingCounselingCount = CounselingSession::where('student_id', $student->id)
            ->whereIn('status', ['menunggu', 'disetujui'])
            ->count();

        $completedCounselingCount = CounselingSession::where('student_id', $student->id)
            ->where('status', 'selesai')
            ->count();

        return view('siswa.dashboard', compact(
            'student',
            'pendingQuestionnaires',
            'totalActiveQuestionnaires',
            'totalAnswered',
            'counselingSessions',
            'pendingCounselingCount',
            'completedCounselingCount'
        ));
    }
}
