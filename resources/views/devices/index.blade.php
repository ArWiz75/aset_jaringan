<x-app-layout>
    <x-slot name="title">Perangkat</x-slot>

    @push('styles')
    <style>
        /* ===== PAGE HEADER ===== */
        .page-header-wrap {
            background: linear-gradient(135deg, #0b1528 0%, #102447 50%, #0d3257 100%);
            border: 1px solid rgba(56, 189, 248, 0.28);
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            margin-bottom: 1.25rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.45), 0 0 25px rgba(56, 189, 248, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(10px);
        }
        .page-header-wrap::before {
            content: "";
            position: absolute;
            top: -60px; right: -50px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.18) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .page-header-wrap::after {
            content: "";
            position: absolute;
            bottom: -70px; right: 120px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .page-header-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #f8fafc;
            margin: 0;
            letter-spacing: -0.02em;
        }
        .page-header-sub {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 4px;
        }
        .hdr-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.48rem 0.95rem;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: 9px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .hdr-btn:hover { transform: translateY(-1px); }
        .hdr-btn-ghost {
            background: rgba(255, 255, 255, 0.06);
            color: #e2e8f0;
            border: 1px solid rgba(99, 120, 150, 0.3);
            backdrop-filter: blur(6px);
        }
        .hdr-btn-ghost:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            border-color: rgba(99, 120, 150, 0.5);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }
        .hdr-btn-primary {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #0b1120;
            font-weight: 800;
            border: 1px solid rgba(245, 158, 11, 0.5);
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.25), 0 4px 14px rgba(0, 0, 0, 0.35);
        }
        .hdr-btn-primary:hover {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            box-shadow: 0 0 26px rgba(245, 158, 11, 0.4), 0 6px 18px rgba(0, 0, 0, 0.4);
            color: #0b1120;
        }

        /* ===== STAT CARDS ROW ===== */
        .stat-cards-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.85rem;
            margin-bottom: 1.25rem;
        }
        @media(max-width:768px){.stat-cards-row{grid-template-columns:repeat(2,1fr);}}
        @media(max-width:480px){.stat-cards-row{grid-template-columns:1fr;}}

        .stat-card {
            border-radius: 14px;
            padding: 1.05rem 1.15rem;
            display: flex;
            align-items: center;
            gap: 0.9rem;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(8px);
        }
        .stat-card:hover { transform: translateY(-2px); }

        .stat-card-blue {
            border: 1px solid rgba(56, 189, 248, 0.35);
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.08), 0 4px 16px rgba(0,0,0,0.4), inset 0 1px 0 rgba(56, 189, 248, 0.1);
            background: linear-gradient(135deg, rgba(14, 22, 36, 0.9) 0%, rgba(7, 35, 55, 0.7) 100%);
        }
        .stat-card-blue:hover {
            box-shadow: 0 0 28px rgba(56, 189, 248, 0.2), 0 6px 20px rgba(0,0,0,0.5);
            border-color: rgba(56, 189, 248, 0.55);
        }

        .stat-card-green {
            border: 1px solid rgba(16, 185, 129, 0.35);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.08), 0 4px 16px rgba(0,0,0,0.4), inset 0 1px 0 rgba(16, 185, 129, 0.1);
            background: linear-gradient(135deg, rgba(13, 22, 20, 0.9) 0%, rgba(5, 40, 30, 0.7) 100%);
        }
        .stat-card-green:hover {
            box-shadow: 0 0 28px rgba(16, 185, 129, 0.2), 0 6px 20px rgba(0,0,0,0.5);
            border-color: rgba(16, 185, 129, 0.55);
        }

        .stat-card-purple {
            border: 1px solid rgba(139, 92, 246, 0.35);
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.08), 0 4px 16px rgba(0,0,0,0.4), inset 0 1px 0 rgba(139, 92, 246, 0.1);
            background: linear-gradient(135deg, rgba(18, 13, 30, 0.9) 0%, rgba(35, 15, 60, 0.7) 100%);
        }
        .stat-card-purple:hover {
            box-shadow: 0 0 28px rgba(139, 92, 246, 0.2), 0 6px 20px rgba(0,0,0,0.5);
            border-color: rgba(139, 92, 246, 0.55);
        }

        .stat-card-red {
            border: 1px solid rgba(239, 68, 68, 0.35);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.08), 0 4px 16px rgba(0,0,0,0.4), inset 0 1px 0 rgba(239, 68, 68, 0.1);
            background: linear-gradient(135deg, rgba(22, 10, 10, 0.9) 0%, rgba(50, 10, 10, 0.7) 100%);
        }
        .stat-card-red:hover {
            box-shadow: 0 0 28px rgba(239, 68, 68, 0.2), 0 6px 20px rgba(0,0,0,0.5);
            border-color: rgba(239, 68, 68, 0.55);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .stat-icon svg { width: 22px; height: 22px; }
        .stat-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #94a3b8;
            margin-bottom: 3px;
        }
        .stat-value {
            font-size: 1.65rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        /* ===== STATUS PILLS ===== */
        .status-pills-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            overflow-x: auto;
            padding-bottom: 6px;
            margin-bottom: 1rem;
        }
        .status-pills-bar::-webkit-scrollbar { height: 4px; }
        .status-pills-bar::-webkit-scrollbar-thumb { background: rgba(99, 120, 150, 0.25); border-radius: 4px; }

        .spill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.4rem 0.9rem;
            font-size: 0.74rem;
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.2s ease;
            background: rgba(22, 30, 46, 0.7);
            border: 1px solid rgba(99, 120, 150, 0.22);
            color: #94a3b8;
            backdrop-filter: blur(6px);
        }
        .spill:hover {
            transform: translateY(-1px);
            border-color: rgba(99, 120, 150, 0.45);
            color: #e2e8f0;
        }
        .spill-dot { width: 7px; height: 7px; border-radius: 50%; }
        .spill-count {
            padding: 1px 7px;
            border-radius: 30px;
            font-size: 0.65rem;
            font-weight: 800;
            background: rgba(255, 255, 255, 0.08);
        }

        .spill-all.active {
            background: rgba(56, 189, 248, 0.15);
            border-color: rgba(56, 189, 248, 0.5);
            color: #38bdf8;
            box-shadow: 0 0 14px rgba(56, 189, 248, 0.2);
        }
        .spill-all.active .spill-count { background: rgba(56, 189, 248, 0.25); color: #7dd3fc; }

        .spill-aktif .spill-dot { background: #10b981; box-shadow: 0 0 6px rgba(16, 185, 129, 0.6); }
        .spill-aktif.active {
            background: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.5);
            color: #34d399;
            box-shadow: 0 0 14px rgba(16, 185, 129, 0.2);
        }
        .spill-aktif.active .spill-count { background: rgba(16, 185, 129, 0.25); color: #a7f3d0; }

        .spill-ganti .spill-dot { background: #8b5cf6; box-shadow: 0 0 6px rgba(139, 92, 246, 0.6); }
        .spill-ganti.active {
            background: rgba(139, 92, 246, 0.15);
            border-color: rgba(139, 92, 246, 0.5);
            color: #c4b5fd;
            box-shadow: 0 0 14px rgba(139, 92, 246, 0.2);
        }
        .spill-ganti.active .spill-count { background: rgba(139, 92, 246, 0.25); color: #ddd6fe; }

        .spill-rusak .spill-dot { background: #ef4444; box-shadow: 0 0 6px rgba(239, 68, 68, 0.6); }
        .spill-rusak.active {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.5);
            color: #fca5a5;
            box-shadow: 0 0 14px rgba(239, 68, 68, 0.2);
        }
        .spill-rusak.active .spill-count { background: rgba(239, 68, 68, 0.25); color: #fecaca; }

        .spill-maint .spill-dot { background: #f59e0b; box-shadow: 0 0 6px rgba(245, 158, 11, 0.6); }
        .spill-maint.active {
            background: rgba(245, 158, 11, 0.15);
            border-color: rgba(245, 158, 11, 0.5);
            color: #fcd34d;
            box-shadow: 0 0 14px rgba(245, 158, 11, 0.2);
        }
        .spill-maint.active .spill-count { background: rgba(245, 158, 11, 0.25); color: #fef3c7; }

        .spill-nonaktif .spill-dot { background: #94a3b8; }
        .spill-nonaktif.active {
            background: rgba(148, 163, 184, 0.15);
            border-color: rgba(148, 163, 184, 0.45);
            color: #cbd5e1;
            box-shadow: 0 0 14px rgba(148, 163, 184, 0.15);
        }
        .spill-nonaktif.active .spill-count { background: rgba(148, 163, 184, 0.25); color: #f1f5f9; }

        /* ===== PERLU DIGANTI BANNER ===== */
        .repl-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            background: linear-gradient(135deg, rgba(30, 18, 50, 0.95), rgba(46, 16, 80, 0.9));
            border: 1px solid rgba(139, 92, 246, 0.4);
            border-left: 4px solid #8b5cf6;
            border-radius: 14px;
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.12), 0 4px 16px rgba(0, 0, 0, 0.4);
            padding: 1rem 1.25rem;
            margin-bottom: 1.15rem;
            backdrop-filter: blur(8px);
        }
        .repl-banner-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(139, 92, 246, 0.2);
            border: 1px solid rgba(139, 92, 246, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .repl-banner-title { font-size: 0.92rem; font-weight: 800; color: #c4b5fd; }
        .repl-banner-sub { font-size: 0.78rem; color: #a78bfa; margin-top: 2px; line-height: 1.4; }
        .repl-export-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.45rem 0.9rem;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .btn-cetak {
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
            color: #fff;
            border: 1px solid rgba(139, 92, 246, 0.5);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.35);
        }
        .btn-cetak:hover {
            background: linear-gradient(135deg, #6d28d9, #7c3aed);
            box-shadow: 0 6px 16px rgba(139, 92, 246, 0.5);
            color: #fff;
        }
        .btn-pdf {
            background: rgba(139, 92, 246, 0.12);
            color: #c4b5fd;
            border: 1px solid rgba(139, 92, 246, 0.4);
        }
        .btn-pdf:hover { background: rgba(139, 92, 246, 0.22); color: #ddd6fe; }
        .btn-excel {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff;
            border: 1px solid rgba(16, 185, 129, 0.5);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        .btn-excel:hover {
            background: linear-gradient(135deg, #047857, #059669);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.45);
            color: #fff;
        }

        /* ===== FILTER CARD ===== */
        .filter-card {
            background: rgba(22, 30, 46, 0.85);
            border: 1px solid rgba(99, 120, 150, 0.22);
            border-radius: 14px;
            padding: 1.1rem 1.25rem;
            margin-bottom: 1.15rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(8px);
        }
        .filter-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #94a3b8;
            margin-bottom: 0.35rem;
        }
        .filter-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.85) !important;
            border: 1px solid rgba(99, 120, 150, 0.3) !important;
            border-radius: 10px !important;
            padding: 0.55rem 0.95rem !important;
            font-size: 0.82rem !important;
            color: #e2e8f0 !important;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .filter-input:focus {
            border-color: #38bdf8 !important;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.18) !important;
            background: rgba(15, 23, 42, 0.95) !important;
            outline: none;
        }
        .filter-input option {
            background: #161b22;
            color: #e2e8f0;
        }
        .filter-btn-submit {
            background: linear-gradient(135deg, #0284c7, #0ea5e9);
            color: #fff;
            border: 1px solid rgba(56, 189, 248, 0.4);
            border-radius: 10px;
            padding: 0.55rem 1.1rem;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s ease;
            box-shadow: 0 0 16px rgba(14, 165, 233, 0.3);
            white-space: nowrap;
        }
        .filter-btn-submit:hover {
            background: linear-gradient(135deg, #0369a1, #0284c7);
            box-shadow: 0 0 22px rgba(14, 165, 233, 0.45);
            transform: translateY(-1px);
        }
        .filter-reset-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.55rem 0.8rem;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
            border: 1px solid rgba(99, 120, 150, 0.3);
            text-decoration: none;
            transition: all 0.2s;
        }
        .filter-reset-btn:hover {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.4);
        }

        /* ===== TABLE ===== */
        .devices-table-wrap {
            background: rgba(22, 30, 46, 0.85);
            border: 1px solid rgba(99, 120, 150, 0.22);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.04);
            backdrop-filter: blur(8px);
        }
        .devices-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.82rem;
        }
        .devices-table thead tr {
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid rgba(99, 120, 150, 0.25);
        }
        .devices-table thead th {
            padding: 0.9rem 1rem;
            text-align: left;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8 !important;
        }
        .devices-table thead th:last-child { text-align: center; }
        .devices-table tbody tr {
            border-bottom: 1px solid rgba(99, 120, 150, 0.12);
            transition: background 0.18s ease;
        }
        .devices-table tbody tr:hover {
            background: rgba(56, 189, 248, 0.04);
        }
        .devices-table tbody tr:last-child { border-bottom: none; }
        .devices-table td {
            padding: 0.85rem 1rem !important;
            vertical-align: middle;
        }

        .dev-name {
            font-weight: 800;
            font-size: 0.88rem;
            color: #f1f5f9;
            line-height: 1.25;
            transition: color 0.15s ease;
        }
        .devices-table tbody tr:hover .dev-name { color: #38bdf8; }
        .dev-model {
            font-size: 0.68rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 2px;
        }
        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 0.25rem 0.6rem;
            border-radius: 7px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(99, 120, 150, 0.25);
            font-size: 0.7rem;
            font-weight: 700;
            color: #cbd5e1;
        }
        .type-badge svg { width: 13px; height: 13px; color: #94a3b8; }

        .ip-cell {
            font-family: "JetBrains Mono", "Courier New", monospace;
            font-size: 0.77rem;
            font-weight: 700;
            color: #38bdf8;
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.28);
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-block;
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.08);
        }

        .loc-name { font-size: 0.79rem; font-weight: 700; color: #cbd5e1; }
        .loc-sub { font-size: 0.68rem; color: #64748b; font-style: italic; margin-top: 2px; }

        /* Badges */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 0.25rem 0.68rem;
            border-radius: 20px;
            font-size: 0.67rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }
        .sbadge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }

        .sbadge-aktif {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }
        .sbadge-aktif .sbadge-dot { background: #10b981; box-shadow: 0 0 6px rgba(16, 185, 129, 0.8); }

        .sbadge-ganti {
            background: rgba(139, 92, 246, 0.15);
            color: #c4b5fd;
            border: 1px solid rgba(139, 92, 246, 0.35);
        }
        .sbadge-ganti .sbadge-dot { background: #8b5cf6; box-shadow: 0 0 6px rgba(139, 92, 246, 0.8); }

        .sbadge-rusak {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.35);
        }
        .sbadge-rusak .sbadge-dot { background: #ef4444; box-shadow: 0 0 6px rgba(239, 68, 68, 0.8); }

        .sbadge-maint {
            background: rgba(245, 158, 11, 0.15);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.35);
        }
        .sbadge-maint .sbadge-dot { background: #f59e0b; box-shadow: 0 0 6px rgba(245, 158, 11, 0.8); }

        .sbadge-nonaktif {
            background: rgba(148, 163, 184, 0.12);
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, 0.25);
        }
        .sbadge-nonaktif .sbadge-dot { background: #94a3b8; }

        /* Action Buttons */
        .act-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 31px;
            height: 31px;
            border-radius: 8px;
            border: 1px solid rgba(99, 120, 150, 0.25);
            cursor: pointer;
            background: rgba(255, 255, 255, 0.04);
            color: #94a3b8;
            transition: all 0.18s ease;
            text-decoration: none;
        }
        .act-btn:hover { transform: translateY(-1px); }
        .act-btn-view:hover {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
            border-color: rgba(56, 189, 248, 0.4);
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.2);
        }
        .act-btn-repl:hover {
            background: rgba(139, 92, 246, 0.15);
            color: #c4b5fd;
            border-color: rgba(139, 92, 246, 0.4);
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.2);
        }
        .act-btn-edit:hover {
            background: rgba(245, 158, 11, 0.15);
            color: #fcd34d;
            border-color: rgba(245, 158, 11, 0.4);
            box-shadow: 0 0 10px rgba(245, 158, 11, 0.2);
        }
        .act-btn-del:hover {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.4);
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);
        }
        .act-btn svg { width: 15px; height: 15px; }

        .pagination-wrap {
            padding: 0.9rem 1.15rem;
            background: rgba(15, 23, 42, 0.9);
            border-top: 1px solid rgba(99, 120, 150, 0.2);
        }
        .empty-state { padding: 4rem 1rem; text-align: center; }
        .empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(99, 120, 150, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }
        .empty-icon svg { width: 32px; height: 32px; color: #64748b; }
        .empty-title { font-size: 0.98rem; font-weight: 700; color: #e2e8f0; }
        .empty-sub { font-size: 0.8rem; color: #64748b; margin-top: 4px; }

        /* ===== MODAL ===== */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 60;
            background: rgba(5, 8, 15, 0.75);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .modal-box {
            background: #161b22;
            border-radius: 18px;
            padding: 1.5rem;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.75), 0 0 35px rgba(139, 92, 246, 0.15);
            border: 1px solid rgba(139, 92, 246, 0.35);
            animation: modalPop 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        @keyframes modalPop {
            from { opacity: 0; transform: scale(0.94) translateY(12px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-header-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(139, 92, 246, 0.2);
            border: 1px solid rgba(139, 92, 246, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .modal-form-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #94a3b8;
            margin-bottom: 0.4rem;
        }
        .modal-input {
            width: 100%;
            background: #0d1117 !important;
            border: 1px solid rgba(99, 120, 150, 0.3) !important;
            border-radius: 10px !important;
            padding: 0.6rem 0.95rem !important;
            font-size: 0.84rem !important;
            color: #f1f5f9 !important;
            transition: all 0.2s;
        }
        .modal-input:focus {
            border-color: #8b5cf6 !important;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2) !important;
            outline: none;
        }
        .modal-input option {
            background: #161b22;
            color: #f1f5f9;
        }
        .modal-close-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid rgba(99, 120, 150, 0.3);
            background: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.2s;
        }
        .modal-close-btn:hover {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.4);
        }
    </style>
    @endpush

    {{-- PAGE HEADER --}}
    <div class="page-header-wrap">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;position:relative;z-index:1;">
            <div>
                <h1 class="page-header-title">Manajemen Perangkat</h1>
                <p class="page-header-sub">Kelola dan pantau seluruh aset infrastruktur jaringan DISKOMINFO</p>
            </div>
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;align-items:center;">
                <a href="{{ route('export.devices.replacement.print') }}" target="_blank" class="hdr-btn hdr-btn-ghost">
                    <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Laporan Penggantian
                    @if(($statusCounts['Perlu Diganti'] ?? 0) > 0)
                        <span style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#0d1117;padding:0 7px;border-radius:20px;font-size:0.65rem;font-weight:800;">{{ $statusCounts['Perlu Diganti'] }}</span>
                    @endif
                </a>
                <a href="{{ route('export.devices.print') }}?{{ http_build_query(request()->query()) }}" target="_blank" class="hdr-btn hdr-btn-ghost">
                    <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak
                </a>
                <a href="{{ route('export.devices.pdf') }}?{{ http_build_query(request()->query()) }}" class="hdr-btn hdr-btn-ghost">
                    <svg style="width:15px;height:15px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                    PDF
                </a>
                <a href="{{ route('export.devices.excel') }}?{{ http_build_query(request()->query()) }}" class="hdr-btn hdr-btn-ghost">
                    <svg style="width:15px;height:15px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path></svg>
                    Excel
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('devices.create') }}" class="hdr-btn hdr-btn-primary">
                    <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    + Tambah Perangkat
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- STAT SUMMARY CARDS --}}
    <div class="stat-cards-row">
        <a href="{{ route('devices.index', request()->except('status','page')) }}" class="stat-card stat-card-blue">
            <div class="stat-icon" style="background:rgba(56,189,248,0.15);border:1px solid rgba(56,189,248,0.3);">
                <svg fill="none" stroke="#38bdf8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
            </div>
            <div>
                <div class="stat-label">Total Perangkat</div>
                <div class="stat-value" style="color:#38bdf8;">{{ $statusCounts['total'] ?? 0 }}</div>
            </div>
        </a>
        <a href="{{ route('devices.index', array_merge(request()->except('page'), ['status'=>'Aktif'])) }}" class="stat-card stat-card-green">
            <div class="stat-icon" style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);">
                <svg fill="none" stroke="#34d399" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="stat-label">Aktif</div>
                <div class="stat-value" style="color:#34d399;">{{ $statusCounts['Aktif'] ?? 0 }}</div>
            </div>
        </a>
        <a href="{{ route('devices.index', array_merge(request()->except('page'), ['status'=>'Perlu Diganti'])) }}" class="stat-card stat-card-purple">
            <div class="stat-icon" style="background:rgba(139,92,246,0.15);border:1px solid rgba(139,92,246,0.3);">
                <svg fill="none" stroke="#c4b5fd" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            </div>
            <div>
                <div class="stat-label">Perlu Diganti</div>
                <div class="stat-value" style="color:#c4b5fd;">{{ $statusCounts['Perlu Diganti'] ?? 0 }}</div>
            </div>
        </a>
        <a href="{{ route('devices.index', array_merge(request()->except('page'), ['status'=>'Rusak'])) }}" class="stat-card stat-card-red">
            <div class="stat-icon" style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);">
                <svg fill="none" stroke="#fca5a5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19H19a2 2 0 001.73-3L13.73 4a2 2 0 00-3.46 0L3.27 16A2 2 0 005.07 19z"/></svg>
            </div>
            <div>
                <div class="stat-label">Rusak / Masalah</div>
                <div class="stat-value" style="color:#fca5a5;">{{ ($statusCounts['Rusak'] ?? 0) + ($statusCounts['Maintenance'] ?? 0) }}</div>
            </div>
        </a>
    </div>

    {{-- STATUS FILTER PILLS --}}
    <div class="status-pills-bar">
        <a href="{{ route('devices.index', request()->except('status','page')) }}" class="spill spill-all {{ !request('status') ? 'active' : '' }}">
            <span class="spill-dot" style="{{ !request('status') ? 'background:#38bdf8;' : 'background:#64748b;' }}"></span>
            Semua <span class="spill-count">{{ $statusCounts['total'] ?? 0 }}</span>
        </a>
        <a href="{{ route('devices.index', array_merge(request()->except('page'), ['status'=>'Aktif'])) }}" class="spill spill-aktif {{ request('status') === 'Aktif' ? 'active' : '' }}">
            <span class="spill-dot"></span> Aktif <span class="spill-count">{{ $statusCounts['Aktif'] ?? 0 }}</span>
        </a>
        <a href="{{ route('devices.index', array_merge(request()->except('page'), ['status'=>'Perlu Diganti'])) }}" class="spill spill-ganti {{ request('status') === 'Perlu Diganti' ? 'active' : '' }}">
            <span class="spill-dot"></span> Perlu Diganti <span class="spill-count">{{ $statusCounts['Perlu Diganti'] ?? 0 }}</span>
        </a>
        <a href="{{ route('devices.index', array_merge(request()->except('page'), ['status'=>'Rusak'])) }}" class="spill spill-rusak {{ request('status') === 'Rusak' ? 'active' : '' }}">
            <span class="spill-dot"></span> Rusak <span class="spill-count">{{ $statusCounts['Rusak'] ?? 0 }}</span>
        </a>
        <a href="{{ route('devices.index', array_merge(request()->except('page'), ['status'=>'Maintenance'])) }}" class="spill spill-maint {{ request('status') === 'Maintenance' ? 'active' : '' }}">
            <span class="spill-dot"></span> Maintenance <span class="spill-count">{{ $statusCounts['Maintenance'] ?? 0 }}</span>
        </a>
        <a href="{{ route('devices.index', array_merge(request()->except('page'), ['status'=>'Nonaktif'])) }}" class="spill spill-nonaktif {{ request('status') === 'Nonaktif' ? 'active' : '' }}">
            <span class="spill-dot"></span> Nonaktif <span class="spill-count">{{ $statusCounts['Nonaktif'] ?? 0 }}</span>
        </a>
    </div>

    {{-- PERLU DIGANTI BANNER --}}
    @if(request('status') === 'Perlu Diganti')
    <div class="repl-banner">
        <div style="display:flex;align-items:center;gap:0.9rem;">
            <div class="repl-banner-icon">🔄</div>
            <div>
                <div class="repl-banner-title">Daftar Rekomendasi Penggantian — {{ $devices->total() }} Unit</div>
                <div class="repl-banner-sub">Perangkat yang ditandai untuk pertimbangan pimpinan dan perencanaan pengadaan pengganti.</div>
            </div>
        </div>
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
            <a href="{{ route('export.devices.replacement.print', request()->query()) }}" target="_blank" class="repl-export-btn btn-cetak">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Usulan
            </a>
            <a href="{{ route('export.devices.replacement.pdf', request()->query()) }}" class="repl-export-btn btn-pdf">
                <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path></svg>
                PDF
            </a>
            <a href="{{ route('export.devices.replacement.excel', request()->query()) }}" class="repl-export-btn btn-excel">
                <svg style="width:14px;height:14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path></svg>
                Excel
            </a>
        </div>
    </div>
    @endif

    {{-- FILTER FORM --}}
    <form method="GET" class="filter-card">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:0.75rem;align-items:end;">
            <div>
                <label class="filter-label">Cari Perangkat</label>
                <div style="position:relative;">
                    <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari merk, S/N, IP..." class="filter-input" style="padding-left:2.2rem !important;">
                </div>
            </div>
            <div>
                <label class="filter-label">Status</label>
                <select name="status" class="filter-input">
                    <option value="">Semua Status</option>
                    @foreach(['Aktif','Rusak','Maintenance','Perlu Diganti','Nonaktif'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="filter-label">Tipe Perangkat</label>
                <select name="tipe" class="filter-input">
                    <option value="">Semua Tipe</option>
                    @foreach(['Router','Switch','Access Point','Modem','Server','Firewall','Lainnya'] as $t)
                    <option value="{{ $t }}" {{ request('tipe') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;gap:0.4rem;">
                <button type="submit" class="filter-btn-submit">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
                @if(request()->hasAny(['search','status','tipe']))
                <a href="{{ route('devices.index') }}" class="filter-reset-btn" title="Reset Filter">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
                @endif
            </div>
        </div>
    </form>

    {{-- DEVICES TABLE --}}
    <div class="devices-table-wrap">
        <div style="overflow-x:auto;">
            <table class="devices-table">
                <thead>
                    <tr>
                        <th>Merk / Model</th>
                        <th>Tipe</th>
                        <th>IP Address</th>
                        <th>Lokasi OPD</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devices as $device)
                    <tr>
                        <td>
                            <div class="dev-name">{{ $device->merk }}</div>
                            @if($device->model)<div class="dev-model">{{ $device->model }}</div>@endif
                        </td>
                        <td>
                            <span class="type-badge">
                                <x-device-icon :type="$device->tipe" class="w-3.5 h-3.5" />
                                {{ $device->tipe }}
                            </span>
                        </td>
                        <td>
                            @if($device->ip_address)
                                <span class="ip-cell">{{ $device->ip_address }}</span>
                            @else
                                <span style="color:#475569;font-size:0.8rem;">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="loc-name">{{ Str::limit($device->opdLocation->nama ?? '-', 28) }}</div>
                            @if($device->lokasi_pemasangan)
                            <div class="loc-sub">{{ Str::limit($device->lokasi_pemasangan, 28) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($device->status === 'Aktif')
                                <span class="sbadge sbadge-aktif"><span class="sbadge-dot"></span> Aktif</span>
                            @elseif($device->status === 'Perlu Diganti')
                                <span class="sbadge sbadge-ganti"><span class="sbadge-dot"></span> Perlu Diganti</span>
                            @elseif($device->status === 'Rusak')
                                <span class="sbadge sbadge-rusak"><span class="sbadge-dot"></span> Rusak</span>
                            @elseif($device->status === 'Maintenance')
                                <span class="sbadge sbadge-maint"><span class="sbadge-dot"></span> Maintenance</span>
                            @else
                                <span class="sbadge sbadge-nonaktif"><span class="sbadge-dot"></span> {{ $device->status }}</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
                                <a href="{{ route('devices.show', ['device'=>$device->id,'from'=>'devices']) }}" class="act-btn act-btn-view" title="Lihat Detail">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <button type="button"
                                    onclick="openReplacementModal({id:{{ $device->id }},merk:'{{ addslashes($device->merk) }}',model:'{{ addslashes($device->model ?? '') }}',lokasi:'{{ addslashes($device->opdLocation->nama ?? '') }}',status:'{{ $device->status }}',alasan:'{{ addslashes($device->alasan_penggantian ?? '') }}',rekomendasi:'{{ addslashes($device->rekomendasi_pengganti ?? '') }}',biaya:'{{ $device->estimasi_biaya ?? '' }}',actionUrl:'{{ route('devices.mark-replacement', $device) }}'})"
                                    class="act-btn act-btn-repl" title="Set Status / Rekomendasi Penggantian">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                </button>
                                <a href="{{ route('devices.edit', $device) }}" class="act-btn act-btn-edit" title="Edit Perangkat">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('devices.destroy', $device) }}" onsubmit="return confirm('Hapus perangkat ini? Tindakan tidak bisa dibatalkan.')" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="act-btn act-btn-del" title="Hapus Perangkat">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                                <div class="empty-title">Tidak ada data perangkat</div>
                                <div class="empty-sub">Coba ubah filter pencarian atau tambah perangkat baru.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">{{ $devices->withQueryString()->links() }}</div>
    </div>

    {{-- REPLACEMENT MODAL --}}
    @if(auth()->user()->isAdmin())
    <div id="replacementModal" class="modal-backdrop" style="display:none;">
        <div class="modal-box">
            <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:1rem;border-bottom:1px solid rgba(99,120,150,0.2);margin-bottom:1.25rem;">
                <div style="display:flex;align-items:center;gap:0.75rem;">
                    <div class="modal-header-icon">🔄</div>
                    <div>
                        <h3 style="font-size:0.95rem;font-weight:800;color:#f1f5f9;margin:0;" id="modalDeviceTitle">Set Status Perangkat</h3>
                        <p style="font-size:0.75rem;color:#94a3b8;margin:2px 0 0;" id="modalDeviceLocation">Lokasi OPD</p>
                    </div>
                </div>
                <button type="button" onclick="closeReplacementModal()" class="modal-close-btn">
                    <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="replacementForm" method="POST" action="" style="display:flex;flex-direction:column;gap:1rem;">
                @csrf
                <div>
                    <label class="modal-form-label">Status Perangkat <span style="color:#ef4444;">*</span></label>
                    <select name="status" id="modalStatusSelect" required class="modal-input">
                        <option value="Perlu Diganti">🔄 Perlu Diganti — Usulan Pengadaan</option>
                        <option value="Aktif">✓ Aktif — Kondisi Baik</option>
                        <option value="Rusak">✕ Rusak</option>
                        <option value="Maintenance">⚙️ Maintenance — Dalam Perbaikan</option>
                        <option value="Nonaktif">— Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="modal-form-label">Alasan / Pertimbangan Teknis</label>
                    <textarea name="alasan_penggantian" id="modalAlasan" rows="3" class="modal-input" placeholder="Tuliskan kendala teknis atau alasan perangkat harus diganti..."></textarea>
                </div>
                <div>
                    <label class="modal-form-label">Usulan Tipe Pengganti</label>
                    <input type="text" name="rekomendasi_pengganti" id="modalRekomendasi" class="modal-input" placeholder="Cth: MikroTik RB4011iGS+RM / Cisco CBS250">
                </div>
                <div>
                    <label class="modal-form-label">Estimasi Biaya Pengadaan (Rp)</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:0.8rem;font-weight:700;color:#64748b;">Rp</span>
                        <input type="number" step="0.01" name="estimasi_biaya" id="modalBiaya" class="modal-input" style="padding-left:2.5rem !important;" placeholder="3500000">
                    </div>
                </div>
                <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.6rem;padding-top:1.1rem;border-top:1px solid rgba(99,120,150,0.2);">
                    <button type="button" onclick="closeReplacementModal()" style="padding:0.5rem 1.1rem;border-radius:10px;border:1px solid rgba(99,120,150,0.3);background:rgba(255,255,255,0.05);color:#cbd5e1;font-size:0.82rem;font-weight:700;cursor:pointer;">Batal</button>
                    <button type="submit" style="padding:0.5rem 1.4rem;border-radius:10px;background:linear-gradient(135deg,#7c3aed,#8b5cf6);color:#fff;font-size:0.82rem;font-weight:800;cursor:pointer;border:1px solid rgba(139,92,246,0.5);box-shadow:0 0 20px rgba(139,92,246,0.35);display:inline-flex;align-items:center;gap:6px;">
                        <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Simpan Status
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openReplacementModal(data) {
            document.getElementById('modalDeviceTitle').innerText = data.merk + (data.model ? ' ' + data.model : '');
            document.getElementById('modalDeviceLocation').innerText = '📍 ' + (data.lokasi || '-');
            document.getElementById('replacementForm').action = data.actionUrl;
            document.getElementById('modalStatusSelect').value = data.status || 'Perlu Diganti';
            document.getElementById('modalAlasan').value = data.alasan || '';
            document.getElementById('modalRekomendasi').value = data.rekomendasi || '';
            document.getElementById('modalBiaya').value = data.biaya || '';
            document.getElementById('replacementModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        function closeReplacementModal() {
            document.getElementById('replacementModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        document.getElementById('replacementModal').addEventListener('click', function(e) {
            if (e.target === this) closeReplacementModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeReplacementModal();
        });
    </script>
    @endif
</x-app-layout>
