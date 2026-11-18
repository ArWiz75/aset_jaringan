<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Log Maintenance – DISKOMINFO Jembrana</title>
    @include('partials.print-styles')
</head>
<body>

{{-- ── Action Bar (layar saja) ─────────────────────────────── --}}
<div class="action-bar no-print">
    <div class="action-bar-left">
        <a href="{{ route('maintenance-logs.index') }}" class="btn btn-back">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
        <span class="action-bar-title">Pratinjau Cetak
            <span>— Log Maintenance Jaringan</span>
        </span>
    </div>
    <div class="action-bar-right">
        <a href="{{ route('export.maintenance.pdf') }}?{{ http_build_query(request()->query()) }}" class="btn btn-pdf">
            <svg style="width:13px;height:13px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
            Unduh PDF
        </a>
        <a href="{{ route('export.maintenance.excel') }}?{{ http_build_query(request()->query()) }}" class="btn btn-excel">
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
        <div class="doc-title">Laporan Log Maintenance Jaringan</div>
        <div class="doc-subtitle">Dinas Komunikasi dan Informatika – Pemerintah Kabupaten Jembrana</div>
    </div>

    {{-- Meta Info --}}
    <div class="meta-bar">
        <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
        <span><strong>Total Log:</strong> {{ $logs->count() }} entri</span>
        <span><strong>Dicetak oleh:</strong> {{ auth()->user()->name ?? 'System' }}</span>
    </div>

    {{-- Statistik Ringkas --}}
    @php
        $logSelesai = $logs->where('status','Selesai')->count();
        $logPending = $logs->where('status','Pending')->count();
        $logProses  = $logs->where('status','Dalam Proses')->count();
        $totalBiaya = $logs->sum('biaya');
    @endphp
    <div class="summary-grid cols-4" style="margin-bottom:12px;">
        <div class="summary-card">
            <div class="sc-label">Total Entri</div>
            <div class="sc-value">{{ $logs->count() }}<span class="sc-unit">log</span></div>
        </div>
        <div class="summary-card c-green">
            <div class="sc-label">Selesai</div>
            <div class="sc-value" style="color:#15803d;">{{ $logSelesai }}</div>
        </div>
        <div class="summary-card c-orange">
            <div class="sc-label">Pending / Proses</div>
            <div class="sc-value" style="color:#c2410c;">{{ $logPending + $logProses }}</div>
        </div>
        <div class="summary-card c-blue">
            <div class="sc-label">Total Biaya</div>
            <div class="sc-value" style="font-size:13px; color:#1d4ed8;">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Tabel Log --}}
    <table>
        <thead>
            <tr>
                <th style="width:22px;" class="text-center">No</th>
                <th style="width:120px;">Perangkat</th>
                <th style="width:120px;">Lokasi OPD</th>
                <th style="width:70px;">Jenis</th>
                <th>Deskripsi Pekerjaan</th>
                <th style="width:60px;" class="text-center">Tanggal</th>
                <th style="width:80px;" class="text-right">Biaya</th>
                <th style="width:70px;" class="text-center">Status</th>
                <th style="width:80px;">Teknisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $i => $log)
            <tr>
                <td class="text-center" style="color:#64748b;">{{ $i + 1 }}</td>
                <td>
                    <div class="font-bold" style="color:#0f172a; font-size:10px;">{{ $log->device->merk ?? '-' }}</div>
                    @if(!empty($log->device->nomor_seri))
                        <div class="font-mono" style="font-size:8.5px; color:#94a3b8;">{{ $log->device->nomor_seri }}</div>
                    @endif
                    @if(!empty($log->device->tipe))
                        <div style="font-size:8.5px; color:#64748b;">{{ $log->device->tipe }}</div>
                    @endif
                </td>
                <td style="font-size:9.5px;">{{ $log->device->opdLocation->nama ?? '-' }}</td>
                <td>
                    @php
                        $jenisClass = match($log->jenis) {
                            'Perbaikan'    => 'badge-rusak',
                            'Penggantian'  => 'badge-perlu-diganti',
                            'Konfigurasi'  => 'badge-proses',
                            'Preventif'    => 'badge-selesai',
                            default        => ''
                        };
                    @endphp
                    <span class="badge {{ $jenisClass }}">{{ $log->jenis }}</span>
                </td>
                <td style="font-size:9.5px; line-height:1.45;">{{ Str::limit($log->deskripsi, 80) }}</td>
                <td class="text-center" style="font-size:9.5px; color:#475569; white-space:nowrap;">
                    {{ $log->tanggal->format('d/m/Y') }}
                </td>
                <td class="text-right font-mono" style="font-size:9.5px; color:#1d4ed8;">
                    {{ $log->biaya ? 'Rp '.number_format($log->biaya, 0, ',', '.') : '-' }}
                </td>
                <td class="text-center">
                    @php
                        $stClass = match($log->status) {
                            'Selesai'       => 'badge-selesai',
                            'Pending'       => 'badge-pending',
                            'Dalam Proses'  => 'badge-proses',
                            default         => ''
                        };
                    @endphp
                    <span class="badge {{ $stClass }}">{{ $log->status }}</span>
                </td>
                <td style="font-size:9.5px;">{{ $log->user->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding:20px; color:#94a3b8; font-style:italic;">
                    Tidak ada data log maintenance yang cocok dengan filter.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($logs->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right">TOTAL BIAYA MAINTENANCE :</td>
                <td class="text-right font-mono" style="color:#1d4ed8;">
                    Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                </td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- Footer --}}
    <div class="print-footer">
        <span>Sistem Informasi Manajemen Aset Jaringan – DISKOMINFO Kabupaten Jembrana</span>
        <span>Dicetak: {{ auth()->user()->name ?? 'System' }} &nbsp;|&nbsp; {{ now()->format('d/m/Y H:i:s') }}</span>
    </div>
</div>

</body>
</html>
