<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceProposal;
use App\Models\OpdLocation;
use App\Models\MaintenanceLog;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Cache metrik agregasi dashboard selama 30 detik untuk navigasi super cepat
        $data = Cache::remember('dashboard_metrics_data', 30, function () {
            // Satu query untuk semua stat perangkat berdasarkan status
            $deviceStats = Device::selectRaw('
                COUNT(*) as total,
                SUM(status = "Aktif") as aktif,
                SUM(status = "Perlu Diganti") as perlu_diganti,
                SUM(status = "Rusak") as rusak,
                SUM(status = "Maintenance") as maintenance,
                SUM(status = "Nonaktif") as nonaktif
            ')->first();

            // Satu query untuk semua stat maintenance
            $maintenanceStats = MaintenanceLog::selectRaw('
                COUNT(*) as total,
                SUM(status = "Pending") as pending
            ')->first();

            // Satu query untuk stat proposal
            $proposalStats = DeviceProposal::selectRaw('
                COUNT(*) as total,
                SUM(status IN ("Diusulkan","Dalam Pengadaan")) as pending
            ')->first();

            $totalLocations = OpdLocation::count();

            // Gunakan whereDoesntHave untuk efisiensi index tanpa temporary table HAVING
            $emptyLocations = OpdLocation::whereDoesntHave('devices')->count();

            // Chart: jumlah perangkat per tipe
            $devicesByType = Device::selectRaw('tipe, COUNT(*) as total')
                ->groupBy('tipe')
                ->pluck('total', 'tipe');

            // Susun devicesByStatus langsung dari deviceStats tanpa query tambahan
            $devicesByStatus = collect([
                'Aktif'         => (int) ($deviceStats->aktif ?? 0),
                'Perlu Diganti' => (int) ($deviceStats->perlu_diganti ?? 0),
                'Rusak'         => (int) ($deviceStats->rusak ?? 0),
                'Maintenance'   => (int) ($deviceStats->maintenance ?? 0),
                'Nonaktif'      => (int) ($deviceStats->nonaktif ?? 0),
            ]);

            // Top 10 lokasi OPD berdasarkan jumlah perangkat
            $devicesPerLocation = OpdLocation::withCount('devices')
                ->orderBy('devices_count', 'desc')
                ->limit(10)
                ->get(['id', 'nama', 'kecamatan']);

            return [
                'totalDevices'       => (int) ($deviceStats->total ?? 0),
                'activeDevices'      => (int) ($deviceStats->aktif ?? 0),
                'replaceDevices'     => (int) ($deviceStats->perlu_diganti ?? 0),
                'brokenDevices'      => (int) ($deviceStats->rusak ?? 0),
                'maintenanceDevices' => (int) ($deviceStats->maintenance ?? 0),
                'inactiveDevices'    => (int) ($deviceStats->nonaktif ?? 0),
                'totalLocations'     => $totalLocations,
                'totalMaintenance'   => (int) ($maintenanceStats->total ?? 0),
                'pendingMaintenance' => (int) ($maintenanceStats->pending ?? 0),
                'totalProposals'     => (int) ($proposalStats->total ?? 0),
                'pendingProposals'   => (int) ($proposalStats->pending ?? 0),
                'emptyLocations'     => $emptyLocations,
                'devicesByType'      => $devicesByType,
                'devicesByStatus'    => $devicesByStatus,
                'devicesPerLocation' => $devicesPerLocation,
            ];
        });

        // 5 log maintenance terbaru (live & cepat dengan eager loading)
        $recentMaintenance = MaintenanceLog::with(['device:id,merk,model,opd_location_id', 'device.opdLocation:id,nama', 'user:id,name'])
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', array_merge($data, [
            'recentMaintenance' => $recentMaintenance,
        ]));
    }
}
