<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\OpdLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $query = Device::with('opdLocation');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                  ->orWhere('nomor_seri', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Filter by location
        if ($request->filled('opd_location_id')) {
            $query->where('opd_location_id', $request->opd_location_id);
        }

        $devices = $query->orderBy('created_at', 'desc')->paginate(15);
        $locations = OpdLocation::orderByRaw('LOWER(nama)')->get(['id', 'nama']);

        // Satu query untuk semua stat status (menggantikan 6 query terpisah)
        $rawStats = Device::selectRaw('
            COUNT(*) as total,
            SUM(status = "Aktif") as aktif,
            SUM(status = "Perlu Diganti") as perlu_diganti,
            SUM(status = "Rusak") as rusak,
            SUM(status = "Maintenance") as maintenance,
            SUM(status = "Nonaktif") as nonaktif
        ')->first();

        $statusCounts = [
            'total'         => $rawStats->total,
            'Aktif'         => $rawStats->aktif,
            'Perlu Diganti' => $rawStats->perlu_diganti,
            'Rusak'         => $rawStats->rusak,
            'Maintenance'   => $rawStats->maintenance,
            'Nonaktif'      => $rawStats->nonaktif,
        ];

        return view('devices.index', compact('devices', 'locations', 'statusCounts'));
    }

    public function create()
    {
        $locations = OpdLocation::orderByRaw('LOWER(nama)')->get(['id', 'nama']);
        return view('devices.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'opd_location_id' => 'required|exists:opd_locations,id',
            'lokasi_pemasangan' => 'nullable|string|max:255',
            'merk' => 'required|string|max:255',
            'tipe' => 'required|in:Router,Switch,Access Point,Modem,Server,Firewall,Lainnya',
            'model' => 'nullable|string|max:255',
            'nomor_seri' => 'nullable|string|max:255|unique:devices',
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:Aktif,Rusak,Maintenance,Perlu Diganti,Nonaktif',
            'mikrotik_backup_config' => 'nullable|string',
            'tanggal_install' => 'nullable|date',
            'tanggal_rusak' => 'required_if:status,Rusak|nullable|date',
            'alasan_penggantian' => 'nullable|string',
            'rekomendasi_pengganti' => 'nullable|string|max:255',
            'estimasi_biaya' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
            'foto_perangkat' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:5120',
        ]);

        if ($request->hasFile('foto_perangkat')) {
            $validated['foto_perangkat'] = $request->file('foto_perangkat')->store('foto_perangkat', 'public');
        }

        Device::create($validated);

        if ($request->has('redirect_to_opd')) {
            return redirect()->route('opd-locations.show', $request->redirect_to_opd)
                ->with('success', 'Perangkat berhasil ditambahkan.');
        }

        return redirect()->route('devices.index')
            ->with('success', 'Perangkat berhasil ditambahkan.');
    }

    public function show(Device $device)
    {
        $device->load(['opdLocation', 'maintenanceLogs.user']);
        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        $locations = OpdLocation::orderByRaw('LOWER(nama)')->get(['id', 'nama']);
        return view('devices.edit', compact('device', 'locations'));
    }

    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'opd_location_id' => 'required|exists:opd_locations,id',
            'lokasi_pemasangan' => 'nullable|string|max:255',
            'merk' => 'required|string|max:255',
            'tipe' => 'required|in:Router,Switch,Access Point,Modem,Server,Firewall,Lainnya',
            'model' => 'nullable|string|max:255',
            'nomor_seri' => 'nullable|string|max:255|unique:devices,nomor_seri,' . $device->id,
            'ip_address' => 'nullable|string|max:45',
            'status' => 'required|in:Aktif,Rusak,Maintenance,Perlu Diganti,Nonaktif',
            'mikrotik_backup_config' => 'nullable|string',
            'tanggal_install' => 'nullable|date',
            'tanggal_rusak' => 'required_if:status,Rusak|nullable|date',
            'alasan_penggantian' => 'nullable|string',
            'rekomendasi_pengganti' => 'nullable|string|max:255',
            'estimasi_biaya' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
            'foto_perangkat' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:5120',
        ]);

        if ($request->hasFile('foto_perangkat')) {
            if ($device->foto_perangkat) {
                Storage::disk('public')->delete($device->foto_perangkat);
            }
            $validated['foto_perangkat'] = $request->file('foto_perangkat')->store('foto_perangkat', 'public');
        }

        $device->update($validated);

        if ($request->has('redirect_to_opd')) {
            return redirect()->route('opd-locations.show', $request->redirect_to_opd)
                ->with('success', 'Data sudah berhasil dirubah.');
        }

        return redirect()->route('devices.index')
            ->with('success', 'Data sudah berhasil dirubah.');
    }

    /**
     * Update status penggantian perangkat dengan cepat (modal / quick action)
     */
    public function markReplacement(Request $request, Device $device)
    {
        $validated = $request->validate([
            'status' => 'required|in:Aktif,Rusak,Maintenance,Perlu Diganti,Nonaktif',
            'alasan_penggantian' => 'nullable|string',
            'rekomendasi_pengganti' => 'nullable|string|max:255',
            'estimasi_biaya' => 'nullable|numeric|min:0',
        ]);

        $device->update($validated);

        $statusText = $device->status === 'Perlu Diganti' ? 'direkomendasikan untuk diganti' : 'status berhasil diperbarui';
        return back()->with('success', "Perangkat {$device->merk} {$device->model} {$statusText}.");
    }

    public function destroy(Request $request, Device $device)
    {
        if ($device->foto_perangkat) {
            Storage::disk('public')->delete($device->foto_perangkat);
        }

        $device->delete();

        if ($request->has('redirect_to_opd')) {
            return redirect()->route('opd-locations.show', $request->redirect_to_opd)
                ->with('success', 'Perangkat berhasil dihapus.');
        }

        return redirect()->route('devices.index')
            ->with('success', 'Perangkat berhasil dihapus.');
    }
}
