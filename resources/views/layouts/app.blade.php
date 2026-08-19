<!DOCTYPE html>
<html lang="id">
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
        :root { --primary: #2563eb; --primary-light: #60a5fa; --accent: #1d4ed8; }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif; margin: 0;
            background-color: #f4f7f9 !important; /* Very clean, professional light gray/blue */
            color: #334155 !important; min-height: 100vh;
        }

        /* Clean Backgrounds */
        .bg-white { background-color: #ffffff !important; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .bg-slate-50 { background-color: #f8fafc !important; }
        .bg-\[\#FDFDFC\] { background-color: #ffffff !important; }

        /* Form inputs clean flat style */
        input[type="text"], input[type="email"], input[type="password"],
        input[type="number"], input[type="url"], input[type="tel"],
        input[type="date"], input[type="datetime-local"],
        input[type="search"], input[type="file"],
        select, textarea {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #1e293b !important;
            border-radius: 6px !important;
            transition: all 0.2s ease;
        }
        input::placeholder, textarea::placeholder { color: #94a3b8 !important; }
        input:focus, select:focus, textarea:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15) !important;
            outline: none !important;
        }

        /* Table clean borders */
        table th { color: #475569 !important; font-weight: 600 !important; font-size: 0.85rem; border-bottom: 2px solid #e2e8f0; }
        table td { color: #334155; border-bottom: 1px solid #e2e8f0; }
        table tr:hover td { background-color: #f8fafc; }

        /* Pagination clean flat */
        nav[role="navigation"] span, nav[role="navigation"] a {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #475569 !important;
            border-radius: 6px !important;
            margin: 0 2px;
        }
        nav[role="navigation"] span[aria-current] {
            background-color: #2563eb !important;
            color: #ffffff !important; border-color: #2563eb !important;
        }
        nav[role="navigation"] a:hover {
            background-color: #f1f5f9 !important; color: #0f172a !important;
        }

        /* Scrollbar minimalistic */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* General layout overrides */
        .rounded-2xl { border-radius: 8px !important; }
        .p-8 { padding: 1.5rem !important; }
        .p-6 { padding: 1.25rem !important; }
        .p-4 { padding: 1rem !important; }
        .mb-6 { margin-bottom: 1rem !important; }
        .mb-5 { margin-bottom: 0.75rem !important; }
        .gap-4 { gap: 1rem !important; }
        .gap-3 { gap: 0.75rem !important; }
        .gap-2 { gap: 0.5rem !important; }
        .space-y-5 > * + * { margin-top: 1rem !important; }
        table td { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
        .text-2xl { font-size: 1.25rem !important; color: #0f172a !important; font-weight: 600 !important; }
        .grid.grid-cols-1.sm\:grid-cols-2.lg\:grid-cols-4 { gap: 1rem !important; }
        .grid.grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3 { gap: 1rem !important; }

        /* Typography */
        h1, h2, h3, h4, h5, h6 { color: #0f172a !important; }
        .text-gray-900 { color: #0f172a !important; }
        .text-gray-800 { color: #1e293b !important; }
        .text-gray-600 { color: #475569 !important; }
        .text-gray-500 { color: #64748b !important; }

        /* Remove ornaments */
        .app-orb { display: none !important; }
        body::before { display: none !important; }

        /* Sidebar Clean Flat */
        .app-sidebar {
            position: fixed; inset-y: 0; left: 0; z-index: 50; width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
            transform: translateX(-100%); transition: transform 0.3s ease;
            display: flex; flex-direction: column;
            box-shadow: none;
        }
        @media (min-width: 1024px) { .app-sidebar { transform: translateX(0); } }
        .app-sidebar.open { transform: translateX(0); }

        @media (min-width: 1024px) { .app-sidebar { width: 250px; } }
        .sidebar-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .sidebar-brand { display: flex; align-items: center; gap: 0.85rem; text-decoration: none; }
        .sidebar-logo {
            width: 36px; height: 36px; border-radius: 8px;
            background-color: #2563eb;
            display: flex; align-items: center; justify-content: center;
        }
        .sidebar-logo svg { width: 20px; height: 20px; color: white; }
        .sidebar-title { font-weight: 700; font-size: 0.95rem; color: #0f172a; line-height: 1.2; }
        .sidebar-sub { font-size: 0.65rem; color: #64748b; font-weight: 500; text-transform: uppercase; }

        /* Nav links */
        .sidebar-nav { padding: 1rem 0.75rem; flex: 1; display: flex; flex-direction: column; gap: 4px; }
        .nav-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.85rem; border-radius: 6px;
            font-size: 0.85rem; font-weight: 500; color: #475569;
            text-decoration: none; transition: all 0.2s ease; border: 1px solid transparent;
        }
        .nav-item:hover { color: #0f172a; background-color: #f1f5f9; }
        .nav-item.active {
            color: #2563eb; background-color: #eff6ff;
            font-weight: 600;
        }
        .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; color: #94a3b8; }
        .nav-item.active svg { color: #2563eb; }
        .nav-item:hover:not(.active) svg { color: #475569; }

        /* Account section */
        .sidebar-account {
            padding: 1rem 1.25rem; margin-top: auto;
            border-top: 1px solid #f1f5f9;
        }
        .account-label { font-size: 0.65rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.5rem; }
        .account-card {
            padding: 0.75rem 0.85rem; border-radius: 8px;
            background-color: #f8fafc; border: 1px solid #e2e8f0;
        }
        .account-name { font-size: 0.85rem; font-weight: 600; color: #1e293b; }
        .account-role { font-size: 0.7rem; color: #64748b; margin-top: 2px; }
        .logout-btn {
            display: flex; align-items: center; gap: 0.5rem; width: 100%;
            margin-top: 0.75rem; padding: 0.6rem 0.85rem; border-radius: 6px;
            font-size: 0.8rem; font-weight: 600; color: #ef4444;
            background-color: transparent; border: 1px solid transparent; cursor: pointer; transition: all 0.2s;
        }
        .logout-btn:hover { background-color: #fef2f2; }
        .logout-btn svg { width: 18px; height: 18px; }

        /* Main content */
        .app-main { position: relative; z-index: 1; min-height: 100vh; }
        @media (min-width: 1024px) { .app-main { margin-left: 250px; } }

        /* Mobile header */
        .mobile-header {
            position: sticky; top: 0; z-index: 40;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between;
        }
        @media (min-width: 1024px) { .mobile-header { display: none; } }
        .mobile-toggle {
            background: none; border: none; color: #64748b; cursor: pointer; padding: 0.25rem;
        }
        .mobile-toggle:hover { color: #0f172a; }
        .mobile-toggle svg { width: 24px; height: 24px; }

        /* Content area */
        .app-content { padding: 1.5rem; max-width: 1400px; margin: 0 auto; }

        /* Flash message */
        .flash-success {
            margin: 0 1.5rem 1rem; padding: 1rem; border-radius: 8px;
            background-color: #ecfdf5; border: 1px solid #34d399;
            color: #065f46; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;
        }
        .flash-success svg { width: 18px; height: 18px; flex-shrink: 0; color: #059669; }

        /* Overlay */
        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(15,23,42,0.4); z-index: 45;
            display: none;
        }

        /* Card overrides for dashboard content - Minimalist Flat */
        .glass-card {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03) !important;
            backdrop-filter: none !important;
            transition: none !important;
        }
        .glass-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
            transform: none !important;
        }
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
                <span style="font-weight:700;font-size:0.85rem;color:#0f172a;">Aset Jaringan</span>
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
