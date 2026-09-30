<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('counseling_notes', function (Blueprint $table) {
            $table->string('status')->default('Dalam Pemantauan')->change();
        });
    }

    public function down(): void
    {
        Schema::table('counseling_notes', function (Blueprint $table) {
            $table->enum('status', ['Dalam Pemantauan', 'Selesai / Teratasi', 'Rujukan / Alih Tangan'])->default('Dalam Pemantauan')->change();
        });
    }
};
