<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceLog;
use App\Models\Device;
use Illuminate\Http\Request;

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

        return view('maintenance-logs.index', compact('logs'));
    }

    public function create(Request $request)
    {
        $devices = Device::with('opdLocation')->orderBy('merk')->get();
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
        $devices = Device::with('opdLocation')->orderBy('merk')->get();
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
            ->with('success', 'Log maintenance berhasil diperbarui.');
    }

    public function destroy(MaintenanceLog $maintenanceLog)
    {
        $maintenanceLog->delete();

        return redirect()->route('maintenance-logs.index')
            ->with('success', 'Log maintenance berhasil dihapus.');
    }
}
