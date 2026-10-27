<x-app-layout>
    <x-slot name="title">Log Maintenance</x-slot>

    @push('styles')
    <style>
        /* ===== PAGE HEADER ===== */
        .page-header-wrap {
            background: linear-gradient(135deg, #1e3a5f 0%, #1a56db 60%, #0ea5e9 100%);
            border-radius: 18px;
            padding: 1.75rem 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 28px rgba(26, 86, 219, 0.28);
        }
        .page-header-wrap::before {
            content: "";
            position: absolute;
            top: -50px; right: -40px;
            width: 220px; height: 220px;
            background: rgba(255,255,255,0.07);
            border-radius: 50%;
            pointer-events: none;
        }
        .page-header-wrap::after {
            content: "";
            position: absolute;
            bottom: -70px; right: 110px;
            width: 270px; height: 270px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
            pointer-events: none;
        }
        .hdr-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 0.5rem 1rem; font-size: 0.8rem; font-weight: 700;
            border-radius: 10px; text-decoration: none;
            transition: all 0.2s ease; white-space: nowrap;
        }
        .hdr-btn:hover { transform: translateY(-1px); }
        .hdr-btn:active { transform: scale(0.97); }
        .hdr-btn-ghost {
            background: rgba(255,255,255,0.13); color: #fff;
            border: 1px solid rgba(255,255,255,0.22);
            backdrop-filter: blur(4px);
        }
        .hdr-btn-ghost:hover { background: rgba(255,255,255,0.22); color: #fff; }
        .hdr-btn-pdf { background: rgba(239,68,68,0.2); color: #fff; border: 1px solid rgba(252,165,165,0.35); backdrop-filter: blur(4px); }
        .hdr-btn-pdf:hover { background: rgba(239,68,68,0.3); color: #fff; }
        .hdr-btn-excel { background: rgba(16,185,129,0.2); color: #fff; border: 1px solid rgba(110,231,183,0.35); backdrop-filter: blur(4px); }
        .hdr-btn-excel:hover { background: rgba(16,185,129,0.3); color: #fff; }
        .hdr-btn-primary {
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            color: #fff; border: none;
            box-shadow: 0 4px 14px rgba(245,158,11,0.4);
        }
        .hdr-btn-primary:hover { box-shadow: 0 6px 20px rgba(245,158,11,0.5); background: linear-gradient(135deg,#fbbf24,#fb923c); color: #fff; }

        /* ===== STAT CARDS ===== */
        .stat-cards-row {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 0.85rem; margin-bottom: 1.5rem;
        }
        @media(max-width: 768px) { .stat-cards-row { grid-template-columns: repeat(2, 1fr); } }
        .stat-card {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 14px;
            padding: 1rem 1.15rem; display: flex; align-items: center; gap: 0.9rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04); transition: all 0.2s ease;
            text-decoration: none;
        }
        .stat-card:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.09); transform: translateY(-2px); }
        .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .stat-icon svg { width: 22px; height: 22px; }
        .stat-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #94a3b8; margin-bottom: 2px; }
        .stat-value { font-size: 1.6rem; font-weight: 800; line-height: 1; }

        /* ===== FILTER CARD ===== */
        .filter-card {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 16px;
            padding: 1.1rem 1.35rem; margin-bottom: 1.35rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .filter-input {
            width: 100%; background: #f8fafc !important;
            border: 1.5px solid #e2e8f0 !important; border-radius: 10px !important;
            padding: 0.55rem 0.95rem !important; font-size: 0.82rem !important;
            color: #1e293b !important; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .filter-input:focus {
            border-color: #1a56db !important;
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1) !important;
            background: #fff !important; outline: none;
        }
        .filter-btn-submit {
            width: 100%; background: linear-gradient(135deg, #1a56db, #0ea5e9);
            color: #fff; border: none; border-radius: 10px;
            padding: 0.55rem 1rem; font-size: 0.82rem; font-weight: 700;
            cursor: pointer; display: inline-flex; align-items: center;
            justify-content: center; gap: 6px; transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(26,86,219,0.25);
        }
        .filter-btn-submit:hover { background: linear-gradient(135deg, #1e40af, #0284c7); }

        /* ===== TABLE ===== */
        .maint-table-wrap {
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 16px; overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .maint-table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
        .maint-table thead tr {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-bottom: 2px solid #e2e8f0;
        }
        .maint-table thead th {
            padding: 0.85rem 1rem; text-align: left;
            font-size: 0.67rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 0.07em; color: #64748b;
        }
        .maint-table thead th:last-child { text-align: center; }
        .maint-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
        .maint-table tbody tr:hover { background: #f0f9ff; }
        .maint-table tbody tr:last-child { border-bottom: none; }
        .maint-table td { padding: 0.8rem 1rem; vertical-align: middle; }

        /* Jenis Badge */
        .jenis-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 0.22rem 0.65rem; border-radius: 8px;
            font-size: 0.68rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .jenis-perbaikan { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .jenis-penggantian { background: #fdf4ff; color: #7e22ce; border: 1px solid #e9d5ff; }
        .jenis-konfigurasi { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .jenis-preventif { background: #fff7ed; color: #9a3412; border: 1px solid #fed7aa; }

        /* Status Badge */
        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 0.25rem 0.7rem; border-radius: 20px;
            font-size: 0.68rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .status-selesai { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .status-selesai .status-dot { background: #10b981; box-shadow: 0 0 0 2px rgba(16,185,129,0.2); }
        .status-pending { background: #fffbeb; color: #78350f; border: 1px solid #fde68a; }
        .status-pending .status-dot { background: #f59e0b; box-shadow: 0 0 0 2px rgba(245,158,11,0.2); }
        .status-proses { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .status-proses .status-dot { background: #3b82f6; box-shadow: 0 0 0 2px rgba(59,130,246,0.2); }

        /* Action Buttons */
        .act-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 8px;
            border: 1px solid #e2e8f0; cursor: pointer;
            background: #f8fafc; color: #94a3b8;
            transition: all 0.15s ease; text-decoration: none;
        }
        .act-btn:hover { transform: scale(1.08); }
        .act-btn-view:hover { background: #eff6ff; color: #1a56db; border-color: #bfdbfe; }
        .act-btn-edit:hover { background: #fffbeb; color: #d97706; border-color: #fde68a; }
        .act-btn-del:hover  { background: #fef2f2; color: #dc2626; border-color: #fca5a5; }
        .act-btn svg { width: 14px; height: 14px; }

        /* Pagination */
        .pagination-wrap {
            padding: 0.85rem 1.1rem;
            background: linear-gradient(to right, #f8fafc, #f1f5f9);
            border-top: 1px solid #e2e8f0;
        }

        /* Empty state */
        .empty-state { padding: 4rem 1rem; text-align: center; }
        .empty-icon {
            width: 64px; height: 64px; border-radius: 18px;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
        }
        .empty-icon svg { width: 32px; height: 32px; color: #94a3b8; }
    </style>
    @endpush

    {{-- ===== PAGE HEADER ===== --}}
    <div class="page-header-wrap">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-white text-xs font-semibold border border-white/20 backdrop-blur-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Riwayat Perbaikan
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Log Maintenance</h1>
                <p class="text-sm text-blue-100 mt-1 font-medium">Riwayat perbaikan dan penggantian perangkat jaringan</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('export.maintenance.print') }}?{{ http_build_query(request()->query()) }}" target="_blank" class="hdr-btn hdr-btn-ghost">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak
                </a>
                <a href="{{ route('export.maintenance.pdf') }}?{{ http_build_query(request()->query()) }}" class="hdr-btn hdr-btn-pdf">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                    PDF
                </a>
                <a href="{{ route('export.maintenance.excel') }}?{{ http_build_query(request()->query()) }}" class="hdr-btn hdr-btn-excel">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"/></svg>
                    Excel
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('maintenance-logs.create') }}" class="hdr-btn hdr-btn-primary">
                    <span style="width:18px;height:18px;background:rgba(255,255,255,0.25);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </span>
                    Tambah Log
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="stat-cards-row">
        <div class="stat-card" style="border-top: 3px solid #1a56db;">
            <div class="stat-icon" style="background: #eff6ff;">
                <svg fill="none" stroke="#1a56db" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Log</p>
                <p class="stat-value" style="color: #1a56db;">{{ $totalLogs }}</p>
            </div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #10b981;">
            <div class="stat-icon" style="background: #ecfdf5;">
                <svg fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="stat-label" style="color: #059669;">Selesai</p>
                <p class="stat-value" style="color: #059669;">{{ $selesai }}</p>
            </div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #f59e0b;">
            <div class="stat-icon" style="background: #fffbeb;">
                <svg fill="none" stroke="#f59e0b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="stat-label" style="color: #d97706;">Pending</p>
                <p class="stat-value" style="color: #d97706;">{{ $pending }}</p>
            </div>
        </div>

        <div class="stat-card" style="border-top: 3px solid #3b82f6;">
            <div class="stat-icon" style="background: #eff6ff;">
                <svg fill="none" stroke="#3b82f6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <p class="stat-label" style="color: #2563eb;">Dalam Proses</p>
                <p class="stat-value" style="color: #2563eb;">{{ $dalamProses }}</p>
            </div>
        </div>
    </div>

    {{-- ===== FILTER CARD ===== --}}
    <div class="filter-card">
        <form method="GET">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Cari Perangkat / Deskripsi</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik untuk mencari..." class="filter-input">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Jenis Maintenance</label>
                    <select name="jenis" class="filter-input">
                        <option value="">Semua Jenis</option>
                        @foreach(['Perbaikan','Penggantian','Konfigurasi','Preventif'] as $j)
                        <option value="{{ $j }}" {{ request('jenis') == $j ? 'selected' : '' }}>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Status</label>
                    <select name="status" class="filter-input">
                        <option value="">Semua Status</option>
                        @foreach(['Selesai','Pending','Dalam Proses'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col justify-end gap-2">
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1 opacity-0">.</label>
                    <button type="submit" class="filter-btn-submit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Cari & Filter
                    </button>
                    @if(request()->anyFilled(['search','jenis','status']))
                    <a href="{{ route('maintenance-logs.index') }}" class="text-center text-xs font-semibold text-slate-500 hover:text-red-500 transition py-1">
                        ✕ Reset Filter
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- ===== TABLE ===== --}}
    <div class="maint-table-wrap">
        <div class="overflow-x-auto">
            <table class="maint-table">
                <thead>
                    <tr>
                        <th>Perangkat</th>
                        <th>Lokasi OPD</th>
                        <th>Jenis</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>
                            <p class="font-extrabold text-slate-800 text-sm leading-tight">{{ $log->device->merk ?? '-' }} {{ $log->device->model ?? '' }}</p>
                            <p class="text-[10px] font-medium text-slate-400 font-mono mt-0.5">SN: {{ $log->device->nomor_seri ?? '-' }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-semibold text-slate-600 leading-tight">{{ $log->device->opdLocation->nama ?? '-' }}</p>
                        </td>
                        <td>
                            @php
                                $jenisClass = match($log->jenis) {
                                    'Perbaikan'   => 'jenis-perbaikan',
                                    'Penggantian' => 'jenis-penggantian',
                                    'Konfigurasi' => 'jenis-konfigurasi',
                                    'Preventif'   => 'jenis-preventif',
                                    default       => 'jenis-perbaikan',
                                };
                            @endphp
                            <span class="jenis-badge {{ $jenisClass }}">{{ $log->jenis }}</span>
                        </td>
                        <td class="max-w-xs">
                            <p class="text-xs text-slate-600 leading-relaxed truncate" title="{{ $log->deskripsi }}">{{ Str::limit($log->deskripsi, 55) }}</p>
                        </td>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[11px] font-bold text-slate-600">{{ $log->tanggal->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="text-xs font-black text-amber-600">
                                {{ $log->biaya ? 'Rp '.number_format($log->biaya, 0, ',', '.') : '-' }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusClass = match($log->status) {
                                    'Selesai'     => 'status-selesai',
                                    'Pending'     => 'status-pending',
                                    'Dalam Proses'=> 'status-proses',
                                    default       => 'status-pending',
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                <span class="status-dot"></span>
                                {{ $log->status }}
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                <a href="{{ route('maintenance-logs.show', $log) }}" class="act-btn act-btn-view" title="Lihat Detail">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('maintenance-logs.edit', $log) }}" class="act-btn act-btn-edit" title="Edit">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('maintenance-logs.destroy', $log) }}" onsubmit="return confirm('Hapus log ini?')" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="act-btn act-btn-del" title="Hapus">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </div>
                                <p class="font-bold text-slate-600 text-sm">Belum ada log maintenance</p>
                                <p class="text-xs text-slate-400 mt-1">
                                    @if(request()->anyFilled(['search','jenis','status']))
                                        Tidak ditemukan hasil untuk filter yang dipilih.
                                    @else
                                        Tambahkan log maintenance pertama Anda.
                                    @endif
                                </p>
                                @if(auth()->user()->isAdmin() && !request()->anyFilled(['search','jenis','status']))
                                <a href="{{ route('maintenance-logs.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-xs font-bold transition hover:shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Log Pertama
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">{{ $logs->withQueryString()->links() }}</div>
    </div>

</x-app-layout>
