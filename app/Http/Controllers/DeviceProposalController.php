<?php

namespace App\Http\Controllers;

use App\Models\DeviceProposal;
use App\Models\OpdLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceProposalController extends Controller
{
    /**
     * Tampilkan daftar usulan penambahan perangkat beserta deteksi OPD belum berinternet.
     */
    public function index(Request $request)
    {
        $query = DeviceProposal::with('opdLocation');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter urgensi
        if ($request->filled('urgensi')) {
            $query->where('urgensi', $request->urgensi);
        }

        // Filter OPD
        if ($request->filled('opd_location_id')) {
            $query->where('opd_location_id', $request->opd_location_id);
        }

        // Filter tipe perangkat
        if ($request->filled('tipe_perangkat')) {
            $query->where('tipe_perangkat', $request->tipe_perangkat);
        }

        // Search text
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('alasan_kebutuhan', 'like', "%{$q}%")
                    ->orWhere('rekomendasi_spesifikasi', 'like', "%{$q}%")
                    ->orWhere('lokasi_ruang', 'like', "%{$q}%")
                    ->orWhere('nama_pengusul', 'like', "%{$q}%")
                    ->orWhereHas('opdLocation', function ($opd) use ($q) {
                        $opd->where('nama', 'like', "%{$q}%");
                    });
            });
        }

        $proposals = $query->latest()->paginate(15)->withQueryString();

        // Statistik Utama
        $totalUsulan = DeviceProposal::count();
        $totalUnit = DeviceProposal::sum('jumlah');
        $totalBiaya = DeviceProposal::sum('estimasi_biaya');
        $pendingUsulan = DeviceProposal::whereIn('status', ['Diusulkan', 'Dalam Pengadaan'])->count();
        $disetujuiUsulan = DeviceProposal::where('status', 'Disetujui')->count();

        // DETEKSI OTOMATIS: OPD yang BELUM memiliki perangkat internet sama sekali (devices_count == 0)
        $emptyOpds = OpdLocation::withCount(['devices', 'networks'])
            ->having('devices_count', 0)
            ->get();

        // Daftar semua OPD untuk dropdown form & filter
        $opdLocations = OpdLocation::orderBy('nama')->get();

        $tipeList = [
            'Router',
            'Switch',
            'Access Point',
            'Modem',
            'Firewall',
            'Server',
            'Converter FO',
            'Kabel & Aksesoris',
            'Lainnya',
        ];

        return view('device-proposals.index', compact(
            'proposals',
            'totalUsulan',
            'totalUnit',
            'totalBiaya',
            'pendingUsulan',
            'disetujuiUsulan',
            'emptyOpds',
            'opdLocations',
            'tipeList'
        ));
    }

    /**
     * Simpan usulan penambahan perangkat baru.
     */
    public function store(Request $request)
    {
        // Bersihkan formatting biaya jika ada input karakter non-angka (seperti Rp atau titik)
        if ($request->filled('estimasi_biaya') && is_string($request->estimasi_biaya)) {
            $cleanedBiaya = preg_replace('/[^0-9]/', '', $request->estimasi_biaya);
            $request->merge(['estimasi_biaya' => $cleanedBiaya !== '' ? (int)$cleanedBiaya : null]);
        }

        $validated = $request->validate([
            'opd_location_id' => 'required|exists:opd_locations,id',
            'tipe_perangkat' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'lokasi_ruang' => 'nullable|string|max:255',
            'urgensi' => 'required|in:Tinggi,Sedang,Rendah',
            'alasan_kebutuhan' => 'required|string',
            'rekomendasi_spesifikasi' => 'nullable|string',
            'estimasi_biaya' => 'nullable|numeric|min:0',
            'nama_pengusul' => 'nullable|string|max:255',
            'status' => 'nullable|in:Diusulkan,Disetujui,Dalam Pengadaan,Terealisasi,Ditolak',
            'catatan' => 'nullable|string',
        ]);

        if (empty($validated['nama_pengusul']) && Auth::check()) {
            $validated['nama_pengusul'] = Auth::user()->name;
        }

        if (empty($validated['status'])) {
            $validated['status'] = 'Diusulkan';
        }

        DeviceProposal::create($validated);

        return redirect()->route('device-proposals.index')->with('success', 'Usulan penambahan perangkat berhasil diajukan dan tercatat ke sistem.');
    }

    /**
     * Update usulan penambahan perangkat.
     */
    public function update(Request $request, DeviceProposal $deviceProposal)
    {
        if ($request->filled('estimasi_biaya') && is_string($request->estimasi_biaya)) {
            $cleanedBiaya = preg_replace('/[^0-9]/', '', $request->estimasi_biaya);
            $request->merge(['estimasi_biaya' => $cleanedBiaya !== '' ? (int)$cleanedBiaya : null]);
        }

        $validated = $request->validate([
            'opd_location_id' => 'required|exists:opd_locations,id',
            'tipe_perangkat' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'lokasi_ruang' => 'nullable|string|max:255',
            'urgensi' => 'required|in:Tinggi,Sedang,Rendah',
            'alasan_kebutuhan' => 'required|string',
            'rekomendasi_spesifikasi' => 'nullable|string',
            'estimasi_biaya' => 'nullable|numeric|min:0',
            'status' => 'required|in:Diusulkan,Disetujui,Dalam Pengadaan,Terealisasi,Ditolak',
            'catatan' => 'nullable|string',
        ]);

        $deviceProposal->update($validated);

        return redirect()->back()->with('success', 'Usulan penambahan perangkat berhasil diperbarui.');
    }

    /**
     * Update cepat status usulan (misal persetujuan pimpinan).
     */
    public function updateStatus(Request $request, DeviceProposal $deviceProposal)
    {
        $validated = $request->validate([
            'status' => 'required|in:Diusulkan,Disetujui,Dalam Pengadaan,Terealisasi,Ditolak',
            'catatan' => 'nullable|string',
        ]);

        $deviceProposal->update($validated);

        return redirect()->back()->with('success', 'Status usulan berhasil diperbarui menjadi: ' . $deviceProposal->status);
    }

    /**
     * Hapus usulan.
     */
    public function destroy(DeviceProposal $deviceProposal)
    {
        $deviceProposal->delete();

        return redirect()->back()->with('success', 'Usulan penambahan perangkat berhasil dihapus.');
    }

    /**
     * Quick-propose paket starter kit internet untuk OPD yang belum memiliki perangkat.
     */
    public function quickProposeEmptyOpd(Request $request, OpdLocation $opdLocation)
    {
        $userName = Auth::check() ? Auth::user()->name : 'Admin DISKOMINFO';

        // 1. Router Utama
        DeviceProposal::create([
            'opd_location_id' => $opdLocation->id,
            'nama_pengusul' => $userName,
            'tipe_perangkat' => 'Router',
            'jumlah' => 1,
            'lokasi_ruang' => 'Ruang Server / Ruang Administrasi Utama',
            'urgensi' => 'Tinggi',
            'alasan_kebutuhan' => 'OPD ' . $opdLocation->nama . ' belum memiliki perangkat jaringan internet sama sekali. Diperlukan Router Gateway utama untuk distribusi koneksi OPD.',
            'rekomendasi_spesifikasi' => 'MikroTik RB4011iGS+RM atau setara (Gigabit, Multi-port)',
            'estimasi_biaya' => 3500000,
            'status' => 'Diusulkan',
            'catatan' => 'Paket Usulan Pengadaan Jaringan Baru (Auto-Generated)'
        ]);

        // 2. Switch Distribusi
        DeviceProposal::create([
            'opd_location_id' => $opdLocation->id,
            'nama_pengusul' => $userName,
            'tipe_perangkat' => 'Switch',
            'jumlah' => 1,
            'lokasi_ruang' => 'Panel Distribusi Lantai Utama',
            'urgensi' => 'Tinggi',
            'alasan_kebutuhan' => 'Distribusi koneksi LAN kabel ke ruang kerja staf dan PC pelayanan di ' . $opdLocation->nama . '.',
            'rekomendasi_spesifikasi' => 'Manageable Switch 24-Port Gigabit (D-Link / Cisco / Ruijie)',
            'estimasi_biaya' => 2800000,
            'status' => 'Diusulkan',
            'catatan' => 'Paket Usulan Pengadaan Jaringan Baru (Auto-Generated)'
        ]);

        // 3. Access Point WiFi
        DeviceProposal::create([
            'opd_location_id' => $opdLocation->id,
            'nama_pengusul' => $userName,
            'tipe_perangkat' => 'Access Point',
            'jumlah' => 2,
            'lokasi_ruang' => 'Area Kantor & Lobi Pelayanan Publik',
            'urgensi' => 'Tinggi',
            'alasan_kebutuhan' => 'Penyediaan sinyal WiFi nirkabel untuk laptop staf dan tamu di ' . $opdLocation->nama . '.',
            'rekomendasi_spesifikasi' => 'Access Point WiFi 6 Dual-Band Ceiling Mounted (Ubiquiti UniFi U6+ / Ruijie Reyee)',
            'estimasi_biaya' => 3600000,
            'status' => 'Diusulkan',
            'catatan' => 'Paket Usulan Pengadaan Jaringan Baru (Auto-Generated)'
        ]);

        return redirect()->route('device-proposals.index', ['opd_location_id' => $opdLocation->id])
            ->with('success', 'Paket usulan pengadaan starter internet untuk ' . $opdLocation->nama . ' (Router, Switch, & 2 AP WiFi) berhasil dibuat!');
    }
}
