<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Log Maintenance – DISKOMINFO Jembrana</title>
    @include('partials.kop-styles')
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #1e293b; line-height: 1.5; margin: 0; padding: 20px; }
        .page-container { max-width: 1100px; margin: 0 auto; background: #fff; padding: 28px 32px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #1e293b; color: white; padding: 8px 7px; text-align: left; font-size: 10.5px; text-transform: uppercase; border: 1px solid #1e293b; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        td { padding: 7px; border: 1px solid #cbd5e1; font-size: 10.5px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .btn-print { background-color: #1e293b; color: white; border: none; padding: 10px 20px; font-size: 13px; border-radius: 6px; cursor: pointer; margin-bottom: 16px; display: inline-flex; align-items: center; gap: 8px; }
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

        <div class="kop-judul-wrap">
            <div class="kop-judul">Laporan Log Maintenance Jaringan</div>
            <div class="kop-sub-judul">Dinas Komunikasi dan Informatika – Kabupaten Jembrana</div>
        </div>

        <div class="meta-info-bar">
            <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            <span><strong>Total Log:</strong> {{ $logs->count() }} entri</span>
            <span><strong>Dicetak oleh:</strong> {{ auth()->user()->name ?? 'System' }}</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th><th>Perangkat</th><th>Lokasi OPD</th><th>Jenis</th>
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
                    <td>{{ Str::limit($log->deskripsi, 60) }}</td>
                    <td>{{ $log->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $log->biaya ? 'Rp '.number_format($log->biaya, 0, ',', '.') : '-' }}</td>
                    <td>{{ $log->status }}</td>
                    <td>{{ $log->user->name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top:12px; font-size:11px; font-weight:bold;">
            Total: {{ $logs->count() }} log maintenance
        </p>

        <div class="print-footer">
            <span>Sistem Informasi Manajemen Aset Jaringan – DISKOMINFO Jembrana</span>
            <span>Dicetak: {{ auth()->user()->name ?? 'System' }} | {{ now()->format('d/m/Y H:i:s') }}</span>
        </div>
    </div>
</body>
</html>
