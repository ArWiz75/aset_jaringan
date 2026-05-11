<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Log Maintenance</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #334155; padding-bottom: 10px; }
        .header h1 { font-size: 16px; margin: 0; color: #334155; }
        .header p { margin: 2px 0; font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #334155; color: white; padding: 6px 8px; text-align: left; font-size: 10px; }
        td { padding: 5px 8px; border-bottom: 1px solid #ddd; font-size: 10px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #999; }
    </style>
</head>
<body>
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
    <p style="margin-top:10px; font-size:10px;">Total: {{ $logs->count() }} log maintenance</p>
    <div class="footer">Dicetak oleh: {{ auth()->user()->name ?? 'System' }}</div>
</body>
</html>
