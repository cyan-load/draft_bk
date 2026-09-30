<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\CounselingNote;
use App\Models\ReportSetting;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounselingNoteController extends Controller
{
    public function store(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);

        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string',
            'keluhan_masalah' => 'required|string',
            'layanan_diberikan' => 'required|string',
            'tindak_lanjut_evaluasi' => 'nullable|string',
            'status' => 'required|in:Dalam Pemantauan,Selesai / Teratasi,Rujukan / Alih Tangan',
        ]);

        $note = CounselingNote::create([
            'student_id' => $student->id,
            'guru_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'keluhan_masalah' => $request->keluhan_masalah,
            'layanan_diberikan' => $request->layanan_diberikan,
            'tindak_lanjut_evaluasi' => $request->tindak_lanjut_evaluasi,
            'status' => $request->status,
        ]);

        // Create student notification
        if ($student->user) {
            AppNotification::create([
                'user_id' => $student->user->id,
                'title' => 'Catatan Bimbingan Diperbarui',
                'message' => 'Guru BK telah menambahkan catatan bimbingan pada rekam jejak konseling Anda.',
                'url' => '/siswa/counseling',
                'type' => 'note',
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'note' => $note]);
        }

        return back()->with('success', 'Catatan bimbingan siswa berhasil disimpan!');
    }

    public function update(Request $request, $studentId, $noteId)
    {
        $note = CounselingNote::where('student_id', $studentId)->findOrFail($noteId);

        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|string',
            'keluhan_masalah' => 'required|string',
            'layanan_diberikan' => 'required|string',
            'tindak_lanjut_evaluasi' => 'nullable|string',
            'status' => 'required|in:Dalam Pemantauan,Selesai / Teratasi,Rujukan / Alih Tangan',
        ]);

        $note->update([
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'keluhan_masalah' => $request->keluhan_masalah,
            'layanan_diberikan' => $request->layanan_diberikan,
            'tindak_lanjut_evaluasi' => $request->tindak_lanjut_evaluasi,
            'status' => $request->status,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'note' => $note]);
        }

        return back()->with('success', 'Catatan bimbingan berhasil diperbarui!');
    }

    public function destroy($studentId, $noteId)
    {
        $note = CounselingNote::where('student_id', $studentId)->findOrFail($noteId);
        $note->delete();

        return back()->with('success', 'Catatan bimbingan berhasil dihapus.');
    }

    // Tampilan Cetak / Print PDF Rekam Catatan Siswa
    public function printNotes(Request $request, $studentId)
    {
        $student = Student::with(['user', 'counselingNotes.counselor'])->findOrFail($studentId);
        $setting = ReportSetting::getSetting();

        // Allow overriding via query parameters for on-the-fly customized printing
        $customSchoolName = $request->query('school_name', $setting->school_name);
        $customAddress = $request->query('school_address', $setting->school_address);
        $customPhone = $request->query('school_phone', $setting->school_phone);
        $customEmail = $request->query('school_email', $setting->school_email);
        $customHeadmaster = $request->query('headmaster_name', $setting->headmaster_name);
        $customHeadmasterNip = $request->query('headmaster_nip', $setting->headmaster_nip);
        $customCounselor = $request->query('counselor_name', $setting->counselor_name);
        $customCounselorNip = $request->query('counselor_nip', $setting->counselor_nip);
        $customCityDate = $request->query('city_date', $setting->city_date);

        $selectedNoteId = $request->query('note_id');
        $notes = $selectedNoteId 
            ? $student->counselingNotes->where('id', $selectedNoteId)
            : $student->counselingNotes;

        return view('guru.students.print-notes', compact(
            'student',
            'notes',
            'setting',
            'customSchoolName',
            'customAddress',
            'customPhone',
            'customEmail',
            'customHeadmaster',
            'customHeadmasterNip',
            'customCounselor',
            'customCounselorNip',
            'customCityDate'
        ));
    }

    // Update default report settings
    public function updateReportSettings(Request $request)
    {
        $setting = ReportSetting::getSetting();
        $setting->update($request->only([
            'school_name',
            'school_address',
            'school_phone',
            'school_email',
            'school_website',
            'headmaster_name',
            'headmaster_nip',
            'counselor_name',
            'counselor_nip',
            'city_date',
        ]));

        return back()->with('success', 'Pengaturan template cetak laporan berhasil disimpan!');
    }
}
