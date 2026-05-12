<x-app-layout>
    <x-slot name="title">Detail Maintenance</x-slot>
    <div class="mb-6">
        <a href="{{ route('maintenance-logs.index') }}" class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 text-sm">← Kembali</a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white mt-2">Detail Log Maintenance</h1>
    </div>
    <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-8 max-w-3xl shadow-sm dark:shadow-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Perangkat</p>
                <p class="text-sm text-slate-900 dark:text-white font-bold leading-tight">{{ $maintenanceLog->device->merk ?? '-' }} {{ $maintenanceLog->device->model ?? '' }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-mono">SN: {{ $maintenanceLog->device->nomor_seri ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Lokasi</p>
                <p class="text-sm text-slate-700 dark:text-slate-300 font-medium">{{ $maintenanceLog->device->opdLocation->nama ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Jenis Maintenance</p>
                <p class="text-sm"><span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold border border-slate-200 dark:border-slate-700/50">{{ $maintenanceLog->jenis }}</span></p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Tanggal</p>
                <p class="text-sm text-slate-700 dark:text-slate-300 font-bold">{{ $maintenanceLog->tanggal->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Status</p>
                <p class="text-sm"><span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $maintenanceLog->status === 'Selesai' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : ($maintenanceLog->status === 'Pending' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20' : 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20') }}">{{ $maintenanceLog->status }}</span></p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Teknisi</p>
                <p class="text-sm text-slate-700 dark:text-slate-300 font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ $maintenanceLog->user->name ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-1">Biaya</p>
                <p class="text-sm text-amber-600 dark:text-amber-400 font-black tracking-tight">{{ $maintenanceLog->biaya ? 'Rp '.number_format($maintenanceLog->biaya, 0, ',', '.') : '-' }}</p>
            </div>
        </div>
        <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-2">Deskripsi Pekerjaan</p>
            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-100 dark:border-slate-700/50">{{ $maintenanceLog->deskripsi }}</p>
        </div>
        @if($maintenanceLog->catatan)
        <div class="mt-5">
            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-2">Catatan Tambahan</p>
            <p class="text-sm text-slate-500 dark:text-slate-400 italic leading-relaxed">{{ $maintenanceLog->catatan }}</p>
        </div>
        @endif
        @if(auth()->user()->isAdmin())
        <div class="flex items-center gap-3 mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
            <a href="{{ route('maintenance-logs.edit', $maintenanceLog) }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold hover:shadow-lg hover:shadow-cyan-500/25 transition-all active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('maintenance-logs.destroy', $maintenanceLog) }}" onsubmit="return confirm('Hapus log ini?')" class="flex-1 sm:flex-none">
                @csrf @method('DELETE')
                <button class="w-full flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20 hover:bg-red-500/20 transition-all text-sm font-bold active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                </button>
            </form>
        </div>
        @endif
    </div>
</x-app-layout>
