@php $d = $device ?? null; @endphp
<div class="space-y-5">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Lokasi OPD <span class="text-red-500">*</span></label>
            <select name="opd_location_id" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm">
                <option value="">Pilih Lokasi</option>
                @foreach($locations as $loc)
                <option value="{{ $loc->id }}" {{ old('opd_location_id', $d->opd_location_id ?? request('opd_location_id')) == $loc->id ? 'selected' : '' }}>{{ $loc->nama }}</option>
                @endforeach
            </select>
            @error('opd_location_id') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Merk <span class="text-red-500">*</span></label>
            <input type="text" name="merk" value="{{ old('merk', $d->merk ?? '') }}" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="MikroTik, Cisco, dll">
            @error('merk') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
    </div>
    <div>
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Lokasi Pemasangan / Ruang</label>
        <input type="text" name="lokasi_pemasangan" value="{{ old('lokasi_pemasangan', $d->lokasi_pemasangan ?? '') }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="Contoh: Ruang Server Lt. 2, Ruang Kabid, dsb">
        @error('lokasi_pemasangan') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tipe <span class="text-red-500">*</span></label>
            <select name="tipe" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm">
                <option value="">Pilih Tipe</option>
                @foreach(['Router','Switch','Access Point','Modem','Server','Firewall','Lainnya'] as $t)
                <option value="{{ $t }}" {{ old('tipe', $d->tipe ?? '') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
            @error('tipe') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nomor Seri</label>
            <input type="text" name="model" value="{{ old('model', $d->model ?? '') }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="Masukkan Nomor Seri">
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Model <span class="text-red-500">*</span></label>
            <input type="text" name="nomor_seri" value="{{ old('nomor_seri', $d->nomor_seri ?? '') }}" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="RB750Gr3, Catalyst 2960, dll">
            @error('nomor_seri') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">IP Address</label>
            <input type="text" name="ip_address" value="{{ old('ip_address', $d->ip_address ?? '') }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-cyan-600 dark:text-cyan-400 font-bold focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="192.168.1.1">
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Status <span class="text-red-500">*</span></label>
            <select name="status" id="status-select" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm">
                @foreach(['Aktif','Rusak','Maintenance','Nonaktif'] as $s)
                <option value="{{ $s }}" {{ old('status', $d->status ?? 'Aktif') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Install</label>
            <input type="date" name="tanggal_install" value="{{ old('tanggal_install', isset($d) && $d->tanggal_install ? $d->tanggal_install->format('Y-m-d') : '') }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm">
        </div>
        <div id="tanggal-rusak-container" style="{{ old('status', $d->status ?? 'Aktif') == 'Rusak' ? '' : 'display: none;' }}">
            <label class="block text-sm font-bold text-red-600 dark:text-red-400 mb-1.5">Tanggal Rusak <span class="text-red-500">*</span></label>
            <input type="date" name="tanggal_rusak" id="tanggal_rusak" value="{{ old('tanggal_rusak', isset($d) && $d->tanggal_rusak ? $d->tanggal_rusak->format('Y-m-d') : '') }}" class="w-full bg-red-50/50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/50 rounded-xl px-4 py-2.5 text-sm text-red-900 dark:text-red-200 focus:border-red-500/50 focus:ring-2 focus:ring-red-500/10 focus:outline-none transition-all shadow-sm">
            @error('tanggal_rusak') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
    </div>
    <div>
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Konfigurasi Backup MikroTik</label>
        <textarea name="mikrotik_backup_config" rows="5" class="w-full bg-slate-50 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-emerald-600 dark:text-emerald-400 font-mono focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm leading-relaxed" placeholder="/ip address&#10;add address=192.168.1.1/24 interface=ether1">{{ old('mikrotik_backup_config', $d->mikrotik_backup_config ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Keterangan</label>
        <textarea name="keterangan" rows="3" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm leading-relaxed" placeholder="Tambahkan catatan atau keterangan perangkat...">{{ old('keterangan', $d->keterangan ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Foto Perangkat (Opsional)</label>
        @if(isset($d) && $d->foto_perangkat)
            <div class="mb-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 w-fit">
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 mb-2 uppercase tracking-wider">File saat ini:</p>
                <img src="{{ asset('storage/' . $d->foto_perangkat) }}" alt="Foto {{ $d->merk }}" class="h-32 w-auto object-cover rounded-lg border border-slate-200 dark:border-slate-700/50 shadow-sm">
            </div>
        @endif
        <div class="relative group">
            <input type="file" name="foto_perangkat" accept=".jpg,.jpeg,.png,.svg" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2 text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-cyan-500/10 file:text-cyan-600 dark:file:text-cyan-400 hover:file:bg-cyan-500/20 focus:outline-none transition-all">
        </div>
        <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-2 font-medium italic">Format: JPG, PNG, atau SVG. Maksimal 5MB.</p>
        @error('foto_perangkat') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status-select');
        const tanggalRusakContainer = document.getElementById('tanggal-rusak-container');
        const tanggalRusakInput = document.getElementById('tanggal_rusak');

        function toggleTanggalRusak() {
            if (statusSelect.value === 'Rusak') {
                tanggalRusakContainer.style.display = 'block';
                tanggalRusakInput.setAttribute('required', 'required');
            } else {
                tanggalRusakContainer.style.display = 'none';
                tanggalRusakInput.removeAttribute('required');
            }
        }

        statusSelect.addEventListener('change', toggleTanggalRusak);
        
        // Initial check
        toggleTanggalRusak();
    });
</script>
