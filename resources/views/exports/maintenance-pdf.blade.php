<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Log Maintenance – DISKOMINFO Jembrana</title>
    @include('partials.pdf-styles')
</head>
<body>

    {{-- KOP SURAT (Mode PDF Base64) --}}
    <x-kop-surat :forPdf="true" />

    {{-- DOKUMEN TITLE --}}
    <div class="doc-header">
        <div class="doc-title">Laporan Riwayat Pemeliharaan &amp; Perbaikan Jaringan</div>
        <div class="doc-subtitle">Dinas Komunikasi dan Informatika &mdash; Pemerintah Kabupaten Jembrana</div>
    </div>

    {{-- META BAR --}}
    <table class="meta-table">
        <tr>
            <td style="width:33%;"><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            <td style="width:34%; text-align:center;"><strong>Ruang Lingkup:</strong> Riwayat Pemeliharaan &amp; Maintenance</td>
            <td style="width:33%; text-align:right;"><strong>Dicetak oleh:</strong> {{ auth()->user()?->name ?? 'Admin DISKOMINFO' }}</td>
        </tr>
    </table>

    {{-- SUMMARY GRID --}}
    @php
        $totalLogs    = $logs->count();
        $selesaiCount = $logs->where('status', 'Selesai')->count();
        $prosesCount  = $logs->whereIn('status', ['Pending', 'Proses'])->count();
        $totalBiaya   = $logs->sum('biaya');
    @endphp
    <table class="summary-table">
        <tr>
            <td style="width:25%;">
                <div class="sc-label">Total Log Kegiatan</div>
                <div class="sc-value">{{ $totalLogs }}<span class="sc-unit">Insiden</span></div>
                <div class="sc-sub">Riwayat penanganan</div>
            </td>
            <td class="sc-green" style="width:25%;">
                <div class="sc-label">Terselesaikan</div>
                <div class="sc-value">{{ $selesaiCount }}<span class="sc-unit">Selesai</span></div>
                <div class="sc-sub">Penanganan tuntas</div>
            </td>
            <td class="sc-orange" style="width:25%;">
                <div class="sc-label">Dalam Proses / Pending</div>
                <div class="sc-value">{{ $prosesCount }}<span class="sc-unit">Pending</span></div>
                <div class="sc-sub">Menunggu tindakan lanjutan</div>
            </td>
            <td class="sc-blue" style="width:25%;">
                <div class="sc-label">Total Realisasi Biaya</div>
                <div class="sc-value" style="font-size:9.5pt;">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
                <div class="sc-sub">Total pengeluaran tercatat</div>
            </td>
        </tr>
    </table>

    {{-- TABEL DATA LOG --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:3%;" class="text-center">No</th>
                <th style="width:16%;">Perangkat &amp; SN</th>
                <th style="width:16%;">Lokasi OPD</th>
                <th style="width:9%;" class="text-center">Jenis</th>
                <th style="width:24%;">Deskripsi Permasalahan / Tindakan</th>
                <th style="width:8%;" class="text-center">Tanggal</th>
                <th style="width:9%;" class="text-right">Biaya (Rp)</th>
                <th style="width:7%;" class="text-center">Status</th>
                <th style="width:8%;">Teknisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $i => $log)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>
                    <div class="font-bold">{{ $log->device->merk ?? '-' }} {{ $log->device->model ?? '' }}</div>
                    <div style="font-size:6.5pt; color:#64748b;" class="font-mono">SN: {{ $log->device->nomor_seri ?? '-' }}</div>
                </td>
                <td>
                    <div class="font-bold">{{ $log->device->opdLocation->nama ?? '-' }}</div>
                    @if($log->device && $log->device->lokasi_pemasangan)
                        <div style="font-size:6.5pt; color:#64748b;">📍 {{ $log->device->lokasi_pemasangan }}</div>
                    @endif
                </td>
                <td class="text-center">
                    <span class="badge" style="background:#f1f5f9; color:#334155; border:0.5px solid #cbd5e1;">{{ $log->jenis }}</span>
                </td>
                <td>
                    <div>{{ $log->deskripsi }}</div>
                    @if($log->catatan)
                        <div style="font-size:6.5pt; color:#64748b; margin-top:1px; font-style:italic;">Catatan: {{ $log->catatan }}</div>
                    @endif
                </td>
                <td class="text-center">{{ $log->tanggal ? $log->tanggal->format('d/m/Y') : '-' }}</td>
                <td class="text-right font-mono font-bold text-blue">
                    {{ $log->biaya && $log->biaya > 0 ? 'Rp ' . number_format($log->biaya, 0, ',', '.') : '-' }}
                </td>
                <td class="text-center">
                    @php $st = strtolower($log->status); @endphp
                    <span class="badge badge-{{ $st }}">{{ $log->status }}</span>
                </td>
                <td>{{ $log->user->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding:16px; color:#94a3b8;">
                    Tidak ada riwayat log pemeliharaan yang tercatat.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($logs->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right">TOTAL PENGELUARAN REALISASI PEMELIHARAAN:</td>
                <td class="text-right font-mono text-blue" style="font-size:8pt;">
                    Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                </td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- TANDA TANGAN RESMI --}}
    <table class="signature-table">
        <tr>
            <td style="width:50%;">
                <div>Mengetahui,</div>
                <div class="sig-role">Kepala Bidang Penyelenggaraan E-Government / TIK</div>
                <div class="sig-space"></div>
                <div class="sig-name">( ........................................................ )</div>
                <div class="sig-nip">NIP. ...................................................</div>
            </td>
            <td style="width:50%;">
                <div>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="sig-role">Pejabat / Tim Teknis Jaringan &amp; Infrastruktur</div>
                <div class="sig-space"></div>
                <div class="sig-name">{{ auth()->user()?->name ?? '( ........................................................ )' }}</div>
                <div class="sig-nip">Pengelola Jaringan Komputer</div>
            </td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <table class="footer-table">
        <tr>
            <td style="text-align:left;">Sistem Informasi Manajemen Aset Jaringan – DISKOMINFO Kab. Jembrana</td>
            <td style="text-align:right;">Dicetak pada: {{ date('d/m/Y H:i') }} WIB | Oleh: {{ auth()->user()?->name ?? 'System' }}</td>
        </tr>
    </table>

</body>
</html>
