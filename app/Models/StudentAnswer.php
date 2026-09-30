<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;

    // Menegaskan nama tabel di database secara eksplisit agar aman
    protected $table = 'student_answers';

    // Mengizinkan kolom-kolom ini diisi data (Mass Assignment)
    protected $fillable = [
        'student_id',
        'questionnaire_id',
        'question_id',
        'question_option_id',
        'jawaban_teks',
    ];

    // Relasi: Jawaban ini milik satu siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi: Jawaban ini terhubung ke kuisioner tertentu
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    // Relasi: Jawaban ini terhubung ke butir pertanyaan tertentu
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relasi: Jawaban ini terhubung ke opsi yang dipilih (jika pilihan ganda)
    public function option()
    {
        return $this->belongsTo(QuestionOption::class, 'question_option_id');
    }

    public function selectedOption()
    {
        return $this->belongsTo(QuestionOption::class, 'question_option_id');
    }
}