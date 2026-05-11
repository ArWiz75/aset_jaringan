<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Manajemen Aset Jaringan</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif; margin: 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #162032 100%);
            color: #e2e8f0; min-height: 100vh;
            display: flex; align-items: center; justify-content: center; padding: 1rem;
            position: relative; overflow: hidden;
        }
        body::before {
            content: ''; position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(148,163,184,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148,163,184,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .orb { position: fixed; border-radius: 50%; filter: blur(100px); opacity: 0.15; pointer-events: none; }
        .orb-1 { width: 400px; height: 400px; background: #4a6fa5; top: -15%; right: 10%; animation: orbF 12s ease-in-out infinite alternate; }
        .orb-2 { width: 300px; height: 300px; background: #38bdf8; bottom: 5%; left: -5%; animation: orbF 10s ease-in-out infinite alternate-reverse; }
        @keyframes orbF { 0% { transform: translateY(0); } 100% { transform: translateY(-25px); } }

        .auth-container { width: 100%; max-width: 420px; position: relative; z-index: 1; }
        .auth-header { text-align: center; margin-bottom: 2rem; }
        .auth-logo {
            width: 56px; height: 56px; border-radius: 16px;
            background: linear-gradient(135deg, #38bdf8, #4a6fa5);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem; box-shadow: 0 8px 25px rgba(56,189,248,0.25);
        }
        .auth-logo svg { width: 28px; height: 28px; color: white; }
        .auth-title { font-size: 1.5rem; font-weight: 800; color: white; margin: 0 0 0.35rem; }
        .auth-sub { font-size: 0.8rem; color: #64748b; margin: 0; }

        .auth-card {
            background: rgba(15,23,42,0.6); backdrop-filter: blur(24px);
            border: 1px solid rgba(148,163,184,0.08); border-radius: 20px;
            padding: 2rem;
        }
        .auth-footer { text-align: center; font-size: 0.7rem; color: #334155; margin-top: 1.5rem; }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-logo">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
            </div>
            <h1 class="auth-title">Manajemen Aset Jaringan</h1>
            <p class="auth-sub">Dinas Komunikasi dan Informatika</p>
        </div>
        <div class="auth-card">
            {{ $slot }}
        </div>
        <p class="auth-footer">&copy; {{ date('Y') }} DISKOMINFO. All rights reserved.</p>
    </div>
</body>
</html>
