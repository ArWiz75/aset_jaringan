<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_location_id')->constrained('opd_locations')->onDelete('cascade');
            $table->string('merk');
            $table->enum('tipe', ['Router', 'Switch', 'Access Point', 'Modem', 'Server', 'Firewall', 'Lainnya']);
            $table->string('model')->nullable();
            $table->string('nomor_seri')->unique();
            $table->string('ip_address')->nullable();
            $table->enum('status', ['Aktif', 'Rusak', 'Maintenance', 'Nonaktif'])->default('Aktif');
            $table->longText('mikrotik_backup_config')->nullable();
            $table->date('tanggal_install')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
