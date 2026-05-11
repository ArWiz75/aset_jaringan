<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full bg-slate-800/50 border border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/20 focus:outline-none"
                placeholder="email">
            @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block text-sm font-medium text-slate-300 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full bg-slate-800/50 border border-slate-700/50 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/20 focus:outline-none"
                placeholder="password">
            @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-slate-800 border-slate-700 text-cyan-500 focus:ring-cyan-500/20" name="remember">
                <span class="ms-2 text-sm text-slate-400">Ingat saya</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold hover:shadow-lg hover:shadow-cyan-500/20 transition-all duration-300">
                Masuk Tes
            </button>
        </div>

        <!-- <div class="mt-4 p-3 rounded-xl bg-slate-800/30 border border-slate-700/30">
            <p class="text-xs text-slate-500 text-center">Demo Accounts:</p>
            <p class="text-xs text-slate-400 text-center mt-1">Admin: admin@kominfo.go.id | password</p>
            <p class="text-xs text-slate-400 text-center">Viewer: staf@kecamatan.go.id | password</p>
        </div> -->
    </form>
</x-guest-layout>
