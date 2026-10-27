<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Usulan Penggantian & Pengadaan Perangkat Jaringan</title>
    <style>
        @page {
            margin: 1.5cm 1.2cm 1.5cm 1.2cm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h3 {
            margin: 0;
            font-size: 11px;
            text-transform: uppercase;
            color: #475569;
            letter-spacing: 0.5px;
        }
        .header h1 {
            margin: 3px 0;
            font-size: 15px;
            text-transform: uppercase;
            color: #0f172a;
        }
        .header p {
            margin: 0;
            font-size: 9px;
            color: #64748b;
        }

        .doc-title-container {
            text-align: center;
            margin-bottom: 12px;
        }
        .doc-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #0f172a;
            margin: 0 0 2px 0;
        }
        .doc-subtitle {
            font-size: 9px;
            color: #475569;
            font-style: italic;
            margin: 0;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 12px;
            font-size: 9px;
            background-color: #f1f5f9;
            padding: 5px 8px;
            border-radius: 4px;
        }

        /* Summary Box */
        .summary-box {
            width: 100%;
            margin-bottom: 12px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
        }
        .summary-box td {
            padding: 6px 10px;
            text-align: center;
            border: none;
        }
        .summary-title {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
        }
        .summary-value {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
        }

        /* Main Table */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 9px;
        }
        table.data-table th {
            background-color: #1e293b;
            color: #ffffff;
            padding: 5px 4px;
            text-align: left;
            font-size: 8.5px;
            text-transform: uppercase;
            border: 1px solid #1e293b;
        }
        table.data-table td {
            padding: 5px 4px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .font-mono { font-family: Courier, monospace; }

        .badge-status {
            color: #7e22ce;
            font-weight: bold;
            font-size: 8.5px;
            text-transform: uppercase;
        }

        .total-row td {
            background-color: #e2e8f0;
            font-weight: bold;
            font-size: 9.5px;
            border-top: 2px solid #0f172a;
        }

        .notes-box {
            margin-top: 12px;
            padding: 6px 8px;
            background-color: #fffbeb;
            border: 1px solid #fef3c7;
            font-size: 8.5px;
            color: #92400e;
        }
        .notes-box p { margin: 2px 0; }

        /* Signatures */
        .signature-table {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            border: none;
            font-size: 9.5px;
        }
        .signature-space {
            height: 50px;
        }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 8px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>Pemerintah Daerah &bull; Dinas Komunikasi dan Informatika</h3>
        <h1>Laporan Rekomendasi Penggantian & Usulan Pengadaan Perangkat</h1>
        <p>Bidang Penyelenggaraan E-Government & Infrastruktur TIK | Sistem Manajemen Aset Jaringan</p>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width:33%;"><strong>Tanggal Cetak:</strong> {{ date('d F Y') }}</td>
            <td style="width:34%; text-align:center;"><strong>Filter Lokasi:</strong> {{ $location ? $location->nama : 'Semua Lokasi OPD' }}</td>
            <td style="width:33%; text-align:right;"><strong>Status:</strong> Rekomendasi Penggantian</td>
        </tr>
    </table>

    <table class="summary-box">
        <tr>
            <td style="border-right: 1px solid #cbd5e1; width:33%;">
                <div class="summary-title">Total Perangkat Perlu Diganti</div>
                <div class="summary-value" style="color:#7e22ce;">{{ $devices->count() }} Unit</div>
            </td>
            <td style="border-right: 1px solid #cbd5e1; width:33%;">
                <div class="summary-title">Sebaran OPD Terdampak</div>
                <div class="summary-value">{{ $totalOpd }} Lokasi OPD</div>
            </td>
            <td style="width:34%;">
                <div class="summary-title">Total Estimasi Kebutuhan Biaya</div>
                <div class="summary-value" style="color:#1d4ed8;">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:20px;" class="text-center">No</th>
                <th style="width:120px;">Lokasi OPD & Ruang</th>
                <th style="width:115px;">Perangkat Saat Ini</th>
                <th style="width:70px;" class="text-center">Tgl / Umur</th>
                <th style="width:65px;" class="text-center">Status</th>
                <th>Alasan Penggantian (Pertimbangan Teknis)</th>
                <th style="width:120px;">Usulan Rekomendasi Pengganti</th>
                <th style="width:90px;" class="text-right">Estimasi Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse($devices as $index => $device)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <div class="font-bold">{{ $device->opdLocation->nama ?? '-' }}</div>
                    <div style="font-size:8px; color:#64748b;">{{ $device->lokasi_pemasangan ?? 'Ruang -' }}</div>
                </td>
                <td>
                    <div class="font-bold">{{ $device->merk }} {{ $device->model }}</div>
                    <div style="font-size:8px; color:#64748b;">
                        {{ $device->tipe }} | SN: {{ $device->nomor_seri ?? '-' }}<br>
                        IP: {{ $device->ip_address ?? '-' }}
                    </div>
                </td>
                <td class="text-center">
                    <div>{{ $device->tanggal_install ? $device->tanggal_install->format('d/m/Y') : '-' }}</div>
                    @if($device->umur_perangkat)
                    <div style="font-size:8px; font-weight:bold; color:#d97706;">({{ $device->umur_perangkat }})</div>
                    @endif
                </td>
                <td class="text-center">
                    <span class="badge-status">{{ $device->status }}</span>
                </td>
                <td>
                    <div style="font-weight:bold; color:#b91c1c;">
                        {{ $device->alasan_penggantian ?? 'Kondisi perangkat menurun / usia teknis habis' }}
                    </div>
                    @if($device->keterangan && $device->keterangan !== $device->alasan_penggantian)
                    <div style="font-size:8px; color:#64748b; font-style:italic;">
                        Catatan: {{ $device->keterangan }}
                    </div>
                    @endif
                </td>
                <td>
                    {{ $device->rekomendasi_pengganti ?? 'Spesifikasi Standar TIK' }}
                </td>
                <td class="text-right font-bold font-mono" style="color:#1d4ed8;">
                    @if($device->estimasi_biaya && $device->estimasi_biaya > 0)
                        Rp {{ number_format($device->estimasi_biaya, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding:15px; color:#64748b;">
                    Tidak ada perangkat dengan status 'Perlu Diganti' yang ditemukan.
                </td>
            </tr>
            @endforelse

            @if($devices->count() > 0)
            <tr class="total-row">
                <td colspan="7" class="text-right">TOTAL KEBUTUHAN ESTIMASI BIAYA PENGADAAN :</td>
                <td class="text-right font-mono" style="color:#1d4ed8;">
                    Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="notes-box">
        <p><strong>Catatan Pertimbangan Teknis Tim Infrastruktur:</strong></p>
        <p>1. Daftar perangkat di atas telah dievaluasi berdasarkan kondisi fisik, keusangan teknologi, dan log pemeliharaan.</p>
        <p>2. Penggantian mendesak untuk menjaga kelancaran koneksi internet & intranet OPD.</p>
        <p>3. Estimasi biaya dapat disesuaikan pada Rencana Kerja Anggaran (RKA/DPA) berdasarkan survei harga pasar/e-Katalog.</p>
    </div>

    <table class="signature-table">
        <tr>
            <td>
                <div>Mengetahui,</div>
                <div style="font-weight:bold; margin-top:2px;">Kepala Bidang Penyelenggaraan E-Government / TIK</div>
                <div class="signature-space"></div>
                <div style="text-decoration:underline; font-weight:bold;">( .............................................................. )</div>
                <div style="font-size:8.5px; color:#64748b;">NIP. .....................................................</div>
            </td>
            <td>
                <div>{{ date('d F Y') }}</div>
                <div style="font-weight:bold; margin-top:2px;">Pejabat / Tim Teknis Jaringan & Infrastruktur</div>
                <div class="signature-space"></div>
                <div style="text-decoration:underline; font-weight:bold;">{{ auth()->user()?->name ?? '( .............................................................. )' }}</div>
                <div style="font-size:8.5px; color:#64748b;">Pengelola Jaringan Komputer</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dicetak melalui Sistem Manajemen Aset Jaringan DISKOMINFO pada {{ date('d/m/Y H:i') }} oleh {{ auth()->user()?->name ?? 'System' }}
    </div>
</body>
</html>
