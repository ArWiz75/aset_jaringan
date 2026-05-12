<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Perangkat Jaringan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #334155; padding-bottom: 10px; }
        .header h1 { font-size: 16px; margin: 0; color: #334155; }
        .header p { margin: 2px 0; font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #334155; color: white; padding: 6px 8px; text-align: left; font-size: 10px; }
        td { padding: 5px 8px; border-bottom: 1px solid #ddd; font-size: 10px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .status-aktif { color: #059669; font-weight: bold; }
        .status-rusak { color: #dc2626; font-weight: bold; }
        .status-maintenance { color: #d97706; font-weight: bold; }
        .status-nonaktif { color: #6b7280; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA PERANGKAT JARINGAN</h1>
        @if(isset($location))
            <p style="font-size: 14px; font-weight: bold; color: #334155; margin-top: 5px;">{{ $location->nama }}</p>
        @else
            <p>Dinas Komunikasi dan Informatika</p>
        @endif
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    @if(isset($location) && $location->denah_file)
        <div style="margin-bottom: 20px; text-align: center;">
            <h3 style="font-size: 12px; color: #334155; margin-bottom: 8px; text-transform: uppercase;">Denah Gedung / Ruangan</h3>
            @php
                $denahPath = storage_path('app/public/' . $location->denah_file);
                $isImage = in_array(strtolower(pathinfo($denahPath, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'svg']);
            @endphp
            @if($isImage && file_exists($denahPath))
                <img src="data:image/{{ pathinfo($denahPath, PATHINFO_EXTENSION) }};base64,{{ base64_encode(file_get_contents($denahPath)) }}" style="max-width: 100%; max-height: 350px; border: 1px solid #ddd; border-radius: 8px;">
            @else
                <p style="font-size: 10px; color: #666;">(Denah tersedia dalam format non-gambar)</p>
            @endif
        </div>
    @endif
    <table>
        <thead>
            <tr>
                <th>No</th><th>Merk</th><th>Tipe</th><th>Model</th><th>No. Seri</th><th>IP Address</th><th>Lokasi OPD</th><th>Lokasi Pemasangan</th><th>Status</th><th>Tgl Install</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $i => $device)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $device->merk }}</td>
                <td>{{ $device->tipe }}</td>
                <td>{{ $device->model ?? '-' }}</td>
                <td>{{ $device->nomor_seri }}</td>
                <td>{{ $device->ip_address ?? '-' }}</td>
                <td>{{ $device->opdLocation->nama ?? '-' }}</td>
                <td>{{ $device->lokasi_pemasangan ?? '-' }}</td>
                <td class="status-{{ strtolower($device->status) }}">{{ $device->status }}</td>
                <td>{{ $device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top:10px; font-size:10px;">Total: {{ $devices->count() }} perangkat</p>
    <div class="footer">Dicetak oleh: {{ auth()->user()->name ?? 'System' }}</div>
</body>
</html>
