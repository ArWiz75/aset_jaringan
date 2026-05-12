<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Data Perangkat - Manajemen Aset Jaringan</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #333; line-height: 1.5; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #334155; padding-bottom: 15px; }
        .header h1 { font-size: 20px; margin: 0 0 5px 0; color: #334155; text-transform: uppercase; }
        .header p { margin: 0; font-size: 12px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #334155; color: white; padding: 10px 8px; text-align: left; font-size: 11px; text-transform: uppercase; border: 1px solid #334155; }
        td { padding: 8px; border: 1px solid #ddd; font-size: 11px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .status-aktif { color: #059669; font-weight: bold; }
        .status-rusak { color: #dc2626; font-weight: bold; }
        .status-maintenance { color: #d97706; font-weight: bold; }
        .status-nonaktif { color: #6b7280; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #999; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
            th { background-color: #334155 !important; color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
        .btn-print { background-color: #334155; color: white; border: none; padding: 10px 20px; font-size: 14px; border-radius: 5px; cursor: pointer; margin-bottom: 20px; display: inline-flex; items-center; gap: 8px; }
        .btn-print:hover { background-color: #1e293b; }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: right;">
        <button class="btn-print" onclick="window.print()">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Sekarang
        </button>
    </div>

    <div class="header">
        <h1>LAPORAN DATA PERANGKAT JARINGAN</h1>
        @if(isset($location))
            <p style="font-size: 16px; font-weight: bold; color: #334155; margin-top: 5px;">{{ $location->nama }}</p>
        @else
            <p>Dinas Komunikasi dan Informatika</p>
        @endif
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    @if(isset($location) && $location->denah_file)
        <div style="margin-bottom: 30px; text-align: center;">
            <h3 style="font-size: 14px; color: #334155; margin-bottom: 10px; text-transform: uppercase;">Denah Gedung / Ruangan</h3>
            @php
                $ext = pathinfo($location->denah_file, PATHINFO_EXTENSION);
                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'svg']);
            @endphp
            @if($isImage)
                <img src="{{ asset('storage/' . $location->denah_file) }}" style="max-width: 100%; max-height: 500px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
            @else
                <div style="padding: 20px; border: 2px dashed #ddd; border-radius: 8px; color: #666;">
                    Dokumen Denah tersedia (Format: {{ strtoupper($ext) }})
                </div>
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
    
    <p style="margin-top:15px; font-size:11px; font-weight:bold;">Total: {{ $devices->count() }} perangkat</p>
    
    <div class="footer">Dicetak oleh: {{ auth()->user()->name ?? 'System' }} | Waktu: {{ date('H:i:s') }}</div>
</body>
</html>
