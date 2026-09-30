<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->default('SMA NEGERI 1 KOTA BANDUNG');
            $table->string('school_address')->default('Jl. Ir. H. Juanda No. 93, Coblong, Kota Bandung, Jawa Barat 40132');
            $table->string('school_phone')->default('(022) 2503582');
            $table->string('school_email')->default('smansabandung@gmail.com');
            $table->string('school_website')->default('www.sman1bandung.sch.id');
            $table->string('headmaster_name')->default('Dr. H. Ahmad Supardi, M.Pd.');
            $table->string('headmaster_nip')->default('19720315 199802 1 003');
            $table->string('counselor_name')->default('Dra. Hj. Siti Rohmah, M.Psi.');
            $table->string('counselor_nip')->default('19800512 200501 2 006');
            $table->string('city_date')->default('Bandung');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_settings');
    }
};
