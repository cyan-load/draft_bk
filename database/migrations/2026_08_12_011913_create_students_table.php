<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            // Data Dasar (Wajib diisi saat Register)
            $table->string('nis')->unique();
            $table->string('email');
            $table->string('nama');
            $table->string('kelas');
            $table->text('alamat');
            $table->string('nomor_telepon');
            
            // Data Tambahan / Opsional (Tanpa kolom pekerjaan orang tua)
            $table->string('foto')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('agama')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nomor_telepon_orang_tua')->nullable(); 
            $table->string('hobi')->nullable();
            $table->string('cita_cita')->nullable();
            
            $table->enum('status', ['aktif', 'lulus', 'pindah'])->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
}