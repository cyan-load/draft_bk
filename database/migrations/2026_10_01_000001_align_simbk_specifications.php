<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('counseling_sessions', 'initiated_by')) {
                $table->string('initiated_by', 20)->default('siswa')->after('guru_id');
            }
            if (!Schema::hasColumn('counseling_sessions', 'rescheduled_reason')) {
                $table->text('rescheduled_reason')->nullable()->after('rejection_reason');
            }
        });

        // Ubah tipe kolom status menjadi string agar fleksibel mendukung status 'dijadwalkan ulang'
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE counseling_sessions MODIFY status VARCHAR(50) NOT NULL DEFAULT 'menunggu'");

        Schema::table('questionnaires', function (Blueprint $table) {
            if (!Schema::hasColumn('questionnaires', 'jenis_instrumen')) {
                $table->string('jenis_instrumen', 50)->default('IKMS')->after('judul');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('counseling_sessions', 'initiated_by')) {
                $table->dropColumn('initiated_by');
            }
            if (Schema::hasColumn('counseling_sessions', 'rescheduled_reason')) {
                $table->dropColumn('rescheduled_reason');
            }
        });

        Schema::table('questionnaires', function (Blueprint $table) {
            if (Schema::hasColumn('questionnaires', 'jenis_instrumen')) {
                $table->dropColumn('jenis_instrumen');
            }
        });
    }
};
