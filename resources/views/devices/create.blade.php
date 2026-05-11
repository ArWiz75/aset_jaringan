<x-app-layout>
    <x-slot name="title">Tambah Perangkat</x-slot>
    @php $redirectToOpd = old('redirect_to_opd', request('opd_location_id')); @endphp
    <div class="mb-6">
        <a href="{{ $redirectToOpd ? route('opd-locations.show', $redirectToOpd) : route('devices.index') }}" class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 text-sm font-medium">← Kembali</a>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white mt-2">Tambah Perangkat Baru</h1>
    </div>
    <div class="bg-white dark:bg-slate-900/50 backdrop-blur border border-slate-200 dark:border-slate-700/50 rounded-2xl p-8 max-w-3xl shadow-sm dark:shadow-xl">
        <form method="POST" action="{{ route('devices.store') }}" enctype="multipart/form-data">
            @csrf
            @if($redirectToOpd)
                <input type="hidden" name="redirect_to_opd" value="{{ $redirectToOpd }}">
            @endif
            @include('devices._form')
            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-slate-100 dark:border-slate-800">
                <button type="submit" class="px-8 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-bold hover:shadow-lg hover:shadow-cyan-500/25 transition-all active:scale-95">Simpan Perangkat</button>
                <a href="{{ $redirectToOpd ? route('opd-locations.show', $redirectToOpd) : route('devices.index') }}" class="px-8 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-all active:scale-95">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
