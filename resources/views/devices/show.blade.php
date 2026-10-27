<x-app-layout>
    <x-slot name="title">Detail Perangkat</x-slot>
    @php
        $from = request()->query('from');
        if ($from === 'opd') {
            $backUrl = route('opd-locations.show', $device->opd_location_id);
            $backText = '← Kembali ke Lokasi OPD';
        } else {
            $backUrl = route('devices.index');
            $backText = '← Kembali ke Daftar Perangkat';
        }
    @endphp
    <div class="mb-6">
        <a href="{{ $backUrl }}" class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 text-sm font-medium transition-colors">{{ $backText }}</a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white mt-2">{{ $device->merk }} {{ $device->model }}</h1>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Device Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm dark:shadow-xl">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Informasi Perangkat
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Merk</p><p class="text-sm text-slate-800 dark:text-white font-semibold">{{ $device->merk }}</p></div>
                    <div><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Tipe</p><p class="text-sm flex items-center gap-2"><x-device-icon :type="$device->tipe" class="w-4 h-4" /><span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-medium border border-slate-200 dark:border-slate-700/50">{{ $device->tipe }}</span></p></div>
                    <div><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Nomor Seri</p><p class="text-sm text-slate-800 dark:text-white font-mono">{{ $device->nomor_seri }}</p></div>
                    <div><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Model</p><p class="text-sm text-slate-800 dark:text-white">{{ $device->model ?? '-' }}</p></div>
                    <div><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">IP Address</p><p class="text-sm text-cyan-600 dark:text-cyan-400 font-mono font-bold">{{ $device->ip_address ?? '-' }}</p></div>
                    <div><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Status</p><p class="text-sm"><span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $device->status === 'Aktif' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : ($device->status === 'Perlu Diganti' ? 'bg-purple-500/15 text-purple-700 dark:text-purple-300 border border-purple-500/30' : ($device->status === 'Rusak' ? 'bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20' : ($device->status === 'Maintenance' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20' : 'bg-slate-500/10 text-slate-500')) ) }}">{{ $device->status }}</span></p></div>
                    <div><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Tanggal Install / Umur</p><p class="text-sm text-slate-800 dark:text-white font-medium">{{ $device->tanggal_install ? $device->tanggal_install->format('d M Y') : '-' }} @if($device->umur_perangkat)<span class="text-xs text-amber-600 dark:text-amber-400 font-bold ml-1">({{ $device->umur_perangkat }})</span>@endif</p></div>
                    <div><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Lokasi OPD</p><p class="text-sm text-slate-800 dark:text-white">{{ $device->opdLocation->nama ?? '-' }}</p></div>
                    <div class="sm:col-span-2"><p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Lokasi Pemasangan / Ruang</p><p class="text-sm text-slate-800 dark:text-white">{{ $device->lokasi_pemasangan ?? '-' }}</p></div>
                </div>
                @if($device->keterangan)
                <div class="mt-5 pt-5 border-t border-slate-100 dark:border-slate-700/50">
                    <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-2">Keterangan</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $device->keterangan }}</p>
                </div>
                @endif
            </div>

            {{-- Rekomendasi Penggantian Callout Box --}}
            @if($device->status === 'Perlu Diganti' || $device->alasan_penggantian)
            <div class="bg-gradient-to-br from-purple-50/80 to-indigo-50/50 dark:from-purple-950/30 dark:to-indigo-950/20 border-2 border-purple-200 dark:border-purple-800/60 rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-purple-200/60 dark:border-purple-800/40 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                            🔄
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-purple-950 dark:text-purple-200">Rekomendasi Penggantian & Usulan Pengadaan</h3>
                            <p class="text-xs text-purple-700/80 dark:text-purple-300/80">Dokumen pertimbangan pimpinan untuk perencanaan penggantian perangkat</p>
                        </div>
                    </div>
                    <a href="{{ route('export.devices.replacement.print', ['opd_location_id' => $device->opd_location_id]) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm w-fit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg> Cetak Usulan Pergantian
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <p class="text-[10px] uppercase tracking-wider font-bold text-purple-900 dark:text-purple-300 mb-1">Alasan Penggantian (Pertimbangan Teknis)</p>
                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 leading-relaxed bg-white dark:bg-slate-900/60 p-3.5 rounded-xl border border-purple-200/50 dark:border-purple-800/40 shadow-sm">
                            {{ $device->alasan_penggantian ?? 'Perangkat mengalami penurunan performa / usia pakai teknis habis dan direkomendasikan untuk diganti.' }}
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-purple-900 dark:text-purple-300 mb-1">Usulan Tipe Pengganti</p>
                            <p class="text-sm font-bold text-slate-900 dark:text-white bg-white dark:bg-slate-900/60 p-2.5 rounded-xl border border-purple-200/50 dark:border-purple-800/40 shadow-sm">
                                {{ $device->rekomendasi_pengganti ?? 'Sesuai Standar TIK' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-purple-900 dark:text-purple-300 mb-1">Estimasi Kebutuhan Biaya</p>
                            <p class="text-base font-bold font-mono text-purple-700 dark:text-purple-300 bg-white dark:bg-slate-900/60 p-2.5 rounded-xl border border-purple-200/50 dark:border-purple-800/40 shadow-sm">
                                {{ $device->estimasi_biaya ? 'Rp ' . number_format($device->estimasi_biaya, 0, ',', '.') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- MikroTik Config --}}
            @if($device->mikrotik_backup_config)
            <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm dark:shadow-xl">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Konfigurasi Backup MikroTik
                </h3>
                <pre class="bg-slate-900 rounded-xl p-4 text-sm text-emerald-400 font-mono overflow-x-auto border border-slate-800 shadow-inner">{{ $device->mikrotik_backup_config }}</pre>
            </div>
            @endif

            {{-- Maintenance History --}}
            <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-6 shadow-sm dark:shadow-xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Riwayat Maintenance
                    </h3>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('maintenance-logs.create', ['device_id' => $device->id]) }}" class="px-3 py-1.5 rounded-lg bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 text-xs font-bold hover:bg-cyan-500/20 transition-all">+ Tambah Log</a>
                    @endif
                </div>
                <div class="space-y-4">
                    @forelse($device->maintenanceLogs->sortByDesc('tanggal') as $log)
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700/30 hover:border-cyan-500/30 transition-colors group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold text-slate-800 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">{{ $log->jenis }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $log->status === 'Selesai' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : ($log->status === 'Pending' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400' : 'bg-blue-500/10 text-blue-600 dark:text-blue-400') }}">{{ $log->status }}</span>
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mb-2 font-medium flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $log->tanggal->format('d M Y') }} • 👤 {{ $log->user->name ?? '-' }}
                        </p>
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $log->deskripsi }}</p>
                        @if($log->biaya) <p class="text-xs font-bold text-amber-600 dark:text-amber-400 mt-2 bg-amber-500/5 px-2 py-1 rounded inline-block border border-amber-500/10">💰 Rp {{ number_format($log->biaya, 0, ',', '.') }}</p> @endif
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-8 text-slate-400 dark:text-slate-600">
                        <svg class="w-12 h-12 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <p class="text-sm">Belum ada riwayat maintenance</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            @if($device->foto_perangkat)
            <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-5 shadow-sm dark:shadow-xl">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Foto Perangkat
                </h3>
                <a href="{{ asset('storage/' . $device->foto_perangkat) }}" target="_blank" class="group block w-full overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700/50 hover:border-cyan-500/50 transition-all bg-slate-50 dark:bg-slate-800 shadow-inner">
                    <img src="{{ asset('storage/' . $device->foto_perangkat) }}" alt="Foto {{ $device->merk }}" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
                </a>
            </div>
            @endif

            @if(auth()->user()->isAdmin())
            <div class="space-y-3">
                <button type="button" onclick="openReplacementModal()" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold shadow-md shadow-purple-500/20 transition-all active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    {{ $device->status === 'Perlu Diganti' ? 'Ubah Status Pergantian' : 'Tandai Perlu Diganti' }}
                </button>
                <a href="{{ route('devices.edit', ['device' => $device, 'from' => request('from')]) }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold hover:shadow-lg hover:shadow-cyan-500/25 transition-all active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Perangkat
                </a>
                <form method="POST" action="{{ route('devices.destroy', $device) }}" onsubmit="return confirm('Yakin hapus perangkat ini?')">
                    @csrf @method('DELETE')
                    @if(request('from') === 'opd')
                        <input type="hidden" name="redirect_to_opd" value="{{ $device->opd_location_id }}">
                    @endif
                    <button class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20 hover:bg-red-500/20 text-sm font-bold transition-all active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Perangkat
                    </button>
                </form>
            </div>

            {{-- Quick Replacement Modal --}}
            <div id="replacementModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" onclick="closeReplacementModal()"></div>
                    <div class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 relative z-10">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold text-lg">
                                    🔄
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ $device->merk }} {{ $device->model }}</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Set Rekomendasi Status Pergantian</p>
                                </div>
                            </div>
                            <button type="button" onclick="closeReplacementModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <form method="POST" action="{{ route('devices.mark-replacement', $device) }}" class="mt-4 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Status Perangkat <span class="text-red-500">*</span>
                                </label>
                                <select name="status" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-900 dark:text-white focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/10 focus:outline-none">
                                    <option value="Perlu Diganti" {{ $device->status === 'Perlu Diganti' ? 'selected' : '' }}>🔄 Perlu Diganti (Usulan Pengadaan Pengganti)</option>
                                    <option value="Aktif" {{ $device->status === 'Aktif' ? 'selected' : '' }}>✓ Aktif (Kondisi Baik)</option>
                                    <option value="Rusak" {{ $device->status === 'Rusak' ? 'selected' : '' }}>✕ Rusak</option>
                                    <option value="Maintenance" {{ $device->status === 'Maintenance' ? 'selected' : '' }}>⚙️ Maintenance (Dalam Perbaikan)</option>
                                    <option value="Nonaktif" {{ $device->status === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Alasan Pergantian / Pertimbangan Teknis
                                </label>
                                <textarea name="alasan_penggantian" rows="3" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/10 focus:outline-none" placeholder="Tuliskan kendala teknis atau alasan mengapa perangkat harus diganti...">{{ $device->alasan_penggantian }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Usulan / Rekomendasi Tipe Pengganti
                                </label>
                                <input type="text" name="rekomendasi_pengganti" value="{{ $device->rekomendasi_pengganti }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/10 focus:outline-none" placeholder="Contoh: MikroTik RB4011iGS+RM / Cisco CBS250">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                    Estimasi Biaya Pengadaan (Rp)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-2.5 text-sm font-bold text-slate-400">Rp</span>
                                    <input type="number" step="0.01" name="estimasi_biaya" value="{{ $device->estimasi_biaya }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl pl-12 pr-4 py-2.5 text-sm font-mono font-bold text-slate-900 dark:text-white focus:border-purple-500/50 focus:ring-2 focus:ring-purple-500/10 focus:outline-none" placeholder="3500000">
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                                <button type="button" onclick="closeReplacementModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm font-semibold transition">
                                    Batal
                                </button>
                                <button type="submit" class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold shadow-md shadow-purple-500/20 transition flex items-center gap-2">
                                    <span>Simpan Status</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                function openReplacementModal() {
                    document.getElementById('replacementModal').style.display = 'block';
                    document.body.style.overflow = 'hidden';
                }
                function closeReplacementModal() {
                    document.getElementById('replacementModal').style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            </script>
            @endif
        </div>
    </div>
</x-app-layout>
