<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\CounselingSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentCounselingController extends Controller
{
    public function index(Request $request)
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->route('login');
        }

        $query = CounselingSession::where('student_id', $student->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $counselings = $query->orderBy('preferred_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $counts = [
            'total' => CounselingSession::where('student_id', $student->id)->count(),
            'menunggu' => CounselingSession::where('student_id', $student->id)->where('status', 'menunggu')->count(),
            'disetujui' => CounselingSession::where('student_id', $student->id)->where('status', 'disetujui')->count(),
            'dijadwalkan_ulang' => CounselingSession::where('student_id', $student->id)->where('status', 'dijadwalkan ulang')->count(),
            'selesai' => CounselingSession::where('student_id', $student->id)->where('status', 'selesai')->count(),
            'ditolak' => CounselingSession::where('student_id', $student->id)->where('status', 'ditolak')->count(),
        ];

        return view('siswa.counseling.index', compact('student', 'counselings', 'counts'));
    }

    public function store(Request $request)
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->route('login');
        }

        $request->validate([
            'category' => 'required|string|in:Pribadi,Belajar,Karir,Sosial',
            'topic' => 'required|string|max:1000',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required|string',
        ]);

        $session = CounselingSession::create([
            'student_id' => $student->id,
            'category' => $request->category,
            'topic' => $request->topic,
            'preferred_date' => $request->preferred_date,
            'preferred_time' => $request->preferred_time,
            'status' => 'menunggu',
            'initiated_by' => 'siswa',
        ]);

        // Kirim Notifikasi Sistem ke seluruh Guru BK
        $teachers = User::where('role', 'guru')->get();
        foreach ($teachers as $teacher) {
            AppNotification::create([
                'user_id' => $teacher->id,
                'title' => 'Pengajuan Konseling Baru',
                'message' => $student->nama . ' (Kelas ' . $student->kelas . ') mengajukan konseling bidang ' . $request->category . ' untuk tanggal ' . date('d M Y', strtotime($request->preferred_date)),
                'url' => '/guru/counseling',
                'type' => 'counseling',
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'session' => $session]);
        }

        return redirect()->route('siswa.counseling.index')->with('success', 'Pengajuan konseling berhasil dikirim! Menunggu konfirmasi dari Guru BK.');
    }

    public function destroy($id)
    {
        $student = Auth::user()->student;
        $counseling = CounselingSession::where('id', $id)
            ->where('student_id', $student->id)
            ->where('status', 'menunggu')
            ->firstOrFail();

        $counseling->delete();

        return redirect()->route('siswa.counseling.index')->with('success', 'Permohonan konseling berhasil dibatalkan.');
    }
}
