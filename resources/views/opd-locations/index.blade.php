<x-app-layout>
    <x-slot name="title">Lokasi OPD</x-slot>

    @push('styles')
    <style>
        /* ===== PAGE HEADER ===== */
        .opd-header-wrap {
            background: linear-gradient(135deg, #06221b 0%, #083b2f 50%, #0d2822 100%);
            border: 1px solid rgba(16, 185, 129, 0.28);
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            margin-bottom: 1.25rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.45), 0 0 25px rgba(16, 185, 129, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(10px);
        }
        .opd-header-wrap::before {
            content: "";
            position: absolute;
            top: -60px; right: -50px;
            width: 220px; height: 220px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.18) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .opd-header-wrap::after {
            content: "";
            position: absolute;
            bottom: -70px; right: 120px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .opd-header-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #f8fafc;
            margin: 0;
            letter-spacing: -0.02em;
        }
        .opd-header-sub {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 4px;
        }
        .opd-hdr-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.48rem 1rem;
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
            border: none;
        }
        .opd-hdr-btn:hover { transform: translateY(-1px); }
        .opd-hdr-btn-primary {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #fff;
            font-weight: 800;
            border: 1px solid rgba(16, 185, 129, 0.5);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3), 0 4px 14px rgba(0, 0, 0, 0.35);
        }
        .opd-hdr-btn-primary:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            box-shadow: 0 0 26px rgba(16, 185, 129, 0.45), 0 6px 18px rgba(0, 0, 0, 0.4);
            color: #fff;
        }

        /* ===== STAT STRIP ===== */
        .opd-stat-strip {
            display: flex;
            gap: 0.85rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }
        .opd-stat-chip {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 12px;
            padding: 0.75rem 1.15rem;
            backdrop-filter: blur(8px);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .opd-stat-chip:hover { transform: translateY(-2px); }

        .opd-stat-chip-green {
            border: 1px solid rgba(16, 185, 129, 0.35);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.08), 0 4px 16px rgba(0,0,0,0.4), inset 0 1px 0 rgba(16, 185, 129, 0.1);
            background: linear-gradient(135deg, rgba(13, 22, 20, 0.9) 0%, rgba(5, 40, 30, 0.7) 100%);
        }
        .opd-stat-chip-green:hover {
            box-shadow: 0 0 28px rgba(16, 185, 129, 0.2), 0 6px 20px rgba(0,0,0,0.5);
        }

        .opd-stat-chip-blue {
            border: 1px solid rgba(56, 189, 248, 0.35);
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.08), 0 4px 16px rgba(0,0,0,0.4), inset 0 1px 0 rgba(56, 189, 248, 0.1);
            background: linear-gradient(135deg, rgba(14, 22, 36, 0.9) 0%, rgba(7, 35, 55, 0.7) 100%);
        }
        .opd-stat-chip-blue:hover {
            box-shadow: 0 0 28px rgba(56, 189, 248, 0.2), 0 6px 20px rgba(0,0,0,0.5);
        }

        .opd-stat-chip-amber {
            border: 1px solid rgba(245, 158, 11, 0.35);
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.08), 0 4px 16px rgba(0,0,0,0.4), inset 0 1px 0 rgba(245, 158, 11, 0.1);
            background: linear-gradient(135deg, rgba(22, 18, 8, 0.9) 0%, rgba(45, 30, 5, 0.7) 100%);
        }
        .opd-stat-chip-amber:hover {
            box-shadow: 0 0 28px rgba(245, 158, 11, 0.2), 0 6px 20px rgba(0,0,0,0.5);
        }

        .opd-stat-chip-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .opd-stat-chip-icon svg { width: 20px; height: 20px; }
        .opd-stat-chip-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #94a3b8;
            margin-bottom: 2px;
        }
        .opd-stat-chip-val {
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        /* ===== SEARCH FORM ===== */
        .opd-search-card {
            background: rgba(22, 30, 46, 0.85);
            border: 1px solid rgba(99, 120, 150, 0.22);
            border-radius: 14px;
            padding: 0.85rem 1.15rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(8px);
        }
        .opd-search-input {
            flex: 1;
            background: rgba(15, 23, 42, 0.85) !important;
            border: 1px solid rgba(99, 120, 150, 0.3) !important;
            border-radius: 10px !important;
            padding: 0.58rem 0.95rem 0.58rem 2.4rem !important;
            font-size: 0.84rem !important;
            color: #e2e8f0 !important;
            transition: all 0.2s;
        }
        .opd-search-input:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.18) !important;
            outline: none;
        }
        .opd-search-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.58rem 1.2rem;
            border-radius: 10px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff;
            font-size: 0.82rem;
            font-weight: 700;
            border: 1px solid rgba(16, 185, 129, 0.4);
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 0 16px rgba(16, 185, 129, 0.3);
            white-space: nowrap;
        }
        .opd-search-btn:hover {
            background: linear-gradient(135deg, #047857, #059669);
            box-shadow: 0 0 22px rgba(16, 185, 129, 0.45);
            transform: translateY(-1px);
        }
        .opd-reset-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
            border: 1px solid rgba(99, 120, 150, 0.3);
            text-decoration: none;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .opd-reset-btn:hover {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.4);
        }

        /* ===== GRID CARDS ===== */
        .opd-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.1rem;
        }
        @media(max-width:1024px){ .opd-grid { grid-template-columns: repeat(2, 1fr); } }
        @media(max-width:640px) { .opd-grid { grid-template-columns: 1fr; } }

        .opd-card {
            background: rgba(22, 30, 46, 0.85);
            border: 1px solid rgba(99, 120, 150, 0.22);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.04);
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(8px);
            position: relative;
        }
        .opd-card:hover {
            border-color: rgba(52, 211, 153, 0.5);
            box-shadow: 0 10px 32px rgba(0, 0, 0, 0.5), 0 0 25px rgba(16, 185, 129, 0.15);
            transform: translateY(-3px);
        }

        /* Card top accent bar */
        .opd-card-accent {
            height: 3px;
            background: linear-gradient(90deg, #10b981, #38bdf8);
        }

        /* Card body */
        .opd-card-body {
            padding: 1.15rem 1.15rem 0.9rem;
            flex: 1;
        }

        /* Top row: icon + perangkat badge */
        .opd-card-toprow {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.9rem;
        }
        .opd-card-locicon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 14px rgba(16, 185, 129, 0.12);
        }
        .opd-card-locicon svg { width: 22px; height: 22px; color: #34d399; }

        .opd-device-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 0.28rem 0.7rem;
            border-radius: 20px;
            font-size: 0.69rem;
            font-weight: 800;
        }
        .opd-device-badge svg { width: 12px; height: 12px; }
        .opd-device-badge.many {
            background: rgba(56, 189, 248, 0.15);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.35);
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.12);
        }
        .opd-device-badge.zero {
            background: rgba(148, 163, 184, 0.1);
            color: #64748b;
            border: 1px solid rgba(99, 120, 150, 0.2);
        }

        /* Card title */
        .opd-card-title {
            font-size: 0.94rem;
            font-weight: 800;
            color: #f1f5f9;
            line-height: 1.35;
            margin-bottom: 0.4rem;
            transition: color 0.15s ease;
        }
        .opd-card:hover .opd-card-title { color: #34d399; }

        /* Location info */
        .opd-card-kec {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.72rem;
            font-weight: 700;
            color: #34d399;
            margin-bottom: 0.3rem;
        }
        .opd-card-kec svg { width: 12px; height: 12px; }
        .opd-card-addr {
            font-size: 0.73rem;
            color: #94a3b8;
            line-height: 1.45;
            margin-bottom: 0.85rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ISP/network tags */
        .opd-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 0.85rem;
        }
        .opd-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.67rem;
            font-weight: 800;
            text-transform: uppercase;
            background: rgba(16, 185, 129, 0.12);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .opd-tag-more {
            background: rgba(255, 255, 255, 0.05);
            color: #94a3b8;
            border-color: rgba(99, 120, 150, 0.25);
            font-weight: 700;
        }

        /* Kontak line */
        .opd-kontak {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.72rem;
            color: #94a3b8;
            font-weight: 500;
        }
        .opd-kontak svg { width: 13px; height: 13px; color: #64748b; flex-shrink: 0; }

        /* Divider */
        .opd-card-divider {
            height: 1px;
            background: rgba(99, 120, 150, 0.15);
            margin: 0 1.15rem;
        }

        /* Card footer actions */
        .opd-card-footer {
            display: flex;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
        }
        .opd-act-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex: 1;
            padding: 0.45rem 0.6rem;
            border-radius: 9px;
            font-size: 0.74rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        .opd-act-btn svg { width: 13px; height: 13px; }
        .opd-act-btn:hover { transform: translateY(-1px); }

        .opd-btn-view {
            background: rgba(56, 189, 248, 0.12);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.3);
        }
        .opd-btn-view:hover {
            background: linear-gradient(135deg, #0284c7, #38bdf8);
            color: #0b1120;
            font-weight: 800;
            border-color: #38bdf8;
            box-shadow: 0 0 14px rgba(56, 189, 248, 0.35);
        }

        .opd-btn-edit {
            background: rgba(245, 158, 11, 0.12);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        .opd-btn-edit:hover {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: #0b1120;
            font-weight: 800;
            border-color: #f59e0b;
            box-shadow: 0 0 14px rgba(245, 158, 11, 0.35);
        }

        .opd-btn-del {
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .opd-btn-del:hover {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: #fff;
            font-weight: 800;
            border-color: #ef4444;
            box-shadow: 0 0 14px rgba(239, 68, 68, 0.35);
        }

        /* Empty state */
        .opd-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 1rem;
        }
        .opd-empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(99, 120, 150, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }
        .opd-empty-icon svg { width: 32px; height: 32px; color: #64748b; }
        .opd-empty-title { font-size: 1rem; font-weight: 700; color: #e2e8f0; }
        .opd-empty-sub { font-size: 0.8rem; color: #64748b; margin-top: 4px; }

        /* Pagination wrap */
        .opd-pagination { margin-top: 1.35rem; }
    </style>
    @endpush

    {{-- ===== PAGE HEADER ===== --}}
    <div class="opd-header-wrap">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;position:relative;z-index:1;">
            <div>
                <h1 class="opd-header-title">
                    <svg style="display:inline;width:24px;height:24px;vertical-align:-4px;margin-right:6px;opacity:0.9;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Lokasi OPD
                </h1>
                <p class="opd-header-sub">Pendataan perangkat jaringan berdasarkan gedung &amp; kantor dinas</p>
            </div>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('opd-locations.create') }}" class="opd-hdr-btn opd-hdr-btn-primary">
                <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                + Tambah Lokasi
            </a>
            @endif
        </div>
    </div>

    {{-- ===== STAT STRIP ===== --}}
    <div class="opd-stat-strip">
        <div class="opd-stat-chip opd-stat-chip-green">
            <div class="opd-stat-chip-icon" style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);">
                <svg fill="none" stroke="#34d399" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <div class="opd-stat-chip-label">Total Lokasi OPD</div>
                <div class="opd-stat-chip-val" style="color:#34d399;">{{ $locations->total() }}</div>
            </div>
        </div>
        <div class="opd-stat-chip opd-stat-chip-blue">
            <div class="opd-stat-chip-icon" style="background:rgba(56,189,248,0.15);border:1px solid rgba(56,189,248,0.3);">
                <svg fill="none" stroke="#38bdf8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
            </div>
            <div>
                <div class="opd-stat-chip-label">Total Perangkat</div>
                <div class="opd-stat-chip-val" style="color:#38bdf8;">{{ $locations->sum('devices_count') }}</div>
            </div>
        </div>
        @if(request('search'))
        <div class="opd-stat-chip opd-stat-chip-amber">
            <div class="opd-stat-chip-icon" style="background:rgba(245,158,11,0.15);border:1px solid rgba(245,158,11,0.3);">
                <svg fill="none" stroke="#fcd34d" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <div>
                <div class="opd-stat-chip-label">Hasil Pencarian</div>
                <div class="opd-stat-chip-val" style="color:#fcd34d;">"{{ request('search') }}"</div>
            </div>
        </div>
        @endif
    </div>

    {{-- ===== SEARCH FORM ===== --}}
    <div class="opd-search-card">
        <form method="GET" style="display:flex;gap:0.6rem;align-items:center;">
            <div style="position:relative;flex:1;">
                <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama OPD, kecamatan, alamat..."
                    class="opd-search-input" style="width:100%;">
            </div>
            <button type="submit" class="opd-search-btn">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari
            </button>
            @if(request('search'))
            <a href="{{ route('opd-locations.index') }}" class="opd-reset-btn" title="Reset pencarian">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
            @endif
        </form>
    </div>

    {{-- ===== CARD GRID ===== --}}
    <div class="opd-grid">
        @forelse($locations as $loc)
        <div class="opd-card">
            {{-- Accent bar --}}
            <div class="opd-card-accent"></div>

            {{-- Body --}}
            <div class="opd-card-body">
                {{-- Top row: icon + badge --}}
                <div class="opd-card-toprow">
                    <div class="opd-card-locicon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="opd-device-badge {{ $loc->devices_count > 0 ? 'many' : 'zero' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
                        {{ $loc->devices_count }} perangkat
                    </span>
                </div>

                {{-- Title --}}
                <h3 class="opd-card-title">{{ $loc->nama }}</h3>

                {{-- Kecamatan --}}
                <div class="opd-card-kec">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $loc->kecamatan }}
                </div>

                {{-- Alamat --}}
                <p class="opd-card-addr">{{ $loc->alamat }}</p>

                {{-- ISP / Network tags --}}
                @if($loc->networks->count() > 0)
                <div class="opd-tags">
                    @foreach($loc->networks->take(3) as $net)
                        <span class="opd-tag">
                            <svg style="width:9px;height:9px;" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="4"/></svg>
                            {{ $net->provider ?? '?' }}
                        </span>
                    @endforeach
                    @if($loc->networks->count() > 3)
                        <span class="opd-tag opd-tag-more">+{{ $loc->networks->count() - 3 }}</span>
                    @endif
                </div>
                @else
                <div style="height:0.75rem;"></div>
                @endif

                {{-- Kontak --}}
                @if($loc->kontak_person)
                <div class="opd-kontak">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>{{ $loc->kontak_person }}</span>
                    @if($loc->telepon)
                        <span style="color:#64748b;">•</span>
                        <svg style="width:12px;height:12px;color:#64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>{{ $loc->telepon }}</span>
                    @endif
                </div>
                @else
                <div style="height:1rem;"></div>
                @endif
            </div>

            {{-- Divider --}}
            <div class="opd-card-divider"></div>

            {{-- Footer actions --}}
            <div class="opd-card-footer">
                <a href="{{ route('opd-locations.show', $loc) }}" class="opd-act-btn opd-btn-view">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Detail
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('opd-locations.edit', $loc) }}" class="opd-act-btn opd-btn-edit">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('opd-locations.destroy', $loc) }}" onsubmit="return confirm('Hapus lokasi ini? Tindakan tidak bisa dibatalkan.')" style="flex:1;display:flex;margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="opd-act-btn opd-btn-del" style="width:100%;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="opd-empty">
            <div class="opd-empty-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
            </div>
            <div class="opd-empty-title">Tidak ada data Lokasi OPD</div>
            <div class="opd-empty-sub">Coba ubah kata kunci pencarian atau tambah lokasi baru.</div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="opd-pagination">{{ $locations->withQueryString()->links() }}</div>

</x-app-layout>
