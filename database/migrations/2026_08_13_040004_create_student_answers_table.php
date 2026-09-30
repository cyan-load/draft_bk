<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAnswersTable extends Migration
{
    public function up(): void
    {
        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            // Berelasi dengan tabel students (Siswa yang mengisi)
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            
            // Relasi ini memudahkan kita saat ingin menarik laporan "Siapa saja yang mengisi kuisioner X?"
            $table->foreignId('questionnaire_id')->constrained('questionnaires')->onDelete('cascade');
            
            // Relasi ke pertanyaan
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            
            // Relasi ke opsi jawaban (Dibuat nullable karena jika pertanyaannya Esai/Teks, ini tidak akan diisi)
            $table->foreignId('question_option_id')->nullable()->constrained('question_options')->onDelete('cascade');
            
            // Kolom untuk menampung jawaban Esai/Paragraf (Dibuat nullable karena jika soalnya Pilihan Ganda, ini tidak akan diisi)
            $table->text('jawaban_teks')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_answers');
    }
}