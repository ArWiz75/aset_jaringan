<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update enum to include 'Perlu Diganti'
        DB::statement("ALTER TABLE devices MODIFY COLUMN status ENUM('Aktif', 'Rusak', 'Maintenance', 'Perlu Diganti', 'Nonaktif') NOT NULL DEFAULT 'Aktif'");

        Schema::table('devices', function (Blueprint $table) {
            $table->text('alasan_penggantian')->nullable()->after('tanggal_rusak');
            $table->text('rekomendasi_pengganti')->nullable()->after('alasan_penggantian');
            $table->decimal('estimasi_biaya', 15, 2)->nullable()->after('rekomendasi_pengganti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['alasan_penggantian', 'rekomendasi_pengganti', 'estimasi_biaya']);
        });

        DB::statement("ALTER TABLE devices MODIFY COLUMN status ENUM('Aktif', 'Rusak', 'Maintenance', 'Nonaktif') NOT NULL DEFAULT 'Aktif'");
    }
};
