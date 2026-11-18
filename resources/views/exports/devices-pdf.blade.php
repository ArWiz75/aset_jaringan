<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Data Perangkat Jaringan – DISKOMINFO Jembrana</title>
    @include('partials.kop-styles')
    <style>
        body { font-family: Arial, sans-serif; font-size: 10.5px; color: #1e293b; margin: 0; padding: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #1e293b; color: white; padding: 6px 7px; text-align: left; font-size: 9.5px; text-transform: uppercase; }
        td { padding: 5px 7px; border-bottom: 1px solid #cbd5e1; font-size: 9.5px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .status-aktif { color: #059669; font-weight: bold; }
        .status-rusak { color: #dc2626; font-weight: bold; }
        .status-maintenance { color: #d97706; font-weight: bold; }
        .status-perlu-diganti { color: #7c3aed; font-weight: bold; }
        .status-nonaktif { color: #6b7280; }
    </style>
</head>
<body>
    {{-- KOP SURAT (mode PDF = base64) --}}
    <x-kop-surat :forPdf="true" />

    <div class="kop-judul-wrap">
        <div class="kop-judul">Laporan Data Perangkat Jaringan</div>
        @if(isset($location))
            <div class="kop-sub-judul">{{ $location->nama }}</div>
        @else
            <div class="kop-sub-judul">Semua Lokasi OPD</div>
        @endif
    </div>

    <div class="meta-info-bar">
        <span><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</span>
        <span><strong>Total:</strong> {{ $devices->count() }} perangkat</span>
        <span><strong>Dicetak:</strong> {{ auth()->user()->name ?? 'System' }}</span>
    </div>

    @if(isset($location) && $location->denah_file)
        <div style="margin-bottom:14px; text-align:center;">
            <h3 style="font-size:11px; color:#1e293b; margin-bottom:6px; text-transform:uppercase;">Denah Gedung / Ruangan</h3>
            @php
                $denahPath = storage_path('app/public/' . $location->denah_file);
                $isImage   = in_array(strtolower(pathinfo($denahPath, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']);
            @endphp
            @if($isImage && file_exists($denahPath))
                <img src="data:image/{{ pathinfo($denahPath, PATHINFO_EXTENSION) }};base64,{{ base64_encode(file_get_contents($denahPath)) }}"
                     style="max-width:100%; max-height:280px; border:1px solid #ddd;">
            @else
                <p style="font-size:9px; color:#666;">(Denah tersedia dalam format non-gambar)</p>
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

    <p style="margin-top:10px; font-size:10px;">Total: {{ $devices->count() }} perangkat</p>

    <div class="print-footer">
        <span>Sistem Informasi Manajemen Aset Jaringan – DISKOMINFO Jembrana</span>
        <span>Dicetak: {{ auth()->user()->name ?? 'System' }}</span>
    </div>
</body>
</html>
