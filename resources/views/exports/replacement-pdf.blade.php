<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Usulan Penggantian &amp; Pengadaan Perangkat – DISKOMINFO</title>
    @include('partials.pdf-styles')
</head>
<body>

    {{-- KOP SURAT (Mode PDF Base64) --}}
    <x-kop-surat :forPdf="true" />

    {{-- DOKUMEN TITLE --}}
    <div class="doc-header">
        <div class="doc-title">Laporan Rekomendasi Penggantian &amp; Usulan Pengadaan Perangkat Jaringan</div>
        <div class="doc-subtitle">Dokumen Bahan Pertimbangan Pimpinan dalam Rangka Perencanaan Penggantian dan Penganggaran Perangkat Pengganti</div>
    </div>

    {{-- META BAR --}}
    <table class="meta-table">
        <tr>
            <td style="width:33%;"><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            <td style="width:34%; text-align:center;"><strong>Filter Lokasi:</strong> {{ $location ? $location->nama : 'Semua Lokasi OPD' }}</td>
            <td style="width:33%; text-align:right;"><strong>Status:</strong> Rekomendasi Pergantian</td>
        </tr>
    </table>

    {{-- SUMMARY GRID --}}
    <table class="summary-table">
        <tr>
            <td class="sc-purple" style="width:33.3%;">
                <div class="sc-label">Total Unit Perlu Diganti</div>
                <div class="sc-value">{{ $devices->count() }}<span class="sc-unit">Unit</span></div>
                <div class="sc-sub">Perangkat prioritas pergantian</div>
            </td>
            <td style="width:33.3%;">
                <div class="sc-label">Sebaran OPD Terdampak</div>
                <div class="sc-value">{{ $totalOpd }}<span class="sc-unit">Lokasi OPD</span></div>
                <div class="sc-sub">Titik lokasi instalasi aktif</div>
            </td>
            <td class="sc-blue" style="width:33.4%;">
                <div class="sc-label">Total Estimasi Kebutuhan Biaya</div>
                <div class="sc-value" style="font-size:10pt;">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
                <div class="sc-sub">Perkiraan anggaran pengadaan pengganti</div>
            </td>
        </tr>
    </table>

    {{-- TABEL DATA PERANGKAT PENGGANTIAN DENGAN MERGE GROUP HEADER OPD --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:3%;" class="text-center">No</th>
                <th style="width:16%;">Ruang / Titik Pasang</th>
                <th style="width:16%;">Perangkat Saat Ini</th>
                <th style="width:8%;" class="text-center">Tgl / Umur</th>
                <th style="width:8%;" class="text-center">Kondisi</th>
                <th style="width:21%;">Alasan Penggantian (Pertimbangan Teknis)</th>
                <th style="width:16%;">Rekomendasi Pengganti</th>
                <th style="width:12%;" class="text-right">Estimasi Biaya</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentOpdId = null;
                $rowNumber = 1;
            @endphp
            @forelse($devices as $device)
                {{-- Baris Pengelompokan / Merge OPD --}}
                @if(!$location && $device->opd_location_id !== $currentOpdId)
                    @php
                        $currentOpdId = $device->opd_location_id;
                        $opdName = $device->opdLocation->nama ?? 'Tanpa Lokasi OPD';
                        $opdCount = $devices->where('opd_location_id', $currentOpdId)->count();
                        $opdSubtotal = $devices->where('opd_location_id', $currentOpdId)->sum('estimasi_biaya');
                    @endphp
                    <tr class="group-header">
                        <td colspan="8">
                            LOKASI OPD: {{ strtoupper($opdName) }}
                            <span class="group-count">
                                ({{ $opdCount }} Unit Perlu Diganti &bull; Estimasi: Rp {{ number_format($opdSubtotal, 0, ',', '.') }})
                            </span>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="text-center">{{ $rowNumber++ }}</td>
                    <td>
                        <div class="font-bold">{{ $device->lokasi_pemasangan ? $device->lokasi_pemasangan : 'Area Utama' }}</div>
                        @if($location)
                            <div style="font-size:6.5pt; color:#64748b;">{{ $device->opdLocation->nama ?? '' }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="font-bold">{{ $device->merk }} {{ $device->model }}</div>
                        <div style="font-size:6.5pt; color:#64748b;">
                            Tipe: {{ $device->tipe }} | SN: {{ $device->nomor_seri ?? '-' }}<br>
                            <span class="font-mono text-blue">IP: {{ $device->ip_address ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <div>{{ $device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-' }}</div>
                        @if($device->umur_perangkat)
                        <div style="font-size:6.5pt; font-weight:bold; color:#d97706;">({{ $device->umur_perangkat }})</div>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge badge-perlu-diganti">{{ $device->status }}</span>
                    </td>
                    <td>
                        <div style="font-weight:bold; color:#b91c1c;">
                            {{ $device->alasan_penggantian ?? 'Kondisi perangkat menurun / usia teknis habis' }}
                        </div>
                        @if($device->keterangan && $device->keterangan !== $device->alasan_penggantian)
                        <div style="font-size:6.5pt; color:#64748b; font-style:italic; margin-top:1px;">
                            Catatan: {{ $device->keterangan }}
                        </div>
                        @endif
                    </td>
                    <td>
                        @if($device->rekomendasi_pengganti)
                            <div class="font-bold">{{ $device->rekomendasi_pengganti }}</div>
                        @else
                            <span class="text-muted" style="font-style:italic;">Standar TIK</span>
                        @endif
                    </td>
                    <td class="text-right font-mono font-bold text-blue">
                        @if($device->estimasi_biaya && $device->estimasi_biaya > 0)
                            Rp {{ number_format($device->estimasi_biaya, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding:16px; color:#94a3b8;">
                        Tidak ada perangkat dengan status 'Perlu Diganti' yang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($devices->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="7" class="text-right">TOTAL KEBUTUHAN ESTIMASI BIAYA PENGADAAN:</td>
                <td class="text-right font-mono text-blue" style="font-size:8pt;">
                    Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- CATATAN PERTIMBANGAN TEKNIS --}}
    <div class="notes-box">
        <p><strong>Catatan Pertimbangan Teknis Tim Infrastruktur Jaringan:</strong></p>
        <p>1. Daftar perangkat di atas telah dievaluasi berdasarkan kondisi fisik, keusangan teknologi, dan log pemeliharaan.</p>
        <p>2. Penggantian disarankan untuk menjaga stabilitas interkoneksi jaringan intranet dan layanan publik OPD.</p>
        <p>3. Estimasi biaya dapat disesuaikan pada Rencana Kerja Anggaran (RKA/DPA) berdasarkan survei harga pasar / e-Katalog LKPP.</p>
    </div>

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
