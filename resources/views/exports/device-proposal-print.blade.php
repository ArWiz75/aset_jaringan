<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Rekomendasi & Usulan Penambahan Perangkat - DISKOMINFO</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.45;
            margin: 0;
            padding: 24px;
            background-color: #f8fafc;
        }
        .page-container {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            padding: 32px 36px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.07);
        }

        /* Kop Surat Resmi */
        .kop-surat {
            border-bottom: 3px double #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }
        .kop-text h2 {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #334155;
        }
        .kop-text h1 {
            margin: 2px 0;
            font-size: 17px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #0f172a;
        }
        .kop-text p {
            margin: 0;
            font-size: 10px;
            color: #64748b;
        }

        /* Document Title */
        .doc-title-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .doc-title {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            color: #0f172a;
            margin: 0 0 4px 0;
            letter-spacing: 0.5px;
        }
        .doc-subtitle {
            font-size: 10.5px;
            color: #475569;
            margin: 0;
            font-style: italic;
        }
        .meta-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            color: #475569;
            margin-top: 10px;
            padding: 6px 10px;
            background: #f1f5f9;
            border-radius: 4px;
        }

        /* Summary Badges */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }
        .summary-card {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px 14px;
            background: #ffffff;
        }
        .summary-card.highlight {
            border-color: #34d399;
            background: #ecfdf5;
        }
        .summary-card.budget {
            border-color: #93c5fd;
            background: #eff6ff;
        }
        .summary-card.warn {
            border-color: #fed7aa;
            background: #fffbeb;
        }
        .summary-card .label {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 4px;
        }
        .summary-card.highlight .label { color: #047857; }
        .summary-card.budget .label { color: #1d4ed8; }
        .summary-card.warn .label { color: #c2410c; }
        .summary-card .value {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
        }
        .summary-card.highlight .value { color: #065f46; }
        .summary-card.budget .value { color: #1e40af; }
        .summary-card.warn .value { color: #9a3412; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
            margin-bottom: 24px;
        }
        table th {
            background-color: #059669;
            color: #ffffff;
            font-weight: 700;
            text-align: left;
            padding: 7px 9px;
            border: 1px solid #047857;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        table td {
            padding: 7px 9px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }

        .urgensi-badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .urgensi-tinggi { background: #fee2e2; color: #991b1b; }
        .urgensi-sedang { background: #fef3c7; color: #92400e; }
        .urgensi-rendah { background: #dbeafe; color: #1e40af; }

        /* Signature block */
        .ttd-container {
            margin-top: 36px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .ttd-box {
            width: 250px;
            text-align: center;
            font-size: 10.5px;
        }
        .ttd-space {
            height: 65px;
        }
        .ttd-name {
            font-weight: 800;
            text-decoration: underline;
            color: #0f172a;
        }

        /* Action bar for screen */
        .no-print {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            background: rgba(15, 23, 42, 0.9);
            padding: 10px 14px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            z-index: 9999;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            color: white;
            transition: all 0.2s;
        }
        .btn-print { background: #059669; }
        .btn-print:hover { background: #047857; }
        .btn-pdf { background: #dc2626; }
        .btn-pdf:hover { background: #b91c1c; }
        .btn-excel { background: #16a34a; }
        .btn-excel:hover { background: #15803d; }

        @media print {
            body { background-color: #ffffff; padding: 0; }
            .page-container { box-shadow: none; padding: 0; max-width: 100%; }
            .no-print { display: none !important; }
            @page { size: landscape; margin: 12mm 15mm; }
        }
    </style>
</head>
<body>

    <div class="page-container">
        {{-- KOP SURAT --}}
        <div class="kop-surat">
            <div class="kop-text">
                <h2>Pemerintah Daerah &bull; Dinas Komunikasi dan Informatika</h2>
                <h1>Laporan Rekomendasi &amp; Usulan Penambahan Perangkat Jaringan</h1>
                <p>Bidang Penyelenggaraan E-Government &amp; Tata Kelola Infrastruktur Teknologi Informasi</p>
            </div>
        </div>

        {{-- DOCUMENT TITLE --}}
        <div class="doc-title-container">
            <div class="doc-title">
                DAFTAR USULAN PENGADAAN &amp; PENAMBAHAN PERANGKAT JARINGAN BARU
            </div>
            <div class="doc-subtitle">
                @if($location)
                    Khusus Lokasi: {{ $location->nama }}
                @else
                    Seluruh Organisasi Perangkat Daerah (OPD) Terdaftar
                @endif
            </div>

            <div class="meta-info">
                <span>Tanggal Cetak: <strong>{{ date('d F Y - H:i') }} WIB</strong></span>
                <span>Dicetak Oleh: <strong>{{ Auth::check() ? Auth::user()->name : 'Admin DISKOMINFO' }}</strong></span>
                <span>Sifat: <strong>Usulan Perencanaan Anggaran &amp; Pengadaan</strong></span>
            </div>
        </div>

        {{-- SUMMARY CARDS --}}
        <div class="summary-grid">
            <div class="summary-card">
                <div class="label">Total Usulan</div>
                <div class="value">{{ $proposals->count() }} Usulan</div>
            </div>
            <div class="summary-card highlight">
                <div class="label">Total Unit Perangkat</div>
                <div class="value">{{ $totalUnit }} Unit</div>
            </div>
            <div class="summary-card budget">
                <div class="label">Estimasi Total Anggaran</div>
                <div class="value">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card warn">
                <div class="label">OPD Belum Berperangkat</div>
                <div class="value">{{ $emptyOpds->count() }} OPD</div>
            </div>
        </div>

        {{-- NOTICE JIKA ADA OPD KOSONG --}}
        @if($emptyOpds->count() > 0 && !request('opd_location_id'))
        <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:6px; padding:8px 12px; margin-bottom:14px; font-size:10px; color:#92400e;">
            <strong>Catatan Khusus Prioritas:</strong> Terdapat {{ $emptyOpds->count() }} lokasi OPD yang saat ini masih belum terpasang perangkat jaringan sama sekali:
            <em>{{ $emptyOpds->pluck('nama')->implode(', ') }}</em>. Disarankan untuk segera diprioritaskan dalam program pengadaan internet.
        </div>
        @endif

        {{-- TABEL DATA USULAN --}}
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 25px;">No</th>
                    <th style="width: 140px;">Lokasi OPD</th>
                    <th style="width: 100px;">Titik Ruang</th>
                    <th style="width: 90px;">Tipe &amp; Jml</th>
                    <th class="text-center" style="width: 65px;">Urgensi</th>
                    <th>Alasan Kebutuhan / Justifikasi Teknis</th>
                    <th>Rekomendasi Spesifikasi / Merk</th>
                    <th class="text-right" style="width: 95px;">Estimasi Biaya</th>
                    <th class="text-center" style="width: 75px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proposals as $idx => $p)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="font-bold">{{ $p->opdLocation->nama ?? '-' }}</td>
                    <td>{{ $p->lokasi_ruang ?: 'Area Utama' }}</td>
                    <td>
                        <strong>{{ $p->tipe_perangkat }}</strong>
                        <div style="font-size:9.5px;color:#64748b;">{{ $p->jumlah }} Unit</div>
                    </td>
                    <td class="text-center">
                        <span class="urgensi-badge urgensi-{{ strtolower($p->urgensi) }}">
                            {{ $p->urgensi }}
                        </span>
                    </td>
                    <td>
                        {{ $p->alasan_kebutuhan }}
                        @if($p->catatan)
                        <div style="font-size:9.5px;color:#64748b;margin-top:2px;"><em>Catatan: {{ $p->catatan }}</em></div>
                        @endif
                    </td>
                    <td>{{ $p->rekomendasi_spesifikasi ?: '-' }}</td>
                    <td class="text-right font-bold">{{ $p->formatted_biaya }}</td>
                    <td class="text-center">
                        <span style="font-weight:700;font-size:9.5px;">{{ $p->status }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 24px; color: #94a3b8;">
                        Tidak ada data usulan penambahan perangkat sesuai filter yang dipilih.
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#ecfdf5; font-weight:bold;">
                    <td colspan="3" class="text-right">TOTAL KEBUTUHAN UNIT:</td>
                    <td>{{ $totalUnit }} Unit</td>
                    <td colspan="3" class="text-right">TOTAL ESTIMASI ANGGARAN:</td>
                    <td class="text-right" style="color:#065f46; font-size:11.5px;">
                        Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        {{-- KOLOM TANDA TANGAN RESMI --}}
        <div class="ttd-container">
            <div class="ttd-box">
                <p>Mengetahui,</p>
                <p style="font-weight:700;">Kepala Dinas Komunikasi &amp; Informatika</p>
                <div class="ttd-space"></div>
                <div class="ttd-name">( .................................................... )</div>
                <p style="font-size:9.5px;color:#64748b;margin-top:2px;">NIP. ....................................................</p>
            </div>

            <div class="ttd-box">
                <p>{{ date('d F Y') }}</p>
                <p style="font-weight:700;">Penanggung Jawab / Tim Jaringan</p>
                <div class="ttd-space"></div>
                <div class="ttd-name">{{ Auth::check() ? Auth::user()->name : 'Admin DISKOMINFO' }}</div>
                <p style="font-size:9.5px;color:#64748b;margin-top:2px;">Pengelola Infrastruktur Jaringan</p>
            </div>
        </div>
    </div>

    {{-- FLOATING ACTION BUTTONS --}}
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Cetak Dokumen</span>
        </button>
        <a href="{{ route('export.proposals.pdf', request()->query()) }}" class="btn btn-pdf">
            <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
            <span>Unduh PDF</span>
        </a>
        <a href="{{ route('export.proposals.excel', request()->query()) }}" class="btn btn-excel">
            <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"/></svg>
            <span>Unduh Excel</span>
        </a>
    </div>

</body>
</html>
