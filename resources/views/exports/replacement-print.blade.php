<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Rekomendasi Penggantian & Pengadaan Perangkat - DISKOMINFO</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11.5px;
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
        .kop-logo {
            position: absolute;
            left: 10px;
            top: 2px;
            width: 60px;
            height: 60px;
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
            grid-template-columns: repeat(3, 1fr);
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
            border-color: #c084fc;
            background: #faf5ff;
        }
        .summary-card.budget {
            border-color: #93c5fd;
            background: #eff6ff;
        }
        .summary-card .label {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 4px;
        }
        .summary-card .value {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }
        .summary-card .sub {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 10.5px;
        }
        th {
            background-color: #1e293b;
            color: #ffffff;
            padding: 8px 6px;
            text-align: left;
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            border: 1px solid #1e293b;
        }
        td {
            padding: 7px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }
        .font-mono { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; }

        .badge-status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #f3e8ff;
            color: #7e22ce;
            border: 1px solid #d8b4fe;
        }

        .total-row td {
            background-color: #f1f5f9;
            font-weight: 800;
            font-size: 11px;
            padding: 8px 6px;
            border-top: 2px solid #0f172a;
        }

        /* Notes Box */
        .notes-box {
            margin-top: 18px;
            padding: 10px 14px;
            background: #fffbeb;
            border: 1px solid #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 4px;
            font-size: 10px;
            color: #92400e;
        }
        .notes-box p { margin: 2px 0; }

        /* Signature block */
        .signature-container {
            margin-top: 36px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .signature-box {
            width: 280px;
            text-align: center;
            font-size: 11px;
        }
        .signature-box .role {
            font-weight: 600;
            margin-bottom: 70px;
            color: #1e293b;
        }
        .signature-box .name {
            font-weight: 700;
            text-decoration: underline;
            color: #0f172a;
        }
        .signature-box .nip {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }

        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #94a3b8;
        }

        /* Print Controls */
        .action-bar {
            position: sticky;
            top: 0;
            z-index: 999;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }
        .btn-primary {
            background-color: #2563eb;
            color: #ffffff;
        }
        .btn-primary:hover { background-color: #1d4ed8; }
        .btn-secondary {
            background-color: #f1f5f9;
            color: #475569;
            border-color: #cbd5e1;
        }
        .btn-secondary:hover { background-color: #e2e8f0; color: #0f172a; }
        .btn-pdf {
            background-color: #fee2e2;
            color: #dc2626;
            border-color: #fca5a5;
        }
        .btn-pdf:hover { background-color: #fecaca; }
        .btn-excel {
            background-color: #ecfdf5;
            color: #059669;
            border-color: #a7f3d0;
        }
        .btn-excel:hover { background-color: #d1fae5; }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .page-container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .action-bar, .no-print {
                display: none !important;
            }
            th {
                background-color: #1e293b !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .summary-card.highlight {
                background-color: #faf5ff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .summary-card.budget {
                background-color: #eff6ff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .total-row td {
                background-color: #f1f5f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .notes-box {
                background-color: #fffbeb !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .badge-status {
                background-color: #f3e8ff !important;
                color: #7e22ce !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    {{-- Action Bar (Hidden on Print) --}}
    <div class="action-bar no-print">
        <div style="display:flex;align-items:center;gap:10px;">
            <a href="{{ route('devices.index') }}" class="btn btn-secondary">
                ← Kembali ke Daftar Perangkat
            </a>
            <span style="font-size:12px;color:#64748b;">|</span>
            <span style="font-size:13px;font-weight:600;color:#0f172a;">
                Pratinjau Cetak Laporan Usulan Penggantian
            </span>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('export.devices.replacement.pdf') }}?{{ http_build_query(request()->query()) }}" class="btn btn-pdf">
                <svg style="width:16px;height:16px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                Unduh PDF
            </a>
            <a href="{{ route('export.devices.replacement.excel') }}?{{ http_build_query(request()->query()) }}" class="btn btn-excel">
                <svg style="width:16px;height:16px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path></svg>
                Export Excel
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Sekarang
            </button>
        </div>
    </div>

    <div class="page-container">
        {{-- Kop Surat Resmi --}}
        <div class="kop-surat">
            <div class="kop-text">
                <h2>Pemerintah Daerah</h2>
                <h1>Dinas Komunikasi dan Informatika</h1>
                <p>Bidang Penyelenggaraan E-Government & Infrastruktur Teknologi Informasi</p>
                <p>Sistem Informasi Manajemen Aset Jaringan (SIM-AJ)</p>
            </div>
        </div>

        {{-- Judul Laporan --}}
        <div class="doc-title-container">
            <h2 class="doc-title">Laporan Rekomendasi Penggantian & Usulan Pengadaan Perangkat Jaringan</h2>
            <p class="doc-subtitle">Dokumen Bahan Pertimbangan Pimpinan dalam Rangka Perencanaan Penggantian dan Penganggaran Perangkat Pengganti</p>
            <div class="meta-info">
                <span><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                <span><strong>Filter Lokasi:</strong> {{ $location ? $location->nama : 'Semua Lokasi OPD' }}</span>
                <span><strong>Status:</strong> Rekomendasi Pergantian</span>
            </div>
        </div>

        {{-- Executive Summary Cards --}}
        <div class="summary-grid">
            <div class="summary-card highlight">
                <div class="label">Total Unit Perlu Diganti</div>
                <div class="value" style="color:#7e22ce;">{{ $devices->count() }} <span style="font-size:12px;font-weight:600;">Unit</span></div>
                <div class="sub">Perangkat prioritas pergantian</div>
            </div>
            <div class="summary-card">
                <div class="label">Sebaran OPD Terdampak</div>
                <div class="value">{{ $totalOpd }} <span style="font-size:12px;font-weight:600;">Lokasi OPD</span></div>
                <div class="sub">Titik lokasi instalasi aktif</div>
            </div>
            <div class="summary-card budget">
                <div class="label">Total Estimasi Kebutuhan Biaya</div>
                <div class="value" style="color:#1d4ed8;font-size:16px;">
                    Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                </div>
                <div class="sub">Perkiraan anggaran pengadaan pengganti</div>
            </div>
        </div>

        {{-- Detail Table --}}
        <table>
            <thead>
                <tr>
                    <th style="width:25px;" class="text-center">No</th>
                    <th style="width:140px;">Lokasi OPD & Ruang</th>
                    <th style="width:130px;">Perangkat Saat Ini</th>
                    <th style="width:80px;" class="text-center">Tgl Pasang / Umur</th>
                    <th style="width:75px;" class="text-center">Kondisi Status</th>
                    <th>Alasan Penggantian (Pertimbangan Teknis)</th>
                    <th style="width:150px;">Usulan / Rekomendasi Pengganti</th>
                    <th style="width:100px;" class="text-right">Estimasi Biaya</th>
                </tr>
            </thead>
            <tbody>
                @forelse($devices as $index => $device)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <div class="font-bold text-slate-900">{{ $device->opdLocation->nama ?? '-' }}</div>
                        <div style="font-size:9.5px;color:#64748b;margin-top:2px;">
                            📍 {{ $device->lokasi_pemasangan ?? 'Ruang tidak spesifik' }}
                        </div>
                    </td>
                    <td>
                        <div class="font-bold">{{ $device->merk }} {{ $device->model }}</div>
                        <div style="font-size:9px;color:#64748b;margin-top:2px;">
                            <span>Tipe: {{ $device->tipe }}</span><br>
                            <span class="font-mono">SN: {{ $device->nomor_seri ?? '-' }}</span><br>
                            <span class="font-mono" style="color:#0284c7;">IP: {{ $device->ip_address ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <div>{{ $device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-' }}</div>
                        @if($device->umur_perangkat)
                        <div style="font-size:9px;font-weight:700;color:#d97706;margin-top:2px;">
                            ({{ $device->umur_perangkat }})
                        </div>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge-status">{{ $device->status }}</span>
                    </td>
                    <td>
                        <div style="font-weight:600;color:#b91c1c;margin-bottom:2px;">
                            {{ $device->alasan_penggantian ?? 'Kondisi perangkat menurun / usia teknis habis' }}
                        </div>
                        @if($device->keterangan && $device->keterangan !== $device->alasan_penggantian)
                        <div style="font-size:9.5px;color:#64748b;margin-top:3px;font-style:italic;">
                            Catatan: {{ $device->keterangan }}
                        </div>
                        @endif
                    </td>
                    <td>
                        @if($device->rekomendasi_pengganti)
                            <div class="font-bold" style="color:#0f172a;">{{ $device->rekomendasi_pengganti }}</div>
                        @else
                            <div style="color:#94a3b8;font-style:italic;">Diserahkan pada spesifikasi standar TIK</div>
                        @endif
                    </td>
                    <td class="text-right font-mono font-bold" style="color:#1d4ed8;">
                        @if($device->estimasi_biaya && $device->estimasi_biaya > 0)
                            Rp {{ number_format($device->estimasi_biaya, 0, ',', '.') }}
                        @else
                            <span style="color:#94a3b8;font-weight:normal;">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding:24px;color:#64748b;font-style:italic;">
                        Tidak ada perangkat dengan status 'Perlu Diganti' yang ditemukan sesuai kriteria filter.
                    </td>
                </tr>
                @endforelse

                @if($devices->count() > 0)
                <tr class="total-row">
                    <td colspan="7" class="text-right">TOTAL KEBUTUHAN ESTIMASI BIAYA PENGADAAN :</td>
                    <td class="text-right font-mono" style="color:#1d4ed8;font-size:12px;">
                        Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        {{-- Notes & Technical Considerations Box --}}
        <div class="notes-box">
            <p><strong>Catatan Pertimbangan Teknis Tim Infrastruktur Jaringan:</strong></p>
            <p>1. Daftar perangkat di atas telah melalui evaluasi kondisi teknis, frekuensi maintenance log perbaikan, serta masa pakai operasional perangkat.</p>
            <p>2. Penggantian perangkat disarankan untuk menjaga stabilitas interkoneksi jaringan intranet dan layanan publik pada masing-masing OPD.</p>
            <p>3. Estimasi biaya merupakan perkiraan harga pasar/e-Katalog perangkat setara dan dapat disesuaikan pada dokumen perencanaan anggaran (RKA/DPA).</p>
        </div>

        {{-- Formal Signature Block --}}
        <div class="signature-container">
            <div class="signature-box">
                <div>Mengetahui,</div>
                <div class="role">Kepala Bidang Penyelenggaraan E-Government / TIK</div>
                <div class="name">( .............................................................. )</div>
                <div class="nip">NIP. .....................................................</div>
            </div>

            <div class="signature-box">
                <div>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div class="role">Pejabat / Tim Teknis Jaringan & Infrastruktur</div>
                <div class="name">{{ auth()->user()?->name ?? '( .............................................................. )' }}</div>
                <div class="nip">Pengelola Jaringan Komputer</div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <span>Sistem Informasi Manajemen Aset Jaringan - DISKOMINFO</span>
            <span>Dicetak oleh: {{ auth()->user()?->name ?? 'System' }} | {{ now()->format('d/m/Y H:i:s') }}</span>
        </div>
    </div>
</body>
</html>
