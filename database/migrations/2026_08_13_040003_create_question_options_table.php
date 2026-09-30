<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionOptionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            // Berelasi dengan tabel questions
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            
            $table->string('teks_opsi');
            $table->integer('bobot_nilai')->default(0); // Untuk skoring otomatis
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_options');
    }
}