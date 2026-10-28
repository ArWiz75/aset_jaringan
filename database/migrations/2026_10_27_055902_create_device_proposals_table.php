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
        Schema::create('device_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_location_id')->constrained('opd_locations')->onDelete('cascade');
            $table->string('nama_pengusul')->nullable();
            $table->string('tipe_perangkat'); // Router, Switch, Access Point, Modem, dll.
            $table->unsignedInteger('jumlah')->default(1);
            $table->string('lokasi_ruang')->nullable(); // Ruang Rapat, Lobi, dsb.
            $table->enum('urgensi', ['Tinggi', 'Sedang', 'Rendah'])->default('Sedang');
            $table->text('alasan_kebutuhan'); // Alasan kebutuhan pengadaan
            $table->text('rekomendasi_spesifikasi')->nullable(); // Spek / merk & model rekomendasi
            $table->decimal('estimasi_biaya', 15, 2)->nullable(); // Estimasi total biaya (Rp)
            $table->enum('status', ['Diusulkan', 'Disetujui', 'Dalam Pengadaan', 'Terealisasi', 'Ditolak'])->default('Diusulkan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_proposals');
    }
};
