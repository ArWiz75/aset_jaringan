{{-- ============================================================
     PARTIAL: CSS Pratinjau Cetak Laporan – Unified Print Styles
     Include dengan: @include('partials.print-styles')
     ============================================================ --}}
<style>
/* ===== RESET & BASE ===== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

body {
    font-family: 'Segoe UI', Inter, Tahoma, Geneva, Verdana, sans-serif;
    font-size: 11px;
    color: #1e293b;
    line-height: 1.5;
    background: #eef2f7;
    padding: 0;
    margin: 0;
}

/* ===== ACTION BAR (screen only) ===== */
.action-bar {
    position: sticky;
    top: 0;
    z-index: 999;
    background: #fff;
    border-bottom: 1px solid #e2e8f0;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}
.action-bar-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
.action-bar-title {
    font-size: 13px;
    font-weight: 700;
    color: #0f172a;
}
.action-bar-title span {
    color: #64748b;
    font-weight: 400;
    margin-left: 4px;
}
.action-bar-right {
    display: flex;
    align-items: center;
    gap: 6px;
}

/* ===== BUTTONS ===== */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 14px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 6px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s;
    border: 1px solid transparent;
    white-space: nowrap;
}
.btn-back    { background:#f1f5f9; color:#475569; border-color:#cbd5e1; }
.btn-back:hover { background:#e2e8f0; color:#0f172a; }
.btn-print   { background:#1e293b; color:#fff; }
.btn-print:hover { background:#0f172a; }
.btn-pdf     { background:#fef2f2; color:#dc2626; border-color:#fca5a5; }
.btn-pdf:hover   { background:#fee2e2; }
.btn-excel   { background:#f0fdf4; color:#059669; border-color:#a7f3d0; }
.btn-excel:hover { background:#dcfce7; }

/* ===== PAGE CONTAINER ===== */
.page-wrap {
    max-width: 940px;
    margin: 18px auto;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.09);
    padding: 28px 32px 24px;
}

/* ===== KOP SURAT (dari komponen) ===== */
.kop-surat-resmi { margin-bottom: 0; page-break-inside: avoid; }
.kop-img { width: 100%; max-width: 100%; display: block; height: auto; margin: 0 auto; }
.kop-line-double { border: none; border-top: 3px double #0f172a; margin-top: 5px; margin-bottom: 14px; }

/* ===== JUDUL LAPORAN ===== */
.doc-header {
    text-align: center;
    margin-bottom: 12px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e2e8f0;
}
.doc-title {
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    color: #0f172a;
    letter-spacing: 0.4px;
    line-height: 1.3;
}
.doc-subtitle {
    font-size: 10px;
    color: #64748b;
    font-style: italic;
    margin-top: 3px;
}

/* ===== META INFO BAR ===== */
.meta-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    font-size: 9.5px;
    color: #475569;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 5px;
    padding: 5px 10px;
    margin-bottom: 12px;
}
.meta-bar strong { color: #1e293b; }

/* ===== SUMMARY GRID ===== */
.summary-grid {
    display: grid;
    gap: 10px;
    margin-bottom: 14px;
}
.cols-3 { grid-template-columns: repeat(3, 1fr); }
.cols-4 { grid-template-columns: repeat(4, 1fr); }

.summary-card {
    border: 1px solid #cbd5e1;
    border-radius: 7px;
    padding: 9px 12px;
    background: #fff;
}
.summary-card.c-purple { border-color: #c084fc; background: #faf5ff; }
.summary-card.c-blue   { border-color: #93c5fd; background: #eff6ff; }
.summary-card.c-green  { border-color: #6ee7b7; background: #ecfdf5; }
.summary-card.c-orange { border-color: #fdba74; background: #fff7ed; }
.summary-card.c-red    { border-color: #fca5a5; background: #fef2f2; }

.summary-card .sc-label {
    font-size: 8.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    margin-bottom: 3px;
}
.summary-card .sc-value {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
}
.summary-card .sc-unit {
    font-size: 11px;
    font-weight: 600;
    color: #475569;
    margin-left: 2px;
}
.summary-card .sc-sub {
    font-size: 8.5px;
    color: #94a3b8;
    margin-top: 2px;
}
.summary-card.c-purple .sc-value { color: #7e22ce; }
.summary-card.c-blue   .sc-value { color: #1d4ed8; }
.summary-card.c-green  .sc-value { color: #059669; }
.summary-card.c-orange .sc-value { color: #c2410c; }

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10.5px;
    margin-top: 6px;
}
thead th {
    background: #1e293b;
    color: #fff;
    padding: 7px 6px;
    text-align: left;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    border: 1px solid #1e293b;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
}
tbody td {
    padding: 6px;
    border: 1px solid #dde3ec;
    vertical-align: top;
    color: #1e293b;
}
tbody tr:nth-child(even) td { background: #f8fafc; }
tbody tr:hover td { background: #f1f5f9; }
.total-row td {
    background: #f1f5f9 !important;
    font-weight: 800;
    font-size: 10.5px;
    padding: 7px 6px;
    border-top: 2px solid #1e293b;
}

/* ===== BADGES ===== */
.badge {
    display: inline-block;
    padding: 2px 7px;
    border-radius: 4px;
    font-size: 8.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    white-space: nowrap;
}
.badge-aktif          { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.badge-rusak          { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
.badge-maintenance    { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.badge-perlu-diganti  { background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; }
.badge-nonaktif       { background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; }
.badge-selesai        { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.badge-pending        { background: #fef9c3; color: #a16207; border: 1px solid #fde047; }
.badge-proses         { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
.badge-diusulkan      { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.badge-disetujui      { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.badge-pengadaan      { background: #ede9fe; color: #6d28d9; border: 1px solid #c4b5fd; }
.badge-terealisasi    { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
.badge-ditolak        { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }

/* Urgensi */
.badge-tinggi   { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
.badge-sedang   { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.badge-rendah   { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }

/* ===== NOTES BOX ===== */
.notes-box {
    margin-top: 14px;
    padding: 9px 12px;
    background: #fffbeb;
    border: 1px solid #fef3c7;
    border-left: 3px solid #f59e0b;
    border-radius: 5px;
    font-size: 9.5px;
    color: #78350f;
    line-height: 1.6;
}
.notes-box p { margin: 1px 0; }
.notes-box strong { color: #92400e; }

/* ===== SIGNATURE ===== */
.signature-block {
    margin-top: 28px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    page-break-inside: avoid;
}
.signature-box {
    text-align: center;
    font-size: 10.5px;
}
.signature-box .sig-role {
    font-size: 10px;
    font-weight: 600;
    color: #1e293b;
    margin-top: 2px;
    margin-bottom: 54px;
}
.signature-box .sig-name {
    font-weight: 700;
    color: #0f172a;
    text-decoration: underline;
    font-size: 11px;
}
.signature-box .sig-nip {
    font-size: 9.5px;
    color: #64748b;
    margin-top: 2px;
}
.signature-box .sig-date {
    font-size: 10px;
    color: #475569;
    margin-bottom: 2px;
}

/* ===== PRINT FOOTER ===== */
.print-footer {
    margin-top: 16px;
    padding-top: 7px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 8.5px;
    color: #94a3b8;
}

/* ===== UTILITY ===== */
.text-center { text-align: center; }
.text-right  { text-align: right; }
.font-bold   { font-weight: 700; }
.font-mono   { font-family: ui-monospace, 'Cascadia Code', Consolas, monospace; }
.text-muted  { color: #94a3b8; }
.text-blue   { color: #1d4ed8; }
.text-red    { color: #dc2626; }
.text-green  { color: #15803d; }
.cell-compact td { padding: 4px 6px !important; }

/* ===== PRINT MEDIA RULES ===== */
@media print {
    * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }

    body { background: #fff; padding: 0; }

    .action-bar,
    .no-print { display: none !important; }

    .page-wrap {
        box-shadow: none;
        border-radius: 0;
        padding: 12px 16px;
        margin: 0;
        max-width: 100%;
    }

    thead th {
        background: #1e293b !important;
        color: #fff !important;
    }
    tbody tr:nth-child(even) td {
        background: #f8fafc !important;
    }
    .total-row td { background: #f1f5f9 !important; }
    .summary-card.c-purple { background: #faf5ff !important; }
    .summary-card.c-blue   { background: #eff6ff !important; }
    .summary-card.c-green  { background: #ecfdf5 !important; }
    .summary-card.c-orange { background: #fff7ed !important; }
    .notes-box { background: #fffbeb !important; }
    .meta-bar  { background: #f8fafc !important; }

    table { page-break-inside: auto; }
    tr { page-break-inside: avoid; page-break-after: auto; }
    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }

    .signature-block { page-break-inside: avoid; }
}

/* ===== SCREEN PREVIEW: PAPER FRAME ===== */
@media screen {
    .page-wrap {
        min-height: 90vh;
        margin: 18px auto 36px;
    }
}
</style>
