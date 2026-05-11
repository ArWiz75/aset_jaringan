<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Log Maintenance - Manajemen Aset Jaringan</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #333; line-height: 1.5; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #334155; padding-bottom: 15px; }
        .header h1 { font-size: 20px; margin: 0 0 5px 0; color: #334155; text-transform: uppercase; }
        .header p { margin: 0; font-size: 12px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #334155; color: white; padding: 10px 8px; text-align: left; font-size: 11px; text-transform: uppercase; border: 1px solid #334155; }
        td { padding: 8px; border: 1px solid #ddd; font-size: 11px; }
        tr:nth-child(even) { background-color: #f8fafc; }
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
        <h1>LAPORAN LOG MAINTENANCE JARINGAN</h1>
        <p>Dinas Komunikasi dan Informatika</p>
        <p>Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th><th>Perangkat</th><th>Lokasi</th><th>Jenis</th><th>Deskripsi</th><th>Tanggal</th><th>Biaya</th><th>Status</th><th>Teknisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $i => $log)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $log->device->merk ?? '-' }} ({{ $log->device->nomor_seri ?? '' }})</td>
                <td>{{ $log->device->opdLocation->nama ?? '-' }}</td>
                <td>{{ $log->jenis }}</td>
                <td>{{ Str::limit($log->deskripsi, 50) }}</td>
                <td>{{ $log->tanggal->format('d/m/Y') }}</td>
                <td>{{ $log->biaya ? 'Rp '.number_format($log->biaya, 0, ',', '.') : '-' }}</td>
                <td>{{ $log->status }}</td>
                <td>{{ $log->user->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p style="margin-top:15px; font-size:11px; font-weight:bold;">Total: {{ $logs->count() }} log maintenance</p>
    
    <div class="footer">Dicetak oleh: {{ auth()->user()->name ?? 'System' }} | Waktu: {{ date('H:i:s') }}</div>
</body>
</html>
