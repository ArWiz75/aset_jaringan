<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Rekomendasi Penggantian & Pengadaan Perangkat - DISKOMINFO</title>
    @include('partials.print-styles')
</head>
<body>

    {{-- ===== ACTION BAR (tersembunyi saat cetak) ===== --}}
    <div class="action-bar">
        <div class="action-bar-left">
            <a href="{{ route('devices.index') }}" class="btn btn-back">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <span style="color:#cbd5e1;font-size:16px;">|</span>
            <div class="action-bar-title">
                Pratinjau Cetak
                <span>— Laporan Rekomendasi Penggantian Perangkat</span>
            </div>
        </div>
        <div class="action-bar-right">
            <a href="{{ route('export.devices.replacement.pdf') }}?{{ http_build_query(request()->query()) }}"
               class="btn btn-pdf">
                <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                </svg>
                Unduh PDF
            </a>
            <a href="{{ route('export.devices.replacement.excel') }}?{{ http_build_query(request()->query()) }}"
               class="btn btn-excel">
                <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"/>
                </svg>
                Export Excel
            </a>
            <button onclick="window.print()" class="btn btn-print">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Sekarang
            </button>
        </div>
    </div>

    {{-- ===== HALAMAN DOKUMEN ===== --}}
    <div class="page-wrap">

        {{-- KOP SURAT --}}
        <x-kop-surat />

        {{-- JUDUL DOKUMEN --}}
        <div class="doc-header">
            <div class="doc-title">Laporan Rekomendasi Penggantian &amp; Usulan Pengadaan Perangkat Jaringan</div>
            <div class="doc-subtitle">Dokumen Bahan Pertimbangan Pimpinan dalam Rangka Perencanaan Penggantian dan Penganggaran Perangkat Pengganti</div>
        </div>

        {{-- META INFO --}}
        <div class="meta-bar">
            <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            <span><strong>Filter Lokasi:</strong> {{ $location ? $location->nama : 'Semua Lokasi OPD' }}</span>
            <span><strong>Status:</strong> Rekomendasi Pergantian</span>
            <span><strong>Dicetak oleh:</strong> {{ auth()->user()?->name ?? 'Admin DISKOMINFO' }}</span>
        </div>

        {{-- RINGKASAN EKSEKUTIF --}}
        <div class="summary-grid cols-3">
            <div class="summary-card c-purple">
                <div class="sc-label">Total Unit Perlu Diganti</div>
                <div class="sc-value">{{ $devices->count() }}<span class="sc-unit">Unit</span></div>
                <div class="sc-sub">Perangkat prioritas pergantian</div>
            </div>
            <div class="summary-card">
                <div class="sc-label">Sebaran OPD Terdampak</div>
                <div class="sc-value">{{ $totalOpd }}<span class="sc-unit">Lokasi</span></div>
                <div class="sc-sub">Titik lokasi instalasi aktif</div>
            </div>
            <div class="summary-card c-blue">
                <div class="sc-label">Total Estimasi Kebutuhan Biaya</div>
                <div class="sc-value" style="font-size:15px;">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
                <div class="sc-sub">Perkiraan anggaran pengadaan pengganti</div>
            </div>
        </div>

        {{-- TABEL DETAIL PERANGKAT --}}
        <table>
            <thead>
                <tr>
                    <th style="width:24px;" class="text-center">No</th>
                    <th style="width:150px;">Lokasi OPD &amp; Ruang</th>
                    <th style="width:135px;">Perangkat Saat Ini</th>
                    <th style="width:75px;" class="text-center">Tgl Pasang / Umur</th>
                    <th style="width:70px;" class="text-center">Kondisi</th>
                    <th>Alasan Penggantian (Pertimbangan Teknis)</th>
                    <th style="width:145px;">Rekomendasi Pengganti</th>
                    <th style="width:95px;" class="text-right">Estimasi Biaya</th>
                </tr>
            </thead>
            <tbody>
                @forelse($devices as $index => $device)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <div class="font-bold">{{ $device->opdLocation->nama ?? '-' }}</div>
                        <div style="font-size:9px;color:#64748b;margin-top:1px;">
                            📍 {{ $device->lokasi_pemasangan ?? 'Ruang tidak spesifik' }}
                        </div>
                    </td>
                    <td>
                        <div class="font-bold">{{ $device->merk }} {{ $device->model }}</div>
                        <div style="font-size:9px;color:#64748b;margin-top:1px;">
                            <span>Tipe: {{ $device->tipe }}</span><br>
                            <span class="font-mono">SN: {{ $device->nomor_seri ?? '-' }}</span><br>
                            <span class="font-mono text-blue">IP: {{ $device->ip_address ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <div>{{ $device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-' }}</div>
                        @if($device->umur_perangkat)
                        <div style="font-size:9px;font-weight:700;color:#d97706;margin-top:1px;">({{ $device->umur_perangkat }})</div>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge badge-perlu-diganti">{{ $device->status }}</span>
                    </td>
                    <td>
                        <div style="font-weight:600;color:#b91c1c;">
                            {{ $device->alasan_penggantian ?? 'Kondisi perangkat menurun / usia teknis habis' }}
                        </div>
                        @if($device->keterangan && $device->keterangan !== $device->alasan_penggantian)
                        <div style="font-size:9px;color:#64748b;margin-top:2px;font-style:italic;">
                            Catatan: {{ $device->keterangan }}
                        </div>
                        @endif
                    </td>
                    <td>
                        @if($device->rekomendasi_pengganti)
                            <div class="font-bold">{{ $device->rekomendasi_pengganti }}</div>
                        @else
                            <span class="text-muted" style="font-style:italic;">Sesuai spesifikasi standar TIK</span>
                        @endif
                    </td>
                    <td class="text-right font-mono font-bold text-blue">
                        @if($device->estimasi_biaya && $device->estimasi_biaya > 0)
                            Rp {{ number_format($device->estimasi_biaya, 0, ',', '.') }}
                        @else
                            <span class="text-muted" style="font-weight:normal;">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding:24px;color:#94a3b8;font-style:italic;">
                        Tidak ada perangkat dengan status &ldquo;Perlu Diganti&rdquo; sesuai kriteria filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($devices->count() > 0)
            <tfoot>
                <tr class="total-row">
                    <td colspan="7" class="text-right">TOTAL KEBUTUHAN ESTIMASI BIAYA PENGADAAN:</td>
                    <td class="text-right font-mono text-blue" style="font-size:11px;">
                        Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>

        {{-- CATATAN TEKNIS --}}
        <div class="notes-box">
            <p><strong>Catatan Pertimbangan Teknis Tim Infrastruktur Jaringan:</strong></p>
            <p>1. Daftar perangkat di atas telah melalui evaluasi kondisi teknis, frekuensi maintenance, serta masa pakai operasional perangkat.</p>
            <p>2. Penggantian perangkat disarankan untuk menjaga stabilitas interkoneksi jaringan intranet dan layanan publik pada masing-masing OPD.</p>
            <p>3. Estimasi biaya merupakan perkiraan harga pasar / e-Katalog dan dapat disesuaikan pada dokumen perencanaan anggaran (RKA/DPA).</p>
        </div>

        {{-- TANDA TANGAN --}}
        <div class="signature-block">
            <div class="signature-box">
                <div class="sig-date">Mengetahui,</div>
                <div class="sig-role">Kepala Bidang Penyelenggaraan E-Government / TIK</div>
                <div class="sig-name">( ........................................................ )</div>
                <div class="sig-nip">NIP. ...................................................</div>
            </div>
            <div class="signature-box">
                <div class="sig-date">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="sig-role">Pejabat / Tim Teknis Jaringan &amp; Infrastruktur</div>
                <div class="sig-name">{{ auth()->user()?->name ?? '( ........................................................ )' }}</div>
                <div class="sig-nip">Pengelola Jaringan Komputer</div>
            </div>
        </div>

        {{-- PRINT FOOTER --}}
        <div class="print-footer">
            <span>Sistem Informasi Manajemen Aset Jaringan – DISKOMINFO Kab. Jembrana</span>
            <span>Dicetak: {{ now()->format('d/m/Y H:i:s') }} WIB</span>
        </div>

    </div>{{-- /page-wrap --}}
</body>
</html>
