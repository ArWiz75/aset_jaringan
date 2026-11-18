{{--
    Komponen Kop Surat Resmi
    Pemerintah Kabupaten Jembrana – Dinas Komunikasi dan Informatika

    CARA PAKAI:
      <x-kop-surat />                        → kop biasa
      <x-kop-surat :forPdf="true" />         → mode PDF (gunakan base64 agar tercetak di DomPDF)
      <x-kop-surat judul="Judul Laporan" />  → dengan judul di bawah kop
--}}

@props([
    'forPdf'   => false,   // true jika dirender oleh DomPDF (pakai base64 logo)
    'judul'    => null,    // opsional: judul laporan di bawah kop
    'subJudul' => null,    // opsional: sub-judul laporan
])

@php
    $logoPublicPath = public_path('images/kop-surat.jpg');
    $logoExists     = file_exists($logoPublicPath);

    if ($forPdf && $logoExists) {
        // DomPDF tidak bisa akses URL publik, gunakan base64
        $logoSrc = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPublicPath));
    } else {
        $logoSrc = asset('images/kop-surat.jpg');
    }
@endphp

<div class="kop-surat-resmi" style="text-align: center; margin-bottom: 12px; page-break-inside: avoid;">
    @if($logoExists)
        <img src="{{ $logoSrc }}"
             alt="Kop Surat Dinas Komunikasi dan Informatika Pemerintah Kabupaten Jembrana"
             class="kop-img"
             style="width: 100%; max-width: 100%; height: auto; display: block; margin: 0 auto;">
    @else
        <div class="kop-fallback" style="text-align: center; padding-bottom: 8px;">
            <div style="font-size: 13px; font-weight: 700; color: #0f172a; letter-spacing: 1px; text-transform: uppercase;">PEMERINTAH KABUPATEN JEMBRANA</div>
            <div style="font-size: 18px; font-weight: 900; color: #0f172a; letter-spacing: 0.5px; text-transform: uppercase; margin: 2px 0;">DINAS KOMUNIKASI DAN INFORMATIKA</div>
            <div style="font-size: 10px; color: #334155; margin: 1px 0;">Jalan Surapati No. 1 Negara, Telepon (0365) 41210, Fax.: 41210</div>
            <div style="font-size: 10px; color: #334155;">website: https://kominfo.jembranakab.go.id/ &nbsp;|&nbsp; email: kominfo@jembranakab.go.id</div>
        </div>
    @endif

    {{-- Garis Pembatas Kop Surat (Double Border khas instansi resmi) --}}
    <div class="kop-line-double" style="border-top: 3px double #0f172a; margin-top: 6px; margin-bottom: 16px;"></div>

    @if($judul)
        <div class="kop-judul-wrap" style="text-align: center; margin-top: 8px; margin-bottom: 14px;">
            <div class="kop-judul" style="font-size: 13px; font-weight: 800; text-transform: uppercase; color: #0f172a; letter-spacing: 0.5px;">{{ strtoupper($judul) }}</div>
            @if($subJudul)
                <div class="kop-sub-judul" style="font-size: 10.5px; color: #475569; font-style: italic; margin-top: 3px;">{{ $subJudul }}</div>
            @endif
        </div>
    @endif
</div>
