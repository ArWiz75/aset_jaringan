<x-app-layout>
    <x-slot name="title">Detail {{ $opdLocation->nama }}</x-slot>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <a href="{{ route('opd-locations.index') }}" class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 text-sm">← Kembali</a>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white mt-2">{{ $opdLocation->nama }}</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('export.devices.print', ['opd_location_id' => $opdLocation->id, 'lokasi' => request('lokasi')]) }}" target="_blank" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700/50 text-slate-700 dark:text-white border border-slate-200 dark:border-slate-600/50 hover:bg-slate-200 dark:hover:bg-slate-600/50 text-sm font-medium transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg> Cetak
            </a>
            <a href="{{ route('export.devices.pdf', ['opd_location_id' => $opdLocation->id, 'lokasi' => request('lokasi')]) }}" class="px-4 py-2 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20 hover:bg-red-500/20 text-sm font-medium transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg> PDF
            </a>
            <a href="{{ route('export.devices.excel', ['opd_location_id' => $opdLocation->id, 'lokasi' => request('lokasi')]) }}" class="px-4 py-2 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 text-sm font-medium transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path></svg> Excel
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Info & Denah --}}
        <div class="space-y-6">
            @if($opdLocation->denah_file)
            <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm dark:shadow-xl">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Denah Gedung
                </h3>
                @php
                    $ext = pathinfo($opdLocation->denah_file, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'svg']);
                @endphp
                
                @if($isImage)
                    <a href="{{ asset('storage/' . $opdLocation->denah_file) }}" target="_blank" class="group block w-full overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700/50 hover:border-cyan-500/50 transition bg-slate-50 dark:bg-slate-800 shadow-inner">
                        <img src="{{ asset('storage/' . $opdLocation->denah_file) }}" alt="Denah {{ $opdLocation->nama }}" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
                    </a>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-2 text-center font-medium italic">Klik gambar untuk memperbesar</p>
                @else
                    <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700/50 group hover:border-red-500/30 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 dark:text-white">Dokumen PDF</p>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">Klik untuk melihat denah</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $opdLocation->denah_file) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-500/20 transition-all text-xs font-bold border border-red-500/20">
                            Buka
                        </a>
                    </div>
                @endif
            </div>
            @endif

            <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm dark:shadow-xl">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Info Jaringan
                </h3>
                <div class="space-y-6">
                    @forelse($opdLocation->networks as $network)
                    <div class="p-4 rounded-2xl bg-slate-50/50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700/30">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Jaringan #{{ $loop->iteration }}</span>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-0.5">Cluster / Provider</p>
                                <p class="text-sm text-slate-800 dark:text-white font-bold">{{ $network->cluster ?? '-' }} <span class="text-slate-400 dark:text-slate-600 px-1">/</span> {{ $network->provider ?? '-' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-2 rounded-xl bg-white dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700/50">
                                    <p class="text-[9px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-0.5">Upload</p>
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 font-black tracking-tight">{{ $network->upload ?? '-' }} <span class="text-[8px] opacity-70">Mbps</span></p>
                                </div>
                                <div class="p-2 rounded-xl bg-white dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700/50">
                                    <p class="text-[9px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-0.5">Download</p>
                                    <p class="text-xs text-cyan-600 dark:text-cyan-400 font-black tracking-tight">{{ $network->download ?? '-' }} <span class="text-[8px] opacity-70">Mbps</span></p>
                                </div>
                            </div>
                            @if($network->network_ip)
                            <div>
                                <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-0.5">Network IP</p>
                                <p class="text-xs text-slate-800 dark:text-white font-mono font-bold">{{ $network->network_ip }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-slate-500 dark:text-slate-400 italic">Data jaringan belum tersedia.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm dark:shadow-xl">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    Info Lokasi
                </h3>
                <div class="space-y-4">
                    <div><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Kecamatan</p><p class="text-sm text-slate-800 dark:text-white font-semibold">{{ $opdLocation->kecamatan }}</p></div>
                    <div><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Alamat</p><p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed font-medium">{{ $opdLocation->alamat }}</p></div>
                    @if($opdLocation->kontak_person)
                    <div>
                        <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Kontak Person</p>
                        <p class="text-sm text-slate-800 dark:text-white font-bold">{{ $opdLocation->kontak_person }}</p>
                        <p class="text-xs text-cyan-600 dark:text-cyan-400 font-medium mt-0.5">{{ $opdLocation->telepon ?? '-' }}</p>
                    </div>
                    @endif
                    @if($opdLocation->latitude)
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50">
                        <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Koordinat GPS</p>
                        <p class="text-xs text-cyan-600 dark:text-cyan-400 font-mono font-bold">{{ $opdLocation->latitude }}, {{ $opdLocation->longitude }}</p>
                    </div>
                    @endif
                    @if($opdLocation->keterangan)
                    <div>
                        <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Keterangan Tambahan</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed italic">{{ $opdLocation->keterangan }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Right Column: Perangkat --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm dark:shadow-xl h-full flex flex-col">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Perangkat</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Total: {{ $devices->count() }} Perangkat</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        {{-- Filter Lokasi Pemasangan --}}
                        <form method="GET" class="flex items-center gap-2">
                            <select name="lokasi" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 rounded-xl px-3 py-2 text-[11px] font-bold text-slate-700 dark:text-slate-300 focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm">
                                <option value="">Semua Lokasi / Ruang</option>
                                @foreach($pemasanganList as $loc)
                                <option value="{{ $loc }}" {{ request('lokasi') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                @endforeach
                            </select>
                        </form>
                        
                        @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="{{ route('devices.create', ['opd_location_id' => $opdLocation->id]) }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-xs font-bold hover:shadow-lg hover:shadow-cyan-500/25 transition-all flex items-center gap-2 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Perangkat
                        </a>
                        @endif
                    </div>
                </div>
                <div class="space-y-2 flex-1">
                    @forelse($devices as $device)
                    @php
                        $typeLower = strtolower($device->tipe);
                        $bgClasses = [
                            'router' => 'from-cyan-500/10 to-blue-600/5 border-cyan-500/20',
                            'switch' => 'from-indigo-500/10 to-indigo-600/5 border-indigo-500/20',
                            'access point' => 'from-purple-500/10 to-purple-600/5 border-purple-500/20',
                            'modem' => 'from-emerald-500/10 to-emerald-600/5 border-emerald-500/20',
                            'server' => 'from-amber-500/10 to-amber-600/5 border-amber-500/20',
                            'firewall' => 'from-rose-500/10 to-rose-600/5 border-rose-500/20',
                            'lainnya' => 'from-slate-500/10 to-slate-600/5 border-slate-500/20',
                        ];
                        $bgClass = $bgClasses[$typeLower] ?? $bgClasses['lainnya'];
                    @endphp
                    <a href="{{ route('devices.show', ['device' => $device->id, 'from' => 'opd']) }}" class="flex items-center justify-between gap-3 px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/30 hover:bg-white dark:hover:bg-slate-800/50 transition-all border border-slate-200/50 dark:border-slate-700/30 hover:border-cyan-500/30 group shadow-sm">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 flex-shrink-0 rounded-lg bg-gradient-to-br {{ $bgClass }} flex items-center justify-center border group-hover:scale-105 transition-transform">
                                <x-device-icon :type="$device->tipe" class="w-4 h-4" />
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-slate-800 dark:text-white truncate group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">{{ $device->merk }} {{ $device->model }}</h4>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-tighter">{{ $device->tipe }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                    <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400">SN: {{ $device->nomor_seri ?? '-' }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                    <span class="text-[10px] font-mono text-cyan-600 dark:text-cyan-400 font-bold">{{ $device->ip_address ?? '-' }}</span>
                                    @if($device->lokasi_pemasangan)
                                    <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                    <span class="text-[10px] text-slate-500 dark:text-slate-400 truncate italic">{{ $device->lokasi_pemasangan }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider shadow-sm
                                {{ $device->status === 'Aktif' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : ($device->status === 'Rusak' ? 'bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20' : 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20') }}">
                                {{ $device->status }}
                            </span>
                            <svg class="w-4 h-4 text-slate-300 dark:text-slate-700 group-hover:text-cyan-500 group-hover:translate-x-0.5 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                    @empty
                    <div class="flex flex-col items-center justify-center py-16 text-slate-400 dark:text-slate-600 bg-slate-50 dark:bg-slate-800/10 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700/50">
                        <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        <p class="text-sm font-medium italic">Belum ada perangkat terdaftar di lokasi ini</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
