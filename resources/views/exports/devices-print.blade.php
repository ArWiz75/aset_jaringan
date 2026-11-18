<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Data Perangkat – DISKOMINFO Jembrana</title>
    @include('partials.print-styles')
</head>
<body>

{{-- ── Action Bar (layar saja) ─────────────────────────────── --}}
<div class="action-bar no-print">
    <div class="action-bar-left">
        <a href="{{ route('devices.index') }}" class="btn btn-back">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
        <span class="action-bar-title">Pratinjau Cetak
            <span>— Data Perangkat Jaringan</span>
        </span>
    </div>
    <div class="action-bar-right">
        <a href="{{ route('export.devices.pdf') }}?{{ http_build_query(request()->query()) }}" class="btn btn-pdf">
            <svg style="width:13px;height:13px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
            Unduh PDF
        </a>
        <a href="{{ route('export.devices.excel') }}?{{ http_build_query(request()->query()) }}" class="btn btn-excel">
            <svg style="width:13px;height:13px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path></svg>
            Export Excel
        </a>
        <button onclick="window.print()" class="btn btn-print">
            <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak
        </button>
    </div>
</div>

<div class="page-wrap">
    {{-- KOP SURAT --}}
    <x-kop-surat />

    {{-- Judul --}}
    <div class="doc-header">
        <div class="doc-title">Laporan Data Perangkat Jaringan</div>
        @if(isset($location))
            <div class="doc-subtitle">{{ $location->nama }}</div>
        @else
            <div class="doc-subtitle">Semua Lokasi OPD – Dinas Komunikasi dan Informatika Kabupaten Jembrana</div>
        @endif
    </div>

    {{-- Meta Info --}}
    <div class="meta-bar">
        <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
        <span><strong>Total Perangkat:</strong> {{ $devices->count() }} unit</span>
        @if(isset($location))
            <span><strong>Lokasi Filter:</strong> {{ $location->nama }}</span>
        @endif
        <span><strong>Dicetak oleh:</strong> {{ auth()->user()->name ?? 'System' }}</span>
    </div>

    {{-- Denah Gedung (jika ada) --}}
    @if(isset($location) && $location->denah_file)
        @php $ext = pathinfo($location->denah_file, PATHINFO_EXTENSION); @endphp
        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'svg']))
            <div style="margin-bottom:14px; text-align:center;">
                <div style="font-size:9px;font-weight:700;text-transform:uppercase;color:#64748b;letter-spacing:0.5px;margin-bottom:5px;">Denah Gedung / Ruangan</div>
                <img src="{{ asset('storage/' . $location->denah_file) }}"
                     style="max-width:100%; max-height:280px; border:1px solid #dde3ec; border-radius:5px;">
            </div>
        @endif
    @endif

    {{-- Tabel Data Perangkat --}}
    <table>
        <thead>
            <tr>
                <th style="width:22px;" class="text-center">No</th>
                <th style="width:90px;">Merk / Model</th>
                <th style="width:70px;">Tipe</th>
                <th style="width:90px; font-family:monospace;">No. Seri</th>
                <th style="width:80px; font-family:monospace;">IP Address</th>
                <th>Lokasi OPD</th>
                <th style="width:100px;">Lokasi Pasang</th>
                <th style="width:70px;" class="text-center">Status</th>
                <th style="width:65px;" class="text-center">Tgl Pasang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($devices as $i => $device)
            <tr>
                <td class="text-center" style="color:#64748b;">{{ $i + 1 }}</td>
                <td>
                    <div class="font-bold" style="color:#0f172a;">{{ $device->merk }}</div>
                    @if($device->model)
                        <div style="font-size:9px;color:#64748b;">{{ $device->model }}</div>
                    @endif
                </td>
                <td>{{ $device->tipe }}</td>
                <td class="font-mono" style="font-size:9.5px;">{{ $device->nomor_seri ?? '-' }}</td>
                <td class="font-mono" style="font-size:9.5px;color:#0369a1;">{{ $device->ip_address ?? '-' }}</td>
                <td style="font-size:10px;">{{ $device->opdLocation->nama ?? '-' }}</td>
                <td style="font-size:9.5px;color:#475569;">{{ $device->lokasi_pemasangan ?? '-' }}</td>
                <td class="text-center">
                    @php
                        $st = $device->status;
                        $stClass = match($st) {
                            'Aktif'         => 'badge-aktif',
                            'Rusak'         => 'badge-rusak',
                            'Maintenance'   => 'badge-maintenance',
                            'Perlu Diganti' => 'badge-perlu-diganti',
                            'Nonaktif'      => 'badge-nonaktif',
                            default         => ''
                        };
                    @endphp
                    <span class="badge {{ $stClass }}">{{ $st }}</span>
                </td>
                <td class="text-center" style="font-size:9.5px;color:#475569;">
                    {{ $device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding:20px; color:#94a3b8; font-style:italic;">
                    Tidak ada data perangkat yang cocok dengan filter.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:8px; display:flex; justify-content:space-between; font-size:10px; font-weight:700; color:#1e293b;">
        <span>Total: <span style="color:#1d4ed8;">{{ $devices->count() }}</span> perangkat</span>
        @php
            $aktifCount  = $devices->where('status','Aktif')->count();
            $rusakCount  = $devices->where('status','Rusak')->count();
            $ggantiCount = $devices->where('status','Perlu Diganti')->count();
        @endphp
        <span style="font-weight:400; color:#64748b; font-size:9.5px;">
            Aktif: {{ $aktifCount }} &nbsp;|&nbsp; Rusak: {{ $rusakCount }} &nbsp;|&nbsp; Perlu Diganti: {{ $ggantiCount }}
        </span>
    </div>

    {{-- Footer --}}
    <div class="print-footer">
        <span>Sistem Informasi Manajemen Aset Jaringan – DISKOMINFO Kabupaten Jembrana</span>
        <span>Dicetak: {{ auth()->user()->name ?? 'System' }} &nbsp;|&nbsp; {{ now()->format('d/m/Y H:i:s') }}</span>
    </div>
</div>

</body>
</html>
