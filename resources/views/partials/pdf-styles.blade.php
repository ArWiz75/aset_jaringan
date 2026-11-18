{{-- ============================================================
     PARTIAL: CSS Khusus Export PDF (Engine: DomPDF / CSS 2.1)
     Include dengan: @include('partials.pdf-styles')
     ============================================================ --}}
<style>
    @page {
        margin: 14mm 15mm 15mm 15mm;
        size: a4 landscape;
    }
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 8pt;
        color: #1e293b;
        line-height: 1.4;
        background: #ffffff;
    }

    /* KOP SURAT */
    .kop-surat-resmi {
        margin-bottom: 12px;
        page-break-inside: avoid;
    }
    .kop-img {
        width: 100%;
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    /* JUDUL DOKUMEN */
    .doc-header {
        text-align: center;
        margin-top: 4px;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1.5px solid #cbd5e1;
        page-break-inside: avoid;
    }
    .doc-title {
        font-size: 11.5pt;
        font-weight: bold;
        text-transform: uppercase;
        color: #0f172a;
        letter-spacing: 0.4px;
        margin-bottom: 3px;
    }
    .doc-subtitle {
        font-size: 8pt;
        color: #475569;
        font-style: italic;
    }

    /* META BAR (Table-based for DomPDF compatibility) */
    table.meta-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 12px;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        page-break-inside: avoid;
    }
    table.meta-table td {
        padding: 5px 10px;
        font-size: 7.5pt;
        color: #475569;
        border: none;
    }
    table.meta-table td strong {
        color: #0f172a;
    }

    /* SUMMARY TABLE */
    table.summary-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 14px;
        page-break-inside: avoid;
    }
    table.summary-table td {
        padding: 6px 10px;
        border: 1px solid #cbd5e1;
        background-color: #ffffff;
        vertical-align: middle;
    }
    .sc-label {
        font-size: 6.5pt;
        font-weight: bold;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.3px;
        margin-bottom: 2px;
    }
    .sc-value {
        font-size: 11.5pt;
        font-weight: bold;
        color: #0f172a;
        line-height: 1.1;
    }
    .sc-unit {
        font-size: 7.5pt;
        font-weight: normal;
        color: #64748b;
        margin-left: 2px;
    }
    .sc-sub {
        font-size: 6.5pt;
        color: #94a3b8;
        margin-top: 2px;
    }
    .sc-purple { background-color: #faf5ff !important; border-color: #c084fc !important; }
    .sc-purple .sc-value { color: #7e22ce !important; }
    .sc-blue   { background-color: #eff6ff !important; border-color: #93c5fd !important; }
    .sc-blue .sc-value { color: #1d4ed8 !important; }
    .sc-green  { background-color: #ecfdf5 !important; border-color: #6ee7b7 !important; }
    .sc-green .sc-value { color: #059669 !important; }
    .sc-orange { background-color: #fff7ed !important; border-color: #fdba74 !important; }
    .sc-orange .sc-value { color: #c2410c !important; }

    /* DATA TABLE */
    table.data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 6px;
        margin-bottom: 12px;
        font-size: 7.5pt;
        page-break-inside: auto;
    }
    table.data-table thead {
        display: table-header-group;
    }
    table.data-table tfoot {
        display: table-footer-group;
    }
    table.data-table tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    table.data-table th {
        background-color: #1e293b;
        color: #ffffff;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 7pt;
        letter-spacing: 0.3px;
        padding: 6px 6px;
        border: 1px solid #1e293b;
        text-align: left;
    }
    table.data-table td {
        padding: 5px 6px;
        border: 1px solid #cbd5e1;
        vertical-align: top;
        color: #1e293b;
        word-wrap: break-word;
    }
    table.data-table tbody tr:nth-child(even) td {
        background-color: #f8fafc;
    }

    /* BARIS MERGED GROUP HEADER (Pemisah Antar OPD) */
    tr.group-header td {
        background-color: #f1f5f9 !important;
        color: #0f172a;
        font-weight: bold;
        font-size: 7.8pt;
        padding: 5px 8px;
        border: 1px solid #94a3b8;
        border-left: 4px solid #1e293b;
        text-align: left;
    }
    tr.group-header td .group-count {
        font-weight: normal;
        font-size: 7pt;
        color: #475569;
        margin-left: 6px;
    }

    .total-row td {
        background-color: #f1f5f9 !important;
        font-weight: bold;
        font-size: 8pt;
        padding: 6px 6px;
        border-top: 2px solid #0f172a;
    }

    /* BADGES */
    .badge {
        display: inline-block;
        padding: 1.5px 5px;
        font-size: 6.5pt;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 3px;
        white-space: nowrap;
    }
    .badge-aktif         { color: #15803d; background-color: #dcfce7; border: 0.5px solid #86efac; }
    .badge-rusak         { color: #b91c1c; background-color: #fee2e2; border: 0.5px solid #fca5a5; }
    .badge-maintenance   { color: #b45309; background-color: #fef3c7; border: 0.5px solid #fde68a; }
    .badge-perlu-diganti { color: #7e22ce; background-color: #f3e8ff; border: 0.5px solid #d8b4fe; }
    .badge-nonaktif      { color: #475569; background-color: #f1f5f9; border: 0.5px solid #cbd5e1; }
    .badge-tinggi        { color: #991b1b; background-color: #fee2e2; border: 0.5px solid #fca5a5; }
    .badge-sedang        { color: #92400e; background-color: #fef3c7; border: 0.5px solid #fde68a; }
    .badge-rendah        { color: #15803d; background-color: #dcfce7; border: 0.5px solid #86efac; }
    .badge-selesai       { color: #15803d; background-color: #dcfce7; border: 0.5px solid #86efac; }
    .badge-pending       { color: #a16207; background-color: #fef9c3; border: 0.5px solid #fde047; }
    .badge-proses        { color: #1d4ed8; background-color: #dbeafe; border: 0.5px solid #bfdbfe; }
    .badge-diusulkan     { color: #0369a1; background-color: #e0f2fe; border: 0.5px solid #bae6fd; }
    .badge-disetujui     { color: #15803d; background-color: #dcfce7; border: 0.5px solid #86efac; }

    /* NOTES BOX */
    .notes-box {
        margin-top: 12px;
        margin-bottom: 14px;
        padding: 6px 10px;
        background-color: #fffbeb;
        border: 1px solid #fef3c7;
        border-left: 3px solid #f59e0b;
        font-size: 7pt;
        color: #78350f;
        page-break-inside: avoid;
    }
    .notes-box p { margin: 2px 0; }
    .notes-box strong { color: #92400e; }

    /* SIGNATURE BLOCK (Table-based) */
    table.signature-table {
        width: 100%;
        margin-top: 24px;
        margin-bottom: 12px;
        border-collapse: collapse;
        page-break-inside: avoid;
    }
    table.signature-table td {
        border: none;
        text-align: center;
        font-size: 8pt;
        vertical-align: top;
    }
    .sig-role {
        font-weight: bold;
        color: #1e293b;
        margin-top: 2px;
    }
    .sig-space {
        height: 52px;
    }
    .sig-name {
        font-weight: bold;
        text-decoration: underline;
        color: #0f172a;
        font-size: 8.5pt;
    }
    .sig-nip {
        font-size: 7.5pt;
        color: #64748b;
        margin-top: 2px;
    }

    /* FOOTER */
    table.footer-table {
        width: 100%;
        margin-top: 16px;
        border-top: 1px solid #cbd5e1;
        padding-top: 5px;
        page-break-inside: avoid;
    }
    table.footer-table td {
        border: none;
        font-size: 6.5pt;
        color: #94a3b8;
    }

    /* UTILITY */
    .text-center { text-align: center; }
    .text-right  { text-align: right; }
    .font-bold   { font-weight: bold; }
    .font-mono   { font-family: 'Courier New', Courier, monospace; }
    .text-muted  { color: #94a3b8; }
    .text-blue   { color: #1d4ed8; }
    .text-green  { color: #059669; }
</style>
