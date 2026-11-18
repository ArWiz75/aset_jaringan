<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Data Perangkat - DISKOMINFO Jembrana</title>
    @include('partials.kop-styles')
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #1e293b; line-height: 1.5; margin: 0; padding: 20px; }
        .page-container { max-width: 1100px; margin: 0 auto; background: #fff; padding: 28px 32px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #1e293b; color: white; padding: 8px 7px; text-align: left; font-size: 10.5px; text-transform: uppercase; border: 1px solid #1e293b; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        td { padding: 7px; border: 1px solid #cbd5e1; font-size: 10.5px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .status-aktif { color: #059669; font-weight: bold; }
        .status-rusak { color: #dc2626; font-weight: bold; }
        .status-maintenance { color: #d97706; font-weight: bold; }
        .status-perlu-diganti { color: #7c3aed; font-weight: bold; }
        .status-nonaktif { color: #6b7280; }
        .btn-print { background-color: #1e293b; color: white; border: none; padding: 10px 20px; font-size: 13px; border-radius: 6px; cursor: pointer; margin-bottom: 16px; display: inline-flex; align-items: center; gap: 8px; }
        .btn-print:hover { background-color: #0f172a; }
        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
            tr:nth-child(even) { background-color: #f8fafc !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align:right; margin-bottom:12px;">
        <button class="btn-print" onclick="window.print()">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Sekarang
        </button>
    </div>

    <div class="page-container">
        {{-- KOP SURAT RESMI --}}
        <x-kop-surat />

        {{-- Judul & Meta --}}
        <div class="kop-judul-wrap">
            <div class="kop-judul">Laporan Data Perangkat Jaringan</div>
            @if(isset($location))
                <div class="kop-sub-judul">{{ $location->nama }}</div>
            @else
                <div class="kop-sub-judul">Semua Lokasi OPD</div>
            @endif
        </div>

        <div class="meta-info-bar">
            <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            <span><strong>Total Perangkat:</strong> {{ $devices->count() }} unit</span>
            <span><strong>Dicetak oleh:</strong> {{ auth()->user()->name ?? 'System' }}</span>
        </div>

        @if(isset($location) && $location->denah_file)
            <div style="margin-bottom:20px; text-align:center;">
                <h3 style="font-size:12px; color:#1e293b; margin-bottom:8px; text-transform:uppercase;">Denah Gedung / Ruangan</h3>
                @php
                    $ext = pathinfo($location->denah_file, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'svg']);
                @endphp
                @if($isImage)
                    <img src="{{ asset('storage/' . $location->denah_file) }}" style="max-width:100%; max-height:400px; border:1px solid #ddd; border-radius:6px;">
                @else
                    <div style="padding:16px; border:2px dashed #ddd; border-radius:6px; color:#666;">
                        Dokumen Denah tersedia (Format: {{ strtoupper($ext) }})
                    </div>
                @endif
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>No</th><th>Merk</th><th>Tipe</th><th>Model</th><th>No. Seri</th>
                    <th>IP Address</th><th>Lokasi OPD</th><th>Lokasi Pemasangan</th>
                    <th>Status</th><th>Tgl Install</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $i => $device)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $device->merk }}</td>
                    <td>{{ $device->tipe }}</td>
                    <td>{{ $device->model ?? '-' }}</td>
                    <td>{{ $device->nomor_seri ?? '-' }}</td>
                    <td>{{ $device->ip_address ?? '-' }}</td>
                    <td>{{ $device->opdLocation->nama ?? '-' }}</td>
                    <td>{{ $device->lokasi_pemasangan ?? '-' }}</td>
                    <td class="status-{{ \Illuminate\Support\Str::slug($device->status) }}">{{ $device->status }}</td>
                    <td>{{ $device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top:12px; font-size:11px; font-weight:bold; color:#1e293b;">
            Total: {{ $devices->count() }} perangkat
        </p>

        <div class="print-footer">
            <span>Sistem Informasi Manajemen Aset Jaringan – DISKOMINFO Jembrana</span>
            <span>Dicetak: {{ auth()->user()->name ?? 'System' }} | {{ now()->format('d/m/Y H:i:s') }}</span>
        </div>
    </div>
</body>
</html>
