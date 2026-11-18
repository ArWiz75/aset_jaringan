<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Usulan Pengadaan Perangkat – DISKOMINFO</title>
    @include('partials.pdf-styles')
</head>
<body>

    {{-- KOP SURAT (Mode PDF Base64) --}}
    <x-kop-surat :forPdf="true" />

    {{-- DOKUMEN TITLE --}}
    <div class="doc-header">
        <div class="doc-title">Daftar Usulan Pengadaan &amp; Penambahan Perangkat Jaringan Baru</div>
        <div class="doc-subtitle">
            @if($location)
                Khusus Lokasi: {{ $location->nama }} &mdash; Dokumen Perencanaan Anggaran
            @else
                Seluruh Organisasi Perangkat Daerah (OPD) Terdaftar &mdash; Usulan Perencanaan Anggaran &amp; Pengadaan
            @endif
        </div>
    </div>

    {{-- META BAR --}}
    <table class="meta-table">
        <tr>
            <td style="width:33%;"><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            <td style="width:34%; text-align:center;"><strong>Filter Lokasi:</strong> {{ $location ? $location->nama : 'Semua OPD' }}</td>
            <td style="width:33%; text-align:right;"><strong>Dicetak oleh:</strong> {{ Auth::check() ? Auth::user()->name : 'Admin DISKOMINFO' }}</td>
        </tr>
    </table>

    {{-- SUMMARY GRID --}}
    <table class="summary-table">
        <tr>
            <td style="width:25%;">
                <div class="sc-label">Total Usulan</div>
                <div class="sc-value">{{ $proposals->count() }}<span class="sc-unit">Usulan</span></div>
                <div class="sc-sub">Jumlah entri pengajuan</div>
            </td>
            <td class="sc-green" style="width:25%;">
                <div class="sc-label">Total Unit Perangkat</div>
                <div class="sc-value">{{ $totalUnit }}<span class="sc-unit">Unit</span></div>
                <div class="sc-sub">Kebutuhan pengadaan</div>
            </td>
            <td class="sc-blue" style="width:25%;">
                <div class="sc-label">Estimasi Total Anggaran</div>
                <div class="sc-value" style="font-size:9.5pt;">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
                <div class="sc-sub">Perkiraan kebutuhan dana</div>
            </td>
            <td class="sc-orange" style="width:25%;">
                <div class="sc-label">OPD Belum Berperangkat</div>
                <div class="sc-value">{{ $emptyOpds->count() }}<span class="sc-unit">OPD</span></div>
                <div class="sc-sub">Lokasi prioritas internet</div>
            </td>
        </tr>
    </table>

    {{-- CATATAN PRIORITAS OPD KOSONG --}}
    @if($emptyOpds->count() > 0 && !request('opd_location_id'))
    <div class="notes-box">
        <p><strong>⚠️ Catatan Prioritas:</strong> Terdapat <strong>{{ $emptyOpds->count() }}</strong> lokasi OPD yang belum terpasang perangkat jaringan sama sekali:
        <em>{{ $emptyOpds->pluck('nama')->implode(', ') }}</em>. Disarankan untuk segera diprioritaskan.</p>
    </div>
    @endif

    {{-- TABEL DATA USULAN DENGAN MERGE GROUP HEADER OPD --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:3%;" class="text-center">No</th>
                <th style="width:14%;">Titik Ruang</th>
                <th style="width:12%;">Tipe Perangkat</th>
                <th style="width:7%;" class="text-center">Jumlah</th>
                <th style="width:7%;" class="text-center">Urgensi</th>
                <th style="width:23%;">Alasan Kebutuhan / Justifikasi Teknis</th>
                <th style="width:14%;">Rekomendasi Spesifikasi</th>
                <th style="width:12%;" class="text-right">Estimasi Biaya</th>
                <th style="width:8%;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentOpdId = null;
                $rowNumber = 1;
            @endphp
            @forelse($proposals as $p)
                {{-- Baris Pengelompokan / Merge OPD --}}
                @if(!$location && $p->opd_location_id !== $currentOpdId)
                    @php
                        $currentOpdId = $p->opd_location_id;
                        $opdName = $p->opdLocation->nama ?? 'Tanpa Lokasi OPD';
                        $opdCount = $proposals->where('opd_location_id', $currentOpdId)->count();
                        $opdUnits = $proposals->where('opd_location_id', $currentOpdId)->sum('jumlah');
                        $opdAnggaran = $proposals->where('opd_location_id', $currentOpdId)->sum('estimasi_biaya');
                    @endphp
                    <tr class="group-header">
                        <td colspan="9">
                            LOKASI OPD: {{ strtoupper($opdName) }}
                            <span class="group-count">
                                ({{ $opdCount }} Usulan &bull; {{ $opdUnits }} Unit &bull; Estimasi: Rp {{ number_format($opdAnggaran, 0, ',', '.') }})
                            </span>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="text-center">{{ $rowNumber++ }}</td>
                    <td>
                        <div class="font-bold">{{ $p->lokasi_ruang ?: 'Area Utama' }}</div>
                        @if($location)
                            <div style="font-size:6.5pt; color:#64748b;">{{ $p->opdLocation->nama ?? '' }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="font-bold">{{ $p->tipe_perangkat }}</div>
                    </td>
                    <td class="text-center font-bold">{{ $p->jumlah }} Unit</td>
                    <td class="text-center">
                        @php $urg = strtolower($p->urgensi); @endphp
                        <span class="badge badge-{{ $urg === 'tinggi' ? 'tinggi' : ($urg === 'sedang' ? 'sedang' : 'rendah') }}">
                            {{ $p->urgensi }}
                        </span>
                    </td>
                    <td>
                        <div>{{ $p->alasan_kebutuhan }}</div>
                        @if($p->catatan)
                            <div style="font-size:6.5pt; color:#64748b; margin-top:1px; font-style:italic;">Catatan: {{ $p->catatan }}</div>
                        @endif
                    </td>
                    <td>{{ $p->rekomendasi_spesifikasi ?: '-' }}</td>
                    <td class="text-right font-mono font-bold text-blue">{{ $p->formatted_biaya }}</td>
                    <td class="text-center">
                        @php $st = strtolower(str_replace(' ', '-', $p->status)); @endphp
                        <span class="badge badge-{{ $st }}">{{ $p->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding:16px; color:#94a3b8;">
                        Tidak ada data usulan penambahan perangkat sesuai filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($proposals->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL KEBUTUHAN UNIT:</td>
                <td class="text-center font-bold">{{ $totalUnit }} Unit</td>
                <td colspan="3" class="text-right">TOTAL ESTIMASI ANGGARAN:</td>
                <td class="text-right font-mono text-green" style="font-size:8pt;">
                    Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                </td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{-- CATATAN PERTIMBANGAN TEKNIS --}}
    <div class="notes-box">
        <p><strong>Catatan Pertimbangan Teknis Tim Infrastruktur Jaringan:</strong></p>
        <p>1. Usulan pengadaan di atas telah disusun berdasarkan survei kebutuhan dan evaluasi kapasitas jaringan.</p>
        <p>2. Tingkat urgensi ditentukan berdasarkan kebutuhan layanan publik dan program prioritas bidang TIK.</p>
        <p>3. Estimasi biaya mengacu pada harga referensi pasar / e-Katalog LKPP dan dapat disesuaikan pada dokumen RKA/DPA.</p>
    </div>

    {{-- TANDA TANGAN RESMI --}}
    <table class="signature-table">
        <tr>
            <td style="width:50%;">
                <div>Mengetahui,</div>
                <div class="sig-role">Kepala Dinas Komunikasi &amp; Informatika<br>Kabupaten Jembrana</div>
                <div class="sig-space"></div>
                <div class="sig-name">( ........................................................ )</div>
                <div class="sig-nip">NIP. ...................................................</div>
            </td>
            <td style="width:50%;">
                <div>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="sig-role">Penanggung Jawab / Tim Jaringan &amp; Infrastruktur</div>
                <div class="sig-space"></div>
                <div class="sig-name">{{ Auth::check() ? Auth::user()->name : '( ........................................................ )' }}</div>
                <div class="sig-nip">Pengelola Infrastruktur Jaringan</div>
            </td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <table class="footer-table">
        <tr>
            <td style="text-align:left;">Sistem Informasi Manajemen Aset Jaringan – DISKOMINFO Kab. Jembrana</td>
            <td style="text-align:right;">Dicetak pada: {{ date('d/m/Y H:i') }} WIB | Oleh: {{ Auth::check() ? Auth::user()->name : 'Admin DISKOMINFO' }}</td>
        </tr>
    </table>

</body>
</html>
