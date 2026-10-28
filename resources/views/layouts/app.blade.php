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
        /* ===== DARK MODE THEME ===== */
        :root {
            --primary: #38bdf8;
            --primary-light: #7dd3fc;
            --accent: #0ea5e9;
            --bg-base: #0d1117;
            --bg-surface: #161b22;
            --bg-elevated: #1c2333;
            --bg-card: #1e2736;
            --border: rgba(99, 120, 150, 0.25);
            --text-primary: #e2e8f0;
            --text-secondary: #8b9ab1;
            --text-muted: #5a6a80;
            --sidebar-bg: #161b22;
            --sidebar-border: rgba(99,120,150,0.2);
        }
        * { box-sizing: border-box; }

        html, body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: var(--bg-base) !important;
            color: var(--text-primary) !important;
            min-height: 100vh;
        }

        /* ── Background overrides ── */
        .bg-white { background-color: var(--bg-card) !important; box-shadow: 0 1px 4px rgba(0,0,0,0.4); }
        .bg-slate-50 { background-color: var(--bg-elevated) !important; }
        .bg-\[\#FDFDFC\] { background-color: var(--bg-card) !important; }

        /* ── Form inputs ── */
        input[type="text"], input[type="email"], input[type="password"],
        input[type="number"], input[type="url"], input[type="tel"],
        input[type="date"], input[type="datetime-local"],
        input[type="search"], input[type="file"],
        select, textarea {
            background-color: var(--bg-elevated) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-primary) !important;
            border-radius: 7px !important;
            transition: all 0.2s ease;
        }
        input::placeholder, textarea::placeholder { color: var(--text-muted) !important; }
        input:focus, select:focus, textarea:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.18) !important;
            outline: none !important;
        }
        select option { background-color: var(--bg-elevated); color: var(--text-primary); }

        /* ── Tables ── */
        table th {
            color: var(--text-secondary) !important;
            font-weight: 600 !important;
            font-size: 0.82rem;
            border-bottom: 1px solid var(--border);
            background-color: var(--bg-elevated);
        }
        table td { color: var(--text-primary); border-bottom: 1px solid var(--border); }
        table tr:hover td { background-color: rgba(56, 189, 248, 0.04); }

        /* ── Pagination ── */
        nav[role="navigation"] span, nav[role="navigation"] a {
            background-color: var(--bg-elevated) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-secondary) !important;
            border-radius: 7px !important;
            margin: 0 2px;
            transition: all 0.15s;
        }
        nav[role="navigation"] span[aria-current] {
            background-color: var(--primary) !important;
            color: #0d1117 !important;
            border-color: var(--primary) !important;
            font-weight: 700;
        }
        nav[role="navigation"] a:hover {
            background-color: var(--bg-card) !important;
            color: var(--text-primary) !important;
            border-color: rgba(56,189,248,0.3) !important;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(99,120,150,0.35); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(56,189,248,0.45); }

        /* ── Layout spacing ── */
        .rounded-2xl { border-radius: 12px !important; }
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
        .text-2xl { font-size: 1.25rem !important; color: var(--text-primary) !important; font-weight: 600 !important; }
        .grid.grid-cols-1.sm\:grid-cols-2.lg\:grid-cols-4 { gap: 1rem !important; }
        .grid.grid-cols-1.md\:grid-cols-2.lg\:grid-cols-3 { gap: 1rem !important; }

        /* ── Typography ── */
        h1, h2, h3, h4, h5, h6 { color: var(--text-primary) !important; }
        .text-gray-900 { color: var(--text-primary) !important; }
        .text-gray-800 { color: #c8d6e8 !important; }
        .text-gray-600 { color: var(--text-secondary) !important; }
        .text-gray-500 { color: var(--text-muted) !important; }

        /* ── Remove ornaments ── */
        .app-orb { display: none !important; }
        body::before { display: none !important; }

        /* ── Sidebar Dark Glassmorphism ── */
        .app-sidebar {
            position: fixed; inset-y: 0; left: 0; z-index: 50; width: 250px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            transform: translateX(-100%); transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            display: flex; flex-direction: column;
            box-shadow: 4px 0 24px rgba(0,0,0,0.5);
        }
        @media (min-width: 1024px) { .app-sidebar { transform: translateX(0); } }
        .app-sidebar.open { transform: translateX(0); }
        @media (min-width: 1024px) { .app-sidebar { width: 250px; } }

        .sidebar-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--sidebar-border);
        }
        .sidebar-brand { display: flex; align-items: center; gap: 0.85rem; text-decoration: none; }
        .sidebar-logo {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(14,165,233,0.4);
        }
        .sidebar-logo svg { width: 20px; height: 20px; color: white; }
        .sidebar-title { font-weight: 800; font-size: 0.95rem; color: var(--text-primary); line-height: 1.2; }
        .sidebar-sub { font-size: 0.62rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; }

        /* ── Nav links dark ── */
        .sidebar-nav { padding: 1rem 0.75rem; flex: 1; display: flex; flex-direction: column; gap: 3px; }
        .nav-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.85rem; border-radius: 8px;
            font-size: 0.85rem; font-weight: 500; color: var(--text-secondary);
            text-decoration: none; transition: all 0.2s ease; border: 1px solid transparent;
        }
        .nav-item:hover {
            color: var(--text-primary);
            background-color: rgba(56, 189, 248, 0.08);
            border-color: rgba(56, 189, 248, 0.15);
        }
        .nav-item.active {
            color: var(--primary);
            background: rgba(56, 189, 248, 0.12);
            border-color: rgba(56, 189, 248, 0.25);
            font-weight: 700;
            box-shadow: inset 0 0 0 1px rgba(56,189,248,0.1);
        }
        .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; color: var(--text-muted); transition: color 0.2s; }
        .nav-item.active svg { color: var(--primary); }
        .nav-item:hover:not(.active) svg { color: var(--text-secondary); }

        /* ── Account section dark ── */
        .sidebar-account {
            padding: 1rem 1.25rem; margin-top: auto;
            border-top: 1px solid var(--sidebar-border);
        }
        .account-label { font-size: 0.62rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.5rem; }
        .account-card {
            padding: 0.75rem 0.85rem; border-radius: 8px;
            background-color: var(--bg-elevated); border: 1px solid var(--border);
        }
        .account-name { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); }
        .account-role { font-size: 0.7rem; color: var(--text-muted); margin-top: 2px; }
        .logout-btn {
            display: flex; align-items: center; gap: 0.5rem; width: 100%;
            margin-top: 0.75rem; padding: 0.6rem 0.85rem; border-radius: 7px;
            font-size: 0.8rem; font-weight: 600; color: #f87171;
            background-color: transparent; border: 1px solid transparent; cursor: pointer; transition: all 0.2s;
        }
        .logout-btn:hover { background-color: rgba(239,68,68,0.12); border-color: rgba(239,68,68,0.25); }
        .logout-btn svg { width: 18px; height: 18px; }

        /* ── Main content ── */
        .app-main { position: relative; min-height: 100vh; }
        @media (min-width: 1024px) { .app-main { margin-left: 250px; } }

        /* ── Mobile header dark ── */
        .mobile-header {
            position: sticky; top: 0; z-index: 40;
            background-color: var(--sidebar-bg);
            border-bottom: 1px solid var(--sidebar-border);
            padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between;
            backdrop-filter: blur(8px);
        }
        @media (min-width: 1024px) { .mobile-header { display: none; } }
        .mobile-toggle {
            background: none; border: none; color: var(--text-secondary); cursor: pointer; padding: 0.25rem;
        }
        .mobile-toggle:hover { color: var(--text-primary); }
        .mobile-toggle svg { width: 24px; height: 24px; }

        /* ── Content area ── */
        .app-content { padding: 1.5rem; max-width: 1400px; margin: 0 auto; }

        /* ── Toast Notification dark ── */
        .toast-notification {
            position: fixed; top: 1.5rem; right: 1.5rem; z-index: 99999;
            display: flex; align-items: flex-start; gap: 0.85rem;
            min-width: 320px; max-width: 440px;
            padding: 1rem 1.25rem 1.15rem;
            background: var(--bg-card);
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6), 0 0 0 1px var(--border);
            border: 1px solid var(--border);
            overflow: hidden;
            animation: toastSlideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            transition: all 0.3s ease;
        }
        .toast-notification.toast-hide {
            opacity: 0;
            transform: translateX(110%);
        }
        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateX(110%) scale(0.95); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }
        .toast-notification.toast-success { border-left: 4px solid #10b981; }
        .toast-notification.toast-error { border-left: 4px solid #ef4444; }
        .toast-icon {
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 1px;
        }
        .toast-success .toast-icon { background: rgba(16,185,129,0.15); color: #34d399; }
        .toast-error .toast-icon { background: rgba(239,68,68,0.15); color: #f87171; }
        .toast-body { flex: 1; }
        .toast-title { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); line-height: 1.2; }
        .toast-message { font-size: 0.825rem; color: var(--text-secondary); margin-top: 0.25rem; line-height: 1.4; }
        .toast-close {
            background: transparent; border: none; color: var(--text-muted); cursor: pointer;
            padding: 4px; border-radius: 6px; display: flex; align-items: center; justify-content: center;
            transition: all 0.15s; margin-top: -2px; margin-right: -4px;
        }
        .toast-close:hover { color: var(--text-primary); background: var(--bg-elevated); }
        .toast-progress {
            position: absolute; bottom: 0; left: 0; height: 3px; width: 100%;
            animation: toastProgress 4.5s linear forwards;
        }
        .toast-success .toast-progress { background: linear-gradient(90deg, #059669, #10b981); }
        .toast-error .toast-progress { background: linear-gradient(90deg, #dc2626, #ef4444); }
        @keyframes toastProgress { from { width: 100%; } to { width: 0%; } }

        /* ── Overlay ── */
        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 45;
            display: none; backdrop-filter: blur(3px);
        }

        /* ── Glass cards dark ── */
        .glass-card {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.35) !important;
            backdrop-filter: blur(8px);
            transition: box-shadow 0.2s ease !important;
        }
        .glass-card:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.5) !important;
        }

        /* ── Tailwind dark: class overrides ── */
        .dark\:bg-slate-900 { background-color: var(--bg-card) !important; }
        .dark\:bg-slate-800 { background-color: var(--bg-elevated) !important; }
        .dark\:border-slate-800 { border-color: var(--border) !important; }
        .dark\:text-white { color: var(--text-primary) !important; }
        .dark\:text-slate-300 { color: #cbd5e1 !important; }
        .dark\:text-slate-400 { color: var(--text-secondary) !important; }
        .dark\:text-slate-500 { color: var(--text-muted) !important; }
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
            <a href="{{ route('devices.index', ['status' => 'Perlu Diganti']) }}" class="nav-item {{ request('status') === 'Perlu Diganti' ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Perlu Diganti
            </a>
            <a href="{{ route('device-proposals.index') }}" class="nav-item {{ request()->routeIs('device-proposals.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Usulan Perangkat</span>
                @php
                    $pendingPropCount = \App\Models\DeviceProposal::whereIn('status', ['Diusulkan', 'Dalam Pengadaan'])->count();
                @endphp
                @if($pendingPropCount > 0)
                <span style="margin-left: auto; font-size: 0.65rem; font-weight: 700; padding: 1px 6px; border-radius: 999px; background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                    {{ $pendingPropCount }}
                </span>
                @endif
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
                <span style="font-weight:700;font-size:0.85rem;color:#e2e8f0;">Aset Jaringan</span>
            </div>
        </header>

        {{-- Toast Notification --}}
        @if(session('success') || session('status') || session('error'))
            @php
                $isError = session()->has('error');
                $message = session('success') ?? session('status') ?? session('error');
            @endphp
            <div id="toastNotification" class="toast-notification {{ $isError ? 'toast-error' : 'toast-success' }}" role="alert">
                <div class="toast-icon">
                    @if($isError)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    @endif
                </div>
                <div class="toast-body">
                    <div class="toast-title">{{ $isError ? 'Terjadi Kesalahan' : 'Berhasil!' }}</div>
                    <div class="toast-message">{{ $message }}</div>
                </div>
                <button type="button" class="toast-close" onclick="closeToast()" title="Tutup">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div class="toast-progress"></div>
            </div>
            <script>
                function closeToast() {
                    const el = document.getElementById('toastNotification');
                    if (el) {
                        el.classList.add('toast-hide');
                        setTimeout(() => { if (el) el.remove(); }, 300);
                    }
                }
                setTimeout(closeToast, 4500);
            </script>
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
