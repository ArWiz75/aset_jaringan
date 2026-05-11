<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Manajemen Aset Jaringan - DISKOMINFO. Kelola infrastruktur jaringan daerah secara modern dan efisien.">
    <title>Manajemen Aset Jaringan - DISKOMINFO</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --slate-blue: #4a6fa5;
            --slate-blue-light: #6b8fc5;
            --soft-gray: #f0f2f5;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; margin: 0; overflow-x: hidden; background: #f8fafc; color: #1e293b; }

        /* Animated gradient bg */
        .hero-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #2d5a87 70%, #1e293b 100%);
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at 30% 50%, rgba(74,111,165,0.15) 0%, transparent 60%),
                        radial-gradient(ellipse at 70% 20%, rgba(56,189,248,0.08) 0%, transparent 50%);
            animation: bgPulse 8s ease-in-out infinite alternate;
        }
        @keyframes bgPulse {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-2%, 2%) scale(1.05); }
        }

        /* Grid pattern overlay */
        .grid-pattern {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(148,163,184,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148,163,184,0.05) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: orbFloat 12s ease-in-out infinite alternate;
        }
        .orb-1 { width: 400px; height: 400px; background: #4a6fa5; top: -10%; right: 10%; animation-delay: 0s; }
        .orb-2 { width: 300px; height: 300px; background: #38bdf8; bottom: 10%; left: -5%; animation-delay: -4s; }
        .orb-3 { width: 200px; height: 200px; background: #818cf8; top: 50%; right: -5%; animation-delay: -8s; }
        @keyframes orbFloat {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-30px) scale(1.1); }
        }

        /* Navbar */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 50;
            padding: 1rem 2rem;
            display: flex; align-items: center; justify-content: space-between;
            transition: all 0.3s;
        }
        .navbar.scrolled {
            background: rgba(15,23,42,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(148,163,184,0.1);
            padding: 0.75rem 2rem;
        }
        .nav-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .nav-logo {
            width: 42px; height: 42px; border-radius: 12px;
            background: linear-gradient(135deg, #38bdf8, #4a6fa5);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(56,189,248,0.3);
        }
        .nav-logo svg { width: 24px; height: 24px; color: white; }
        .nav-title { font-weight: 700; font-size: 1.1rem; color: white; }
        .nav-subtitle { font-size: 0.7rem; color: #94a3b8; font-weight: 400; }
        .nav-links { display: flex; align-items: center; gap: 0.5rem; }
        .nav-link {
            padding: 0.5rem 1.25rem; border-radius: 10px; font-size: 0.875rem; font-weight: 500;
            color: #cbd5e1; text-decoration: none; transition: all 0.25s;
        }
        .nav-link:hover { color: white; background: rgba(255,255,255,0.08); }
        .nav-btn {
            padding: 0.6rem 1.5rem; border-radius: 10px; font-size: 0.875rem; font-weight: 600;
            background: linear-gradient(135deg, #38bdf8, #4a6fa5);
            color: white; text-decoration: none; border: none; cursor: pointer;
            transition: all 0.3s; box-shadow: 0 4px 15px rgba(56,189,248,0.25);
        }
        .nav-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(56,189,248,0.35); }

        /* Hero Content */
        .hero-content {
            position: relative; z-index: 10;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            min-height: 100vh; padding: 8rem 2rem 4rem; text-align: center;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.4rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600;
            background: rgba(56,189,248,0.1); border: 1px solid rgba(56,189,248,0.2);
            color: #7dd3fc; margin-bottom: 2rem; letter-spacing: 0.05em; text-transform: uppercase;
            animation: fadeUp 0.8s ease both;
        }
        .hero-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: #38bdf8; animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100% { opacity:1; } 50% { opacity:0.4; } }

        .hero-h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 800;
            color: white; line-height: 1.1; margin: 0 0 1.5rem; max-width: 800px;
            animation: fadeUp 0.8s ease 0.15s both;
        }
        .hero-h1 span {
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero-desc {
            font-size: 1.125rem; color: #94a3b8; max-width: 560px;
            line-height: 1.7; margin: 0 0 2.5rem;
            animation: fadeUp 0.8s ease 0.3s both;
        }
        .hero-actions {
            display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;
            animation: fadeUp 0.8s ease 0.45s both;
        }
        .btn-primary {
            padding: 0.85rem 2rem; border-radius: 12px; font-size: 1rem; font-weight: 600;
            background: linear-gradient(135deg, #38bdf8, #4a6fa5);
            color: white; text-decoration: none; border: none; cursor: pointer;
            transition: all 0.3s; box-shadow: 0 4px 20px rgba(56,189,248,0.3);
            display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(56,189,248,0.4); }
        .btn-secondary {
            padding: 0.85rem 2rem; border-radius: 12px; font-size: 1rem; font-weight: 600;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(148,163,184,0.2);
            color: #e2e8f0; text-decoration: none; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.1); border-color: rgba(148,163,184,0.4); }

        /* Stats row */
        .stats-row {
            display: flex; gap: 3rem; margin-top: 4rem; padding-top: 3rem;
            border-top: 1px solid rgba(148,163,184,0.1);
            animation: fadeUp 0.8s ease 0.6s both;
        }
        .stat { text-align: center; }
        .stat-val { font-size: 2rem; font-weight: 800; color: white; }
        .stat-val span { color: #38bdf8; }
        .stat-label { font-size: 0.8rem; color: #64748b; margin-top: 0.25rem; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Features Section */
        .features-section {
            padding: 6rem 2rem; background: #f8fafc;
            position: relative;
        }
        .section-header { text-align: center; max-width: 600px; margin: 0 auto 4rem; }
        .section-tag {
            display: inline-block; font-size: 0.75rem; font-weight: 700;
            color: #4a6fa5; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.75rem;
        }
        .section-title { font-size: 2.25rem; font-weight: 800; color: #0f172a; margin: 0 0 1rem; }
        .section-desc { font-size: 1rem; color: #64748b; line-height: 1.7; }

        .features-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem; max-width: 1100px; margin: 0 auto;
        }
        .feature-card {
            background: white; border-radius: 16px; padding: 2rem;
            border: 1px solid #e2e8f0;
            transition: all 0.35s; position: relative; overflow: hidden;
        }
        .feature-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #38bdf8, #4a6fa5);
            transform: scaleX(0); transform-origin: left; transition: transform 0.35s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); border-color: transparent; }
        .feature-card:hover::before { transform: scaleX(1); }

        .feature-icon {
            width: 48px; height: 48px; border-radius: 12px;
            background: linear-gradient(135deg, rgba(56,189,248,0.1), rgba(74,111,165,0.1));
            display: flex; align-items: center; justify-content: center; margin-bottom: 1.25rem;
        }
        .feature-icon svg { width: 24px; height: 24px; color: #4a6fa5; }
        .feature-card h3 { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 0.5rem; }
        .feature-card p { font-size: 0.875rem; color: #64748b; line-height: 1.6; margin: 0; }

        /* CTA Section */
        .cta-section {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #0f172a, #1e3a5f);
            text-align: center; position: relative; overflow: hidden;
        }
        .cta-section::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse at center, rgba(56,189,248,0.08), transparent 70%);
        }
        .cta-content { position: relative; z-index: 1; }
        .cta-title { font-size: 2rem; font-weight: 800; color: white; margin: 0 0 1rem; }
        .cta-desc { font-size: 1rem; color: #94a3b8; margin: 0 0 2rem; max-width: 500px; display: inline-block; }

        /* Footer */
        footer {
            background: #0f172a; padding: 2rem; text-align: center;
            border-top: 1px solid rgba(148,163,184,0.1);
        }
        footer p { color: #475569; font-size: 0.8rem; margin: 0; }
        footer a { color: #38bdf8; text-decoration: none; }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar { padding: 0.75rem 1rem; }
            .nav-links { gap: 0.25rem; }
            .nav-link { padding: 0.5rem 0.75rem; font-size: 0.8rem; }
            .nav-btn { padding: 0.5rem 1rem; font-size: 0.8rem; }
            .stats-row { gap: 1.5rem; flex-wrap: wrap; }
            .hero-content { padding: 6rem 1.5rem 3rem; }
            .features-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar" id="mainNav">
        <a href="/" class="nav-brand">
            <div class="nav-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
            </div>
            <div>
                <div class="nav-title">Aset Jaringan</div>
                <div class="nav-subtitle">DISKOMINFO</div>
            </div>
        </a>
        <div class="nav-links">
            @auth
                <a href="{{ route('dashboard') }}" class="nav-btn">Dashboard →</a>
            @else
                <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="nav-btn">Daftar</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-bg">
        <div class="grid-pattern"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="hero-content">
            <div class="hero-badge"><span class="dot"></span> Platform Manajemen Jaringan</div>
            <h1 class="hero-h1">Kelola Infrastruktur <span>Jaringan Daerah</span> dengan Mudah</h1>
            <p class="hero-desc">Sistem terpadu untuk pemantauan, pengelolaan, dan pemeliharaan aset jaringan di seluruh OPD. Dirancang untuk efisiensi dan transparansi.</p>
            <div class="hero-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary">
                        Buka Dashboard
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary">
                        Mulai Sekarang
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="#features" class="btn-secondary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Pelajari Lebih
                    </a>
                @endauth
            </div>
            <div class="stats-row">
                <div class="stat">
                    <div class="stat-val">100<span>+</span></div>
                    <div class="stat-label">Perangkat Terkelola</div>
                </div>
                <div class="stat">
                    <div class="stat-val">50<span>+</span></div>
                    <div class="stat-label">Lokasi OPD</div>
                </div>
                <div class="stat">
                    <div class="stat-val">24<span>/7</span></div>
                    <div class="stat-label">Monitoring Aktif</div>
                </div>
                <div class="stat">
                    <div class="stat-val">99<span>%</span></div>
                    <div class="stat-label">Uptime Jaringan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features-section" id="features">
        <div class="section-header">
            <div class="section-tag">Fitur Unggulan</div>
            <h2 class="section-title">Semua yang Anda Butuhkan</h2>
            <p class="section-desc">Solusi lengkap untuk mengelola infrastruktur jaringan daerah secara efisien dan modern.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                </div>
                <h3>Manajemen Perangkat</h3>
                <p>Kelola seluruh perangkat jaringan termasuk router, switch, dan access point dengan data lengkap dan foto dokumentasi.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3>Pemetaan Lokasi OPD</h3>
                <p>Visualisasi lokasi setiap OPD beserta detail konfigurasi jaringan multi-provider dan kecepatan koneksi.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3>Log Maintenance</h3>
                <p>Catat dan lacak seluruh aktivitas pemeliharaan perangkat dengan riwayat lengkap dan laporan terstruktur.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3>Ekspor Laporan</h3>
                <p>Ekspor data ke format PDF dan Excel untuk kebutuhan pelaporan resmi dan audit infrastruktur jaringan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3>Dashboard Analitik</h3>
                <p>Visualisasi data real-time dengan grafik interaktif untuk memantau status dan performa jaringan.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3>Akses Terkontrol</h3>
                <p>Sistem role-based access dengan pembagian hak akses Administrator dan Viewer untuk keamanan data.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="cta-content">
            <h2 class="cta-title">Siap Mengelola Jaringan Anda?</h2>
            <p class="cta-desc">Masuk ke sistem untuk mulai memantau dan mengelola seluruh aset jaringan daerah.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary">Buka Dashboard →</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary">Masuk Sekarang →</a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} <a href="/">Manajemen Aset Jaringan</a> — DISKOMINFO. All rights reserved.</p>
    </footer>

    <script>
        // Navbar scroll effect
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                e.preventDefault();
                document.querySelector(a.getAttribute('href'))?.scrollIntoView({ behavior: 'smooth' });
            });
        });

        // Intersection Observer for fade-in
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.feature-card').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `all 0.6s ease ${i * 0.1}s`;
            observer.observe(el);
        });
    </script>
</body>
</html>
