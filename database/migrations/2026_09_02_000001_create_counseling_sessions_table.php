<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counseling_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('category')->default('Pribadi'); // Pribadi, Belajar, Karir, Sosial
            $table->text('topic'); // Topik / Masalah / Permohonan Konseling
            $table->date('preferred_date')->nullable(); // Tanggal yang diajukan siswa / disetujui guru
            $table->string('preferred_time')->nullable(); // Waktu/Jam yang diajukan
            $table->string('room_or_media')->nullable(); // Ruang BK 1, Google Meet, dll.
            
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('counselor_notes')->nullable(); // Catatan konseling dari Guru BK
            $table->text('rejection_reason')->nullable(); // Alasan jika ditolak
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counseling_sessions');
    }
};
