<x-app-layout>
    <x-slot name="title">Detail Log Maintenance</x-slot>

    @push('styles')
    <style>
        .detail-header-wrap {
            background: linear-gradient(135deg, #1e3a5f 0%, #1a56db 60%, #0ea5e9 100%);
            border-radius: 18px;
            padding: 1.75rem 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 28px rgba(26, 86, 219, 0.28);
        }
        .detail-header-wrap::before {
            content: ""; position: absolute;
            top: -50px; right: -40px;
            width: 220px; height: 220px;
            background: rgba(255,255,255,0.07); border-radius: 50%;
        }
        .detail-header-wrap::after {
            content: ""; position: absolute;
            bottom: -60px; right: 100px;
            width: 250px; height: 250px;
            background: rgba(255,255,255,0.04); border-radius: 50%;
        }
        .hdr-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 0.5rem 1rem; font-size: 0.8rem; font-weight: 700;
            border-radius: 10px; text-decoration: none;
            transition: all 0.2s ease; white-space: nowrap;
        }
        .hdr-btn:hover { transform: translateY(-1px); }
        .hdr-btn:active { transform: scale(0.97); }
        .hdr-btn-back {
            background: rgba(255,255,255,0.13); color: #fff;
            border: 1px solid rgba(255,255,255,0.22); backdrop-filter: blur(4px);
        }
        .hdr-btn-back:hover { background: rgba(255,255,255,0.22); color: #fff; }
        .hdr-btn-edit {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            color: #fff; box-shadow: 0 4px 12px rgba(245,158,11,0.35);
        }
        .hdr-btn-edit:hover { box-shadow: 0 6px 18px rgba(245,158,11,0.45); color: #fff; }

        .info-card {
            background: #fff; border: 1px solid #e2e8f0;
            border-radius: 16px; padding: 1.75rem;
            box-shadow: 0 1px 6px rgba(0,0,0,0.05);
        }
        .info-label {
            font-size: 0.65rem; font-weight: 800;
            text-transform: uppercase; letter-spacing: 0.08em;
            color: #94a3b8; margin-bottom: 0.3rem;
        }
        .info-value { font-size: 0.88rem; font-weight: 700; color: #0f172a; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 0.3rem 0.8rem; border-radius: 20px;
            font-size: 0.68rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; }
        .status-selesai { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .status-selesai .status-dot { background: #10b981; box-shadow: 0 0 6px rgba(16,185,129,0.5); }
        .status-pending { background: #fffbeb; color: #78350f; border: 1px solid #fde68a; }
        .status-pending .status-dot { background: #f59e0b; box-shadow: 0 0 6px rgba(245,158,11,0.5); }
        .status-proses { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .status-proses .status-dot { background: #3b82f6; box-shadow: 0 0 6px rgba(59,130,246,0.5); }

        .jenis-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 0.3rem 0.75rem; border-radius: 8px;
            font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .jenis-perbaikan   { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .jenis-penggantian { background: #fdf4ff; color: #7e22ce; border: 1px solid #e9d5ff; }
        .jenis-konfigurasi { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .jenis-preventif   { background: #fff7ed; color: #9a3412; border: 1px solid #fed7aa; }
    </style>
    @endpush

    {{-- ===== DETAIL HEADER ===== --}}
    <div class="detail-header-wrap">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('maintenance-logs.index') }}" class="hdr-btn hdr-btn-back">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Log
                    </a>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Detail Log Maintenance</h1>
                <p class="text-sm text-blue-100 mt-1 font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    {{ $maintenanceLog->device->merk ?? '-' }} {{ $maintenanceLog->device->model ?? '' }}
                </p>
            </div>
            @if(auth()->user()->isAdmin())
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('maintenance-logs.edit', $maintenanceLog) }}" class="hdr-btn hdr-btn-edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Log
                </a>
                <form method="POST" action="{{ route('maintenance-logs.destroy', $maintenanceLog) }}" onsubmit="return confirm('Hapus log ini?')" style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" class="hdr-btn" style="background:rgba(239,68,68,0.2);color:#fff;border:1px solid rgba(252,165,165,0.35);backdrop-filter:blur(4px);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    {{-- ===== DETAIL CARD ===== --}}
    <div class="max-w-4xl">
        <div class="info-card">
            {{-- Header Info --}}
            <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg,#1a56db,#0ea5e9);">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Informasi Log Maintenance</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Dicatat pada {{ $maintenanceLog->tanggal->format('d M Y') }} oleh {{ $maintenanceLog->user->name ?? '-' }}</p>
                </div>
                <div class="ml-auto">
                    @php
                        $statusClass = match($maintenanceLog->status) {
                            'Selesai'      => 'status-selesai',
                            'Pending'      => 'status-pending',
                            'Dalam Proses' => 'status-proses',
                            default        => 'status-pending',
                        };
                    @endphp
                    <span class="status-badge {{ $statusClass }}">
                        <span class="status-dot"></span>
                        {{ $maintenanceLog->status }}
                    </span>
                </div>
            </div>

            {{-- Grid Info --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-5">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="info-label">Perangkat</p>
                    <p class="info-value">{{ $maintenanceLog->device->merk ?? '-' }} {{ $maintenanceLog->device->model ?? '' }}</p>
                    <p class="text-[10px] font-mono text-slate-400 mt-0.5">SN: {{ $maintenanceLog->device->nomor_seri ?? '-' }}</p>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="info-label">Lokasi OPD</p>
                    <p class="info-value text-sm">{{ $maintenanceLog->device->opdLocation->nama ?? '-' }}</p>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="info-label">Jenis Maintenance</p>
                    <div class="mt-1">
                        @php
                            $jenisClass = match($maintenanceLog->jenis) {
                                'Perbaikan'   => 'jenis-perbaikan',
                                'Penggantian' => 'jenis-penggantian',
                                'Konfigurasi' => 'jenis-konfigurasi',
                                'Preventif'   => 'jenis-preventif',
                                default       => 'jenis-perbaikan',
                            };
                        @endphp
                        <span class="jenis-badge {{ $jenisClass }}">{{ $maintenanceLog->jenis }}</span>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="info-label">Tanggal</p>
                    <p class="info-value flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $maintenanceLog->tanggal->format('d M Y') }}
                    </p>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="info-label">Teknisi / PIC</p>
                    <p class="info-value flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ $maintenanceLog->user->name ?? '-' }}
                    </p>
                </div>

                <div class="p-3.5 rounded-xl border" style="background: #fffbeb; border-color: #fde68a;">
                    <p class="info-label" style="color:#d97706;">Biaya</p>
                    <p class="text-lg font-black" style="color:#d97706;">
                        {{ $maintenanceLog->biaya ? 'Rp '.number_format($maintenanceLog->biaya, 0, ',', '.') : '-' }}
                    </p>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mt-6 pt-6 border-t border-slate-100">
                <p class="info-label mb-2">Deskripsi Pekerjaan</p>
                <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100 text-sm text-slate-700 leading-relaxed">
                    {{ $maintenanceLog->deskripsi }}
                </div>
            </div>

            {{-- Catatan --}}
            @if($maintenanceLog->catatan)
            <div class="mt-5">
                <p class="info-label mb-2">Catatan Tambahan</p>
                <div class="p-4 rounded-xl bg-amber-50/50 border border-amber-100 text-sm text-slate-600 italic leading-relaxed">
                    {{ $maintenanceLog->catatan }}
                </div>
            </div>
            @endif
        </div>
    </div>

</x-app-layout>
