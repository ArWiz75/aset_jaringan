<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="status-msg">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Alamat Email</label>
            <input id="email" type="email" name="email"
                value="{{ old('email') }}"
                required autofocus autocomplete="username"
                class="form-input {{ $errors->has('email') ? 'has-error' : '' }}"
                placeholder="nama@instansi.go.id">
            @error('email')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrap">
                <input id="password" type="password" name="password"
                    required autocomplete="current-password"
                    class="form-input {{ $errors->has('password') ? 'has-error' : '' }}"
                    placeholder="••••••••"
                    style="padding-right: 3rem;">
                <button type="button" class="toggle-pw" onclick="togglePw('password', this)">
                    <svg class="eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg class="eye-closed" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember + Forgot -->
        <div class="form-row">
            <label class="remember" for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    style="font-size:0.78rem; color:#6366f1; text-decoration:none; font-weight:600; transition:color 0.2s;"
                    onmouseover="this.style.color='#a5b4fc'"
                    onmouseout="this.style.color='#6366f1'">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-submit">
            Masuk ke Sistem
        </button>
    </form>
</x-guest-layout>