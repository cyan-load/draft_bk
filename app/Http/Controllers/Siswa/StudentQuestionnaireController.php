<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentQuestionnaireController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        // Hanya tampilkan kuisioner berstatus published atau finished (Draft disembunyikan dari siswa)
        $questionnaires = Questionnaire::where(function($q) {
                $q->where('status', 'published')
                  ->orWhere('status', 'finished')
                  ->orWhere('is_active', 1)
                  ->orWhere('published', 1);
            })
            ->where(function($q) use ($student) {
                $q->where('target_kelas', 'Semua Kelas')
                  ->orWhere('target_kelas', 'like', "%{$student->kelas}%")
                  ->orWhere('target_kelas', 'like', '%' . substr($student->kelas, 0, strpos($student->kelas, '-') ?: 2) . '%');
            })
            ->latest()
            ->get();
        
        $answeredIds = StudentAnswer::where('student_id', $student->id)
            ->pluck('questionnaire_id')
            ->unique()
            ->toArray();

        return view('siswa.questionnaires.index', compact('questionnaires', 'answeredIds'));
    }

    public function show($id)
    {
        $student = Auth::user()->student;
        $questionnaire = Questionnaire::with('questions.options')->findOrFail($id);
        
        $alreadyAnswered = StudentAnswer::where('student_id', $student->id)
            ->where('questionnaire_id', $id)
            ->exists();

        if ($alreadyAnswered) {
            return redirect()->route('siswa.questionnaires.result', $id);
        }

        if ($questionnaire->status === 'finished') {
            return redirect()->route('siswa.questionnaires.index')->with('error', 'Kuisioner ini telah ditutup oleh Guru BK dan tidak dapat diisi lagi.');
        }

        if ($questionnaire->status === 'draft') {
            return redirect()->route('siswa.questionnaires.index')->with('error', 'Kuisioner ini belum dipublikasikan.');
        }

        return view('siswa.questionnaires.show', compact('questionnaire'));
    }

    public function store(Request $request, $id)
    {
        $student = Auth::user()->student;
        $questionnaire = Questionnaire::with('questions.options')->findOrFail($id);

        if ($questionnaire->status === 'finished') {
            return redirect()->route('siswa.questionnaires.index')->with('error', 'Kuisioner ini telah ditutup.');
        }

        foreach ($questionnaire->questions as $question) {
            $answerKey = 'question_' . $question->id;
            
            if ($request->has($answerKey) || $request->filled($answerKey)) {
                $answerInput = $request->input($answerKey);
                
                if (is_array($answerInput)) {
                    // Jika multiple choice checkbox: simpan setiap opsi yang dipilih agar skor terakumulasi penuh
                    foreach ($answerInput as $val) {
                        if (is_null($val) || trim($val) === '') continue;

                        $opt = $question->options->first(function($o) use ($val) {
                            return $o->id == $val || $o->teks_opsi == $val;
                        });

                        StudentAnswer::create([
                            'student_id'         => $student->id,
                            'questionnaire_id'   => $questionnaire->id,
                            'question_id'        => $question->id,
                            'question_option_id' => $opt ? $opt->id : null,
                            'jawaban_teks'       => $opt ? $opt->teks_opsi : $val,
                        ]);
                    }
                } else {
                    $val = $answerInput;
                    if (!is_null($val) && trim($val) !== '') {
                        $opt = $question->options->first(function($o) use ($val) {
                            return $o->id == $val || $o->teks_opsi == $val;
                        });

                        StudentAnswer::create([
                            'student_id'       => $student->id,
                            'questionnaire_id' => $questionnaire->id,
                            'question_id'      => $question->id,
                            'question_option_id' => $opt ? $opt->id : null,
                            'jawaban_teks'     => $opt ? $opt->teks_opsi : $val,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('siswa.questionnaires.index')->with('success', 'Kuisioner berhasil dikirim. Terima kasih!');
    }

    public function result($id)
    {
        $student = Auth::user()->student;
        $questionnaire = Questionnaire::with('questions.options')->findOrFail($id);
        
        $answers = StudentAnswer::with('option')
            ->where('student_id', $student->id)
            ->where('questionnaire_id', $id)
            ->get()
            ->groupBy('question_id');

        return view('siswa.questionnaires.result', compact('questionnaire', 'answers'));
    }
}