<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Data Perangkat Jaringan – DISKOMINFO Jembrana</title>
    @include('partials.pdf-styles')
</head>
<body>

    {{-- KOP SURAT (Mode PDF Base64) --}}
    <x-kop-surat :forPdf="true" />

    {{-- DOKUMEN TITLE --}}
    <div class="doc-header">
        <div class="doc-title">Laporan Data Perangkat Jaringan</div>
        <div class="doc-subtitle">
            @if(isset($location))
                Lokasi: {{ $location->nama }} &mdash; Dinas Komunikasi dan Informatika Kabupaten Jembrana
            @else
                Seluruh Lokasi Organisasi Perangkat Daerah (OPD) Terdaftar
            @endif
        </div>
    </div>

    {{-- META BAR --}}
    <table class="meta-table">
        <tr>
            <td style="width:33%;"><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            <td style="width:34%; text-align:center;"><strong>Filter Lokasi:</strong> {{ isset($location) ? $location->nama : 'Semua Lokasi OPD' }}</td>
            <td style="width:33%; text-align:right;"><strong>Dicetak oleh:</strong> {{ auth()->user()?->name ?? 'Admin DISKOMINFO' }}</td>
        </tr>
    </table>

    {{-- SUMMARY GRID --}}
    @php
        $totalCount  = $devices->count();
        $aktifCount  = $devices->where('status', 'Aktif')->count();
        $rusakCount  = $devices->whereIn('status', ['Rusak', 'Maintenance'])->count();
        $gantiCount  = $devices->where('status', 'Perlu Diganti')->count();
    @endphp
    <table class="summary-table">
        <tr>
            <td style="width:25%;">
                <div class="sc-label">Total Perangkat</div>
                <div class="sc-value">{{ $totalCount }}<span class="sc-unit">Unit</span></div>
                <div class="sc-sub">Total aset terdata</div>
            </td>
            <td class="sc-green" style="width:25%;">
                <div class="sc-label">Status Aktif</div>
                <div class="sc-value">{{ $aktifCount }}<span class="sc-unit">Unit</span></div>
                <div class="sc-sub">Beroperasi normal</div>
            </td>
            <td class="sc-orange" style="width:25%;">
                <div class="sc-label">Rusak / Maintenance</div>
                <div class="sc-value">{{ $rusakCount }}<span class="sc-unit">Unit</span></div>
                <div class="sc-sub">Butuh perbaikan</div>
            </td>
            <td class="sc-purple" style="width:25%;">
                <div class="sc-label">Perlu Diganti</div>
                <div class="sc-value">{{ $gantiCount }}<span class="sc-unit">Unit</span></div>
                <div class="sc-sub">Usulan peremajaan</div>
            </td>
        </tr>
    </table>

    {{-- DENAH JIKA ADA --}}
    @if(isset($location) && $location->denah_file)
        @php
            $denahPath = storage_path('app/public/' . $location->denah_file);
            $isImage   = in_array(strtolower(pathinfo($denahPath, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']);
        @endphp
        @if($isImage && file_exists($denahPath))
        <div style="margin-top:8px; margin-bottom:12px; text-align:center; page-break-inside:avoid;">
            <div style="font-size:7.5pt; font-weight:bold; color:#1e293b; margin-bottom:4px; text-transform:uppercase;">
                Denah Ruangan / Gedung: {{ $location->nama }}
            </div>
            <img src="data:image/{{ pathinfo($denahPath, PATHINFO_EXTENSION) }};base64,{{ base64_encode(file_get_contents($denahPath)) }}"
                 style="max-width:85%; max-height:170px; border:1px solid #cbd5e1; display:inline-block;">
        </div>
        @endif
    @endif

    {{-- TABEL DATA PERANGKAT DENGAN MERGE GROUP HEADER OPD --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:3%;" class="text-center">No</th>
                <th style="width:17%;">Titik / Ruang Pasang</th>
                <th style="width:18%;">Merk &amp; Model</th>
                <th style="width:9%;" class="text-center">Tipe</th>
                <th style="width:13%;">No. Seri</th>
                <th style="width:12%;">IP Address</th>
                <th style="width:9%;" class="text-center">Status</th>
                <th style="width:8%;" class="text-center">Tgl Pasang</th>
                <th style="width:11%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentOpdId = null;
                $rowNumber = 1;
            @endphp
            @forelse($devices as $device)
                {{-- Baris Pengelompokan / Merge OPD --}}
                @if(!isset($location) && $device->opd_location_id !== $currentOpdId)
                    @php
                        $currentOpdId = $device->opd_location_id;
                        $opdName = $device->opdLocation->nama ?? 'Tanpa Lokasi OPD';
                        $opdCount = $devices->where('opd_location_id', $currentOpdId)->count();
                    @endphp
                    <tr class="group-header">
                        <td colspan="9">
                            LOKASI OPD: {{ strtoupper($opdName) }}
                            <span class="group-count">({{ $opdCount }} Perangkat Terdata)</span>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="text-center">{{ $rowNumber++ }}</td>
                    <td>
                        <div class="font-bold">{{ $device->lokasi_pemasangan ? $device->lokasi_pemasangan : 'Area Utama / Umum' }}</div>
                        @if(isset($location))
                            <div style="font-size:6.5pt; color:#64748b;">{{ $device->opdLocation->nama ?? '' }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="font-bold">{{ $device->merk }}</div>
                        <div style="font-size:6.5pt; color:#475569;">{{ $device->model ?? '-' }}</div>
                    </td>
                    <td class="text-center">{{ $device->tipe }}</td>
                    <td class="font-mono" style="font-size:6.5pt;">{{ $device->nomor_seri ?? '-' }}</td>
                    <td class="font-mono text-blue" style="font-size:6.5pt;">{{ $device->ip_address ?? '-' }}</td>
                    <td class="text-center">
                        @php $st = strtolower(str_replace(' ', '-', $device->status)); @endphp
                        <span class="badge badge-{{ $st }}">{{ $device->status }}</span>
                    </td>
                    <td class="text-center">
                        {{ $device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-' }}
                    </td>
                    <td style="font-size:6.5pt; color:#475569;">
                        {{ $device->keterangan ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding:16px; color:#94a3b8;">
                        Tidak ada data perangkat yang sesuai kriteria filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($devices->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td colspan="6" class="text-right">TOTAL KESELURUHAN PERANGKAT TERDATA:</td>
                <td colspan="3" class="font-bold">{{ $devices->count() }} Unit Perangkat</td>
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
