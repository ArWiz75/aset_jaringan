{{-- ============================================================
     PARTIAL: CSS Kop Surat Resmi
     Include dengan: @include('partials.kop-styles')
     ============================================================ --}}
<style>
/* ===== KOP SURAT RESMI ===== */
.kop-surat-resmi {
    margin-bottom: 0;
    page-break-inside: avoid;
}
.kop-img {
    width: 100%;
    max-width: 100%;
    display: block;
    margin: 0 auto;
}

/* Fallback teks jika gambar tidak ada */
.kop-fallback {
    text-align: center;
    padding-bottom: 8px;
}
.kop-instansi-atas {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: 1px;
    text-transform: uppercase;
}
.kop-instansi {
    font-size: 18px;
    font-weight: 900;
    color: #0f172a;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin: 2px 0;
}
.kop-alamat {
    font-size: 10px;
    color: #334155;
    margin: 1px 0;
}
.kop-line {
    border: none;
    border-top: 3px double #0f172a;
    margin: 4px 0 0 0;
}

/* Judul laporan di bawah kop */
.kop-judul-wrap {
    text-align: center;
    margin-top: 14px;
    margin-bottom: 14px;
}
.kop-judul {
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    color: #0f172a;
    letter-spacing: 0.5px;
}
.kop-sub-judul {
    font-size: 10px;
    color: #475569;
    font-style: italic;
    margin-top: 2px;
}

/* Pemisah antara kop dan isi laporan */
.kop-separator {
    border: none;
    border-top: 1px solid #cbd5e1;
    margin: 12px 0 16px 0;
}

/* Meta info (tanggal cetak, filter, dll) */
.meta-info-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 10px;
    color: #475569;
    margin-bottom: 14px;
    padding: 5px 10px;
    background: #f1f5f9;
    border-radius: 4px;
    border: 1px solid #e2e8f0;
}

/* Footer resmi cetak */
.print-footer {
    margin-top: 20px;
    padding-top: 8px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    font-size: 9px;
    color: #94a3b8;
}

/* Blok tanda tangan */
.signature-container {
    margin-top: 32px;
    display: flex;
    justify-content: space-between;
    page-break-inside: avoid;
}
.signature-box {
    width: 260px;
    text-align: center;
    font-size: 11px;
}
.signature-box .role {
    font-weight: 600;
    margin-bottom: 65px;
    color: #1e293b;
    font-size: 10.5px;
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

@media print {
    .kop-img {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>

