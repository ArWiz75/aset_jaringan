<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Usulan Pengadaan Perangkat Jaringan - DISKOMINFO</title>
    @include('partials.print-styles')
    <style>
        /* Extra: landscape hint for wide table */
        @media print {
            @page { size: landscape; margin: 10mm 14mm; }
        }
    </style>
</head>
<body>

    {{-- ===== ACTION BAR (tersembunyi saat cetak) ===== --}}
    <div class="action-bar">
        <div class="action-bar-left">
            <a href="{{ route('device-proposals.index') }}" class="btn btn-back">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <span style="color:#cbd5e1;font-size:16px;">|</span>
            <div class="action-bar-title">
                Pratinjau Cetak
                <span>— Daftar Usulan Pengadaan Perangkat</span>
            </div>
        </div>
        <div class="action-bar-right">
            <a href="{{ route('export.proposals.pdf', request()->query()) }}"
               class="btn btn-pdf">
                <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                </svg>
                Unduh PDF
            </a>
            <a href="{{ route('export.proposals.excel', request()->query()) }}"
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
            <div class="doc-title">Daftar Usulan Pengadaan &amp; Penambahan Perangkat Jaringan Baru</div>
            <div class="doc-subtitle">
                @if($location)
                    Khusus Lokasi: {{ $location->nama }}
                @else
                    Seluruh Organisasi Perangkat Daerah (OPD) Terdaftar &mdash; Usulan Perencanaan Anggaran &amp; Pengadaan
                @endif
            </div>
        </div>

        {{-- META INFO --}}
        <div class="meta-bar">
            <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} WIB</span>
            <span><strong>Filter Lokasi:</strong> {{ $location ? $location->nama : 'Semua OPD' }}</span>
            <span><strong>Sifat:</strong> Usulan Perencanaan Anggaran</span>
            <span><strong>Dicetak oleh:</strong> {{ Auth::check() ? Auth::user()->name : 'Admin DISKOMINFO' }}</span>
        </div>

        {{-- RINGKASAN EKSEKUTIF --}}
        <div class="summary-grid cols-4">
            <div class="summary-card">
                <div class="sc-label">Total Usulan</div>
                <div class="sc-value">{{ $proposals->count() }}<span class="sc-unit">Usulan</span></div>
                <div class="sc-sub">Jumlah entri pengajuan</div>
            </div>
            <div class="summary-card c-green">
                <div class="sc-label">Total Unit Perangkat</div>
                <div class="sc-value">{{ $totalUnit }}<span class="sc-unit">Unit</span></div>
                <div class="sc-sub">Kebutuhan unit pengadaan</div>
            </div>
            <div class="summary-card c-blue">
                <div class="sc-label">Estimasi Total Anggaran</div>
                <div class="sc-value" style="font-size:13px;">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
                <div class="sc-sub">Perkiraan kebutuhan anggaran</div>
            </div>
            <div class="summary-card c-orange">
                <div class="sc-label">OPD Belum Berperangkat</div>
                <div class="sc-value">{{ $emptyOpds->count() }}<span class="sc-unit">OPD</span></div>
                <div class="sc-sub">Lokasi belum ada instalasi</div>
            </div>
        </div>

        {{-- NOTICE OPD KOSONG --}}
        @if($emptyOpds->count() > 0 && !request('opd_location_id'))
        <div class="notes-box" style="margin-bottom:12px;">
            <p><strong>⚠️ Catatan Prioritas:</strong> Terdapat <strong>{{ $emptyOpds->count() }}</strong> lokasi OPD yang belum terpasang perangkat jaringan sama sekali:</p>
            <p style="margin-top:3px;"><em>{{ $emptyOpds->pluck('nama')->implode(', ') }}</em></p>
            <p style="margin-top:2px;">Disarankan untuk segera diprioritaskan dalam program pengadaan internet.</p>
        </div>
        @endif

        {{-- TABEL USULAN PERANGKAT --}}
        <table>
            <thead>
                <tr>
                    <th style="width:24px;" class="text-center">No</th>
                    <th style="width:145px;">Lokasi OPD</th>
                    <th style="width:95px;">Titik Ruang</th>
                    <th style="width:90px;">Tipe &amp; Jumlah</th>
                    <th style="width:62px;" class="text-center">Urgensi</th>
                    <th>Alasan Kebutuhan / Justifikasi Teknis</th>
                    <th style="width:130px;">Rekomendasi Spesifikasi</th>
                    <th style="width:90px;" class="text-right">Estimasi Biaya</th>
                    <th style="width:70px;" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proposals as $idx => $p)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="font-bold">{{ $p->opdLocation->nama ?? '-' }}</td>
                    <td>{{ $p->lokasi_ruang ?: 'Area Utama' }}</td>
                    <td>
                        <div class="font-bold">{{ $p->tipe_perangkat }}</div>
                        <div style="font-size:9px;color:#64748b;margin-top:1px;">{{ $p->jumlah }} Unit</div>
                    </td>
                    <td class="text-center">
                        @php $urg = strtolower($p->urgensi); @endphp
                        <span class="badge badge-{{ $urg === 'tinggi' ? 'tinggi' : ($urg === 'sedang' ? 'sedang' : 'rendah') }}">
                            {{ $p->urgensi }}
                        </span>
                    </td>
                    <td>
                        <div>{{ $p->alasan_kebutuhan }}</div>
                        @if($p->catatan)
                        <div style="font-size:9px;color:#64748b;margin-top:2px;font-style:italic;">
                            Catatan: {{ $p->catatan }}
                        </div>
                        @endif
                    </td>
                    <td>{{ $p->rekomendasi_spesifikasi ?: '-' }}</td>
                    <td class="text-right font-bold font-mono">{{ $p->formatted_biaya }}</td>
                    <td class="text-center">
                        @php $st = strtolower(str_replace(' ', '-', $p->status)); @endphp
                        <span class="badge badge-{{ $st }}">{{ $p->status }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding:24px;color:#94a3b8;font-style:italic;">
                        Tidak ada data usulan penambahan perangkat sesuai filter yang dipilih.
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-right">TOTAL KEBUTUHAN UNIT:</td>
                    <td class="font-bold">{{ $totalUnit }} Unit</td>
                    <td colspan="3" class="text-right">TOTAL ESTIMASI ANGGARAN:</td>
                    <td class="text-right font-mono text-green" style="font-size:11px;">
                        Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        {{-- CATATAN TEKNIS --}}
        <div class="notes-box">
            <p><strong>Catatan Pertimbangan Teknis Tim Infrastruktur Jaringan:</strong></p>
            <p>1. Usulan pengadaan di atas telah disusun berdasarkan hasil survei kebutuhan dan evaluasi kapasitas jaringan per lokasi OPD.</p>
            <p>2. Tingkat urgensi ditentukan berdasarkan kebutuhan layanan publik, kondisi infrastruktur eksisting, dan prioritas program kerja bidang TIK.</p>
            <p>3. Estimasi biaya mengacu pada harga referensi pasar / e-Katalog LKPP dan dapat disesuaikan pada dokumen RKA/DPA tahun berjalan.</p>
        </div>

        {{-- TANDA TANGAN --}}
        <div class="signature-block">
            <div class="signature-box">
                <div class="sig-date">Mengetahui,</div>
                <div class="sig-role">Kepala Dinas Komunikasi &amp; Informatika<br>Kabupaten Jembrana</div>
                <div class="sig-name">( ........................................................ )</div>
                <div class="sig-nip">NIP. ...................................................</div>
            </div>
            <div class="signature-box">
                <div class="sig-date">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="sig-role">Penanggung Jawab / Tim Jaringan &amp; Infrastruktur</div>
                <div class="sig-name">{{ Auth::check() ? Auth::user()->name : '( ........................................................ )' }}</div>
                <div class="sig-nip">Pengelola Infrastruktur Jaringan</div>
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
