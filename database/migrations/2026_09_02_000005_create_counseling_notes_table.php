<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counseling_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->date('tanggal')->nullable();
            $table->string('kategori')->default('Pribadi'); // Pribadi, Belajar, Karir, Sosial, Kedisiplinan
            $table->text('keluhan_masalah'); // Uraian masalah / kendala peserta didik
            $table->text('layanan_diberikan'); // Tindakan konseling / pendekatan
            $table->text('tindak_lanjut_evaluasi')->nullable(); // Rencana aksi tindak lanjut
            $table->enum('status', ['Dalam Pemantauan', 'Selesai / Teratasi', 'Rujukan / Alih Tangan'])->default('Dalam Pemantauan');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counseling_notes');
    }
};
