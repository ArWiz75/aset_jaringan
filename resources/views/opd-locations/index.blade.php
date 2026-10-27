<x-app-layout>
    <x-slot name="title">Lokasi OPD</x-slot>

    @push('styles')
    <style>
        /* ===== PAGE HEADER ===== */
        .opd-header-wrap {
            background: linear-gradient(135deg, #064e3b 0%, #059669 55%, #34d399 100%);
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            margin-bottom: 1.25rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(5,150,105,0.28);
        }
        .opd-header-wrap::before {
            content: "";
            position: absolute;
            top: -50px; right: -40px;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
        }
        .opd-header-wrap::after {
            content: "";
            position: absolute;
            bottom: -70px; right: 100px;
            width: 260px; height: 260px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .opd-header-title { font-size: 1.5rem; font-weight: 800; color: #fff; margin: 0; letter-spacing: -0.3px; }
        .opd-header-sub   { font-size: 0.78rem; color: rgba(255,255,255,0.65); margin-top: 2px; }
        .opd-hdr-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 0.5rem 1.1rem; font-size: 0.82rem; font-weight: 700;
            border-radius: 10px; cursor: pointer;
            text-decoration: none; transition: all 0.2s ease; white-space: nowrap;
            border: none;
        }
        .opd-hdr-btn-primary { background: #fff; color: #059669; box-shadow: 0 2px 10px rgba(0,0,0,0.15); }
        .opd-hdr-btn-primary:hover { background: #f0fdf4; color: #047857; }

        /* ===== STAT STRIP ===== */
        .opd-stat-strip {
            display: flex; gap: 0.75rem; margin-bottom: 1.25rem; flex-wrap: wrap;
        }
        .opd-stat-chip {
            display: flex; align-items: center; gap: 0.55rem;
            background: #fff; border: 1px solid #e2e8f0; border-radius: 10px;
            padding: 0.6rem 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .opd-stat-chip-icon { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .opd-stat-chip-icon svg { width: 18px; height: 18px; }
        .opd-stat-chip-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #94a3b8; }
        .opd-stat-chip-val   { font-size: 1.2rem; font-weight: 800; color: #0f172a; line-height: 1; }

        /* ===== SEARCH FORM ===== */
        .opd-search-card {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 14px;
            padding: 0.9rem 1.1rem; margin-bottom: 1.25rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .opd-search-input {
            flex: 1; background: #f8fafc !important; border: 1.5px solid #e2e8f0 !important;
            border-radius: 10px !important; padding: 0.6rem 0.95rem 0.6rem 2.4rem !important;
            font-size: 0.84rem !important; color: #1e293b !important; transition: all 0.2s;
        }
        .opd-search-input:focus { border-color: #059669 !important; box-shadow: 0 0 0 3px rgba(5,150,105,0.1) !important; background: #fff !important; }
        .opd-search-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 0.6rem 1.2rem; border-radius: 10px;
            background: linear-gradient(135deg, #059669, #047857);
            color: #fff; font-size: 0.82rem; font-weight: 700;
            border: none; cursor: pointer; transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(5,150,105,0.3);
        }
        .opd-search-btn:hover { background: linear-gradient(135deg, #047857, #065f46); }
        .opd-reset-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 38px; height: 38px; border-radius: 10px;
            background: #f1f5f9; color: #475569; border: 1.5px solid #e2e8f0;
            text-decoration: none; transition: all 0.2s; flex-shrink: 0;
        }
        .opd-reset-btn:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }

        /* ===== GRID CARDS ===== */
        .opd-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
        @media(max-width:1024px){ .opd-grid { grid-template-columns: repeat(2, 1fr); } }
        @media(max-width:640px) { .opd-grid { grid-template-columns: 1fr; } }

        .opd-card {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 16px;
            overflow: hidden; transition: all 0.25s ease;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            display: flex; flex-direction: column;
        }
        .opd-card:hover {
            border-color: #6ee7b7;
            box-shadow: 0 8px 24px rgba(5,150,105,0.12);
            transform: translateY(-3px);
        }

        /* Card top accent bar */
        .opd-card-accent { height: 4px; background: linear-gradient(90deg, #059669, #34d399); }

        /* Card body */
        .opd-card-body { padding: 1.1rem 1.1rem 0.8rem; flex: 1; }

        /* Top row: icon + perangkat badge */
        .opd-card-toprow { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.85rem; }
        .opd-card-locicon {
            width: 42px; height: 42px; border-radius: 12px;
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            border: 1px solid #a7f3d0;
            display: flex; align-items: center; justify-content: center;
        }
        .opd-card-locicon svg { width: 22px; height: 22px; color: #059669; }
        .opd-device-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 0.28rem 0.65rem; border-radius: 20px;
            font-size: 0.69rem; font-weight: 800;
            background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
        }
        .opd-device-badge svg { width: 12px; height: 12px; }
        .opd-device-badge.many { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
        .opd-device-badge.zero { background: #f8fafc; color: #94a3b8; border-color: #e2e8f0; }

        /* Card title */
        .opd-card-title { font-size: 0.9rem; font-weight: 800; color: #0f172a; line-height: 1.3; margin-bottom: 0.35rem; }
        .opd-card:hover .opd-card-title { color: #059669; }

        /* Location info */
        .opd-card-kec { display: flex; align-items: center; gap: 4px; font-size: 0.72rem; font-weight: 700; color: #059669; margin-bottom: 0.2rem; }
        .opd-card-kec svg { width: 11px; height: 11px; }
        .opd-card-addr { font-size: 0.71rem; color: #94a3b8; line-height: 1.4; margin-bottom: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

        /* ISP/network tags */
        .opd-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 0.75rem; }
        .opd-tag {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 8px; border-radius: 6px;
            font-size: 0.67rem; font-weight: 800; text-transform: uppercase;
            background: linear-gradient(135deg, #d1fae5, #ecfdf5);
            color: #065f46; border: 1px solid #6ee7b7;
        }
        .opd-tag-more { background: #f1f5f9; color: #64748b; border-color: #e2e8f0; font-weight: 700; }

        /* Kontak line */
        .opd-kontak { display: flex; align-items: center; gap: 5px; font-size: 0.71rem; color: #64748b; font-weight: 500; }
        .opd-kontak svg { width: 13px; height: 13px; color: #94a3b8; flex-shrink: 0; }

        /* Divider */
        .opd-card-divider { height: 1px; background: #f1f5f9; margin: 0 1.1rem; }

        /* Card footer actions */
        .opd-card-footer { display: flex; gap: 0.5rem; padding: 0.75rem 1rem; }
        .opd-act-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 5px;
            flex: 1; padding: 0.45rem 0.6rem; border-radius: 9px;
            font-size: 0.73rem; font-weight: 700;
            text-decoration: none; transition: all 0.18s ease; border: none; cursor: pointer;
        }
        .opd-act-btn svg { width: 13px; height: 13px; }
        .opd-btn-view  { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .opd-btn-view:hover  { background: #1d4ed8; color: #fff; border-color: #1d4ed8; }
        .opd-btn-edit  { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .opd-btn-edit:hover  { background: #d97706; color: #fff; border-color: #d97706; }
        .opd-btn-del   { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }
        .opd-btn-del:hover   { background: #dc2626; color: #fff; border-color: #dc2626; }

        /* Empty state */
        .opd-empty { grid-column: 1 / -1; text-align: center; padding: 4rem 1rem; }
        .opd-empty-icon { width: 64px; height: 64px; border-radius: 18px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
        .opd-empty-icon svg { width: 32px; height: 32px; color: #94a3b8; }
        .opd-empty-title { font-size: 1rem; font-weight: 700; color: #475569; }
        .opd-empty-sub   { font-size: 0.78rem; color: #94a3b8; margin-top: 4px; }

        /* Pagination wrap */
        .opd-pagination { margin-top: 1.25rem; }
    </style>
    @endpush

    {{-- ===== PAGE HEADER ===== --}}
    <div class="opd-header-wrap">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;position:relative;z-index:1;">
            <div>
                <h1 class="opd-header-title">
                    <svg style="display:inline;width:24px;height:24px;vertical-align:-5px;margin-right:6px;opacity:0.9;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
        <div class="opd-stat-chip">
            <div class="opd-stat-chip-icon" style="background:#ecfdf5;">
                <svg fill="none" stroke="#059669" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <div class="opd-stat-chip-label">Total Lokasi OPD</div>
                <div class="opd-stat-chip-val" style="color:#059669;">{{ $locations->total() }}</div>
            </div>
        </div>
        <div class="opd-stat-chip">
            <div class="opd-stat-chip-icon" style="background:#eff6ff;">
                <svg fill="none" stroke="#1d4ed8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
            </div>
            <div>
                <div class="opd-stat-chip-label">Total Perangkat</div>
                <div class="opd-stat-chip-val" style="color:#1d4ed8;">{{ $locations->sum('devices_count') }}</div>
            </div>
        </div>
        @if(request('search'))
        <div class="opd-stat-chip" style="border-color:#fde68a;background:#fffbeb;">
            <div class="opd-stat-chip-icon" style="background:#fef3c7;">
                <svg fill="none" stroke="#d97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <div>
                <div class="opd-stat-chip-label">Hasil Pencarian</div>
                <div class="opd-stat-chip-val" style="color:#d97706;">"{{ request('search') }}"</div>
            </div>
        </div>
        @endif
    </div>

    {{-- ===== SEARCH FORM ===== --}}
    <div class="opd-search-card">
        <form method="GET" style="display:flex;gap:0.5rem;align-items:center;">
            <div style="position:relative;flex:1;">
                <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
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
                        <span style="color:#cbd5e1;">•</span>
                        <svg style="width:12px;height:12px;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
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
                <form method="POST" action="{{ route('opd-locations.destroy', $loc) }}" onsubmit="return confirm('Hapus lokasi ini? Tindakan tidak bisa dibatalkan.')" style="flex:1;display:flex;">
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
