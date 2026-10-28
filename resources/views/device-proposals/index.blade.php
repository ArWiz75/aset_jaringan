<x-app-layout>
    <x-slot name="title">Usulan & Rekomendasi Penambahan Perangkat</x-slot>

    @push('styles')
    <style>
        .prop-header-wrap {
            background: linear-gradient(135deg, #064e3b 0%, #059669 55%, #10b981 100%);
            border-radius: 18px;
            padding: 1.75rem 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(5, 150, 105, 0.28);
        }
        .prop-header-wrap::before {
            content: "";
            position: absolute;
            top: -60px; right: -50px;
            width: 250px; height: 250px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }
        .prop-btn {
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
        .prop-btn:hover { transform: translateY(-1px); }
        .prop-btn:active { transform: scale(0.97); }

        .btn-tambah-prop {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 0.6rem 1.25rem;
            border-radius: 12px;
            font-size: 0.84rem;
            font-weight: 800;
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            color: #fff;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.45);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: none;
        }
        .btn-tambah-prop:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.55);
            color: #fff;
        }

        .stat-card-prop {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: all 0.2s ease;
        }
        .stat-card-prop:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }
        .dark .stat-card-prop {
            background: rgba(15, 23, 42, 0.7);
            border-color: rgba(51, 65, 85, 0.6);
        }

        .empty-opd-card {
            border: 1px solid #fed7aa;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border-radius: 14px;
            padding: 1.15rem 1.25rem;
            transition: all 0.2s ease;
        }
        .empty-opd-card:hover {
            border-color: #f97316;
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.15);
        }
    </style>
    @endpush

    <div x-data="{
        createModalOpen: false,
        editModalOpen: false,
        statusModalOpen: false,
        selectedProp: null,
        selectedOpdId: '',
        openCreateWithOpd(opdId = '') {
            this.selectedOpdId = opdId;
            this.createModalOpen = true;
        },
        openEdit(prop) {
            this.selectedProp = prop;
            this.editModalOpen = true;
        },
        openStatus(prop) {
            this.selectedProp = prop;
            this.statusModalOpen = true;
        }
    }">

        {{-- ===== HEADER SECTION ===== --}}
        <div class="prop-header-wrap">
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                <div>
                    {{-- Breadcrumbs / Subtitle --}}
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-white text-xs font-semibold backdrop-blur-sm border border-white/20">
                            <svg class="w-3.5 h-3.5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Perencanaan &amp; Pengadaan Aset
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight flex items-center gap-3">
                        <span>Rekomendasi &amp; Usulan Penambahan Perangkat</span>
                    </h1>

                    <p class="text-xs sm:text-sm text-emerald-100 mt-2 max-w-2xl font-medium leading-relaxed">
                        Manajemen usulan pengadaan perangkat jaringan baru per OPD untuk dilaporkan ke pimpinan, termasuk pemantauan lokasi OPD yang belum terpasang infrastruktur internet.
                    </p>
                </div>

                {{-- Action Toolbar --}}
                <div class="flex flex-wrap items-center gap-2.5">
                    {{-- Cetak Laporan Resmi --}}
                    <a href="{{ route('export.proposals.print', request()->query()) }}" target="_blank"
                       class="prop-btn bg-white/15 hover:bg-white/25 text-white border border-white/25 backdrop-blur-sm shadow-sm"
                       title="Cetak Laporan Resmi Format DISKOMINFO">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Laporan</span>
                    </a>

                    {{-- Export PDF --}}
                    <a href="{{ route('export.proposals.pdf', request()->query()) }}"
                       class="prop-btn bg-rose-500/20 hover:bg-rose-500/30 text-white border border-rose-400/40 backdrop-blur-sm"
                       title="Unduh Laporan Format PDF Landscape">
                        <svg class="w-4 h-4 text-rose-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                        <span>PDF</span>
                    </a>

                    {{-- Export Excel --}}
                    <a href="{{ route('export.proposals.excel', request()->query()) }}"
                       class="prop-btn bg-emerald-400/25 hover:bg-emerald-400/35 text-white border border-emerald-300/40 backdrop-blur-sm"
                       title="Unduh Lembar Kerja Excel">
                        <svg class="w-4 h-4 text-emerald-100" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"/></svg>
                        <span>Excel</span>
                    </a>

                    {{-- Admin: Tambah Usulan --}}
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <button type="button" @click="openCreateWithOpd()" class="btn-tambah-prop">
                        <span style="width:20px;height:20px;background:rgba(255,255,255,0.25);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        </span>
                        <span>+ Ajukan Usulan Baru</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===== FLASH MESSAGES ===== --}}
        @if(session('success'))
        <div class="mb-5 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3 text-emerald-800 dark:text-emerald-200 text-xs font-bold shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-5 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 flex items-center gap-3 text-rose-800 dark:text-rose-200 text-xs font-bold shadow-sm">
            <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-5 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-xs shadow-sm">
            <div class="flex items-center gap-2 font-bold mb-1">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Mohon periksa kesalahan input berikut:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 ml-2 font-medium">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ===== STATS MINI CARDS ===== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5 mb-6">
            {{-- Total Usulan --}}
            <div class="stat-card-prop">
                <div class="w-11 h-11 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Item Usulan</p>
                    <p class="text-xl font-black text-slate-900 dark:text-white leading-none mt-1">{{ $totalUsulan }} Usulan</p>
                </div>
            </div>

            {{-- Total Unit --}}
            <div class="stat-card-prop">
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Total Kebutuhan Unit</p>
                    <p class="text-xl font-black text-emerald-600 dark:text-emerald-400 leading-none mt-1">{{ $totalUnit }} Unit</p>
                </div>
            </div>

            {{-- Total Estimasi Biaya --}}
            <div class="stat-card-prop">
                <div class="w-11 h-11 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400">Estimasi Total Anggaran</p>
                    <p class="text-lg font-black text-purple-600 dark:text-purple-400 leading-none mt-1">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Status Butuh Tindak Lanjut --}}
            <div class="stat-card-prop">
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Proses / Belum Realisasi</p>
                    <p class="text-xl font-black text-amber-600 dark:text-amber-400 leading-none mt-1">{{ $pendingUsulan }} Usulan</p>
                </div>
            </div>
        </div>

        {{-- ===== DETEKSI OTOMATIS: OPD BELUM BERPERANGKAT INTERNET ===== --}}
        @if($emptyOpds->count() > 0)
        <div class="mb-6 p-5 rounded-2xl bg-gradient-to-r from-amber-500/10 via-orange-500/10 to-amber-500/5 border border-amber-500/30">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-amber-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                            <span>Perhatian Khusus: Terdapat {{ $emptyOpds->count() }} OPD Belum Memiliki Perangkat Internet</span>
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">
                            OPD berikut belum tercatat memiliki Router, Switch, atau Access Point. Klik usulkan paket starter otomatis atau buat usulan mandiri untuk dilaporkan ke pimpinan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                @foreach($emptyOpds as $emptyOpd)
                <div class="empty-opd-card flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h4 class="text-sm font-black text-slate-900 leading-tight">
                                {{ $emptyOpd->nama }}
                            </h4>
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-rose-500/15 text-rose-700 border border-rose-500/30 uppercase tracking-wider flex-shrink-0">
                                0 Perangkat
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 line-clamp-2 mb-3">
                            {{ $emptyOpd->alamat ?: 'Alamat belum diatur' }} {{ $emptyOpd->kecamatan ? '(Kec. ' . $emptyOpd->kecamatan . ')' : '' }}
                        </p>
                    </div>

                    @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="flex items-center gap-2 pt-2.5 border-t border-amber-200/80">
                        {{-- Quick propose form --}}
                        <form method="POST" action="{{ route('device-proposals.quick-empty', $emptyOpd) }}" class="m-0 flex-1" onsubmit="return confirm('Buat paket usulan starter internet (1 Router, 1 Switch, 2 AP) untuk {{ $emptyOpd->nama }}?')">
                            @csrf
                            <button type="submit" class="w-full px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold transition flex items-center justify-center gap-1 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span>+ Paket Starter (Router/Sw/AP)</span>
                            </button>
                        </form>

                        {{-- Manual proposal --}}
                        <button type="button" @click="openCreateWithOpd('{{ $emptyOpd->id }}')" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 text-[11px] font-bold transition">
                            Usul Mandiri
                        </button>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ===== MAIN PROPOSALS TABLE CARD ===== --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 sm:p-6 shadow-sm">
            
            {{-- Filter & Search Toolbar --}}
            <form method="GET" action="{{ route('device-proposals.index') }}" class="mb-5 space-y-3">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-2.5 flex-1">
                        {{-- Search input --}}
                        <div class="relative min-w-[240px] flex-1">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari OPD, tipe perangkat, alasan, atau spek..."
                                   class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 dark:bg-slate-800 text-slate-800 dark:text-slate-200">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>

                        {{-- Filter OPD --}}
                        <select name="opd_location_id" onchange="this.form.submit()" class="text-xs rounded-xl border border-slate-200 dark:border-slate-700 dark:bg-slate-800 px-3 py-2 font-semibold">
                            <option value="">Semua Lokasi OPD</option>
                            @foreach($opdLocations as $opd)
                            <option value="{{ $opd->id }}" {{ request('opd_location_id') == $opd->id ? 'selected' : '' }}>
                                {{ $opd->nama }}
                            </option>
                            @endforeach
                        </select>

                        {{-- Filter Tipe --}}
                        <select name="tipe_perangkat" onchange="this.form.submit()" class="text-xs rounded-xl border border-slate-200 dark:border-slate-700 dark:bg-slate-800 px-3 py-2 font-semibold">
                            <option value="">Semua Tipe Perangkat</option>
                            @foreach($tipeList as $t)
                            <option value="{{ $t }}" {{ request('tipe_perangkat') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>

                        {{-- Filter Urgensi --}}
                        <select name="urgensi" onchange="this.form.submit()" class="text-xs rounded-xl border border-slate-200 dark:border-slate-700 dark:bg-slate-800 px-3 py-2 font-semibold">
                            <option value="">Semua Urgensi</option>
                            <option value="Tinggi" {{ request('urgensi') == 'Tinggi' ? 'selected' : '' }}>Urgensi Tinggi</option>
                            <option value="Sedang" {{ request('urgensi') == 'Sedang' ? 'selected' : '' }}>Urgensi Sedang</option>
                            <option value="Rendah" {{ request('urgensi') == 'Rendah' ? 'selected' : '' }}>Urgensi Rendah</option>
                        </select>

                        {{-- Filter Status --}}
                        <select name="status" onchange="this.form.submit()" class="text-xs rounded-xl border border-slate-200 dark:border-slate-700 dark:bg-slate-800 px-3 py-2 font-semibold">
                            <option value="">Semua Status Usulan</option>
                            <option value="Diusulkan" {{ request('status') == 'Diusulkan' ? 'selected' : '' }}>Diusulkan</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Dalam Pengadaan" {{ request('status') == 'Dalam Pengadaan' ? 'selected' : '' }}>Dalam Pengadaan</option>
                            <option value="Terealisasi" {{ request('status') == 'Terealisasi' ? 'selected' : '' }}>Terealisasi</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold transition">
                            Terapkan Filter
                        </button>
                        @if(request()->anyFilled(['q', 'opd_location_id', 'tipe_perangkat', 'urgensi', 'status']))
                        <a href="{{ route('device-proposals.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 text-xs font-semibold transition">
                            Reset
                        </a>
                        @endif
                    </div>
                </div>
            </form>

            {{-- Table --}}
            <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-700">
                            <th class="py-3 px-3.5 font-bold text-slate-600 dark:text-slate-300 w-12 text-center">No</th>
                            <th class="py-3 px-3.5 font-bold text-slate-600 dark:text-slate-300">Lokasi OPD &amp; Ruangan</th>
                            <th class="py-3 px-3.5 font-bold text-slate-600 dark:text-slate-300">Perangkat &amp; Jumlah</th>
                            <th class="py-3 px-3.5 font-bold text-slate-600 dark:text-slate-300 text-center">Urgensi</th>
                            <th class="py-3 px-3.5 font-bold text-slate-600 dark:text-slate-300">Alasan Kebutuhan &amp; Spesifikasi Rekomendasi</th>
                            <th class="py-3 px-3.5 font-bold text-slate-600 dark:text-slate-300 text-right">Estimasi Biaya</th>
                            <th class="py-3 px-3.5 font-bold text-slate-600 dark:text-slate-300 text-center">Status</th>
                            @if(auth()->check() && auth()->user()->isAdmin())
                            <th class="py-3 px-3.5 font-bold text-slate-600 dark:text-slate-300 text-center w-28">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($proposals as $idx => $p)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-3.5 text-center font-bold text-slate-400">
                                {{ $proposals->firstItem() + $idx }}
                            </td>
                            <td class="py-3.5 px-3.5">
                                <a href="{{ route('opd-locations.show', $p->opd_location_id) }}" class="font-extrabold text-slate-900 dark:text-white hover:text-emerald-600 transition block">
                                    {{ $p->opdLocation->nama ?? '-' }}
                                </a>
                                <p class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    Titik: <strong>{{ $p->lokasi_ruang ?: 'Area Utama OPD' }}</strong>
                                </p>
                            </td>
                            <td class="py-3.5 px-3.5">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-extrabold text-slate-800 dark:text-slate-200">{{ $p->tipe_perangkat }}</span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300">
                                        {{ $p->jumlah }} Unit
                                    </span>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-0.5">Oleh: {{ $p->nama_pengusul ?: 'Admin' }}</p>
                            </td>
                            <td class="py-3.5 px-3.5 text-center">
                                @php $uBadge = $p->urgensi_badge; @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $uBadge['bg'] }} {{ $uBadge['text'] }} border {{ $uBadge['border'] }}">
                                    {{ $p->urgensi }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3.5 max-w-xs">
                                <p class="text-slate-800 dark:text-slate-200 font-medium leading-relaxed">
                                    {{ $p->alasan_kebutuhan }}
                                </p>
                                @if($p->rekomendasi_spesifikasi)
                                <div class="mt-1.5 p-2 rounded-lg bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/80 text-[11px] text-slate-600 dark:text-slate-400">
                                    <span class="font-bold text-slate-700 dark:text-slate-300">Spek Rekomendasi:</span> {{ $p->rekomendasi_spesifikasi }}
                                </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-3.5 text-right font-black text-slate-900 dark:text-white">
                                {{ $p->formatted_biaya }}
                            </td>
                            <td class="py-3.5 px-3.5 text-center">
                                @php $sBadge = $p->status_badge; @endphp
                                <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $sBadge['bg'] }} {{ $sBadge['text'] }} border {{ $sBadge['border'] }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            @if(auth()->check() && auth()->user()->isAdmin())
                            <td class="py-3.5 px-3.5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    {{-- Ubah Status Button --}}
                                    <button type="button" @click="openStatus({{ json_encode($p) }})" title="Ubah Status Usulan"
                                            class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-300 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </button>

                                    {{-- Edit Button --}}
                                    <button type="button" @click="openEdit({{ json_encode($p) }})" title="Edit Usulan"
                                            class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 dark:text-blue-400 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>

                                    {{-- Delete Button --}}
                                    <form method="POST" action="{{ route('device-proposals.destroy', $p) }}" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus usulan perangkat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Usulan"
                                                class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:hover:bg-rose-900/50 dark:text-rose-400 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ (auth()->check() && auth()->user()->isAdmin()) ? 8 : 7 }}" class="py-12 text-center text-slate-400">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Belum Ada Usulan Penambahan Perangkat</p>
                                <p class="text-xs text-slate-500 mt-1">Gunakan tombol di atas untuk mengajukan rekomendasi perangkat baru.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $proposals->links() }}
            </div>
        </div>

        {{-- ===== MODAL CREATE USULAN BARU ===== --}}
        <template x-teleport="body">
            <div x-show="createModalOpen" x-cloak class="fixed inset-0 flex items-center justify-center p-3 sm:p-4 z-[99999]">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="createModalOpen = false"></div>
                <div class="relative bg-white dark:bg-slate-900 rounded-2xl max-w-xl w-full shadow-2xl border border-slate-200 dark:border-slate-800 z-10 max-h-[90vh] flex flex-col overflow-hidden">
                    {{-- Pinned Modal Header --}}
                    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between flex-shrink-0 bg-white dark:bg-slate-900">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900 dark:text-white leading-tight">Form Usulan Penambahan Perangkat</h3>
                                <p class="text-[11px] text-slate-500">Isi kebutuhan perangkat jaringan baru untuk diajukan ke pimpinan.</p>
                            </div>
                        </div>
                        <button type="button" @click="createModalOpen = false" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Form with Scrollable Content & Pinned Footer --}}
                    <form method="POST" action="{{ route('device-proposals.store') }}" class="flex flex-col flex-1 overflow-hidden m-0">
                        @csrf
                        {{-- Scrollable Form Body --}}
                        <div class="p-5 space-y-4 overflow-y-auto flex-1">
                            {{-- OPD Location --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Lokasi OPD Target <span class="text-rose-500">*</span></label>
                                <select name="opd_location_id" x-model="selectedOpdId" required class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5 font-medium">
                                    <option value="">-- Pilih Lokasi OPD --</option>
                                    @foreach($opdLocations as $opd)
                                    <option value="{{ $opd->id }}">{{ $opd->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tipe & Jumlah --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tipe Perangkat <span class="text-rose-500">*</span></label>
                                    <select name="tipe_perangkat" required class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5 font-medium">
                                        @foreach($tipeList as $t)
                                        <option value="{{ $t }}">{{ $t }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jumlah Unit <span class="text-rose-500">*</span></label>
                                    <input type="number" name="jumlah" value="1" min="1" required class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5 font-medium">
                                </div>
                            </div>

                            {{-- Lokasi Ruang & Urgensi --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Titik Pasang / Ruangan</label>
                                    <input type="text" name="lokasi_ruang" placeholder="Contoh: Ruang Rapat Lt. 2 / Lobi" class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5 font-medium">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tingkat Urgensi <span class="text-rose-500">*</span></label>
                                    <select name="urgensi" required class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5 font-medium">
                                        <option value="Tinggi">Tinggi (Kritis / Urgent)</option>
                                        <option value="Sedang" selected>Sedang (Dibutuhkan)</option>
                                        <option value="Rendah">Rendah (Penyempurnaan)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Alasan Kebutuhan --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Alasan Kebutuhan / Justifikasi Teknis <span class="text-rose-500">*</span></label>
                                <textarea name="alasan_kebutuhan" rows="3" required placeholder="Jelaskan mengapa perangkat ini perlu ditambah (misal: OPD baru belum ada internet, area blank spot, penambahan staf baru, dsb.)" class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5 font-medium"></textarea>
                            </div>

                            {{-- Rekomendasi Spek & Estimasi Biaya --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Rekomendasi Spek / Merk</label>
                                    <input type="text" name="rekomendasi_spesifikasi" placeholder="Misal: MikroTik RB4011 / Ruijie 1300 Pro" class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5 font-medium">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Estimasi Biaya Total (Rp)</label>
                                    <input type="number" name="estimasi_biaya" placeholder="Misal: 1495000" min="0" step="1000" class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5 font-medium">
                                </div>
                            </div>
                        </div>

                        {{-- Pinned Modal Footer (Always Visible!) --}}
                        <div class="px-5 py-3.5 bg-slate-50 dark:bg-slate-800/80 border-t border-slate-200 dark:border-slate-700 flex items-center justify-end gap-2.5 flex-shrink-0">
                            <button type="button" @click="createModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 dark:text-slate-300 text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                                Batal
                            </button>
                            <button type="submit" style="background-color: #059669 !important; color: #ffffff !important; border: none !important;" class="px-5 py-2.5 rounded-xl text-white text-xs font-bold shadow-md shadow-emerald-500/25 hover:opacity-95 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Simpan Usulan Perangkat</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        {{-- ===== MODAL EDIT USULAN ===== --}}
        <template x-teleport="body">
            <div x-show="editModalOpen" x-cloak class="fixed inset-0 flex items-center justify-center p-3 sm:p-4 z-[99999]">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="editModalOpen = false"></div>
                <div class="relative bg-white dark:bg-slate-900 rounded-2xl max-w-xl w-full shadow-2xl border border-slate-200 dark:border-slate-800 z-10 max-h-[90vh] flex flex-col overflow-hidden" x-show="selectedProp">
                    {{-- Pinned Header --}}
                    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between flex-shrink-0 bg-white dark:bg-slate-900">
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Edit Usulan Penambahan Perangkat</h3>
                        <button type="button" @click="editModalOpen = false" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Form with Scrollable Body and Pinned Footer --}}
                    <form method="POST" :action="selectedProp ? ('/device-proposals/' + selectedProp.id) : ''" class="flex flex-col flex-1 overflow-hidden m-0">
                        @csrf
                        @method('PUT')
                        <div class="p-5 space-y-4 overflow-y-auto flex-1">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Lokasi OPD <span class="text-rose-500">*</span></label>
                                <select name="opd_location_id" :value="selectedProp?.opd_location_id" required class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5">
                                    @foreach($opdLocations as $opd)
                                    <option value="{{ $opd->id }}">{{ $opd->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tipe Perangkat <span class="text-rose-500">*</span></label>
                                    <select name="tipe_perangkat" :value="selectedProp?.tipe_perangkat" required class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5">
                                        @foreach($tipeList as $t)
                                        <option value="{{ $t }}">{{ $t }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jumlah Unit <span class="text-rose-500">*</span></label>
                                    <input type="number" name="jumlah" :value="selectedProp?.jumlah" min="1" required class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Titik Pasang / Ruangan</label>
                                    <input type="text" name="lokasi_ruang" :value="selectedProp?.lokasi_ruang" class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Urgensi <span class="text-rose-500">*</span></label>
                                    <select name="urgensi" :value="selectedProp?.urgensi" required class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5">
                                        <option value="Tinggi">Tinggi</option>
                                        <option value="Sedang">Sedang</option>
                                        <option value="Rendah">Rendah</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Alasan Kebutuhan <span class="text-rose-500">*</span></label>
                                <textarea name="alasan_kebutuhan" rows="3" required :value="selectedProp?.alasan_kebutuhan" class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5"></textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Rekomendasi Spek</label>
                                    <input type="text" name="rekomendasi_spesifikasi" :value="selectedProp?.rekomendasi_spesifikasi" class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Estimasi Biaya (Rp)</label>
                                    <input type="number" name="estimasi_biaya" :value="selectedProp?.estimasi_biaya" min="0" class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Status Usulan <span class="text-rose-500">*</span></label>
                                <select name="status" :value="selectedProp?.status" required class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5">
                                    <option value="Diusulkan">Diusulkan</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Dalam Pengadaan">Dalam Pengadaan</option>
                                    <option value="Terealisasi">Terealisasi</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>

                        {{-- Pinned Footer --}}
                        <div class="px-5 py-3.5 bg-slate-50 dark:bg-slate-800/80 border-t border-slate-200 dark:border-slate-700 flex items-center justify-end gap-2.5 flex-shrink-0">
                            <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                            <button type="submit" style="background-color: #2563eb !important; color: #ffffff !important; border: none !important;" class="px-5 py-2.5 rounded-xl text-white text-xs font-bold shadow-md hover:opacity-95 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        {{-- ===== MODAL QUICK STATUS UPDATE ===== --}}
        <template x-teleport="body">
            <div x-show="statusModalOpen" x-cloak class="fixed inset-0 flex items-center justify-center p-3 sm:p-4 z-[99999]">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="statusModalOpen = false"></div>
                <div class="relative bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full shadow-2xl border border-slate-200 dark:border-slate-800 z-10 flex flex-col overflow-hidden" x-show="selectedProp">
                    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between flex-shrink-0 bg-white dark:bg-slate-900">
                        <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Ubah Status Usulan Pengadaan</h3>
                        <button type="button" @click="statusModalOpen = false" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" :action="selectedProp ? ('/device-proposals/' + selectedProp.id + '/status') : ''" class="flex flex-col m-0">
                        @csrf
                        @method('PATCH')
                        <div class="p-5 space-y-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Perangkat:</p>
                                <p class="text-xs font-extrabold text-slate-800 dark:text-white" x-text="(selectedProp?.tipe_perangkat + ' (' + selectedProp?.jumlah + ' unit) - ' + (selectedProp?.opd_location?.nama || ''))"></p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Status Baru <span class="text-rose-500">*</span></label>
                                <select name="status" :value="selectedProp?.status" required class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5 font-bold">
                                    <option value="Diusulkan">🟡 Diusulkan (Menunggu Pembahasan)</option>
                                    <option value="Disetujui">🔵 Disetujui (Siap Masuk Anggaran)</option>
                                    <option value="Dalam Pengadaan">🟣 Dalam Pengadaan (Proses Belanja/Instalasi)</option>
                                    <option value="Terealisasi">🟢 Terealisasi (Sudah Terpasang)</option>
                                    <option value="Ditolak">🔴 Ditolak (Tidak Disetujui)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Catatan Pimpinan / Diskominfo</label>
                                <textarea name="catatan" rows="2" placeholder="Catatan pertimbangan persetujuan atau alasan penolakan..." :value="selectedProp?.catatan" class="w-full text-xs rounded-xl border border-slate-300 dark:border-slate-700 dark:bg-slate-800 p-2.5"></textarea>
                            </div>
                        </div>

                        <div class="px-5 py-3.5 bg-slate-50 dark:bg-slate-800/80 border-t border-slate-200 dark:border-slate-700 flex items-center justify-end gap-2.5 flex-shrink-0">
                            <button type="button" @click="statusModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-100 transition">Batal</button>
                            <button type="submit" style="background-color: #059669 !important; color: #ffffff !important; border: none !important;" class="px-5 py-2.5 rounded-xl text-white text-xs font-bold shadow-md hover:opacity-95 transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Simpan Status</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

    </div>
</x-app-layout>
