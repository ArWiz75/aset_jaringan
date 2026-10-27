<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Manajemen Aset Jaringan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --c-bg: #02040a;
            --c-surface: #070c18;
            --c-border: rgba(255,255,255,0.07);
            --c-accent: #6366f1;
            --c-accent2: #06b6d4;
            --c-accent3: #8b5cf6;
        }
        html, body { height: 100%; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--c-bg);
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ── CANVAS ─────────── */
        #bg-canvas { position: fixed; inset: 0; z-index: 0; pointer-events: none; }

        /* ── AURORA ─────────── */
        .aurora { position: fixed; border-radius: 50%; filter: blur(110px); pointer-events: none; z-index: 0; }
        .aurora-1 { width: 600px; height: 600px; background: radial-gradient(circle, rgba(99,102,241,0.22) 0%, transparent 70%); top: -20%; left: -10%; animation: af1 18s ease-in-out infinite; }
        .aurora-2 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(6,182,212,0.15) 0%, transparent 70%); bottom: -15%; right: -10%; animation: af2 22s ease-in-out infinite; }
        .aurora-3 { width: 350px; height: 350px; background: radial-gradient(circle, rgba(139,92,246,0.14) 0%, transparent 70%); top: 50%; left: 30%; transform: translate(-50%,-50%); animation: af3 16s ease-in-out infinite; }
        @keyframes af1 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(40px,30px) scale(1.1)} }
        @keyframes af2 { 0%,100%{transform:translate(0,0) scale(1.05)} 50%{transform:translate(-30px,-20px) scale(1)} }
        @keyframes af3 { 0%,100%{transform:translate(-50%,-50%) scale(1)} 50%{transform:translate(-50%,-50%) scale(1.15)} }

        /* Dot grid */
        .dot-grid {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image: radial-gradient(rgba(255,255,255,0.055) 1px, transparent 1px);
            background-size: 32px 32px;
            mask-image: radial-gradient(ellipse 90% 90% at 50% 50%, black, transparent);
        }

        /* ── LEFT PANEL ─────── */
        .left-panel {
            position: relative; z-index: 1;
            flex: 1; display: none;
            flex-direction: column; justify-content: center; align-items: flex-start;
            padding: 4rem;
            border-right: 1px solid var(--c-border);
        }
        @media(min-width: 1024px) { .left-panel { display: flex; } }

        .panel-badge {
            display: inline-flex; align-items: center; gap: 0.6rem;
            background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.28);
            border-radius: 99px; padding: 0.4rem 1.1rem; margin-bottom: 2.5rem;
        }
        .panel-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--c-accent2); box-shadow: 0 0 10px var(--c-accent2); animation: blink 2.4s ease-in-out infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }
        .panel-badge span { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: #a5b4fc; }

        .panel-logo {
            width: 64px; height: 64px; border-radius: 20px; margin-bottom: 2rem;
            background: linear-gradient(135deg, var(--c-accent), var(--c-accent2));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 32px rgba(99,102,241,0.5);
        }
        .panel-logo svg { width: 32px; height: 32px; color: white; }

        .panel-title {
            font-size: clamp(2rem, 3vw, 2.8rem); font-weight: 900;
            letter-spacing: -0.03em; color: #fff; line-height: 1.1; margin-bottom: 1.25rem;
        }
        .panel-title .grad {
            background: linear-gradient(135deg, var(--c-accent2), var(--c-accent), var(--c-accent3));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .panel-desc { font-size: 0.95rem; color: #64748b; line-height: 1.75; max-width: 380px; margin-bottom: 3rem; }

        /* Feature pills */
        .feature-list { display: flex; flex-direction: column; gap: 1rem; }
        .feature-item {
            display: flex; align-items: center; gap: 0.875rem;
            background: rgba(255,255,255,0.03); border: 1px solid var(--c-border);
            border-radius: 14px; padding: 0.875rem 1.25rem;
            transition: all 0.3s;
        }
        .feature-item:hover { background: rgba(99,102,241,0.06); border-color: rgba(99,102,241,0.2); }
        .fi-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .fi-icon svg { width: 18px; height: 18px; }
        .fi-indigo { background: rgba(99,102,241,0.15); color: #a5b4fc; }
        .fi-cyan { background: rgba(6,182,212,0.15); color: #67e8f9; }
        .fi-violet { background: rgba(139,92,246,0.15); color: #c4b5fd; }
        .fi-text h4 { font-size: 0.85rem; font-weight: 700; color: #f1f5f9; }
        .fi-text p { font-size: 0.75rem; color: #64748b; margin-top: 0.1rem; }

        /* Panel bottom */
        .panel-footer { margin-top: auto; padding-top: 3rem; }
        .panel-footer p { font-size: 0.72rem; color: #1e293b; }

        /* ── RIGHT / FORM PANEL ─ */
        .right-panel {
            position: relative; z-index: 1;
            width: 100%; max-width: 520px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 2.5rem 2rem;
            min-height: 100vh;
        }
        @media(min-width: 1024px) { .right-panel { padding: 3rem; } }

        /* Form card */
        .auth-card {
            width: 100%; max-width: 420px;
            background: rgba(7,12,24,0.8);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 28px;
            padding: 2.5rem;
            backdrop-filter: blur(24px) saturate(160%);
            -webkit-backdrop-filter: blur(24px);
            box-shadow: 0 0 0 1px rgba(99,102,241,0.06), 0 32px 64px rgba(0,0,0,0.6);
            position: relative; overflow: hidden;
        }
        .auth-card::before {
            content: '';
            position: absolute; top: 0; left: 10%; right: 10%; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(99,102,241,0.45), transparent);
        }
        .auth-card::after {
            content: '';
            position: absolute; top: -60px; left: 50%; transform: translateX(-50%);
            width: 280px; height: 140px;
            background: radial-gradient(ellipse, rgba(99,102,241,0.12), transparent 70%);
            pointer-events: none;
        }

        /* Mobile logo (shown only on small) */
        .mobile-header { text-align: center; margin-bottom: 2rem; }
        @media(min-width: 1024px) { .mobile-header { display: none; } }
        .mob-logo { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg, var(--c-accent), var(--c-accent2)); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 0 24px rgba(99,102,241,0.4); }
        .mob-logo svg { width: 26px; height: 26px; color: white; }
        .mob-title { font-size: 1.2rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; }
        .mob-sub { font-size: 0.72rem; color: #64748b; margin-top: 0.25rem; }

        /* Form heading */
        .form-heading { margin-bottom: 2rem; position: relative; z-index: 1; }
        .form-heading h2 { font-size: 1.4rem; font-weight: 800; color: #fff; letter-spacing: -0.02em; margin-bottom: 0.35rem; }
        .form-heading p { font-size: 0.82rem; color: #64748b; }

        /* Inputs */
        .form-group { margin-bottom: 1.25rem; position: relative; z-index: 1; }
        .form-label {
            display: block; font-size: 0.78rem; font-weight: 600;
            color: #94a3b8; margin-bottom: 0.5rem; letter-spacing: 0.01em;
        }
        .form-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-size: 0.9rem; font-family: inherit;
            color: #f1f5f9;
            outline: none;
            transition: all 0.25s;
        }
        .form-input::placeholder { color: #334155; }
        .form-input:focus {
            border-color: rgba(99,102,241,0.5);
            background: rgba(99,102,241,0.06);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }
        .form-input.has-error { border-color: rgba(244,63,94,0.5); box-shadow: 0 0 0 3px rgba(244,63,94,0.1); }
        .error-msg { font-size: 0.72rem; color: #f87171; margin-top: 0.4rem; }

        /* Password wrapper */
        .input-wrap { position: relative; }
        .toggle-pw {
            position: absolute; right: 0.875rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #475569;
            display: flex; align-items: center; transition: color 0.2s;
        }
        .toggle-pw:hover { color: #94a3b8; }
        .toggle-pw svg { width: 18px; height: 18px; }

        /* Remember + forgot */
        .form-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.75rem; position: relative; z-index: 1; }
        .remember { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
        .remember input[type="checkbox"] {
            width: 16px; height: 16px; border-radius: 5px; cursor: pointer;
            accent-color: var(--c-accent);
        }
        .remember span { font-size: 0.8rem; color: #64748b; }

        /* Submit button */
        .btn-submit {
            position: relative; width: 100%; padding: 0.9rem;
            border-radius: 14px; border: none; cursor: pointer;
            font-family: inherit; font-size: 0.95rem; font-weight: 700; color: #fff;
            background: linear-gradient(135deg, var(--c-accent), var(--c-accent3));
            box-shadow: 0 4px 24px rgba(99,102,241,0.42);
            transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden; z-index: 1;
        }
        .btn-submit::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.14), transparent);
            transition: left 0.5s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(99,102,241,0.55); }
        .btn-submit:hover::before { left: 100%; }
        .btn-submit:active { transform: translateY(0); }

        /* Session status */
        .status-msg {
            background: rgba(6,182,212,0.1); border: 1px solid rgba(6,182,212,0.25);
            border-radius: 10px; padding: 0.75rem 1rem; font-size: 0.8rem;
            color: #67e8f9; margin-bottom: 1.25rem; position: relative; z-index: 1;
        }

        /* Card footer */
        .card-footer { text-align: center; margin-top: 1.5rem; font-size: 0.72rem; color: #1e293b; position: relative; z-index: 1; }
    </style>
</head>
<body>
    <canvas id="bg-canvas"></canvas>
    <div class="aurora aurora-1"></div>
    <div class="aurora aurora-2"></div>
    <div class="aurora aurora-3"></div>
    <div class="dot-grid"></div>

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="panel-badge">
            <span class="panel-dot"></span>
            <span>Sistem Aktif</span>
        </div>

        <div class="panel-logo">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
            </svg>
        </div>

        <h1 class="panel-title">
            Manajemen<br>
            <span class="grad">Aset Jaringan</span>
        </h1>
        <p class="panel-desc">
            Platform terpadu DISKOMINFO untuk mengelola seluruh infrastruktur jaringan daerah secara efisien, transparan, dan real-time.
        </p>

        <div class="feature-list">
            <div class="feature-item">
                <div class="fi-icon fi-indigo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                </div>
                <div class="fi-text">
                    <h4>Manajemen Perangkat</h4>
                    <p>Kelola router, switch & access point</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="fi-icon fi-cyan">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="fi-text">
                    <h4>Pemetaan Lokasi OPD</h4>
                    <p>Visualisasi lokasi & konfigurasi jaringan</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="fi-icon fi-violet">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="fi-text">
                    <h4>Laporan & Analitik</h4>
                    <p>Ekspor PDF/Excel & dashboard real-time</p>
                </div>
            </div>
        </div>

        <div class="panel-footer">
            <p>&copy; {{ date('Y') }} DISKOMINFO. All rights reserved.</p>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <!-- Mobile header -->
        <div class="mobile-header">
            <div class="mob-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
            </div>
            <div class="mob-title">Aset Jaringan</div>
            <div class="mob-sub">DISKOMINFO</div>
        </div>

        <div class="auth-card">
            <div class="form-heading">
                <h2>Selamat Datang</h2>
                <p>Masuk untuk mengakses panel manajemen jaringan.</p>
            </div>

            {{ $slot }}
        </div>

        <p class="card-footer">&copy; {{ date('Y') }} DISKOMINFO. All rights reserved.</p>
    </div>

    <script>
    (function(){
        const canvas = document.getElementById('bg-canvas');
        const ctx = canvas.getContext('2d');
        let W, H, stars = [];
        function resize(){ W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }
        resize();
        window.addEventListener('resize', resize);
        for(let i=0;i<100;i++) stars.push({ x:Math.random(), y:Math.random(), r:Math.random()*1.1+0.2, speed:Math.random()*0.0004+0.0001, offset:Math.random()*Math.PI*2 });
        function draw(ts){
            ctx.clearRect(0,0,W,H);
            stars.forEach(s=>{
                const a = 0.1+0.5*Math.abs(Math.sin(ts*s.speed+s.offset));
                ctx.beginPath(); ctx.arc(s.x*W,s.y*H,s.r,0,Math.PI*2);
                ctx.fillStyle=`rgba(255,255,255,${a})`; ctx.fill();
            });
            requestAnimationFrame(draw);
        }
        requestAnimationFrame(draw);
    })();

    // Toggle password visibility
    function togglePw(id, btn) {
        const inp = document.getElementById(id);
        const isText = inp.type === 'text';
        inp.type = isText ? 'password' : 'text';
        btn.querySelector('.eye-open').style.display = isText ? 'block' : 'none';
        btn.querySelector('.eye-closed').style.display = isText ? 'none' : 'block';
    }
    </script>
</body>
</html>