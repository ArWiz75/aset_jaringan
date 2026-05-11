<x-app-layout>
    <x-slot name="title">Lokasi OPD</x-slot>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Lokasi OPD</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Pendataan perangkat berdasarkan gedung dinas</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('opd-locations.create') }}" class="px-4 py-2 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-medium hover:shadow-lg hover:shadow-cyan-500/20 transition">+ Tambah Lokasi</a>
        @endif
    </div>

    <form method="GET" class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-4 mb-6 shadow-sm">
        <div class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama OPD, kecamatan..." class="flex-1 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:border-cyan-500/50 focus:outline-none">
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20 hover:bg-cyan-500/20 text-sm font-medium transition">🔍 Cari</button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($locations as $loc)
        <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-5 hover:border-cyan-500/30 transition-all duration-300 group shadow-sm">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                </div>
                <span class="px-2 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 text-xs font-semibold">{{ $loc->devices_count }} perangkat</span>
            </div>
            <h3 class="text-slate-900 dark:text-white font-semibold text-sm mb-1 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition">{{ $loc->nama }}</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">📍 {{ $loc->kecamatan }}</p>
            <p class="text-xs text-slate-400 dark:text-slate-500 mb-3 line-clamp-2">{{ $loc->alamat }}</p>
            @if($loc->networks->count() > 0)
            <div class="flex flex-wrap gap-1.5 mb-3">
                @foreach($loc->networks->take(2) as $net)
                    <span class="px-2 py-0.5 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[9px] font-bold border border-emerald-500/20">{{ $net->provider ?? '?' }}</span>
                @endforeach
                @if($loc->networks->count() > 2)
                    <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[9px] text-slate-500 dark:text-slate-400 font-bold border border-slate-200 dark:border-slate-700/50">+{{ $loc->networks->count() - 2 }}</span>
                @endif
            </div>
            @endif
            @if($loc->kontak_person)
            <p class="text-xs text-slate-500 dark:text-slate-400">👤 {{ $loc->kontak_person }} {{ $loc->telepon ? '• ' . $loc->telepon : '' }}</p>
            @endif
            <div class="flex items-center gap-2 mt-4 pt-4 border-t border-slate-100 dark:border-slate-700/50">
                <a href="{{ route('opd-locations.show', $loc) }}" class="flex items-center justify-center gap-1.5 flex-1 px-3 py-1.5 rounded-lg bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-500/20 hover:text-cyan-700 dark:hover:text-cyan-300 transition-all text-xs font-medium border border-cyan-500/20">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Detail
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('opd-locations.edit', $loc) }}" class="flex items-center justify-center gap-1.5 flex-1 px-3 py-1.5 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 hover:bg-amber-500/20 hover:text-amber-700 dark:hover:text-amber-300 transition-all text-xs font-medium border border-amber-500/20">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('opd-locations.destroy', $loc) }}" onsubmit="return confirm('Hapus lokasi ini?')" class="flex-1 flex">
                    @csrf @method('DELETE')
                    <button class="flex items-center justify-center gap-1.5 w-full px-3 py-1.5 rounded-lg bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-500/20 hover:text-red-700 dark:hover:text-red-300 transition-all text-xs font-medium border border-red-500/20">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-slate-400 dark:text-slate-500">Tidak ada data lokasi OPD</div>
        @endforelse
    </div>
    <div class="mt-6">{{ $locations->withQueryString()->links() }}</div>
</x-app-layout>
