<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menambahkan database indexes untuk kolom yang sering dipakai
 * dalam filter, search, ORDER BY, dan WHERE clause.
 *
 * Manfaat:
 * - devices.status      → filter status di DeviceController & DashboardController
 * - devices.tipe        → filter tipe di DeviceController & ExportController
 * - devices.created_at  → ORDER BY created_at DESC di DeviceController::index
 * - maintenance_logs.status  → filter & count status di MaintenanceLogController
 * - maintenance_logs.tanggal → ORDER BY tanggal DESC
 * - device_proposals.status  → filter & count di DeviceProposalController
 * - device_proposals.urgensi → filter urgensi
 * - opd_locations.nama       → ORDER BY nama (abjad)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->index('status',        'idx_devices_status');
            $table->index('tipe',          'idx_devices_tipe');
            $table->index('created_at',    'idx_devices_created_at');
        });

        Schema::table('maintenance_logs', function (Blueprint $table) {
            $table->index('status',  'idx_maint_status');
            $table->index('jenis',   'idx_maint_jenis');
            $table->index('tanggal', 'idx_maint_tanggal');
        });

        Schema::table('device_proposals', function (Blueprint $table) {
            $table->index('status',  'idx_proposals_status');
            $table->index('urgensi', 'idx_proposals_urgensi');
        });

        Schema::table('opd_locations', function (Blueprint $table) {
            $table->index('nama', 'idx_opd_nama');
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropIndex('idx_devices_status');
            $table->dropIndex('idx_devices_tipe');
            $table->dropIndex('idx_devices_created_at');
        });

        Schema::table('maintenance_logs', function (Blueprint $table) {
            $table->dropIndex('idx_maint_status');
            $table->dropIndex('idx_maint_jenis');
            $table->dropIndex('idx_maint_tanggal');
        });

        Schema::table('device_proposals', function (Blueprint $table) {
            $table->dropIndex('idx_proposals_status');
            $table->dropIndex('idx_proposals_urgensi');
        });

        Schema::table('opd_locations', function (Blueprint $table) {
            $table->dropIndex('idx_opd_nama');
        });
    }
};

