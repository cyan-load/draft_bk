<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('title');
            $table->text('content');
            $table->string('category')->default('Informasi'); // Informasi, Beasiswa, Akademik, Karir, Layanan
            $table->string('target_kelas')->default('Semua Kelas'); // Semua Kelas, X, XI, XII
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
