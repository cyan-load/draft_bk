<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            // Berelasi dengan tabel questionnaires
            $table->foreignId('questionnaire_id')->constrained('questionnaires')->onDelete('cascade');
            
            $table->text('teks_pertanyaan');
            $table->string('tipe_jawaban'); // single_choice, multichoice, text
            $table->string('aspek')->nullable(); // Pribadi, Sosial, Belajar, Karier (Dibuat nullable)
            $table->boolean('is_wajib')->default(1); // 1 = Wajib, 0 = Opsional
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
}