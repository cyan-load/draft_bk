<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Student;
use App\Models\StudentAnswer;
use App\Models\ReportSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QuestionnaireController extends Controller
{
    // Menampilkan halaman index beserta filter dan pencarian
    public function index(Request $request)
    {
        $query = Questionnaire::withCount(['questions', 'answers as respondents_count' => function($q) {
            $q->select(DB::raw('count(distinct(student_id))'));
        }]);

        // Pencarian teks (Judul atau Deskripsi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter Target Kelas
        if ($request->filled('kelas')) {
            $query->where('target_kelas', $request->kelas);
        }

        // Filter Status (Draft / Published / Finished)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $questionnaires = $query->latest()->paginate(9)->withQueryString();

        return view('guru.questionnaires.index', compact('questionnaires'));
    }

    // Menampilkan halaman pembuatan kuisioner
    public function create()
    {
        return view('guru.questionnaires.create');
    }

    // Menyimpan kuisioner baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'jenis_instrumen' => 'nullable|string|max:50',
            'deskripsi'       => 'nullable|string',
            'target_kelas'    => 'required|string',
            'status'          => 'nullable|in:draft,published,finished',
        ]);

        $status = $request->status ?? ($request->is_active ? 'published' : 'draft');

        DB::beginTransaction();
        try {
            // 1. Simpan tabel utama
            $questionnaire = Questionnaire::create([
                'judul'           => $request->judul,
                'jenis_instrumen' => $request->jenis_instrumen ?? 'IKMS',
                'deskripsi'       => $request->deskripsi,
                'target_kelas'    => $request->target_kelas,
                'status'          => $status,
                'is_active'       => $status === 'published' ? 1 : 0,
                'published'       => $status === 'published' ? 1 : 0,
            ]);

            // 2. Simpan pertanyaan & opsi
            $this->saveQuestions($questionnaire, $request->questions, $request->questions_json);

            DB::commit();
            $statusLabels = [
                'draft'     => 'disimpan sebagai Draft',
                'published' => 'berhasil Dipublikasikan',
                'finished'  => 'disimpan sebagai Selesai / Ditutup',
            ];
            $pesan = $statusLabels[$status] ?? 'berhasil disimpan';
            return redirect()->route('guru.questionnaires.index')->with('success', "Kuisioner {$pesan}!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()])->withInput();
        }
    }

    // Menampilkan detail hasil dan respon seluruh siswa yang mengisi kuisioner ini
    public function show($id)
    {
        $questionnaire = Questionnaire::with([
            'questions.options',
            'answers.student',
            'answers.question',
            'answers.option'
        ])->findOrFail($id);

        $answersByStudent = $questionnaire->answers->groupBy('student_id');

        $respondents = [];
        foreach ($answersByStudent as $studentId => $answers) {
            $firstAns = $answers->first();
            $student = $firstAns->student ?? Student::find($studentId);
            
            if ($student) {
                $totalScore = $answers->sum(function($ans) {
                    return $ans->option ? ($ans->option->bobot_nilai ?? 0) : 0;
                });

                $respondents[] = [
                    'student' => $student,
                    'filled_at' => $firstAns->created_at,
                    'total_answered' => $answers->pluck('question_id')->unique()->count(),
                    'total_score' => $totalScore,
                    'answers' => $answers->groupBy('question_id'),
                ];
            }
        }

        return view('guru.questionnaires.show', compact('questionnaire', 'respondents'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $questionnaire = Questionnaire::with('questions.options')->findOrFail($id);
        return view('guru.questionnaires.edit', compact('questionnaire'));
    }

    // Mengupdate data kuisioner
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'target_kelas' => 'required|string',
            'status'       => 'nullable|in:draft,published,finished',
        ]);

        $status = $request->status ?? ($request->is_active ? 'published' : 'draft');

        DB::beginTransaction();
        try {
            $questionnaire = Questionnaire::findOrFail($id);
            
            // 1. Update tabel utama
            $questionnaire->update([
                'judul'        => $request->judul,
                'deskripsi'    => $request->deskripsi,
                'target_kelas' => $request->target_kelas,
                'status'       => $status,
                'is_active'    => $status === 'published' ? 1 : 0,
                'published'    => $status === 'published' ? 1 : 0,
            ]);

            // 2. Hapus pertanyaan lama agar bersih, lalu buat ulang yang baru
            $questionnaire->questions()->delete(); 
            $this->saveQuestions($questionnaire, $request->questions, $request->questions_json);

            DB::commit();
            return redirect()->route('guru.questionnaires.index')->with('success', 'Kuisioner berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui: ' . $e->getMessage()])->withInput();
        }
    }

    // Mengubah status cepat (Draft / Published / Finished)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:draft,published,finished',
        ]);

        $questionnaire = Questionnaire::findOrFail($id);
        $status = $request->status;

        $questionnaire->update([
            'status'    => $status,
            'is_active' => $status === 'published' ? 1 : 0,
            'published' => $status === 'published' ? 1 : 0,
        ]);

        $statusLabels = [
            'draft'     => 'Draft (Tidak terlihat siswa)',
            'published' => 'Published (Aktif diisi siswa)',
            'finished'  => 'Finished (Ditutup / Selesai)',
        ];

        return back()->with('success', 'Status kuisioner berhasil diubah menjadi: ' . ($statusLabels[$status] ?? $status));
    }

    // Menghapus kuisioner
    public function destroy($id)
    {
        $questionnaire = Questionnaire::findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Hapus jawaban siswa terkait
            StudentAnswer::where('questionnaire_id', $id)->delete();
            
            // Hapus opsi jawaban & pertanyaan terkait
            $questions = Question::where('questionnaire_id', $id)->get();
            foreach ($questions as $q) {
                QuestionOption::where('question_id', $q->id)->delete();
                $q->delete();
            }
            
            $questionnaire->delete();
            DB::commit();

            return redirect()->route('guru.questionnaires.index')->with('success', 'Kuisioner berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus kuisioner: ' . $e->getMessage());
        }
    }

    // -------------------------------------------------------------
    // EKSPOR DATA HASIL KUISIONER KE EXCEL/CSV SEPERTI DATASET
    // Kolom: Nama, NIS, Kelas, Soal 1, Soal 2, ..., Total Skor
    // -------------------------------------------------------------
    public function exportExcel($id)
    {
        $questionnaire = Questionnaire::with([
            'questions.options',
            'answers.student',
            'answers.question',
            'answers.option'
        ])->findOrFail($id);

        $answersByStudent = $questionnaire->answers->groupBy('student_id');
        $questions = $questionnaire->questions;

        $filename = 'Dataset_Kuisioner_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $questionnaire->judul) . '_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function() use ($questionnaire, $questions, $answersByStudent) {
            $handle = fopen('php://output', 'w');
            
            // Tambahkan UTF-8 BOM agar Microsoft Excel langsung membaca aksen/format tanpa error karakter
            fputs($handle, "\xEF\xBB\xBF");

            // Header Tabel Murni Dataset (Baris 1)
            $headerRow = ['Nama Lengkap', 'NIS', 'Kelas'];
            foreach ($questions as $index => $q) {
                $headerRow[] = strip_tags($q->teks_pertanyaan);
            }
            $headerRow[] = 'Total Skor';
            fputcsv($handle, $headerRow);

            // Data Baris per Siswa (Baris 2 dst)
            foreach ($answersByStudent as $studentId => $answers) {
                $firstAns = $answers->first();
                $student = $firstAns->student ?? Student::find($studentId);

                if (!$student) continue;

                $answersGrouped = $answers->groupBy('question_id');
                $totalScore = 0;

                $row = [
                    $student->nama,
                    $student->nis,
                    $student->kelas,
                ];

                foreach ($questions as $q) {
                    $qAnswers = $answersGrouped->get($q->id);
                    if ($qAnswers && $qAnswers->isNotEmpty()) {
                        $selectedText = $qAnswers->map(function($ans) {
                            return $ans->option ? $ans->option->teks_opsi : $ans->jawaban_teks;
                        })->filter()->unique()->implode(', ');

                        $row[] = $selectedText;
                        $totalScore += $qAnswers->sum(function($ans) {
                            return $ans->option ? ($ans->option->bobot_nilai ?? 0) : 0;
                        });
                    } else {
                        $row[] = '-';
                    }
                }

                $row[] = $totalScore;
                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    // -------------------------------------------------------------
    // PRINT PDF HASIL KUISIONER SISWA (PER SISWA)
    // -------------------------------------------------------------
    public function printStudent($id, $studentId)
    {
        $questionnaire = Questionnaire::with('questions.options')->findOrFail($id);
        $student = Student::findOrFail($studentId);
        
        $answers = StudentAnswer::with(['question', 'option'])
            ->where('questionnaire_id', $id)
            ->where('student_id', $studentId)
            ->get()
            ->groupBy('question_id');

        $totalScore = $answers->flatten()->sum(function($ans) {
            return $ans->option ? ($ans->option->bobot_nilai ?? 0) : 0;
        });

        $setting = ReportSetting::getSetting();

        return view('guru.questionnaires.print-student', compact('questionnaire', 'student', 'answers', 'totalScore', 'setting'));
    }

    // -------------------------------------------------------------
    // PRINT PDF REKAPITULASI SEMUA SISWA
    // -------------------------------------------------------------
    public function printAll($id)
    {
        $questionnaire = Questionnaire::with([
            'questions.options',
            'answers.student',
            'answers.question',
            'answers.option'
        ])->findOrFail($id);

        $answersByStudent = $questionnaire->answers->groupBy('student_id');
        $setting = ReportSetting::getSetting();

        return view('guru.questionnaires.print-all', compact('questionnaire', 'answersByStudent', 'setting'));
    }

    // -------------------------------------------------------------
    // FUNGSI HELPER: Menyimpan array pertanyaan ke database
    // Mendukung array POST reguler maupun JSON string
    // -------------------------------------------------------------
    private function saveQuestions($questionnaire, $questions, $questionsJson = null)
    {
        if (empty($questions) && !empty($questionsJson)) {
            $questions = json_decode($questionsJson, true);
        }

        if (is_array($questions)) {
            foreach ($questions as $qData) {
                $teks = $qData['teks_pertanyaan'] ?? $qData['question_text'] ?? '';
                // Hanya simpan jika teks pertanyaan tidak kosong
                if (!empty(trim($teks))) {
                    
                    // Simpan Butir Pertanyaan
                    $question = Question::create([
                        'questionnaire_id' => $questionnaire->id,
                        'teks_pertanyaan'  => $teks,
                        'tipe_jawaban'     => $qData['tipe_jawaban'] ?? $qData['question_type'] ?? 'single_choice',
                        'is_wajib'         => !empty($qData['is_wajib']) || !empty($qData['is_required']) ? 1 : 0,
                        'aspek'            => $qData['aspek'] ?? $qData['category'] ?? null,
                    ]);

                    $optionsList = $qData['opsi'] ?? $qData['options'] ?? [];
                    // Simpan Opsi Jawaban (HANYA JIKA tipe jawaban adalah Pilihan Ganda / Checkbox)
                    if (in_array($question->tipe_jawaban, ['single_choice', 'multichoice']) && is_array($optionsList)) {
                        foreach ($optionsList as $oData) {
                            $teksOpsi = $oData['teks'] ?? $oData['option_text'] ?? '';
                            if (!empty(trim($teksOpsi))) {
                                QuestionOption::create([
                                    'question_id' => $question->id,
                                    'teks_opsi'   => $teksOpsi,
                                    'bobot_nilai' => $oData['bobot'] ?? $oData['score'] ?? $oData['bobot_nilai'] ?? 0,
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }

    public function preview($id)
    {
        // Mengambil kuisioner beserta pertanyaan dan opsi jawabannya
        $questionnaire = Questionnaire::with('questions.options')->findOrFail($id);
        return view('guru.questionnaires.preview', compact('questionnaire'));
    }
}