<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Log Maintenance – DISKOMINFO Jembrana</title>
    @include('partials.kop-styles')
    <style>
        body { font-family: Arial, sans-serif; font-size: 10.5px; color: #1e293b; margin: 0; padding: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #1e293b; color: white; padding: 6px 7px; text-align: left; font-size: 9.5px; text-transform: uppercase; }
        td { padding: 5px 7px; border-bottom: 1px solid #cbd5e1; font-size: 9.5px; }
        tr:nth-child(even) { background-color: #f8fafc; }
    </style>
</head>
<body>
    {{-- KOP SURAT (mode PDF = base64) --}}
    <x-kop-surat :forPdf="true" />

    <div class="kop-judul-wrap">
        <div class="kop-judul">Laporan Log Maintenance Jaringan</div>
        <div class="kop-sub-judul">Dinas Komunikasi dan Informatika – Kabupaten Jembrana</div>
    </div>

    <div class="meta-info-bar">
        <span><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</span>
        <span><strong>Total:</strong> {{ $logs->count() }} log</span>
        <span><strong>Dicetak:</strong> {{ auth()->user()->name ?? 'System' }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th><th>Perangkat</th><th>Lokasi</th><th>Jenis</th>
                <th>Deskripsi</th><th>Tanggal</th><th>Biaya</th><th>Status</th><th>Teknisi</th>
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

    <div class="print-footer">
        <span>Sistem Informasi Manajemen Aset Jaringan – DISKOMINFO Jembrana</span>
        <span>Dicetak: {{ auth()->user()->name ?? 'System' }}</span>
    </div>
</body>
</html>
