<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceProposal;
use App\Models\OpdLocation;
use App\Models\MaintenanceLog;

class DashboardController extends Controller
{
    public function index()
    {
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

        $totalLocations  = OpdLocation::count();
        $emptyLocations  = OpdLocation::withCount('devices')
            ->having('devices_count', 0)
            ->count();

        // Chart: jumlah perangkat per tipe & per status
        $devicesByType   = Device::selectRaw('tipe, COUNT(*) as total')
            ->groupBy('tipe')
            ->pluck('total', 'tipe');

        $devicesByStatus = Device::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // 5 log maintenance terbaru
        $recentMaintenance = MaintenanceLog::with(['device:id,merk,model,opd_location_id', 'device.opdLocation:id,nama', 'user:id,name'])
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        // Top 10 lokasi OPD berdasarkan jumlah perangkat
        $devicesPerLocation = OpdLocation::withCount('devices')
            ->orderBy('devices_count', 'desc')
            ->limit(10)
            ->get(['id', 'nama', 'kecamatan']);

        return view('dashboard', [
            'totalDevices'       => $deviceStats->total,
            'activeDevices'      => $deviceStats->aktif,
            'replaceDevices'     => $deviceStats->perlu_diganti,
            'brokenDevices'      => $deviceStats->rusak,
            'maintenanceDevices' => $deviceStats->maintenance,
            'inactiveDevices'    => $deviceStats->nonaktif,
            'totalLocations'     => $totalLocations,
            'totalMaintenance'   => $maintenanceStats->total,
            'pendingMaintenance' => $maintenanceStats->pending,
            'totalProposals'     => $proposalStats->total,
            'pendingProposals'   => $proposalStats->pending,
            'emptyLocations'     => $emptyLocations,
            'devicesByType'      => $devicesByType,
            'devicesByStatus'    => $devicesByStatus,
            'recentMaintenance'  => $recentMaintenance,
            'devicesPerLocation' => $devicesPerLocation,
        ]);
    }
}
