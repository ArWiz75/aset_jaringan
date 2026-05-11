@php $log = $maintenanceLog ?? null; @endphp
<div class="space-y-5">
    <div>
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Perangkat <span class="text-red-500">*</span></label>
        <select name="device_id" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm">
            <option value="">Pilih Perangkat</option>
            @foreach($devices as $device)
            <option value="{{ $device->id }}" {{ old('device_id', $log->device_id ?? $selectedDeviceId ?? '') == $device->id ? 'selected' : '' }}>{{ $device->merk }} {{ $device->nomor_seri }} ({{ $device->model }}) - {{ $device->opdLocation->nama ?? '' }}</option>
            @endforeach
        </select>
        @error('device_id') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Jenis <span class="text-red-500">*</span></label>
            <select name="jenis" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm">
                @foreach(['Perbaikan','Penggantian','Konfigurasi','Preventif'] as $j)
                <option value="{{ $j }}" {{ old('jenis', $log->jenis ?? '') == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
            <input type="date" name="tanggal" value="{{ old('tanggal', isset($log) && $log->tanggal ? $log->tanggal->format('Y-m-d') : date('Y-m-d')) }}" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Status <span class="text-red-500">*</span></label>
            <select name="status" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm">
                @foreach(['Pending','Dalam Proses','Selesai'] as $s)
                <option value="{{ $s }}" {{ old('status', $log->status ?? 'Pending') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
        <textarea name="deskripsi" rows="3" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm leading-relaxed" placeholder="Jelaskan detail maintenance...">{{ old('deskripsi', $log->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Biaya (Rp)</label>
            <div class="relative">
                <span class="absolute left-4 top-2.5 text-sm text-slate-400 font-bold">Rp</span>
                <input type="number" name="biaya" value="{{ old('biaya', $log->biaya ?? '') }}" min="0" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl pl-10 pr-4 py-2.5 text-sm text-amber-600 dark:text-amber-400 font-bold focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="0">
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Catatan</label>
            <input type="text" name="catatan" value="{{ old('catatan', $log->catatan ?? '') }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="Catatan opsional...">
        </div>
    </div>
</div>
