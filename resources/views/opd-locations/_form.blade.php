@php $loc = $opdLocation ?? null; @endphp
<div class="space-y-5">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nama OPD <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $loc->nama ?? '') }}" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="Contoh: Dinas Komunikasi dan Informatika">
            @error('nama') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Kecamatan <span class="text-red-500">*</span></label>
            <input type="text" name="kecamatan" value="{{ old('kecamatan', $loc->kecamatan ?? '') }}" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="Masukkan nama kecamatan">
            @error('kecamatan') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
    </div>
    {{-- Section Jaringan (Multiple) --}}
    <div class="pt-2" x-data="{ 
        networks: {{ json_encode(old('networks', (isset($loc) && $loc->networks->count() > 0) ? $loc->networks->map(fn($n) => [
            'cluster' => $n->cluster,
            'provider' => $n->provider,
            'upload' => $n->upload,
            'download' => $n->download,
            'network_ip' => $n->network_ip
        ]) : [['cluster' => '', 'provider' => '', 'upload' => '', 'download' => '', 'network_ip' => '']])) }}
    }">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-wider flex items-center gap-2">
                <div class="w-2 h-5 bg-cyan-500 rounded-full"></div>
                Informasi Jaringan
            </h3>
            <button type="button" @click="networks.push({cluster: '', provider: '', upload: '', download: '', network_ip: ''})" class="px-3 py-1.5 rounded-lg bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 text-[10px] font-bold hover:bg-cyan-500/20 transition-all flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v12m6-6H6"/></svg>
                Tambah Jaringan
            </button>
        </div>

        <div class="space-y-4">
            <template x-for="(network, index) in networks" :key="index">
                <div class="relative p-5 rounded-2xl bg-slate-50/50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700/50 group transition-all hover:border-cyan-500/30">
                    {{-- Row Header with Counter and Remove Button --}}
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest" x-text="'Jaringan #' + (index + 1)"></span>
                        <button type="button" x-show="networks.length > 1" @click="networks.splice(index, 1)" class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-500/10 transition-all opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Cluster</label>
                            <input type="text" :name="'networks['+index+'][cluster]'" x-model="network.cluster" class="w-full bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-3 py-2 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all" placeholder="Contoh: Perkantoran Terpadu">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Provider</label>
                            <input type="text" :name="'networks['+index+'][provider]'" x-model="network.provider" class="w-full bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-3 py-2 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all" placeholder="Contoh: Flynet, Telkom, dll">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Upload</label>
                            <div class="relative">
                                <input type="text" :name="'networks['+index+'][upload]'" x-model="network.upload" class="w-full bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/50 rounded-xl pl-3 pr-10 py-2 text-sm text-emerald-600 dark:text-emerald-400 font-bold focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all" placeholder="70">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-slate-400">Mbps</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Download</label>
                            <div class="relative">
                                <input type="text" :name="'networks['+index+'][download]'" x-model="network.download" class="w-full bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/50 rounded-xl pl-3 pr-10 py-2 text-sm text-cyan-600 dark:text-cyan-400 font-bold focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all" placeholder="120">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-slate-400">Mbps</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Network IP</label>
                            <input type="text" :name="'networks['+index+'][network_ip]'" x-model="network.network_ip" class="w-full bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-3 py-2 text-sm text-slate-900 dark:text-white font-mono focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all" placeholder="192.168.66.0">
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
    <div>
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
        <textarea name="alamat" rows="2" required class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm leading-relaxed" placeholder="Masukkan alamat lengkap lokasi...">{{ old('alamat', $loc->alamat ?? '') }}</textarea>
        @error('alamat') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Latitude</label>
            <input type="number" step="any" name="latitude" value="{{ old('latitude', $loc->latitude ?? '') }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white font-mono focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="-6.9175">
            @error('latitude') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Longitude</label>
            <input type="number" step="any" name="longitude" value="{{ old('longitude', $loc->longitude ?? '') }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white font-mono focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="107.6191">
            @error('longitude') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Kontak Person</label>
            <input type="text" name="kontak_person" value="{{ old('kontak_person', $loc->kontak_person ?? '') }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="Nama penanggung jawab">
            @error('kontak_person') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Telepon/WhatsApp</label>
            <input type="text" name="telepon" value="{{ old('telepon', $loc->telepon ?? '') }}" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm" placeholder="Contoh: 08123456789">
            @error('telepon') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
        </div>
    </div>
    <div>
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Keterangan</label>
        <textarea name="keterangan" rows="2" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-cyan-500/50 focus:ring-2 focus:ring-cyan-500/10 focus:outline-none transition-all shadow-sm leading-relaxed" placeholder="Catatan tambahan lokasi...">{{ old('keterangan', $loc->keterangan ?? '') }}</textarea>
        @error('keterangan') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Denah Gedung/Ruangan (Opsional)</label>
        @if(isset($loc) && $loc->denah_file)
            <div class="mb-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 w-fit">
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 mb-1 uppercase tracking-wider">File saat ini:</p>
                <a href="{{ asset('storage/' . $loc->denah_file) }}" target="_blank" class="text-xs text-cyan-600 dark:text-cyan-400 font-bold hover:underline flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Denah Terpasang
                </a>
            </div>
        @endif
        <div class="relative group">
            <input type="file" name="denah_file" accept=".jpg,.jpeg,.png,.svg,.pdf" class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-xl px-4 py-2 text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-cyan-500/10 file:text-cyan-600 dark:file:text-cyan-400 hover:file:bg-cyan-500/20 focus:outline-none transition-all">
        </div>
        <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-2 font-medium italic">Format: JPG, PNG, SVG, atau PDF. Maksimal 5MB.</p>
        @error('denah_file') <p class="text-red-500 text-[10px] font-bold mt-1.5">{{ $message }}</p> @enderror
    </div>
</div>
