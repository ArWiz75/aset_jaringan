<?php

namespace App\Http\Controllers;

use App\Models\OpdLocation;
use App\Models\OpdNetwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OpdLocationController extends Controller
{
    public function index(Request $request)
    {
        $query = OpdLocation::withCount('devices');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $locations = $query->with('networks')->orderBy('nama')->paginate(15);

        return view('opd-locations.index', compact('locations'));
    }

    public function create()
    {
        return view('opd-locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'kontak_person' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'denah_file' => 'nullable|file|mimes:jpg,jpeg,png,svg,pdf|max:5120',
            'networks' => 'nullable|array',
            'networks.*.cluster' => 'nullable|string|max:255',
            'networks.*.provider' => 'nullable|string|max:255',
            'networks.*.upload' => 'nullable|string|max:255',
            'networks.*.download' => 'nullable|string|max:255',
            'networks.*.network_ip' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('denah_file')) {
            $validated['denah_file'] = $request->file('denah_file')->store('denah_opd', 'public');
        }

        $location = OpdLocation::create($validated);

        if ($request->filled('networks')) {
            foreach ($request->networks as $network) {
                if (array_filter($network)) {
                    $location->networks()->create($network);
                }
            }
        }

        return redirect()->route('opd-locations.index')
            ->with('success', 'Lokasi OPD berhasil ditambahkan.');
    }

    public function show(Request $request, OpdLocation $opdLocation)
    {
        $opdLocation->load(['networks']);
        
        $deviceQuery = $opdLocation->devices();
        
        if ($request->filled('lokasi')) {
            $deviceQuery->where('lokasi_pemasangan', $request->lokasi);
        }
        
        $devices = $deviceQuery->orderBy('merk')->get();
        $pemasanganList = $opdLocation->devices()->whereNotNull('lokasi_pemasangan')->distinct()->pluck('lokasi_pemasangan');

        // Group devices by lokasi_pemasangan (room)
        $groupedDevices = $devices->groupBy(function ($device) {
            return $device->lokasi_pemasangan ?: 'Belum Ditentukan';
        })->sortKeys();

        return view('opd-locations.show', compact('opdLocation', 'devices', 'pemasanganList', 'groupedDevices'));
    }

    public function edit(OpdLocation $opdLocation)
    {
        $opdLocation->load('networks');
        return view('opd-locations.edit', compact('opdLocation'));
    }

    public function update(Request $request, OpdLocation $opdLocation)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'kontak_person' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'denah_file' => 'nullable|file|mimes:jpg,jpeg,png,svg,pdf|max:5120',
            'networks' => 'nullable|array',
            'networks.*.cluster' => 'nullable|string|max:255',
            'networks.*.provider' => 'nullable|string|max:255',
            'networks.*.upload' => 'nullable|string|max:255',
            'networks.*.download' => 'nullable|string|max:255',
            'networks.*.network_ip' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('denah_file')) {
            if ($opdLocation->denah_file) {
                Storage::disk('public')->delete($opdLocation->denah_file);
            }
            $validated['denah_file'] = $request->file('denah_file')->store('denah_opd', 'public');
        }

        $opdLocation->update($validated);

        $opdLocation->networks()->delete();
        if ($request->filled('networks')) {
            foreach ($request->networks as $network) {
                if (array_filter($network)) {
                    $opdLocation->networks()->create($network);
                }
            }
        }

        return redirect()->route('opd-locations.index')
            ->with('success', 'Lokasi OPD berhasil diperbarui.');
    }

    public function destroy(OpdLocation $opdLocation)
    {
        if ($opdLocation->denah_file) {
            Storage::disk('public')->delete($opdLocation->denah_file);
        }
        
        $opdLocation->delete();

        return redirect()->route('opd-locations.index')
            ->with('success', 'Lokasi OPD berhasil dihapus.');
    }
}
