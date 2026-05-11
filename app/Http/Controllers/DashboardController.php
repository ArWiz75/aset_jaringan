<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\OpdLocation;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDevices = Device::count();
        $activeDevices = Device::where('status', 'Aktif')->count();
        $brokenDevices = Device::where('status', 'Rusak')->count();
        $maintenanceDevices = Device::where('status', 'Maintenance')->count();
        $inactiveDevices = Device::where('status', 'Nonaktif')->count();
        $totalLocations = OpdLocation::count();
        $totalMaintenance = MaintenanceLog::count();
        $pendingMaintenance = MaintenanceLog::where('status', 'Pending')->count();

        // Device count by type for chart
        $devicesByType = Device::selectRaw('tipe, COUNT(*) as total')
            ->groupBy('tipe')
            ->pluck('total', 'tipe');

        // Device count by status for chart
        $devicesByStatus = Device::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Recent maintenance logs
        $recentMaintenance = MaintenanceLog::with(['device', 'user'])
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        // Devices per location
        $devicesPerLocation = OpdLocation::withCount('devices')
            ->orderBy('devices_count', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalDevices',
            'activeDevices',
            'brokenDevices',
            'maintenanceDevices',
            'inactiveDevices',
            'totalLocations',
            'totalMaintenance',
            'pendingMaintenance',
            'devicesByType',
            'devicesByStatus',
            'recentMaintenance',
            'devicesPerLocation'
        ));
    }
}
