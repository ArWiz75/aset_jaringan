<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceLog;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MaintenanceLogController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceLog::with(['device.opdLocation', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('device', function ($dq) use ($search) {
                      $dq->where('merk', 'like', "%{$search}%")
                         ->orWhere('nomor_seri', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs = $query->orderBy('tanggal', 'desc')->paginate(15);

        // Cache statistik maintenance status
        $stats = Cache::remember('maintenance_status_counts', 30, function () {
            $raw = MaintenanceLog::selectRaw('
                COUNT(*) as total,
                SUM(status = "Selesai") as selesai,
                SUM(status = "Pending") as pending,
                SUM(status = "Dalam Proses") as dalam_proses
            ')->first();

            return [
                'total'        => (int) ($raw->total ?? 0),
                'selesai'      => (int) ($raw->selesai ?? 0),
                'pending'      => (int) ($raw->pending ?? 0),
                'dalam_proses' => (int) ($raw->dalam_proses ?? 0),
            ];
        });

        $totalLogs   = $stats['total'];
        $selesai     = $stats['selesai'];
        $pending     = $stats['pending'];
        $dalamProses = $stats['dalam_proses'];

        return view('maintenance-logs.index', compact('logs', 'totalLogs', 'selesai', 'pending', 'dalamProses'));
    }

    public function create(Request $request)
    {
        $devices = Cache::remember('devices_maintenance_dropdown', 60, function () {
            return Device::with('opdLocation:id,nama')->orderBy('merk')->get(['id', 'merk', 'model', 'tipe', 'opd_location_id']);
        });
        $selectedDeviceId = $request->get('device_id');
        return view('maintenance-logs.create', compact('devices', 'selectedDeviceId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'jenis' => 'required|in:Perbaikan,Penggantian,Konfigurasi,Preventif',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'biaya' => 'nullable|numeric|min:0',
            'status' => 'required|in:Selesai,Pending,Dalam Proses',
            'catatan' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        MaintenanceLog::create($validated);

        return redirect()->route('maintenance-logs.index')
            ->with('success', 'Log maintenance berhasil ditambahkan.');
    }

    public function show(MaintenanceLog $maintenanceLog)
    {
        $maintenanceLog->load(['device.opdLocation', 'user']);
        return view('maintenance-logs.show', compact('maintenanceLog'));
    }

    public function edit(MaintenanceLog $maintenanceLog)
    {
        $devices = Device::with('opdLocation:id,nama')->orderBy('merk')->get(['id', 'merk', 'model', 'tipe', 'opd_location_id']);
        return view('maintenance-logs.edit', compact('maintenanceLog', 'devices'));
    }

    public function update(Request $request, MaintenanceLog $maintenanceLog)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'jenis' => 'required|in:Perbaikan,Penggantian,Konfigurasi,Preventif',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'biaya' => 'nullable|numeric|min:0',
            'status' => 'required|in:Selesai,Pending,Dalam Proses',
            'catatan' => 'nullable|string',
        ]);

        $maintenanceLog->update($validated);

        return redirect()->route('maintenance-logs.index')
            ->with('success', 'Data sudah berhasil dirubah.');
    }

    public function destroy(MaintenanceLog $maintenanceLog)
    {
        $maintenanceLog->delete();

        return redirect()->route('maintenance-logs.index')
            ->with('success', 'Log maintenance berhasil dihapus.');
    }
}
