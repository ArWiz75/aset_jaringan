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
        Schema::table('opd_locations', function (Blueprint $table) {
            $table->string('cluster')->nullable()->after('nama');
            $table->string('provider')->nullable()->after('cluster');
            $table->string('upload')->nullable()->after('provider');
            $table->string('download')->nullable()->after('upload');
            $table->string('network_ip')->nullable()->after('download');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opd_locations', function (Blueprint $table) {
            $table->dropColumn(['cluster', 'provider', 'upload', 'download', 'network_ip']);
        });
    }
};
