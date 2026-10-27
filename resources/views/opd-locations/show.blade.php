<x-app-layout>
    <x-slot name="title">Detail {{ $opdLocation->nama }}</x-slot>

    @push('styles')
    <style>
        /* ===== HEADER STYLING ===== */
        .show-header-wrap {
            background: linear-gradient(135deg, #064e3b 0%, #059669 55%, #10b981 100%);
            border-radius: 18px;
            padding: 1.75rem 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(5, 150, 105, 0.30);
        }
        .show-header-wrap::before {
            content: "";
            position: absolute;
            top: -60px; right: -50px;
            width: 250px; height: 250px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }
        .show-header-wrap::after {
            content: "";
            position: absolute;
            bottom: -80px; right: 120px;
            width: 300px; height: 300px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
            pointer-events: none;
        }

        .show-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.55rem 1rem;
            border-radius: 11px;
            font-size: 0.815rem;
            font-weight: 700;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            white-space: nowrap;
        }
        .show-btn:hover {
            transform: translateY(-1px);
        }
        .show-btn:active {
            transform: scale(0.97);
        }

        /* Tombol Tambah Perangkat di Header */
        .btn-tambah-perangkat {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            font-size: 0.84rem;
            font-weight: 800;
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            color: #fff;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.45);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }
        .btn-tambah-perangkat::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 50%);
            border-radius: inherit;
        }
        .btn-tambah-perangkat:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.55);
            background: linear-gradient(135deg, #fbbf24 0%, #fb923c 100%);
            color: #fff;
        }
        .btn-tambah-perangkat:active {
            transform: scale(0.97);
        }

        /* ===== STATS STRIP ===== */
        .stats-mini-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 0.85rem 1.15rem;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: all 0.2s ease;
        }
        .stats-mini-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }
        .dark .stats-mini-card {
            background: rgba(15, 23, 42, 0.7);
            border-color: rgba(51, 65, 85, 0.6);
        }

        /* ===== SPEEDOMETER PILL ===== */
        .speed-badge {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.65rem 0.85rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dark .speed-badge {
            background: rgba(15, 23, 42, 0.5);
            border-color: rgba(51, 65, 85, 0.5);
        }

        /* ===== DEVICE ROW STYLING ===== */
        .device-item-row {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }
        .dark .device-item-row {
            border-bottom-color: rgba(51, 65, 85, 0.4);
        }
        .device-item-row:last-child {
            border-bottom: none;
        }
        .device-item-row:hover {
            background-color: #f0fdf4;
        }
        .dark .device-item-row:hover {
            background-color: rgba(30, 41, 59, 0.5);
        }

        /* Status glowing dot */
        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        .status-dot.active {
            background-color: #10b981;
            box-shadow: 0 0 6px rgba(16, 185, 129, 0.7);
        }
        .status-dot.replacement {
            background-color: #8b5cf6;
            box-shadow: 0 0 6px rgba(139, 92, 246, 0.7);
        }
        .status-dot.damaged {
            background-color: #ef4444;
            box-shadow: 0 0 6px rgba(239, 68, 68, 0.7);
        }
        .status-dot.maintenance {
            background-color: #f59e0b;
            box-shadow: 0 0 6px rgba(245, 158, 11, 0.7);
        }

        /* Action buttons */
        .action-icon-btn {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }
        .action-icon-btn:hover {
            transform: scale(1.1);
        }
        .action-icon-btn:active {
            transform: scale(0.95);
        }

        /* Pulse animation untuk tombol tambah */
        @keyframes pulse-ring {
            0% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.5); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
            100% { transform: scale(0.9); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }
        .btn-tambah-inline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.78rem;
            font-weight: 800;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #fff;
            text-decoration: none;
            box-shadow: 0 2px 10px rgba(5, 150, 105, 0.35);
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .btn-tambah-inline:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(5, 150, 105, 0.45);
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            color: #fff;
        }
        .btn-tambah-inline:active { transform: scale(0.97); }
        .btn-tambah-inline .plus-icon {
            width: 18px; height: 18px;
            background: rgba(255,255,255,0.25);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
    </style>
    @endpush

    <div x-data="{ 
        denahModalOpen: false, 
        copiedIp: null,
        copyToClipboard(text) {
            navigator.clipboard.writeText(text);
            this.copiedIp = text;
            setTimeout(() => { this.copiedIp = null; }, 2000);
        }
    }">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="show-header-wrap">
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                <div>
                    {{-- Breadcrumbs / Back button --}}
                    <div class="flex items-center gap-2 mb-3">
                        <a href="{{ route('opd-locations.index') }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 hover:bg-white/25 text-white text-xs font-semibold backdrop-blur-sm transition border border-white/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali ke Daftar OPD
                        </a>
                        @if($opdLocation->kecamatan)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-900/35 text-emerald-100 text-xs font-medium border border-emerald-400/20">
                            <svg class="w-3 h-3 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Kec. {{ $opdLocation->kecamatan }}
                        </span>
                        @endif
                    </div>

                    {{-- Main Title --}}
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight flex items-center gap-3">
                        <span>{{ $opdLocation->nama }}</span>
                    </h1>

                    {{-- Quick Meta --}}
                    <div class="flex flex-wrap items-center gap-4 mt-2.5 text-xs text-emerald-100 font-medium">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Total <strong>{{ $devices->count() }}</strong> Perangkat
                        </span>
                        <span class="w-1 h-1 rounded-full bg-emerald-300/60"></span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <strong>{{ $groupedDevices->count() }}</strong> Ruangan
                        </span>
                        @if($opdLocation->networks->count() > 0)
                        <span class="w-1 h-1 rounded-full bg-emerald-300/60"></span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            {{ $opdLocation->networks->pluck('provider')->filter()->unique()->implode(', ') ?: 'Jaringan Terdaftar' }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Action Toolbar --}}
                <div class="flex flex-wrap items-center gap-2">
                    {{-- Usulan Ganti Button --}}
                    <a href="{{ route('export.devices.replacement.print', ['opd_location_id' => $opdLocation->id]) }}" 
                       target="_blank" 
                       class="show-btn bg-purple-500/20 hover:bg-purple-500/30 text-white border border-purple-400/40 backdrop-blur-sm shadow-sm" 
                       title="Cetak Usulan Penggantian & Pengadaan OPD Ini">
                        <svg class="w-4 h-4 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Usulan Ganti</span>
                    </a>

                    {{-- Cetak Button --}}
                    <a href="{{ route('export.devices.print', ['opd_location_id' => $opdLocation->id, 'lokasi' => request('lokasi')]) }}" 
                       target="_blank" 
                       class="show-btn bg-white/15 hover:bg-white/25 text-white border border-white/25 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak</span>
                    </a>

                    {{-- PDF Button --}}
                    <a href="{{ route('export.devices.pdf', ['opd_location_id' => $opdLocation->id, 'lokasi' => request('lokasi')]) }}" 
                       class="show-btn bg-rose-500/20 hover:bg-rose-500/30 text-white border border-rose-400/40 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-rose-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                        <span>PDF</span>
                    </a>

                    {{-- Excel Button --}}
                    <a href="{{ route('export.devices.excel', ['opd_location_id' => $opdLocation->id, 'lokasi' => request('lokasi')]) }}" 
                       class="show-btn bg-emerald-400/25 hover:bg-emerald-400/35 text-white border border-emerald-300/40 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-emerald-100" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"/></svg>
                        <span>Excel</span>
                    </a>

                    {{-- Edit OPD Button (Admin Only) --}}
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('opd-locations.edit', $opdLocation) }}" 
                       class="show-btn bg-white/15 hover:bg-white/25 text-white border border-white/25 backdrop-blur-sm shadow-md">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>Edit OPD</span>
                    </a>

                    {{-- ✅ Tambah Perangkat (Admin) - Menonjol di Header --}}
                    <a href="{{ route('devices.create', ['opd_location_id' => $opdLocation->id]) }}" 
                       class="btn-tambah-perangkat">
                        <span class="plus-icon" style="width:20px;height:20px;background:rgba(255,255,255,0.25);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        </span>
                        <span>Tambah Perangkat</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== MAIN GRID LAYOUT ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ======================================================== --}}
            {{-- LEFT COLUMN: Denah, Info Jaringan, Info Lokasi          --}}
            {{-- ======================================================== --}}
            <div class="space-y-6">

                {{-- CARD: Denah Gedung --}}
                @if($opdLocation->denah_file)
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-500 dark:text-amber-400 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            </span>
                            Denah Gedung
                        </h3>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            {{ strtoupper(pathinfo($opdLocation->denah_file, PATHINFO_EXTENSION)) }}
                        </span>
                    </div>

                    @php
                        $ext = pathinfo($opdLocation->denah_file, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'svg', 'webp']);
                    @endphp

                    @if($isImage)
                        <div class="relative group rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 cursor-pointer"
                             @click="denahModalOpen = true">
                            <img src="{{ asset('storage/' . $opdLocation->denah_file) }}" 
                                 alt="Denah {{ $opdLocation->nama }}" 
                                 class="w-full h-44 object-cover object-top group-hover:scale-105 transition-transform duration-500">
                            
                            {{-- Hover Overlay --}}
                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                <span class="px-3 py-1.5 rounded-lg bg-white/90 text-slate-900 text-xs font-bold shadow-lg flex items-center gap-1.5 backdrop-blur-sm">
                                    <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                    Perbesar Denah
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-2.5 px-1">
                            <button @click="denahModalOpen = true" class="text-[11px] text-cyan-600 dark:text-cyan-400 font-semibold hover:underline flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Pratinjau Penuh
                            </button>
                            <a href="{{ asset('storage/' . $opdLocation->denah_file) }}" target="_blank" class="text-[11px] text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 font-medium flex items-center gap-1">
                                <span>Buka tab baru</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    @else
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-red-500/10 text-red-500 flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-white">Dokumen Denah PDF</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Format PDF interaktif</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $opdLocation->denah_file) }}" target="_blank" class="px-3.5 py-1.5 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs font-bold transition shadow-sm">
                                Buka PDF
                            </a>
                        </div>
                    @endif
                </div>
                @endif

                {{-- CARD: Info Jaringan --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </span>
                            Info Jaringan & Bandwidth
                        </h3>
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-cyan-500/10 text-cyan-700 dark:text-cyan-400 border border-cyan-500/20">
                            {{ $opdLocation->networks->count() }} Sambungan
                        </span>
                    </div>

                    <div class="space-y-4">
                        @forelse($opdLocation->networks as $network)
                        <div class="p-4 rounded-xl bg-slate-50/70 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-800 relative">
                            {{-- Line index badge --}}
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span class="text-[11px] font-extrabold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                        Sambungan #{{ $loop->iteration }}
                                    </span>
                                </div>
                                @if($network->provider)
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                    {{ $network->provider }}
                                </span>
                                @endif
                            </div>

                            {{-- Cluster & Provider detail --}}
                            <div class="mb-3">
                                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-0.5">Cluster / ISP</p>
                                <p class="text-sm font-extrabold text-slate-800 dark:text-white flex items-center gap-1.5">
                                    <span>Cluster {{ $network->cluster ?? '-' }}</span>
                                    <span class="text-slate-300 dark:text-slate-600">•</span>
                                    <span class="text-cyan-600 dark:text-cyan-400">{{ $network->provider ?? '-' }}</span>
                                </p>
                            </div>

                            {{-- Speed stats grid --}}
                            <div class="grid grid-cols-2 gap-2.5 mb-3">
                                {{-- Upload --}}
                                <div class="speed-badge">
                                    <div>
                                        <div class="flex items-center gap-1 text-[9px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                            <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                            Upload
                                        </div>
                                        <p class="text-sm font-black text-emerald-600 dark:text-emerald-400 mt-0.5">
                                            {{ $network->upload ?? '0' }} <span class="text-[10px] font-bold text-slate-400">Mbps</span>
                                        </p>
                                    </div>
                                    <div class="w-7 h-7 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                                    </div>
                                </div>

                                {{-- Download --}}
                                <div class="speed-badge">
                                    <div>
                                        <div class="flex items-center gap-1 text-[9px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                            <svg class="w-3 h-3 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                            Download
                                        </div>
                                        <p class="text-sm font-black text-cyan-600 dark:text-cyan-400 mt-0.5">
                                            {{ $network->download ?? '0' }} <span class="text-[10px] font-bold text-slate-400">Mbps</span>
                                        </p>
                                    </div>
                                    <div class="w-7 h-7 rounded-lg bg-cyan-500/10 flex items-center justify-center text-cyan-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Network IP --}}
                            @if($network->network_ip)
                            <div class="pt-2.5 border-t border-slate-200/60 dark:border-slate-800 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Subnet / IP:</span>
                                    <span class="text-xs font-mono font-bold text-slate-800 dark:text-slate-200 ml-1.5">{{ $network->network_ip }}</span>
                                </div>
                                <button @click="copyToClipboard('{{ $network->network_ip }}')" 
                                        type="button" 
                                        title="Salin IP"
                                        class="text-[10px] font-bold text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 flex items-center gap-1 transition">
                                    <template x-if="copiedIp === '{{ $network->network_ip }}'">
                                        <span class="text-emerald-500 flex items-center gap-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Tersalin
                                        </span>
                                    </template>
                                    <template x-if="copiedIp !== '{{ $network->network_ip }}'">
                                        <span class="flex items-center gap-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg> Salin
                                        </span>
                                    </template>
                                </button>
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="py-6 text-center text-slate-400 dark:text-slate-500">
                            <p class="text-xs italic">Belum ada sambungan jaringan terdaftar.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- CARD: Info Lokasi & Kontak --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            </span>
                            Lokasi & Kontak
                        </h3>
                    </div>

                    <div class="space-y-4">
                        {{-- Alamat --}}
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Alamat Lengkap</p>
                            <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed font-medium">
                                {{ $opdLocation->alamat ?: '-' }}
                            </p>
                        </div>

                        {{-- Kontak Person --}}
                        @if($opdLocation->kontak_person || $opdLocation->telepon)
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-800">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Penanggung Jawab / PIC</p>
                            <p class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ $opdLocation->kontak_person ?: 'Nama PIC tidak tercantum' }}
                            </p>
                            @if($opdLocation->telepon)
                            <div class="flex items-center gap-2 mt-2 pt-2 border-t border-slate-200/60 dark:border-slate-700/50">
                                <a href="tel:{{ $opdLocation->telepon }}" class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 hover:underline flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    {{ $opdLocation->telepon }}
                                </a>
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $opdLocation->telepon);
                                    if(str_starts_with($cleanPhone, '0')) {
                                        $waPhone = '62' . substr($cleanPhone, 1);
                                    } else {
                                        $waPhone = $cleanPhone;
                                    }
                                @endphp
                                @if(strlen($cleanPhone) >= 9)
                                <a href="https://wa.me/{{ $waPhone }}" target="_blank" class="text-[11px] px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold hover:bg-emerald-500/20 transition flex items-center gap-1 ml-auto">
                                    WhatsApp →
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endif

                        {{-- Koordinat GPS --}}
                        @if($opdLocation->latitude && $opdLocation->longitude)
                        <div class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-0.5">Koordinat GPS</p>
                                <p class="text-xs font-mono font-bold text-slate-800 dark:text-white">
                                    {{ number_format($opdLocation->latitude, 5) }}, {{ number_format($opdLocation->longitude, 5) }}
                                </p>
                            </div>
                            <a href="https://www.google.com/maps?q={{ $opdLocation->latitude }},{{ $opdLocation->longitude }}" 
                               target="_blank" 
                               class="px-2.5 py-1.5 rounded-lg bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-500/20 text-xs font-bold transition flex items-center gap-1">
                                <span>Peta</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                        @endif

                        {{-- Keterangan --}}
                        @if($opdLocation->keterangan)
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">Catatan Tambahan</p>
                            <div class="p-3 rounded-xl bg-amber-500/5 border border-amber-500/20 text-xs text-slate-600 dark:text-slate-300 italic leading-relaxed">
                                {{ $opdLocation->keterangan }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- ======================================================== --}}
            {{-- RIGHT COLUMN: Daftar Perangkat Berdasarkan Ruangan       --}}
            {{-- ======================================================== --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- STATS STRIP: Quick Device Counts --}}
                @php
                    $countAktif = $devices->where('status', 'Aktif')->count();
                    $countGanti = $devices->where('status', 'Perlu Diganti')->count();
                    $countRusak = $devices->whereIn('status', ['Rusak', 'Maintenance'])->count();
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="stats-mini-card">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">Total Unit</p>
                            <p class="text-xl font-black text-slate-900 dark:text-white leading-none mt-0.5">{{ $devices->count() }}</p>
                        </div>
                    </div>

                    <div class="stats-mini-card">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Aktif Normal</p>
                            <p class="text-xl font-black text-emerald-600 dark:text-emerald-400 leading-none mt-0.5">{{ $countAktif }}</p>
                        </div>
                    </div>

                    <div class="stats-mini-card">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400">Perlu Ganti</p>
                            <p class="text-xl font-black text-purple-600 dark:text-purple-400 leading-none mt-0.5">{{ $countGanti }}</p>
                        </div>
                    </div>

                    <div class="stats-mini-card">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400">Rusak / Maint</p>
                            <p class="text-xl font-black text-rose-600 dark:text-rose-400 leading-none mt-0.5">{{ $countRusak }}</p>
                        </div>
                    </div>
                </div>

                {{-- CARD: Perangkat Container --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">

                    {{-- Toolbar: Filter & Actions --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-sm flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <span>Daftar Perangkat</span>
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-bold border border-emerald-200 dark:border-emerald-800/50">
                                    {{ $devices->count() }} unit
                                </span>
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 ml-10.5">Dikelompokkan menurut ruangan / lokasi pemasangan</p>
                        </div>

                        <div class="flex flex-wrap items-center gap-2.5">
                            {{-- Filter Ruang --}}
                            <form method="GET" class="m-0">
                                <select name="lokasi" onchange="this.form.submit()" 
                                        class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 shadow-sm cursor-pointer transition">
                                    <option value="">Semua Lokasi / Ruang ({{ $pemasanganList->count() }})</option>
                                    @foreach($pemasanganList as $loc)
                                    <option value="{{ $loc }}" {{ request('lokasi') == $loc ? 'selected' : '' }}>
                                        {{ $loc }}
                                    </option>
                                    @endforeach
                                </select>
                            </form>

                            {{-- ✅ Tambah Perangkat (Admin) - Inline dalam Daftar --}}
                            @if(auth()->check() && auth()->user()->isAdmin())
                            <a href="{{ route('devices.create', ['opd_location_id' => $opdLocation->id]) }}" 
                               class="btn-tambah-inline" id="btn-tambah-perangkat">
                                <span class="plus-icon">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                </span>
                                <span>+ Tambah Perangkat</span>
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Content: Rooms Accordion --}}
                    <div class="mt-5 space-y-4" x-data="{ allOpen: true }">
                        @if($devices->count() > 0)
                            {{-- Toggle All Rooms Button --}}
                            <div class="flex items-center justify-end">
                                <button @click="$dispatch('toggle-all-rooms'); allOpen = !allOpen" 
                                        type="button"
                                        class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition flex items-center gap-1.5 uppercase tracking-wider">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                    <span x-text="allOpen ? 'Tutup Semua Ruang' : 'Buka Semua Ruang'">Buka / Tutup Semua</span>
                                </button>
                            </div>

                            @php
                                $roomThemes = [
                                    [ // 0: Royal Blue
                                        'gradient' => 'linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #38bdf8 100%)',
                                        'accent'   => '#2563eb',
                                        'border'   => '#3b82f6',
                                    ],
                                    [ // 1: Emerald Green
                                        'gradient' => 'linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%)',
                                        'accent'   => '#059669',
                                        'border'   => '#10b981',
                                    ],
                                    [ // 2: Purple Violet
                                        'gradient' => 'linear-gradient(135deg, #7c3aed 0%, #8b5cf6 50%, #c084fc 100%)',
                                        'accent'   => '#7c3aed',
                                        'border'   => '#8b5cf6',
                                    ],
                                    [ // 3: Amber / Golden Orange
                                        'gradient' => 'linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%)',
                                        'accent'   => '#d97706',
                                        'border'   => '#f59e0b',
                                    ],
                                    [ // 4: Crimson Rose
                                        'gradient' => 'linear-gradient(135deg, #e11d48 0%, #f43f5e 50%, #fb7185 100%)',
                                        'accent'   => '#e11d48',
                                        'border'   => '#f43f5e',
                                    ],
                                    [ // 5: Indigo Electric
                                        'gradient' => 'linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #818cf8 100%)',
                                        'accent'   => '#4f46e5',
                                        'border'   => '#6366f1',
                                    ],
                                    [ // 6: Deep Teal
                                        'gradient' => 'linear-gradient(135deg, #0d9488 0%, #14b8a6 50%, #2dd4bf 100%)',
                                        'accent'   => '#0d9488',
                                        'border'   => '#14b8a6',
                                    ],
                                    [ // 7: Bright Orange
                                        'gradient' => 'linear-gradient(135deg, #ea580c 0%, #f97316 50%, #fb923c 100%)',
                                        'accent'   => '#ea580c',
                                        'border'   => '#f97316',
                                    ],
                                    [ // 8: Magenta Fuchsia
                                        'gradient' => 'linear-gradient(135deg, #c026d3 0%, #d946ef 50%, #f472b6 100%)',
                                        'accent'   => '#c026d3',
                                        'border'   => '#d946ef',
                                    ],
                                    [ // 9: Vivid Cyan
                                        'gradient' => 'linear-gradient(135deg, #0284c7 0%, #06b6d4 50%, #38bdf8 100%)',
                                        'accent'   => '#0284c7',
                                        'border'   => '#06b6d4',
                                    ],
                                ];

                                $neutralTheme = [
                                    'gradient' => 'linear-gradient(135deg, #475569 0%, #64748b 50%, #94a3b8 100%)',
                                    'accent'   => '#64748b',
                                    'border'   => '#94a3b8',
                                ];
                            @endphp

                            @foreach($groupedDevices as $roomName => $roomDevices)
                            @php
                                $theme = ($roomName === 'Belum Ditentukan') ? $neutralTheme : $roomThemes[$loop->index % count($roomThemes)];
                            @endphp
                            <div x-data="{ open: true }" 
                                 @toggle-all-rooms.window="open = !open"
                                 class="rounded-xl overflow-hidden border transition-all duration-200 shadow-sm"
                                 style="border-color: {{ $theme['border'] }}40; border-left: 5px solid {{ $theme['accent'] }};">
                                
                                {{-- Room Accordion Header --}}
                                <button @click="open = !open" 
                                        type="button"
                                        class="w-full flex items-center justify-between gap-3 px-4 py-3 cursor-pointer select-none text-white transition hover:brightness-105 active:scale-[0.99]"
                                        style="background: {{ $theme['gradient'] }};">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 bg-white/20 backdrop-blur-sm shadow-inner">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($roomName === 'Belum Ditentukan')
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                @endif
                                            </svg>
                                        </div>
                                        <h4 class="text-sm font-extrabold tracking-wide uppercase text-white truncate drop-shadow-sm">
                                            {{ $roomName }}
                                        </h4>
                                    </div>

                                    <div class="flex items-center gap-2.5 flex-shrink-0">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold text-white bg-white/25 border border-white/40 drop-shadow-sm">
                                            {{ $roomDevices->count() }} unit
                                        </span>
                                        <svg class="w-4 h-4 text-white/90 transition-transform duration-200" 
                                             :class="open ? 'rotate-180' : ''" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </button>

                                {{-- Room Devices List --}}
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="bg-white dark:bg-slate-900/60 divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach($roomDevices as $device)
                                    @php
                                        $typeLower = strtolower($device->tipe);
                                        $iconBgClasses = [
                                            'router'       => 'bg-cyan-500/10 text-cyan-600 border-cyan-500/20',
                                            'switch'       => 'bg-indigo-500/10 text-indigo-600 border-indigo-500/20',
                                            'access point' => 'bg-purple-500/10 text-purple-600 border-purple-500/20',
                                            'modem'        => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20',
                                            'server'       => 'bg-amber-500/10 text-amber-600 border-amber-500/20',
                                            'firewall'     => 'bg-rose-500/10 text-rose-600 border-rose-500/20',
                                        ];
                                        $iconClass = $iconBgClasses[$typeLower] ?? 'bg-slate-500/10 text-slate-600 border-slate-500/20';

                                        // Status badge colors
                                        $st = $device->status;
                                        if ($st === 'Aktif') {
                                            $stDot = 'active';
                                            $stClass = 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-500/25';
                                        } elseif ($st === 'Perlu Diganti') {
                                            $stDot = 'replacement';
                                            $stClass = 'bg-purple-500/10 text-purple-700 dark:text-purple-300 border-purple-500/25';
                                        } elseif ($st === 'Rusak') {
                                            $stDot = 'damaged';
                                            $stClass = 'bg-rose-500/10 text-rose-700 dark:text-rose-400 border-rose-500/25';
                                        } elseif ($st === 'Maintenance') {
                                            $stDot = 'maintenance';
                                            $stClass = 'bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-500/25';
                                        } else {
                                            $stDot = '';
                                            $stClass = 'bg-slate-500/10 text-slate-600 border-slate-500/25';
                                        }
                                    @endphp
                                    <div class="device-item-row px-4 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group">
                                        {{-- Device Info Left --}}
                                        <div class="flex items-center gap-3 min-w-0">
                                            {{-- Device Icon --}}
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center border {{ $iconClass }} flex-shrink-0 group-hover:scale-105 transition-transform">
                                                <x-device-icon :type="$device->tipe" class="w-5 h-5" />
                                            </div>

                                            {{-- Details --}}
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('devices.show', ['device' => $device->id, 'from' => 'opd']) }}" 
                                                       class="text-sm font-extrabold text-slate-800 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition truncate">
                                                        {{ $device->merk }} {{ $device->model }}
                                                    </a>
                                                    @if($device->umur_perangkat)
                                                    <span class="hidden md:inline-block text-[10px] px-2 py-0.2 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-500 font-medium">
                                                        Umur: {{ $device->umur_perangkat }}
                                                    </span>
                                                    @endif
                                                </div>

                                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                                        {{ $device->tipe }}
                                                    </span>
                                                    <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                                    <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                                        SN: <span class="font-mono text-slate-700 dark:text-slate-300">{{ $device->nomor_seri ?: '-' }}</span>
                                                    </span>

                                                    @if($device->ip_address)
                                                    <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md bg-cyan-50 dark:bg-cyan-950/40 text-cyan-700 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-800/60 font-mono text-[10px] font-bold">
                                                        {{ $device->ip_address }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Device Status & Action Buttons --}}
                                        <div class="flex items-center justify-between sm:justify-end gap-3 flex-shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-slate-800">
                                            {{-- Status Badge --}}
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider border {{ $stClass }}">
                                                <span class="status-dot {{ $stDot }}"></span>
                                                {{ $device->status }}
                                            </span>

                                            {{-- Buttons --}}
                                            <div class="flex items-center gap-1.5">
                                                {{-- Lihat Detail --}}
                                                <a href="{{ route('devices.show', ['device' => $device->id, 'from' => 'opd']) }}" 
                                                   title="Lihat Detail Perangkat" 
                                                   class="action-icon-btn bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-500/20">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </a>

                                                {{-- Edit Device (Admin) --}}
                                                @if(auth()->check() && auth()->user()->isAdmin())
                                                <a href="{{ route('devices.edit', ['device' => $device->id, 'from' => 'opd']) }}" 
                                                   title="Edit Perangkat" 
                                                   class="action-icon-btn bg-amber-500/10 text-amber-600 dark:text-amber-400 hover:bg-amber-500/20">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </a>

                                                {{-- Hapus Device (Admin) --}}
                                                <form action="{{ route('devices.destroy', $device->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="redirect_to_opd" value="{{ $opdLocation->id }}">
                                                    <button type="submit" 
                                                            title="Hapus Perangkat" 
                                                            class="action-icon-btn bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-500/20">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        @else
                            {{-- Empty State --}}
                            <div class="py-16 text-center rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/30">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                                </div>
                                <h4 class="text-sm font-bold text-slate-700 dark:text-slate-300">Belum Ada Perangkat</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">
                                    Belum ada perangkat terdaftar di OPD ini{{ request('lokasi') ? ' pada ruangan terpilih.' : '.' }}
                                </p>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                <div class="mt-4">
                                    <a href="{{ route('devices.create', ['opd_location_id' => $opdLocation->id]) }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Perangkat Pertama
                                    </a>
                                </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>

        {{-- ===== MODAL LIGHTBOX DENAH ===== --}}
        @if($opdLocation->denah_file && $isImage)
        <div x-show="denahModalOpen" 
             x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/80 backdrop-blur-md flex items-center justify-center p-4"
             @keydown.escape.window="denahModalOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="relative max-w-5xl w-full bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden"
                 @click.away="denahModalOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="scale-95 opacity-0"
                 x-transition:enter-end="scale-100 opacity-100">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Denah Gedung: {{ $opdLocation->nama }}</h3>
                            <p class="text-[11px] text-slate-500">Klik kanan atau gunakan tombol tab baru untuk mengunduh</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <a href="{{ asset('storage/' . $opdLocation->denah_file) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold hover:bg-slate-200 transition flex items-center gap-1">
                            <span>Tab Baru</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        <button @click="denahModalOpen = false" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Modal Body: Image --}}
                <div class="p-4 bg-slate-50 dark:bg-slate-950 flex items-center justify-center max-h-[75vh] overflow-auto">
                    <img src="{{ asset('storage/' . $opdLocation->denah_file) }}" alt="Denah Penuh {{ $opdLocation->nama }}" class="max-w-full h-auto rounded-lg shadow-sm border border-slate-200 dark:border-slate-800">
                </div>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
