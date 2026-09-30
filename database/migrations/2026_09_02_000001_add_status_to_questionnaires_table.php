<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questionnaires', function (Blueprint $table) {
            if (!Schema::hasColumn('questionnaires', 'status')) {
                $table->string('status')->default('draft')->after('target_kelas');
            }
        });

        // Sinkronisasi data lama jika ada
        \DB::table('questionnaires')->where('is_active', 1)->orWhere('published', 1)->update(['status' => 'published']);
        \DB::table('questionnaires')->where('is_active', 0)->where('published', 0)->update(['status' => 'draft']);
    }

    public function down(): void
    {
        Schema::table('questionnaires', function (Blueprint $table) {
            if (Schema::hasColumn('questionnaires', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
