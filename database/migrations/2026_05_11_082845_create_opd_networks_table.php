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
        Schema::create('opd_networks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_location_id')->constrained('opd_locations')->onDelete('cascade');
            $table->string('cluster')->nullable();
            $table->string('provider')->nullable();
            $table->string('upload')->nullable();
            $table->string('download')->nullable();
            $table->string('network_ip')->nullable();
            $table->timestamps();
        });

        // Migrate existing data
        $locations = DB::table('opd_locations')->get();
        foreach ($locations as $loc) {
            // Only migrate if at least one field is filled
            if ($loc->cluster || $loc->provider || $loc->upload || $loc->download || $loc->network_ip) {
                DB::table('opd_networks')->insert([
                    'opd_location_id' => $loc->id,
                    'cluster' => $loc->cluster,
                    'provider' => $loc->provider,
                    'upload' => $loc->upload,
                    'download' => $loc->download,
                    'network_ip' => $loc->network_ip,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Drop legacy columns
        Schema::table('opd_locations', function (Blueprint $table) {
            $table->dropColumn(['cluster', 'provider', 'upload', 'download', 'network_ip']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore legacy columns first
        Schema::table('opd_locations', function (Blueprint $table) {
            $table->string('cluster')->nullable()->after('nama');
            $table->string('provider')->nullable()->after('cluster');
            $table->string('upload')->nullable()->after('provider');
            $table->string('download')->nullable()->after('upload');
            $table->string('network_ip')->nullable()->after('download');
        });

        // Move data back
        $networks = DB::table('opd_networks')->get();
        foreach ($networks as $net) {
            DB::table('opd_locations')->where('id', $net->opd_location_id)->update([
                'cluster' => $net->cluster,
                'provider' => $net->provider,
                'upload' => $net->upload,
                'download' => $net->download,
                'network_ip' => $net->network_ip,
            ]);
        }

        Schema::dropIfExists('opd_networks');
    }
};
