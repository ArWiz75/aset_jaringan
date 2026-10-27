<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Manajemen Aset Jaringan - DISKOMINFO. Kelola infrastruktur jaringan daerah secara modern dan efisien.">
    <title>Manajemen Aset Jaringan - DISKOMINFO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --c-bg: #02040a;
            --c-surface: #070c18;
            --c-border: rgba(255,255,255,0.07);
            --c-text: #e2e8f0;
            --c-muted: #64748b;
            --c-accent: #6366f1;
            --c-accent2: #06b6d4;
            --c-accent3: #8b5cf6;
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--c-bg); color: var(--c-text); overflow-x: hidden; }
        #bg-canvas { position: fixed; inset: 0; z-index: 0; pointer-events: none; }

        /* NAVBAR */
        .navbar { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 1.25rem 2rem; display: flex; align-items: center; justify-content: space-between; transition: all 0.4s; }
        .navbar.scrolled { background: rgba(2,4,10,0.82); backdrop-filter: blur(24px) saturate(180%); -webkit-backdrop-filter: blur(24px); border-bottom: 1px solid var(--c-border); padding: 0.85rem 2rem; }
        .nav-brand { display: flex; align-items: center; gap: 0.875rem; text-decoration: none; }
        .nav-logo { position: relative; width: 44px; height: 44px; border-radius: 14px; background: linear-gradient(135deg, var(--c-accent), var(--c-accent2)); display: flex; align-items: center; justify-content: center; box-shadow: 0 0 24px rgba(99,102,241,0.45); }
        .nav-logo svg { width: 22px; height: 22px; color: white; }
        .nav-brand-text .nav-title { font-size: 1rem; font-weight: 700; color: #fff; letter-spacing: -0.01em; }
        .nav-brand-text .nav-sub { font-size: 0.65rem; font-weight: 600; color: var(--c-accent2); letter-spacing: 0.12em; text-transform: uppercase; }
        .nav-pill { display: flex; align-items: center; gap: 0.25rem; background: rgba(255,255,255,0.04); border: 1px solid var(--c-border); border-radius: 99px; padding: 0.3rem; }
        .nav-link { padding: 0.45rem 1rem; border-radius: 99px; font-size: 0.82rem; font-weight: 500; color: #94a3b8; text-decoration: none; transition: all 0.2s; }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .nav-cta { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.4rem; border-radius: 99px; font-size: 0.85rem; font-weight: 700; text-decoration: none; color: #fff; background: linear-gradient(135deg, var(--c-accent), var(--c-accent3)); box-shadow: 0 4px 20px rgba(99,102,241,0.4); transition: all 0.3s; border: none; cursor: pointer; }
        .nav-cta:hover { transform: translateY(-1px); box-shadow: 0 8px 32px rgba(99,102,241,0.55); }

        /* HERO */
        .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 7rem 2rem 4rem; text-align: center; overflow: hidden; }
        .aurora { position: absolute; border-radius: 50%; filter: blur(100px); pointer-events: none; }
        .aurora-1 { width: 650px; height: 650px; background: radial-gradient(circle, rgba(99,102,241,0.20) 0%, transparent 70%); top: -20%; left: -15%; animation: af1 18s ease-in-out infinite; }
        .aurora-2 { width: 580px; height: 580px; background: radial-gradient(circle, rgba(6,182,212,0.15) 0%, transparent 70%); bottom: -10%; right: -10%; animation: af2 22s ease-in-out infinite; }
        .aurora-3 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(139,92,246,0.13) 0%, transparent 70%); top: 40%; left: 50%; transform: translate(-50%,-50%); animation: af3 15s ease-in-out infinite; }
        @keyframes af1 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(60px,40px) scale(1.1)} }
        @keyframes af2 { 0%,100%{transform:translate(0,0) scale(1.05)} 50%{transform:translate(-40px,-30px) scale(1)} }
        @keyframes af3 { 0%,100%{transform:translate(-50%,-50%) scale(1);opacity:.8} 50%{transform:translate(-50%,-50%) scale(1.15);opacity:1} }
        .hero::before { content:''; position:absolute; inset:0; background-image:radial-gradient(rgba(255,255,255,0.055) 1px,transparent 1px); background-size:36px 36px; mask-image:radial-gradient(ellipse 80% 70% at 50% 50%, black, transparent); pointer-events:none; }
        .hero-inner { position: relative; z-index: 2; max-width: 860px; }
        .eyebrow { display: inline-flex; align-items: center; gap: 0.6rem; background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.28); border-radius: 99px; padding: 0.45rem 1.2rem; margin-bottom: 2rem; animation: fadeUp 0.7s ease both; }
        .eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--c-accent2); box-shadow: 0 0 10px var(--c-accent2); animation: blink 2.4s ease-in-out infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }
        .eyebrow-label { font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: #a5b4fc; }
        .hero-h1 { font-size: clamp(2.6rem, 6.5vw, 5rem); font-weight: 900; line-height: 1.05; letter-spacing: -0.03em; color: #fff; margin-bottom: 1.5rem; animation: fadeUp 0.7s ease 0.12s both; }
        .hero-h1 .grad { background: linear-gradient(135deg, var(--c-accent2) 0%, var(--c-accent) 50%, var(--c-accent3) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-h1 .outline { -webkit-text-stroke: 2px rgba(255,255,255,0.18); color: transparent; }
        .hero-desc { font-size: 1.1rem; color: #94a3b8; line-height: 1.75; max-width: 560px; margin: 0 auto 2.5rem; animation: fadeUp 0.7s ease 0.22s both; }
        .hero-btns { display: flex; gap: 0.875rem; justify-content: center; flex-wrap: wrap; animation: fadeUp 0.7s ease 0.32s both; }
        .btn-glow { position: relative; display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.9rem 2.1rem; border-radius: 14px; font-size: 0.95rem; font-weight: 700; text-decoration: none; color: #fff; border: none; cursor: pointer; background: linear-gradient(135deg, var(--c-accent), var(--c-accent3)); box-shadow: 0 4px 24px rgba(99,102,241,0.42); transition: all 0.3s cubic-bezier(0.4,0,0.2,1); overflow: hidden; }
        .btn-glow::before { content:''; position:absolute; top:0; left:-100%; width:100%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.14),transparent); transition:left 0.5s; }
        .btn-glow:hover { transform: translateY(-2px); box-shadow: 0 10px 40px rgba(99,102,241,0.58); }
        .btn-glow:hover::before { left: 100%; }
        .btn-ghost { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.9rem 2.1rem; border-radius: 14px; font-size: 0.95rem; font-weight: 600; text-decoration: none; color: #cbd5e1; background: rgba(255,255,255,0.045); border: 1px solid rgba(255,255,255,0.11); transition: all 0.3s; }
        .btn-ghost:hover { background: rgba(255,255,255,0.09); border-color: rgba(255,255,255,0.22); color: #fff; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }

        /* STATS */
        .stats-strip { margin-top: 4.5rem; padding-top: 3rem; border-top: 1px solid var(--c-border); display: flex; gap: 4rem; justify-content: center; flex-wrap: wrap; animation: fadeUp 0.7s ease 0.42s both; }
        .stat-item { text-align: center; }
        .stat-num { font-size: 2.4rem; font-weight: 900; letter-spacing: -0.04em; color: #fff; }
        .stat-num em { font-style: normal; background: linear-gradient(135deg, var(--c-accent2), var(--c-accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .stat-label { font-size: 0.78rem; color: var(--c-muted); margin-top: 0.3rem; font-weight: 500; }

        /* FEATURES */
        .features { position: relative; z-index: 1; padding: 7rem 2rem; background: linear-gradient(180deg, var(--c-bg) 0%, var(--c-surface) 100%); }
        .section-eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--c-accent2); margin-bottom: 0.75rem; }
        .section-eyebrow::before { content:''; display:block; width:24px; height:2px; background:var(--c-accent2); border-radius:2px; }
        .section-head { text-align: center; max-width: 580px; margin: 0 auto 4rem; }
        .section-head h2 { font-size: clamp(1.75rem, 3.5vw, 2.75rem); font-weight: 800; color: #fff; letter-spacing: -0.03em; margin-bottom: 0.875rem; }
        .section-head p { font-size: 1rem; color: #64748b; line-height: 1.75; }

        /* BENTO */
        .bento { display: grid; grid-template-columns: repeat(12, 1fr); gap: 1.25rem; max-width: 1140px; margin: 0 auto; }
        .bento-card { background: rgba(255,255,255,0.028); border: 1px solid var(--c-border); border-radius: 24px; padding: 2rem; position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4,0,0.2,1); cursor: default; }
        .bento-card::before { content:''; position:absolute; inset:0; background:radial-gradient(circle at var(--mx,50%) var(--my,50%), rgba(99,102,241,0.08), transparent 60%); opacity:0; transition:opacity 0.4s; }
        .bento-card::after { content:''; position:absolute; top:0; left:10%; right:10%; height:1px; background:linear-gradient(90deg,transparent,rgba(99,102,241,0.5),transparent); opacity:0; transition:opacity 0.4s; }
        .bento-card:hover { border-color: rgba(99,102,241,0.3); transform: translateY(-3px); box-shadow: 0 20px 50px rgba(0,0,0,0.35); }
        .bento-card:hover::before { opacity: 1; }
        .bento-card:hover::after { opacity: 1; }
        .col-8 { grid-column: span 8; }
        .col-4 { grid-column: span 4; }
        .col-6 { grid-column: span 6; }
        .bento-tag { display: inline-flex; align-items: center; background: rgba(99,102,241,0.12); border: 1px solid rgba(99,102,241,0.22); border-radius: 99px; padding: 0.25rem 0.8rem; font-size: 0.68rem; font-weight: 700; color: #a5b4fc; letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 1rem; }
        .card-icon { width: 52px; height: 52px; border-radius: 16px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; }
        .card-icon svg { width: 26px; height: 26px; }
        .ci-indigo { background: rgba(99,102,241,0.13); box-shadow: inset 0 0 0 1px rgba(99,102,241,0.28); color: #a5b4fc; }
        .ci-cyan { background: rgba(6,182,212,0.13); box-shadow: inset 0 0 0 1px rgba(6,182,212,0.28); color: #67e8f9; }
        .ci-violet { background: rgba(139,92,246,0.13); box-shadow: inset 0 0 0 1px rgba(139,92,246,0.28); color: #c4b5fd; }
        .ci-emerald { background: rgba(16,185,129,0.13); box-shadow: inset 0 0 0 1px rgba(16,185,129,0.28); color: #6ee7b7; }
        .ci-amber { background: rgba(245,158,11,0.13); box-shadow: inset 0 0 0 1px rgba(245,158,11,0.28); color: #fcd34d; }
        .ci-rose { background: rgba(244,63,94,0.13); box-shadow: inset 0 0 0 1px rgba(244,63,94,0.28); color: #fda4af; }
        .bento-card h3 { font-size: 1.05rem; font-weight: 700; color: #f1f5f9; margin-bottom: 0.6rem; letter-spacing: -0.01em; }
        .bento-card p { font-size: 0.875rem; color: #64748b; line-height: 1.7; }
        .card-bg-icon { position: absolute; right: -20px; bottom: -20px; width: 160px; height: 160px; opacity: 0.04; }

        /* HOW */
        .how-section { position: relative; z-index: 1; padding: 7rem 2rem; background: var(--c-surface); }
        .steps { display: flex; gap: 0; max-width: 900px; margin: 0 auto; position: relative; }
        .steps::before { content:''; position:absolute; top:28px; left:10%; right:10%; height:1px; background:linear-gradient(90deg,transparent,rgba(99,102,241,0.4),transparent); }
        .step { flex: 1; text-align: center; padding: 0 1.5rem; }
        .step-num { width: 56px; height: 56px; border-radius: 50%; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--c-accent), var(--c-accent3)); box-shadow: 0 0 0 8px rgba(99,102,241,0.1), 0 4px 20px rgba(99,102,241,0.38); position: relative; z-index: 1; }
        .step h4 { font-size: 1rem; font-weight: 700; color: #f1f5f9; margin-bottom: 0.5rem; }
        .step p { font-size: 0.85rem; color: #64748b; line-height: 1.65; }

        /* CTA */
        .cta-section { position: relative; z-index: 1; padding: 6rem 2rem; text-align: center; background: var(--c-bg); }
        .cta-card { max-width: 700px; margin: 0 auto; background: rgba(99,102,241,0.06); border: 1px solid rgba(99,102,241,0.22); border-radius: 32px; padding: 4rem 3rem; position: relative; overflow: hidden; }
        .cta-card::before { content:''; position:absolute; top:-80px; left:50%; transform:translateX(-50%); width:400px; height:200px; background:radial-gradient(ellipse,rgba(99,102,241,0.22),transparent 70%); pointer-events:none; }
        .cta-card h2 { font-size: clamp(1.75rem, 3.5vw, 2.5rem); font-weight: 800; color: #fff; letter-spacing: -0.03em; margin-bottom: 1rem; }
        .cta-card p { font-size: 1rem; color: #64748b; margin-bottom: 2rem; line-height: 1.7; }

        /* FOOTER */
        footer { position: relative; z-index: 1; background: #020409; border-top: 1px solid var(--c-border); padding: 2rem; }
        .footer-inner { max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
        .footer-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .footer-logo { width: 32px; height: 32px; border-radius: 10px; background: linear-gradient(135deg, var(--c-accent), var(--c-accent2)); display: flex; align-items: center; justify-content: center; }
        .footer-logo svg { width: 16px; height: 16px; color: white; }
        .footer-name { font-size: 0.875rem; font-weight: 700; color: #fff; }
        .footer-copy { font-size: 0.775rem; color: #334155; }
        .footer-copy a { color: var(--c-accent2); text-decoration: none; }

        /* REVEAL */
        .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.65s ease, transform 0.65s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .rd1 { transition-delay: 0.1s; }
        .rd2 { transition-delay: 0.2s; }
        .rd3 { transition-delay: 0.3s; }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .col-8,.col-4,.col-6 { grid-column: span 12; }
            .steps { flex-direction: column; gap: 2rem; }
            .steps::before { display: none; }
            .stats-strip { gap: 2rem; }
        }
        @media (max-width: 640px) {
            .navbar { padding: 1rem; }
            .nav-pill { display: none; }
            .hero { padding: 6rem 1.25rem 3rem; }
            .cta-card { padding: 2.5rem 1.5rem; border-radius: 20px; }
            .footer-inner { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<canvas id="bg-canvas"></canvas>

<!-- NAVBAR -->
<nav class="navbar" id="mainNav">
    <a href="/" class="nav-brand">
        <div class="nav-logo">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
            </svg>
        </div>
        <div class="nav-brand-text">
            <div class="nav-title">Aset Jaringan</div>
            <div class="nav-sub">DISKOMINFO</div>
        </div>
    </a>
    <div class="nav-pill">
        <a href="#features" class="nav-link">Fitur</a>
        <a href="#how" class="nav-link">Cara Kerja</a>
        <a href="#cta" class="nav-link">Mulai</a>
    </div>
    <div>
        @auth
            <a href="{{ route('dashboard') }}" class="nav-cta">Dashboard <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>
        @else
            <a href="{{ route('login') }}" class="nav-cta">Masuk <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>
        @endauth
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="aurora aurora-1"></div>
    <div class="aurora aurora-2"></div>
    <div class="aurora aurora-3"></div>
    <div class="hero-inner">
        <div class="eyebrow">
            <span class="eyebrow-dot"></span>
            <span class="eyebrow-label">Platform Manajemen Jaringan</span>
        </div>
        <h1 class="hero-h1">
            Infrastruktur Jaringan<br>
            <span class="grad">Lebih Cerdas,</span>
            <span class="outline"> Lebih Efisien</span>
        </h1>
        <p class="hero-desc">
            Sistem terpadu untuk pemantauan, pengelolaan, dan pemeliharaan aset jaringan
            di seluruh OPD — dirancang untuk efisiensi, transparansi, dan skala daerah.
        </p>
        <div class="hero-btns">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-glow">Buka Dashboard <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>
            @else
                <a href="{{ route('login') }}" class="btn-glow">Mulai Sekarang <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>
                <a href="#features" class="btn-ghost"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Pelajari Lebih</a>
            @endauth
        </div>
        <div class="stats-strip">
            <div class="stat-item">
                <div class="stat-num">100<em>+</em></div>
                <div class="stat-label">Perangkat Terkelola</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">50<em>+</em></div>
                <div class="stat-label">Lokasi OPD</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">24<em>/7</em></div>
                <div class="stat-label">Monitoring Aktif</div>
            </div>
            <div class="stat-item">
                <div class="stat-num">99<em>%</em></div>
                <div class="stat-label">Uptime Jaringan</div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features" id="features">
    <div class="section-head reveal">
        <div class="section-eyebrow">Fitur Unggulan</div>
        <h2>Semua yang Anda Butuhkan</h2>
        <p>Solusi lengkap untuk mengelola infrastruktur jaringan daerah secara efisien dan modern.</p>
    </div>
    <div class="bento">
        <div class="bento-card col-8 reveal">
            <div class="bento-tag">Core Feature</div>
            <div class="card-icon ci-indigo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
            </div>
            <h3>Manajemen Perangkat</h3>
            <p>Kelola seluruh perangkat jaringan termasuk router, switch, dan access point dengan data lengkap dan foto dokumentasi. Pantau status, spesifikasi, dan riwayat setiap aset secara real-time.</p>
            <svg class="card-bg-icon" viewBox="0 0 200 200" fill="none"><circle cx="100" cy="100" r="80" stroke="white" stroke-width="1"/><circle cx="100" cy="100" r="50" stroke="white" stroke-width="1"/><circle cx="100" cy="100" r="20" stroke="white" stroke-width="1"/></svg>
        </div>
        <div class="bento-card col-4 reveal rd1">
            <div class="card-icon ci-cyan">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h3>Pemetaan Lokasi OPD</h3>
            <p>Visualisasi lokasi setiap OPD beserta konfigurasi jaringan, multi-provider, dan kecepatan koneksi.</p>
        </div>
        <div class="bento-card col-4 reveal rd2">
            <div class="card-icon ci-violet">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h3>Log Maintenance</h3>
            <p>Catat dan lacak seluruh aktivitas pemeliharaan dengan riwayat lengkap dan laporan terstruktur.</p>
        </div>
        <div class="bento-card col-4 reveal rd3">
            <div class="card-icon ci-emerald">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3>Ekspor Laporan</h3>
            <p>Ekspor data ke PDF dan Excel untuk kebutuhan pelaporan resmi dan audit infrastruktur.</p>
        </div>
        <div class="bento-card col-4 reveal rd1">
            <div class="card-icon ci-amber">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3>Dashboard Analitik</h3>
            <p>Visualisasi data real-time dengan grafik interaktif untuk memantau status dan performa jaringan.</p>
        </div>
        <div class="bento-card col-4 reveal rd2">
            <div class="card-icon ci-rose">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h3>Akses Terkontrol</h3>
            <p>Sistem role-based access dengan hak Administrator dan Viewer untuk keamanan data yang terjamin.</p>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section" id="how">
    <div class="section-head reveal">
        <div class="section-eyebrow">Cara Kerja</div>
        <h2>Mulai dalam 3 Langkah</h2>
        <p>Proses onboarding yang sederhana agar tim Anda dapat langsung produktif.</p>
    </div>
    <div class="steps">
        <div class="step reveal rd1">
            <div class="step-num">1</div>
            <h4>Daftar & Masuk</h4>
            <p>Masuk menggunakan kredensial yang telah diberikan administrator sistem Anda.</p>
        </div>
        <div class="step reveal rd2">
            <div class="step-num">2</div>
            <h4>Input Data Aset</h4>
            <p>Tambahkan data perangkat, lokasi OPD, dan konfigurasi jaringan ke dalam sistem.</p>
        </div>
        <div class="step reveal rd3">
            <div class="step-num">3</div>
            <h4>Pantau & Kelola</h4>
            <p>Monitor seluruh aset, catat maintenance, dan ekspor laporan kapanpun dibutuhkan.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section" id="cta">
    <div class="cta-card reveal">
        <h2>Siap Kelola Infrastruktur<br>Jaringan Daerah Anda?</h2>
        <p>Bergabunglah dan mulai mengelola seluruh aset jaringan daerah dengan lebih cerdas dan transparan.</p>
        @auth
            <a href="{{ route('dashboard') }}" class="btn-glow">Buka Dashboard →</a>
        @else
            <a href="{{ route('login') }}" class="btn-glow">Masuk Sekarang →</a>
        @endauth
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-inner">
        <a href="/" class="footer-brand">
            <div class="footer-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
            </div>
            <span class="footer-name">Aset Jaringan · DISKOMINFO</span>
        </a>
        <p class="footer-copy">&copy; {{ date('Y') }} <a href="/">Manajemen Aset Jaringan</a> — All rights reserved.</p>
    </div>
</footer>

<script>
(function(){
    const canvas = document.getElementById('bg-canvas');
    const ctx = canvas.getContext('2d');
    let W, H, stars = [];
    function resize(){ W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }
    resize();
    window.addEventListener('resize', resize);
    for(let i=0;i<120;i++) stars.push({ x:Math.random(), y:Math.random(), r:Math.random()*1.2+0.2, speed:Math.random()*0.0004+0.0001, offset:Math.random()*Math.PI*2 });
    function draw(ts){
        ctx.clearRect(0,0,W,H);
        stars.forEach(s=>{
            const a = 0.15 + 0.55*Math.abs(Math.sin(ts*s.speed+s.offset));
            ctx.beginPath();
            ctx.arc(s.x*W, s.y*H, s.r, 0, Math.PI*2);
            ctx.fillStyle = `rgba(255,255,255,${a})`;
            ctx.fill();
        });
        requestAnimationFrame(draw);
    }
    requestAnimationFrame(draw);
})();

const nav = document.getElementById('mainNav');
window.addEventListener('scroll', ()=>{ nav.classList.toggle('scrolled', window.scrollY > 60); });

document.querySelectorAll('a[href^="#"]').forEach(a=>{
    a.addEventListener('click', e=>{
        e.preventDefault();
        const t = document.querySelector(a.getAttribute('href'));
        if(t) t.scrollIntoView({behavior:'smooth'});
    });
});

const obs = new IntersectionObserver(entries=>{
    entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('visible'); obs.unobserve(e.target); } });
}, {threshold: 0.1});
document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));

document.querySelectorAll('.bento-card').forEach(card=>{
    card.addEventListener('mousemove', e=>{
        const r = card.getBoundingClientRect();
        card.style.setProperty('--mx', ((e.clientX-r.left)/r.width*100).toFixed(1)+'%');
        card.style.setProperty('--my', ((e.clientY-r.top)/r.height*100).toFixed(1)+'%');
    });
});
</script>
</body>
</html>