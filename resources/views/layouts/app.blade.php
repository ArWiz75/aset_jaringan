<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Manajemen Aset Jaringan' }} - DISKOMINFO</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --slate-blue: #4a6fa5; --cyan-accent: #38bdf8; }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif; margin: 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #162032 100%) !important;
            color: #e2e8f0 !important; min-height: 100vh;
        }

        /* Global overrides: make Tailwind bg-white into glass */
        .dark .bg-white { background: rgba(15,23,42,0.5) !important; backdrop-filter: blur(16px); }
        .dark .bg-slate-50 { background: rgba(15,23,42,0.3) !important; }
        .dark .bg-\[\#FDFDFC\] { background: rgba(15,23,42,0.5) !important; }

        /* Form inputs global override */
        .dark input[type="text"], .dark input[type="email"], .dark input[type="password"],
        .dark input[type="number"], .dark input[type="url"], .dark input[type="tel"],
        .dark input[type="date"], .dark input[type="datetime-local"],
        .dark input[type="search"], .dark input[type="file"],
        .dark select, .dark textarea {
            background-color: rgba(15,23,42,0.6) !important;
            border-color: rgba(148,163,184,0.15) !important;
            color: #e2e8f0 !important;
        }
        .dark input::placeholder, .dark textarea::placeholder { color: #475569 !important; }
        .dark input:focus, .dark select:focus, .dark textarea:focus {
            border-color: rgba(56,189,248,0.4) !important;
            box-shadow: 0 0 0 2px rgba(56,189,248,0.1) !important;
        }

        /* Table overrides */
        .dark table th { color: #64748b !important; }
        .dark table td { color: #cbd5e1; }
        .dark table tr:hover td { background: rgba(255,255,255,0.02); }

        /* Pagination */
        .dark nav[role="navigation"] span, .dark nav[role="navigation"] a {
            background: rgba(15,23,42,0.5) !important;
            border-color: rgba(148,163,184,0.1) !important;
            color: #94a3b8 !important;
        }
        .dark nav[role="navigation"] span[aria-current] {
            background: rgba(56,189,248,0.15) !important;
            color: #38bdf8 !important; border-color: rgba(56,189,248,0.3) !important;
        }
        .dark nav[role="navigation"] a:hover {
            background: rgba(255,255,255,0.05) !important; color: white !important;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(148,163,184,0.2); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(148,163,184,0.35); }

        /* Compact layout overrides for inner Tailwind views */
        .dark .rounded-2xl { border-radius: 10px !important; }
        .dark .p-8 { padding: 1.25rem !important; }
        .dark .p-6 { padding: 1rem !important; }
        .dark .p-4 { padding: 0.75rem !important; }
        .dark .mb-6 { margin-bottom: 0.75rem !important; }
        .dark .mb-5 { margin-bottom: 0.6rem !important; }
        .dark .gap-4 { gap: 0.5rem !important; }
        .dark .gap-3 { gap: 0.35rem !important; }
        .dark .gap-2 { gap: 0.25rem !important; }
        .dark .space-y-5 > * + * { margin-top: 0.5rem !important; }
        .dark table td { padding-top: 0.4rem !important; padding-bottom: 0.4rem !important; }
        .dark .text-2xl { font-size: 1.25rem !important; }
        .dark .grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-4 { gap: 0.5rem !important; }
        .dark .grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 { gap: 0.5rem !important; }

        /* Grid pattern overlay on body */
        body::before {
            content: ''; position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(148,163,184,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148,163,184,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Floating orbs */
        .app-orb { position: fixed; border-radius: 50%; filter: blur(100px); opacity: 0.15; pointer-events: none; z-index: 0; }
        .app-orb-1 { width: 500px; height: 500px; background: #4a6fa5; top: -15%; right: 5%; animation: orbDrift 15s ease-in-out infinite alternate; }
        .app-orb-2 { width: 350px; height: 350px; background: #38bdf8; bottom: 5%; left: -8%; animation: orbDrift 12s ease-in-out infinite alternate-reverse; }
        @keyframes orbDrift { 0% { transform: translateY(0) scale(1); } 100% { transform: translateY(-20px) scale(1.05); } }

        /* Sidebar */
        .app-sidebar {
            position: fixed; inset-y: 0; left: 0; z-index: 50; width: 240px;
            background: rgba(15,23,42,0.6); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
            border-right: 1px solid rgba(148,163,184,0.08);
            transform: translateX(-100%); transition: transform 0.3s ease;
            display: flex; flex-direction: column;
        }
        @media (min-width: 1024px) { .app-sidebar { transform: translateX(0); } }
        .app-sidebar.open { transform: translateX(0); }

        @media (min-width: 1024px) { .app-sidebar { width: 240px; } }
        .sidebar-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(148,163,184,0.08);
        }
        .sidebar-brand { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
        .sidebar-logo {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, #38bdf8, #4a6fa5);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(56,189,248,0.25);
        }
        .sidebar-logo svg { width: 22px; height: 22px; color: white; }
        .sidebar-title { font-weight: 700; font-size: 0.9rem; color: white; line-height: 1.2; }
        .sidebar-sub { font-size: 0.65rem; color: #64748b; font-weight: 500; }

        /* Nav links */
        .sidebar-nav { padding: 0.75rem; flex: 1; display: flex; flex-direction: column; gap: 2px; }
        .nav-item {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.5rem 0.75rem; border-radius: 8px;
            font-size: 0.8rem; font-weight: 500; color: #94a3b8;
            text-decoration: none; transition: all 0.25s; border: 1px solid transparent;
        }
        .nav-item:hover { color: #e2e8f0; background: rgba(255,255,255,0.05); }
        .nav-item.active {
            color: #38bdf8; background: rgba(56,189,248,0.08);
            border-color: rgba(56,189,248,0.15);
        }
        .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; }

        /* Account section */
        .sidebar-account {
            padding: 0.75rem 1.25rem; margin-top: auto;
            border-top: 1px solid rgba(148,163,184,0.08);
        }
        .account-label { font-size: 0.65rem; font-weight: 600; color: #475569; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.5rem; }
        .account-card {
            padding: 0.6rem 0.85rem; border-radius: 10px;
            background: rgba(255,255,255,0.03); border: 1px solid rgba(148,163,184,0.08);
        }
        .account-name { font-size: 0.85rem; font-weight: 600; color: white; }
        .account-role { font-size: 0.7rem; color: #64748b; }
        .logout-btn {
            display: flex; align-items: center; gap: 0.5rem; width: 100%;
            margin-top: 0.5rem; padding: 0.5rem 0.85rem; border-radius: 10px;
            font-size: 0.8rem; font-weight: 500; color: #f87171;
            background: none; border: none; cursor: pointer; transition: all 0.25s;
        }
        .logout-btn:hover { background: rgba(248,113,113,0.08); color: #fca5a5; }
        .logout-btn svg { width: 18px; height: 18px; }

        /* Main content */
        .app-main { position: relative; z-index: 1; min-height: 100vh; }
        @media (min-width: 1024px) { .app-main { margin-left: 240px; } }

        /* Mobile header */
        .mobile-header {
            position: sticky; top: 0; z-index: 40;
            background: rgba(15,23,42,0.7); backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(148,163,184,0.08);
            padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between;
        }
        @media (min-width: 1024px) { .mobile-header { display: none; } }
        .mobile-toggle {
            background: none; border: none; color: #94a3b8; cursor: pointer; padding: 0.25rem;
        }
        .mobile-toggle:hover { color: white; }
        .mobile-toggle svg { width: 24px; height: 24px; }

        /* Content area */
        .app-content { padding: 0.75rem; }

        /* Flash message */
        .flash-success {
            margin: 0 0.75rem 0.5rem; padding: 0.6rem 0.85rem; border-radius: 10px;
            background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2);
            color: #34d399; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;
        }
        .flash-success svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* Overlay */
        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 45;
            display: none; backdrop-filter: blur(4px);
        }

        /* Card overrides for dashboard content */
        .glass-card {
            background: rgba(15,23,42,0.5); backdrop-filter: blur(16px);
            border: 1px solid rgba(148,163,184,0.08); border-radius: 16px;
            transition: all 0.3s;
        }
        .glass-card:hover { border-color: rgba(148,163,184,0.15); }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-orb app-orb-1"></div>
    <div class="app-orb app-orb-2"></div>

    {{-- Sidebar --}}
    <aside class="app-sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <div class="sidebar-logo">
                    <x-device-icon type="modem" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <div class="sidebar-title">Aset Jaringan</div>
                    <div class="sidebar-sub">DISKOMINFO</div>
                </div>
            </a>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('devices.index') }}" class="nav-item {{ request()->routeIs('devices.*') ? 'active' : '' }}">
                <x-device-icon type="router" class="w-5 h-5" />
                Perangkat
            </a>
            <a href="{{ route('opd-locations.index') }}" class="nav-item {{ request()->routeIs('opd-locations.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Lokasi OPD
            </a>
            <a href="{{ route('maintenance-logs.index') }}" class="nav-item {{ request()->routeIs('maintenance-logs.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Maintenance
            </a>
        </nav>
        <div class="sidebar-account">
            <div class="account-label">Akun</div>
            <div class="account-card">
                <div class="account-name">{{ Auth::user()->name }}</div>
                <div class="account-role">{{ Auth::user()->role === 'admin' ? '🔑 Administrator' : '👁️ Viewer' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    {{-- Main Content --}}
    <div class="app-main">
        {{-- Mobile Header --}}
        <header class="mobile-header">
            <button class="mobile-toggle" onclick="toggleSidebar()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div style="display:flex;align-items:center;gap:0.5rem;">
                <div class="sidebar-logo" style="width:32px;height:32px;">
                    <x-device-icon type="modem" class="w-4.5 h-4.5 text-white" />
                </div>
                <span style="font-weight:700;font-size:0.85rem;color:white;">Aset Jaringan</span>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="flash-success" id="flashMsg">
                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
            <script>setTimeout(() => { const el = document.getElementById('flashMsg'); if(el) el.style.display='none'; }, 4000);</script>
        @endif

        <main class="app-content">
            {{ $slot }}
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').style.display =
                document.getElementById('sidebar').classList.contains('open') ? 'block' : 'none';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').style.display = 'none';
        }
    </script>
    @stack('scripts')
</body>
</html>
