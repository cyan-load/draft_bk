<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\CalendarEvent;
use App\Models\CounselingNote;
use App\Models\CounselingSession;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruCounselingController extends Controller
{
    public function index(Request $request)
    {
        $query = CounselingSession::with('student');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('initiated_by')) {
            $query->where('initiated_by', $request->initiated_by);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('topic', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('nama', 'like', "%{$search}%")
                         ->orWhere('nis', 'like', "%{$search}%")
                         ->orWhere('kelas', 'like', "%{$search}%");
                  });
            });
        }

        $counselings = $query->orderBy('preferred_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $students = Student::where('status', 'aktif')->orderBy('nama')->get();

        $counts = [
            'total' => CounselingSession::count(),
            'menunggu' => CounselingSession::where('status', 'menunggu')->count(),
            'disetujui' => CounselingSession::where('status', 'disetujui')->count(),
            'dijadwalkan_ulang' => CounselingSession::where('status', 'dijadwalkan ulang')->count(),
            'selesai' => CounselingSession::where('status', 'selesai')->count(),
            'ditolak' => CounselingSession::where('status', 'ditolak')->count(),
        ];

        $preselectedStudentId = $request->get('student_id');

        return view('guru.counseling.index', compact('counselings', 'students', 'counts', 'preselectedStudentId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'category' => 'required|string|in:Pribadi,Belajar,Karir,Karier,Sosial',
            'topic' => 'required|string',
            'preferred_date' => 'required|date',
            'preferred_time' => 'required|string',
            'room_or_media' => 'nullable|string',
        ]);

        $category = in_array($request->category, ['Karir', 'Karier']) ? 'Karir' : $request->category;
        $targetDate = $request->preferred_date;
        $targetTime = $request->preferred_time;

        // 1. Cek bentrok di tabel CalendarEvent (hanya agenda umum, bukan phantom konseling)
        $conflictEvent = CalendarEvent::whereDate('event_date', $targetDate)
            ->where('start_time', $targetTime)
            ->where('category', '!=', 'Konseling Individu')
            ->first();

        // 2. Cek bentrok di tabel CounselingSession yang sudah aktif
        $conflictCounseling = CounselingSession::with('student')
            ->whereDate('preferred_date', $targetDate)
            ->where('preferred_time', $targetTime)
            ->whereIn('status', ['disetujui', 'dijadwalkan ulang'])
            ->first();

        if ($conflictEvent || $conflictCounseling) {
            $conflictName = $conflictEvent ? $conflictEvent->title : ('Konseling dengan ' . ($conflictCounseling->student->nama ?? 'Siswa lain'));
            return back()->withInput()->with('error', "Jadwal bentrok! Sudah ada agenda/konseling lain: \"{$conflictName}\" pada tanggal " . date('d M Y', strtotime($targetDate)) . " pukul {$targetTime}. Silakan pilih waktu atau hari yang berbeda.");
        }

        $student = Student::with('user')->findOrFail($request->student_id);

        $session = CounselingSession::create([
            'student_id' => $student->id,
            'guru_id' => Auth::id(),
            'category' => $category,
            'topic' => $request->topic,
            'preferred_date' => $request->preferred_date,
            'preferred_time' => $request->preferred_time,
            'room_or_media' => $request->room_or_media ?? 'Ruang BK',
            'status' => 'disetujui',
            'initiated_by' => 'guru',
        ]);

        // Kirim Notifikasi Sistem ke Siswa
        if ($student->user) {
            AppNotification::create([
                'user_id' => $student->user->id,
                'title' => 'Jadwal Konseling Ditetapkan oleh Guru BK',
                'message' => 'Guru BK telah menjadwalkan sesi konseling untuk Anda pada ' . date('d M Y', strtotime($request->preferred_date)) . ' pukul ' . $request->preferred_time . ' di ' . ($request->room_or_media ?? 'Ruang BK'),
                'url' => '/siswa/counseling',
                'type' => 'counseling',
            ]);
        }

        return redirect()->route('guru.counseling.index')->with('success', 'Inisiasi konseling berhasil dibuat, dijadwalkan ke Kalender BK, dan siswa telah dinotifikasi!');
    }

    public function updateStatus(Request $request, $id = null)
    {
        $id = (!empty($id) && $id !== '0' && $id !== 'null') ? $id : $request->counseling_id;
        $counseling = CounselingSession::findOrFail($id);

        $request->validate([
            'action' => 'required|in:approve,reject,reschedule,complete',
            'preferred_date' => 'nullable|date',
            'preferred_time' => 'nullable|string',
            'room_or_media' => 'nullable|string',
            'rejection_reason' => 'nullable|string',
            'rescheduled_reason' => 'nullable|string',
            'counselor_notes' => 'nullable|string',
            'follow_up' => 'nullable|string',
        ]);

        $action = $request->action;
        $student = $counseling->student;

        if ($action === 'approve') {
            $targetDate = $request->preferred_date ?? ($counseling->preferred_date ? $counseling->preferred_date->format('Y-m-d') : date('Y-m-d'));
            $targetTime = $request->preferred_time ?? $counseling->preferred_time;

            // Cek bentrok jadwal lain
            $conflictEvent = CalendarEvent::whereDate('event_date', $targetDate)
                ->where('start_time', $targetTime)
                ->where('category', '!=', 'Konseling Individu')
                ->first();

            $conflictCounseling = CounselingSession::with('student')
                ->where('id', '!=', $counseling->id)
                ->whereDate('preferred_date', $targetDate)
                ->where('preferred_time', $targetTime)
                ->whereIn('status', ['disetujui', 'dijadwalkan ulang'])
                ->first();

            if ($conflictEvent || $conflictCounseling) {
                $conflictName = $conflictEvent ? $conflictEvent->title : ('Konseling dengan ' . ($conflictCounseling->student->nama ?? 'Siswa lain'));
                return back()->withInput()->with('error', "Persetujuan gagal karena jadwal bentrok! Sudah ada kegiatan: \"{$conflictName}\" pada tanggal " . date('d M Y', strtotime($targetDate)) . " pukul {$targetTime}. Silakan sesuaikan waktu persetujuan.");
            }

            $counseling->update([
                'status' => 'disetujui',
                'guru_id' => Auth::id(),
                'preferred_date' => $targetDate,
                'preferred_time' => $targetTime,
                'room_or_media' => $request->room_or_media ?? ($counseling->room_or_media ?? 'Ruang BK'),
            ]);

            if ($student && $student->user) {
                AppNotification::create([
                    'user_id' => $student->user->id,
                    'title' => 'Pengajuan Konseling Disetujui',
                    'message' => 'Jadwal konseling Anda telah disetujui pada ' . ($counseling->preferred_date ? $counseling->preferred_date->format('d M Y') : 'segera') . ' pukul ' . $counseling->preferred_time . ' di ' . $counseling->room_or_media,
                    'url' => '/siswa/counseling',
                    'type' => 'counseling',
                ]);
            }
            $msg = 'Pengajuan konseling berhasil disetujui dan jadwal telah masuk ke sistem!';
        } elseif ($action === 'reschedule') {
            $targetDate = $request->preferred_date;
            $targetTime = $request->preferred_time;

            if (!$targetDate || !$targetTime) {
                return back()->with('error', 'Tanggal dan jam baru harus diisi untuk menjadwalkan ulang.');
            }

            // Cek bentrok jadwal lain
            $conflictEvent = CalendarEvent::whereDate('event_date', $targetDate)
                ->where('start_time', $targetTime)
                ->where('category', '!=', 'Konseling Individu')
                ->first();

            $conflictCounseling = CounselingSession::with('student')
                ->where('id', '!=', $counseling->id)
                ->whereDate('preferred_date', $targetDate)
                ->where('preferred_time', $targetTime)
                ->whereIn('status', ['disetujui', 'dijadwalkan ulang'])
                ->first();

            if ($conflictEvent || $conflictCounseling) {
                $conflictName = $conflictEvent ? $conflictEvent->title : ('Konseling dengan ' . ($conflictCounseling->student->nama ?? 'Siswa lain'));
                return back()->withInput()->with('error', "Jadwal bentrok! Sudah ada kegiatan: \"{$conflictName}\" pada tanggal " . date('d M Y', strtotime($targetDate)) . " pukul {$targetTime}. Silakan pilih waktu yang berbeda.");
            }

            $counseling->update([
                'status' => 'dijadwalkan ulang',
                'guru_id' => Auth::id(),
                'preferred_date' => $targetDate,
                'preferred_time' => $targetTime,
                'room_or_media' => $request->room_or_media ?? ($counseling->room_or_media ?? 'Ruang BK'),
                'rescheduled_reason' => $request->rescheduled_reason ?? 'Jadwal disesuaikan dengan ketersediaan ruang/waktu.',
            ]);

            if ($student && $student->user) {
                AppNotification::create([
                    'user_id' => $student->user->id,
                    'title' => 'Jadwal Konseling Dijadwalkan Ulang',
                    'message' => 'Jadwal bimbingan Anda disesuaikan menjadi ' . date('d M Y', strtotime($targetDate)) . ' pukul ' . $targetTime . ' di ' . ($request->room_or_media ?? 'Ruang BK') . '. Catatan: ' . ($request->rescheduled_reason ?? '-'),
                    'url' => '/siswa/counseling',
                    'type' => 'counseling',
                ]);
            }
            $msg = 'Jadwal konseling berhasil dijadwalkan ulang dan siswa telah menerima notifikasi!';
        } elseif ($action === 'reject') {
            $counseling->update([
                'status' => 'ditolak',
                'guru_id' => Auth::id(),
                'rejection_reason' => $request->rejection_reason ?? 'Mohon ajukan di waktu lain.',
            ]);

            if ($student && $student->user) {
                AppNotification::create([
                    'user_id' => $student->user->id,
                    'title' => 'Pengajuan Konseling Ditolak/Ditunda',
                    'message' => 'Alasan: ' . ($request->rejection_reason ?? 'Silakan ajukan waktu lain.'),
                    'url' => '/siswa/counseling',
                    'type' => 'counseling',
                ]);
            }
            $msg = 'Pengajuan konseling telah ditolak.';
        } elseif ($action === 'complete') {
            $notesText = $request->counselor_notes ?? 'Sesi konseling telah diselesaikan.';
            $followUpText = $request->follow_up ?? 'Pemantauan berkala dan tindak lanjut perkembangan siswa.';

            $counseling->update([
                'status' => 'selesai',
                'guru_id' => Auth::id(),
                'counselor_notes' => $notesText,
                'completed_at' => now(),
            ]);

            // Buat rekam catatan kasus / layanan siswa
            CounselingNote::create([
                'student_id' => $student->id,
                'guru_id' => Auth::id(),
                'tanggal' => $counseling->preferred_date ?? now(),
                'kategori' => $counseling->category ?? 'Pribadi',
                'keluhan_masalah' => $counseling->topic ?? 'Konseling Bimbingan',
                'layanan_diberikan' => $notesText,
                'tindak_lanjut_evaluasi' => $followUpText,
                'status' => 'Selesai / Teratasi',
            ]);

            if ($student && $student->user) {
                AppNotification::create([
                    'user_id' => $student->user->id,
                    'title' => 'Sesi Konseling Selesai',
                    'message' => 'Sesi konseling telah selesai dilaksanakan. Terima kasih telah berkonsultasi dengan Guru BK.',
                    'url' => '/siswa/counseling',
                    'type' => 'counseling',
                ]);
            }
            $msg = 'Sesi konseling telah diselesaikan dan catatan hasil layanan telah tersimpan ke Rekam Kasus!';
        }

        return redirect()->route('guru.counseling.index')->with('success', $msg);
    }

    public function destroy($id)
    {
        $counseling = CounselingSession::findOrFail($id);
        $counseling->delete();

        return redirect()->route('guru.counseling.index')->with('success', 'Data sesi konseling berhasil dihapus!');
    }
}
