<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Usulan Penambahan Perangkat - DISKOMINFO</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 9px;
            color: #1e293b;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }
        .kop-surat {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 14px;
            text-align: center;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 11px;
            text-transform: uppercase;
            color: #475569;
        }
        .kop-surat h1 {
            margin: 2px 0;
            font-size: 14px;
            text-transform: uppercase;
            color: #0f172a;
        }
        .kop-surat p {
            margin: 0;
            font-size: 8.5px;
            color: #64748b;
        }
        .doc-title {
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .doc-sub {
            text-align: center;
            font-size: 9px;
            color: #475569;
            margin-bottom: 10px;
        }
        .meta-bar {
            background: #f1f5f9;
            padding: 4px 8px;
            margin-bottom: 12px;
            font-size: 8.5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5px;
            margin-bottom: 16px;
        }
        table th {
            background-color: #059669;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 6px;
            border: 1px solid #047857;
            text-align: left;
            text-transform: uppercase;
            font-size: 8px;
        }
        table td {
            padding: 5px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .ttd-wrap {
            margin-top: 24px;
            width: 100%;
        }
        .ttd-box {
            width: 45%;
            float: left;
            text-align: center;
            font-size: 8.5px;
        }
        .ttd-box.right {
            float: right;
        }
        .ttd-space {
            height: 48px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>Pemerintah Daerah &bull; Dinas Komunikasi dan Informatika</h2>
        <h1>Laporan Rekomendasi &amp; Usulan Penambahan Perangkat Jaringan</h1>
        <p>Bidang Penyelenggaraan E-Government &amp; Tata Kelola Infrastruktur Teknologi Informasi</p>
    </div>

    <div class="doc-title">DAFTAR USULAN PENGADAAN PERANGKAT JARINGAN BARU</div>
    <div class="doc-sub">
        @if($location)
            Lokasi: {{ $location->nama }}
        @else
            Seluruh Organisasi Perangkat Daerah (OPD) Terdaftar
        @endif
        &bull; Tanggal Cetak: {{ date('d F Y') }}
    </div>

    <div class="meta-bar">
        Total Usulan: <strong>{{ $proposals->count() }} item</strong> &bull;
        Total Kebutuhan: <strong>{{ $totalUnit }} unit</strong> &bull;
        Estimasi Total Anggaran: <strong>Rp {{ number_format($totalBiaya, 0, ',', '.') }}</strong>
        @if($emptyOpds->count() > 0)
        &bull; <span style="color:#b45309;"><strong>{{ $emptyOpds->count() }} OPD</strong> belum memiliki perangkat sama sekali</span>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 20px;">No</th>
                <th style="width: 120px;">Lokasi OPD</th>
                <th style="width: 85px;">Ruang Pasang</th>
                <th style="width: 85px;">Tipe &amp; Jml</th>
                <th class="text-center" style="width: 50px;">Urgensi</th>
                <th>Alasan Kebutuhan / Justifikasi Teknis</th>
                <th style="width: 110px;">Rekomendasi Spek</th>
                <th class="text-right" style="width: 80px;">Estimasi Biaya</th>
                <th class="text-center" style="width: 60px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proposals as $idx => $p)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td class="font-bold">{{ $p->opdLocation->nama ?? '-' }}</td>
                <td>{{ $p->lokasi_ruang ?: 'Area Utama' }}</td>
                <td>{{ $p->tipe_perangkat }} ({{ $p->jumlah }} unit)</td>
                <td class="text-center">{{ $p->urgensi }}</td>
                <td>{{ $p->alasan_kebutuhan }}</td>
                <td>{{ $p->rekomendasi_spesifikasi ?: '-' }}</td>
                <td class="text-right font-bold">{{ $p->formatted_biaya }}</td>
                <td class="text-center">{{ $p->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data usulan penambahan perangkat.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background:#ecfdf5; font-weight:bold;">
                <td colspan="3" class="text-right">TOTAL KEBUTUHAN UNIT:</td>
                <td>{{ $totalUnit }} Unit</td>
                <td colspan="3" class="text-right">TOTAL ANGGARAN:</td>
                <td class="text-right">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <div class="ttd-wrap">
        <div class="ttd-box">
            <p>Mengetahui,</p>
            <p><strong>Kepala Dinas Komunikasi &amp; Informatika</strong></p>
            <div class="ttd-space"></div>
            <p><strong>( .................................................... )</strong></p>
            <p>NIP. ....................................................</p>
        </div>

        <div class="ttd-box right">
            <p>{{ date('d F Y') }}</p>
            <p><strong>Penanggung Jawab / Tim Jaringan</strong></p>
            <div class="ttd-space"></div>
            <p><strong>{{ Auth::check() ? Auth::user()->name : 'Admin DISKOMINFO' }}</strong></p>
            <p>Pengelola Infrastruktur Jaringan</p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
