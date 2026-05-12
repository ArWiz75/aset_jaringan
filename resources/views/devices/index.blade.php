<x-app-layout>
    <x-slot name="title">Perangkat</x-slot>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Manajemen Perangkat</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Kelola semua perangkat jaringan</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('export.devices.print') }}?{{ http_build_query(request()->query()) }}" target="_blank" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700/50 text-slate-700 dark:text-white border border-slate-200 dark:border-slate-600/50 hover:bg-slate-200 dark:hover:bg-slate-600/50 text-sm font-medium transition flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg> Cetak</a>
            <a href="{{ route('export.devices.pdf') }}?{{ http_build_query(request()->query()) }}" class="px-4 py-2 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20 hover:bg-red-500/20 text-sm font-medium transition flex items-center gap-1.5"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg> PDF</a>
            <a href="{{ route('export.devices.excel') }}?{{ http_build_query(request()->query()) }}" class="px-4 py-2 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 text-sm font-medium transition flex items-center gap-1.5"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path></svg> Excel</a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('devices.create') }}" class="px-4 py-2 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-medium hover:shadow-lg hover:shadow-cyan-500/20 transition">+ Tambah</a>
            @endif
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-4 mb-6 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari merk, SN, IP..." class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/20 focus:outline-none">
            <select name="status" class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:outline-none">
                <option value="">Semua Status</option>
                @foreach(['Aktif','Rusak','Maintenance','Nonaktif'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <select name="tipe" class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:outline-none">
                <option value="">Semua Tipe</option>
                @foreach(['Router','Switch','Access Point','Modem','Server','Firewall','Lainnya'] as $t)
                <option value="{{ $t }}" {{ request('tipe') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20 hover:bg-cyan-500/20 text-sm font-medium transition">🔍 Filter</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl overflow-hidden shadow-sm dark:shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700/50">
                        <th class="text-left px-4 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Merk / Model</th>
                        <th class="text-left px-4 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Tipe</th>
                        <th class="text-left px-4 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">IP Address</th>
                        <th class="text-left px-4 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Lokasi</th>
                        <th class="text-left px-4 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Status</th>
                        <th class="text-center px-4 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                    @forelse($devices as $device)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
                        <td class="px-4 py-2.5">
                            <p class="font-bold text-slate-800 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">{{ $device->merk }}</p>
                            <p class="text-[9px] font-medium text-slate-500 dark:text-slate-500 uppercase tracking-tighter">{{ $device->model }}</p>
                        </td>
                        <td class="px-4 py-2.5">
                            <div class="flex items-center gap-2">
                                <x-device-icon :type="$device->tipe" class="w-3.5 h-3.5" />
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold border border-slate-200 dark:border-slate-700/50">{{ $device->tipe }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-2.5 text-cyan-600 dark:text-cyan-400 font-mono text-xs font-bold">{{ $device->ip_address ?? '-' }}</td>
                        <td class="px-4 py-2.5">
                            <p class="text-slate-700 dark:text-slate-300 text-[11px] font-bold truncate max-w-[150px]">{{ $device->opdLocation->nama ?? '-' }}</p>
                            @if($device->lokasi_pemasangan)
                            <p class="text-[9px] text-slate-400 dark:text-slate-500 mt-0.5 italic truncate max-w-[150px]">{{ $device->lokasi_pemasangan }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-2.5">
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider
                                {{ $device->status === 'Aktif' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : ($device->status === 'Rusak' ? 'bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20' : 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20') }}">
                                {{ $device->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('devices.show', ['device' => $device->id, 'from' => 'devices']) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 hover:bg-cyan-500/10 transition-all" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('devices.edit', $device) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-500/10 transition-all" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('devices.destroy', $device) }}" onsubmit="return confirm('Hapus perangkat ini?')">
                                    @csrf @method('DELETE')
                                    <button class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10 transition-all" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-10 text-center text-slate-400 dark:text-slate-600 font-medium italic">Tidak ada data perangkat ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-slate-50/50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-700/50">{{ $devices->withQueryString()->links() }}</div>
    </div>
</x-app-layout>
