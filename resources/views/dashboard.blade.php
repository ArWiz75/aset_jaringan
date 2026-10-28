<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <style>
        .dash-card {
            background: rgba(22, 30, 46, 0.85);
            border: 1px solid rgba(99, 120, 150, 0.2);
            border-radius: 14px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.04);
            backdrop-filter: blur(8px);
        }
        .dash-card .card-glow { display: none; }
        .welcome-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #1a1035 100%);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 14px; padding: 1.5rem; position: relative;
            overflow: hidden; margin-bottom: 1rem;
            box-shadow: 0 8px 32px rgba(99,102,241,0.2), inset 0 1px 0 rgba(255,255,255,0.05);
        }
        .welcome-banner::before {
            content: ''; position: absolute; top: -80px; right: -60px;
            width: 320px; height: 320px; border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
        .stat-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; margin-bottom: 1rem; }
        @media (max-width: 1280px) { .stat-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px) { .stat-grid { grid-template-columns: 1fr; } }
        .stat-card { border-radius: 14px; padding: 1.2rem; position: relative; overflow: hidden; transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card-blue { border: 1px solid rgba(56,189,248,0.35); box-shadow: 0 0 20px rgba(56,189,248,0.08),0 4px 16px rgba(0,0,0,0.4),inset 0 1px 0 rgba(56,189,248,0.1); background: linear-gradient(135deg,rgba(14,22,36,0.9) 0%,rgba(7,35,55,0.7) 100%); }
        .stat-card-blue:hover { box-shadow: 0 0 30px rgba(56,189,248,0.18),0 8px 24px rgba(0,0,0,0.5); }
        .stat-card-green { border: 1px solid rgba(16,185,129,0.35); box-shadow: 0 0 20px rgba(16,185,129,0.08),0 4px 16px rgba(0,0,0,0.4),inset 0 1px 0 rgba(16,185,129,0.1); background: linear-gradient(135deg,rgba(13,22,20,0.9) 0%,rgba(5,40,30,0.7) 100%); }
        .stat-card-green:hover { box-shadow: 0 0 30px rgba(16,185,129,0.18),0 8px 24px rgba(0,0,0,0.5); }
        .stat-card-purple { border: 1px solid rgba(139,92,246,0.35); box-shadow: 0 0 20px rgba(139,92,246,0.08),0 4px 16px rgba(0,0,0,0.4),inset 0 1px 0 rgba(139,92,246,0.1); background: linear-gradient(135deg,rgba(18,13,30,0.9) 0%,rgba(35,15,60,0.7) 100%); }
        .stat-card-purple:hover { box-shadow: 0 0 30px rgba(139,92,246,0.18),0 8px 24px rgba(0,0,0,0.5); }
        .stat-card-amber { border: 1px solid rgba(245,158,11,0.35); box-shadow: 0 0 20px rgba(245,158,11,0.08),0 4px 16px rgba(0,0,0,0.4),inset 0 1px 0 rgba(245,158,11,0.1); background: linear-gradient(135deg,rgba(22,18,8,0.9) 0%,rgba(45,30,5,0.7) 100%); }
        .stat-card-amber:hover { box-shadow: 0 0 30px rgba(245,158,11,0.18),0 8px 24px rgba(0,0,0,0.5); }
        .stat-card-red { border: 1px solid rgba(239,68,68,0.35); box-shadow: 0 0 20px rgba(239,68,68,0.08),0 4px 16px rgba(0,0,0,0.4),inset 0 1px 0 rgba(239,68,68,0.1); background: linear-gradient(135deg,rgba(22,10,10,0.9) 0%,rgba(50,10,10,0.7) 100%); }
        .stat-card-red:hover { box-shadow: 0 0 30px rgba(239,68,68,0.18),0 8px 24px rgba(0,0,0,0.5); }
        .stat-value { font-size: 2rem; font-weight: 800; margin-top: 0.35rem; line-height: 1; letter-spacing: -0.02em; }
        .stat-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; }
        .stat-footer { font-size: 0.72rem; font-weight: 500; margin-top: 0.85rem; }
        .stat-footer span { font-weight: 700; }
        .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; }
        @media (max-width: 1280px) { .content-grid { grid-template-columns: 1fr; } }
        .chart-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media (max-width: 768px) { .chart-row { grid-template-columns: 1fr; } }
        .card-title { font-size: 0.95rem; font-weight: 700; color: #e2e8f0; }
        .card-subtitle { font-size: 0.78rem; color: #64748b; margin-top: 3px; }
        .timeline-dot { position: absolute; left: -5px; top: 6px; width: 12px; height: 12px; border-radius: 50%; border: 2px solid #0d1117; }
        .timeline-item { position: relative; padding-left: 1.25rem; padding-bottom: 1.25rem; border-left: 2px solid rgba(99,120,150,0.2); }
        .timeline-item:last-child { border-left-color: transparent; padding-bottom: 0; }
        .timeline-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(99,120,150,0.2); border-radius: 10px; padding: 0.85rem; transition: border-color 0.2s; }
        .timeline-card:hover { border-color: rgba(56,189,248,0.25); }
        .badge { font-size: 0.62rem; font-weight: 700; text-transform: uppercase; padding: 3px 8px; border-radius: 6px; letter-spacing: 0.05em; }
        .badge-green { color: #34d399; background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); }
        .badge-amber { color: #fbbf24; background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.3); }
        .badge-blue  { color: #38bdf8; background: rgba(56,189,248,0.15); border: 1px solid rgba(56,189,248,0.3); }
        .progress-bar-bg { width: 100%; height: 5px; background: rgba(255,255,255,0.07); border-radius: 99px; }
        .progress-bar-fill { height: 5px; border-radius: 99px; background: linear-gradient(90deg,#38bdf8,#818cf8); }
        .link-btn { display: block; text-align: center; font-size: 0.82rem; font-weight: 700; padding: 0.6rem; border-radius: 9px; text-decoration: none; transition: all 0.2s; border: 1px solid rgba(56,189,248,0.3); color: #38bdf8; background: rgba(56,189,248,0.08); }
        .link-btn:hover { background: rgba(56,189,248,0.15); border-color: rgba(56,189,248,0.5); color: #7dd3fc; }
        .link-btn-neutral { display: block; text-align: center; font-size: 0.82rem; font-weight: 700; padding: 0.6rem; border-radius: 9px; text-decoration: none; transition: all 0.2s; border: 1px solid rgba(99,120,150,0.25); color: #94a3b8; background: rgba(255,255,255,0.03); }
        .link-btn-neutral:hover { background: rgba(255,255,255,0.07); color: #e2e8f0; border-color: rgba(99,120,150,0.45); }
        .live-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); padding: 0.4rem 0.85rem; border-radius: 8px; box-shadow: 0 0 12px rgba(16,185,129,0.15); }
        .live-dot { position: relative; display: flex; width: 10px; height: 10px; }
        .live-dot .ping { position: absolute; inset: 0; border-radius: 50%; background: #6ee7b7; opacity: 0.75; animation: ping 1.5s cubic-bezier(0,0,0.2,1) infinite; }
        .live-dot .core { position: relative; width: 10px; height: 10px; border-radius: 50%; background: #10b981; }
        @keyframes ping { 75%, 100% { transform: scale(2); opacity: 0; } }
        .loc-item { text-decoration: none; display: block; margin-bottom: 0.85rem; }
        .loc-name { font-size: 0.83rem; font-weight: 600; color: #94a3b8; transition: color 0.2s; }
        .loc-item:hover .loc-name { color: #38bdf8; }
        .loc-count { font-size: 0.72rem; font-weight: 800; color: #e2e8f0; background: rgba(255,255,255,0.07); padding: 2px 8px; border-radius: 5px; border: 1px solid rgba(255,255,255,0.09); }
        .alert-purple { background: linear-gradient(135deg,rgba(30,18,50,0.95),rgba(46,16,80,0.9)); border: 1px solid rgba(139,92,246,0.4); border-left: 4px solid #8b5cf6; border-radius: 12px; box-shadow: 0 0 20px rgba(139,92,246,0.12),0 4px 16px rgba(0,0,0,0.4); padding: 1rem 1.25rem; margin-bottom: 1rem; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; }
        .alert-amber  { background: linear-gradient(135deg,rgba(30,22,8,0.95),rgba(55,35,5,0.9)); border: 1px solid rgba(245,158,11,0.4); border-left: 4px solid #f59e0b; border-radius: 12px; box-shadow: 0 0 20px rgba(245,158,11,0.12),0 4px 16px rgba(0,0,0,0.4); padding: 1rem 1.25rem; margin-bottom: 1rem; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; }
        .alert-emerald { background: linear-gradient(135deg,rgba(8,26,20,0.95),rgba(5,46,35,0.9)); border: 1px solid rgba(16,185,129,0.4); border-left: 4px solid #10b981; border-radius: 12px; box-shadow: 0 0 20px rgba(16,185,129,0.12),0 4px 16px rgba(0,0,0,0.4); padding: 1rem 1.25rem; margin-bottom: 1rem; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; }
        .alert-icon-box { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; flex-shrink: 0; }
        .alert-icon-purple { background: rgba(139,92,246,0.2); border: 1px solid rgba(139,92,246,0.35); }
        .alert-icon-amber  { background: rgba(245,158,11,0.2); border: 1px solid rgba(245,158,11,0.35); }
        .alert-icon-emerald { background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.35); }
        .btn-solid-purple { display:inline-flex;align-items:center;gap:5px;padding:0.45rem 0.9rem;background:linear-gradient(135deg,#7c3aed,#8b5cf6);color:#fff;border-radius:8px;font-size:0.8rem;font-weight:700;text-decoration:none;border:1px solid rgba(139,92,246,0.5);box-shadow:0 4px 12px rgba(139,92,246,0.35);transition:all 0.2s; }
        .btn-solid-purple:hover { background:linear-gradient(135deg,#6d28d9,#7c3aed);box-shadow:0 6px 16px rgba(139,92,246,0.5);color:#fff; }
        .btn-outline-purple { display:inline-flex;align-items:center;padding:0.45rem 0.9rem;background:rgba(139,92,246,0.1);color:#c4b5fd;border:1px solid rgba(139,92,246,0.4);border-radius:8px;font-size:0.8rem;font-weight:700;text-decoration:none;transition:all 0.2s; }
        .btn-outline-purple:hover { background:rgba(139,92,246,0.2);color:#ddd6fe; }
        .btn-solid-amber { display:inline-flex;align-items:center;gap:5px;padding:0.45rem 0.9rem;background:linear-gradient(135deg,#d97706,#f59e0b);color:#0d1117;border-radius:8px;font-size:0.8rem;font-weight:700;text-decoration:none;border:1px solid rgba(245,158,11,0.5);box-shadow:0 4px 12px rgba(245,158,11,0.3);transition:all 0.2s; }
        .btn-solid-amber:hover { background:linear-gradient(135deg,#b45309,#d97706);box-shadow:0 6px 16px rgba(245,158,11,0.4); }
        .btn-outline-amber { display:inline-flex;align-items:center;padding:0.45rem 0.9rem;background:rgba(245,158,11,0.1);color:#fcd34d;border:1px solid rgba(245,158,11,0.35);border-radius:8px;font-size:0.8rem;font-weight:700;text-decoration:none;transition:all 0.2s; }
        .btn-outline-amber:hover { background:rgba(245,158,11,0.2);color:#fde68a; }
        .btn-solid-emerald { display:inline-flex;align-items:center;gap:5px;padding:0.45rem 0.9rem;background:linear-gradient(135deg,#059669,#10b981);color:#fff;border-radius:8px;font-size:0.8rem;font-weight:700;text-decoration:none;border:1px solid rgba(16,185,129,0.5);box-shadow:0 4px 12px rgba(16,185,129,0.3);transition:all 0.2s; }
        .btn-solid-emerald:hover { background:linear-gradient(135deg,#047857,#059669);box-shadow:0 6px 16px rgba(16,185,129,0.45);color:#fff; }
        .btn-outline-emerald { display:inline-flex;align-items:center;padding:0.45rem 0.9rem;background:rgba(16,185,129,0.1);color:#6ee7b7;border:1px solid rgba(16,185,129,0.35);border-radius:8px;font-size:0.8rem;font-weight:700;text-decoration:none;transition:all 0.2s; }
        .btn-outline-emerald:hover { background:rgba(16,185,129,0.2);color:#a7f3d0; }
    </style>

    {{-- Welcome Banner --}}
    <div class="welcome-banner">
        <div style="position:relative;z-index:1;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:0.75rem;">
            <div>
                <h1 style="font-size:1.3rem;font-weight:800;color:#f1f5f9;margin:0 0 0.3rem;letter-spacing:-0.01em;">
                    Halo, {{ auth()->user()->name }} 👋
                </h1>
                <p style="font-size:0.83rem;color:#94a3b8;margin:0;max-width:500px;line-height:1.6;">
                    Ringkasan status aset jaringan daerah saat ini. Pantau performa dan kondisi perangkat secara real-time.
                </p>
            </div>
            <div class="live-badge">
                <div class="live-dot"><span class="ping"></span><span class="core"></span></div>
                <div>
                    <div style="font-size:0.68rem;font-weight:800;color:#34d399;text-transform:uppercase;letter-spacing:0.08em;">System Live</div>
                    <div style="font-size:0.63rem;color:#64748b;font-weight:500;margin-top:1px;">{{ now()->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert: Perlu Diganti --}}
    @if($replaceDevices > 0)
    <div class="alert-purple">
        <div style="display:flex;align-items:center;gap:0.85rem;">
            <div class="alert-icon-box alert-icon-purple">🔄</div>
            <div>
                <div style="font-weight:800;font-size:0.92rem;color:#c4b5fd;">Terdapat {{ $replaceDevices }} Perangkat Direkomendasikan untuk Diganti</div>
                <div style="font-size:0.78rem;color:#7c6aa0;margin-top:2px;line-height:1.5;">Perangkat memerlukan pergantian segera untuk pertimbangan pimpinan dan perencanaan pengadaan perangkat pengganti.</div>
            </div>
        </div>
        <div style="display:flex;gap:0.5rem;flex-shrink:0;">
            <a href="{{ route('export.devices.replacement.print') }}" target="_blank" class="btn-solid-purple">
                <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Usulan
            </a>
            <a href="{{ route('devices.index', ['status' => 'Perlu Diganti']) }}" class="btn-outline-purple">Lihat Daftar</a>
        </div>
    </div>
    @endif

    {{-- Alert: OPD Kosong --}}
    @if(isset($emptyLocations) && $emptyLocations > 0)
    <div class="alert-amber">
        <div style="display:flex;align-items:center;gap:0.85rem;">
            <div class="alert-icon-box alert-icon-amber">⚠️</div>
            <div>
                <div style="font-weight:800;font-size:0.92rem;color:#fcd34d;">Terdapat {{ $emptyLocations }} Lokasi OPD Belum Terpasang Perangkat Internet</div>
                <div style="font-size:0.78rem;color:#92703a;margin-top:2px;line-height:1.5;">Lokasi OPD belum memiliki Router, Switch, atau Access Point. Segera ajukan rekomendasi pengadaan untuk dilaporkan ke pimpinan.</div>
            </div>
        </div>
        <div style="display:flex;gap:0.5rem;flex-shrink:0;">
            <a href="{{ route('device-proposals.index') }}" class="btn-solid-amber">
                <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Ajukan Usulan
            </a>
            <a href="{{ route('export.proposals.print') }}" target="_blank" class="btn-outline-amber">Cetak Usulan</a>
        </div>
    </div>
    @endif

    {{-- Alert: Usulan Baru --}}
    @if(isset($pendingProposals) && $pendingProposals > 0 && (!isset($emptyLocations) || $emptyLocations == 0))
    <div class="alert-emerald">
        <div style="display:flex;align-items:center;gap:0.85rem;">
            <div class="alert-icon-box alert-icon-emerald">📋</div>
            <div>
                <div style="font-weight:800;font-size:0.92rem;color:#6ee7b7;">Terdapat {{ $pendingProposals }} Usulan Penambahan Perangkat Baru</div>
                <div style="font-size:0.78rem;color:#3a7060;margin-top:2px;line-height:1.5;">Daftar rekomendasi pengadaan perangkat jaringan sedang dalam proses peninjauan untuk dilaporkan ke pimpinan.</div>
            </div>
        </div>
        <div style="display:flex;gap:0.5rem;flex-shrink:0;">
            <a href="{{ route('device-proposals.index') }}" class="btn-solid-emerald">Kelola Usulan</a>
            <a href="{{ route('export.proposals.print') }}" target="_blank" class="btn-outline-emerald">Cetak Laporan</a>
        </div>
    </div>
    @endif

    {{-- Stats Grid --}}
    <div class="stat-grid">
        <div class="stat-card stat-card-blue">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                <div>
                    <div class="stat-label" style="color:#38bdf8;">Total Perangkat</div>
                    <div class="stat-value" style="color:#e2e8f0;">{{ $totalDevices }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(56,189,248,0.15);border:1px solid rgba(56,189,248,0.3);color:#38bdf8;">
                    <svg style="width:22px;height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                </div>
            </div>
            <div class="stat-footer" style="color:#64748b;">Tersebar di <span style="color:#38bdf8;">{{ $totalLocations }}</span> Lokasi OPD</div>
        </div>
        <div class="stat-card stat-card-green">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                <div>
                    <div class="stat-label" style="color:#10b981;">Perangkat Aktif</div>
                    <div class="stat-value" style="color:#e2e8f0;">{{ $activeDevices }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(16,185,129,0.15);border:1px solid rgba(16,185,129,0.3);color:#10b981;">
                    <svg style="width:22px;height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <div class="stat-footer" style="color:#64748b;"><span style="color:#34d399;">{{ $totalDevices > 0 ? round(($activeDevices/$totalDevices)*100) : 0 }}%</span> dari total perangkat</div>
        </div>
        <div class="stat-card stat-card-purple">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                <div>
                    <div class="stat-label" style="color:#a78bfa;">Perlu Diganti</div>
                    <div class="stat-value" style="color:#c4b5fd;">{{ $replaceDevices }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(139,92,246,0.15);border:1px solid rgba(139,92,246,0.3);color:#a78bfa;">
                    <svg style="width:22px;height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
            </div>
            <div class="stat-footer" style="color:#64748b;"><a href="{{ route('devices.index', ['status' => 'Perlu Diganti']) }}" style="color:#a78bfa;font-weight:700;text-decoration:none;">Usulan pengadaan →</a></div>
        </div>
        <div class="stat-card stat-card-amber">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                <div>
                    <div class="stat-label" style="color:#f59e0b;">Dalam Perbaikan</div>
                    <div class="stat-value" style="color:#e2e8f0;">{{ $maintenanceDevices }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(245,158,11,0.15);border:1px solid rgba(245,158,11,0.3);color:#f59e0b;">
                    <svg style="width:22px;height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                </div>
            </div>
            <div class="stat-footer" style="color:#64748b;">Terdapat <span style="color:#fbbf24;">{{ $pendingMaintenance }}</span> log pending</div>
        </div>
        <div class="stat-card stat-card-red">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                <div>
                    <div class="stat-label" style="color:#f87171;">Perangkat Rusak</div>
                    <div class="stat-value" style="color:#e2e8f0;">{{ $brokenDevices }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#f87171;">
                    <svg style="width:22px;height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="stat-footer" style="color:#64748b;">Perlu <span style="color:#f87171;">tindakan</span> segera</div>
        </div>
    </div>

    {{-- Charts + Activity --}}
    <div class="content-grid">
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="dash-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <div>
                        <div class="card-title">Distribusi Tipe Perangkat</div>
                        <div class="card-subtitle">Komposisi infrastruktur jaringan saat ini</div>
                    </div>
                </div>
                <div style="position:relative;height:200px;width:100%;"><canvas id="typeChart"></canvas></div>
            </div>
            <div class="chart-row">
                <div class="dash-card">
                    <div style="margin-bottom:1rem;">
                        <div class="card-title">Status Kesehatan</div>
                        <div class="card-subtitle">Proporsi kondisi perangkat</div>
                    </div>
                    <div style="position:relative;height:180px;width:100%;display:flex;justify-content:center;"><canvas id="statusChart"></canvas></div>
                </div>
                <div class="dash-card" style="display:flex;flex-direction:column;">
                    <div style="margin-bottom:1rem;">
                        <div class="card-title">Top Lokasi</div>
                        <div class="card-subtitle">OPD dengan perangkat terbanyak</div>
                    </div>
                    <div style="flex:1;overflow-y:auto;">
                        @foreach($devicesPerLocation->take(4) as $loc)
                        <a href="{{ route('opd-locations.show', $loc) }}" class="loc-item">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                                <span class="loc-name">{{ $loc->nama }}</span>
                                <span class="loc-count">{{ $loc->devices_count }}</span>
                            </div>
                            <div class="progress-bar-bg"><div class="progress-bar-fill" style="width:{{ $totalDevices > 0 ? ($loc->devices_count / $totalDevices) * 100 : 0 }}%"></div></div>
                        </a>
                        @endforeach
                    </div>
                    <a href="{{ route('opd-locations.index') }}" class="link-btn" style="margin-top:1rem;">Lihat Semua</a>
                </div>
            </div>
        </div>
        <div class="dash-card" style="display:flex;flex-direction:column;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                <div>
                    <div class="card-title">Aktivitas Maintenance</div>
                    <div class="card-subtitle">Log perbaikan terbaru</div>
                </div>
            </div>
            <div style="flex:1;">
                @forelse($recentMaintenance as $log)
                <div class="timeline-item">
                    <div class="timeline-dot" style="background-color:{{ $log->status === 'Selesai' ? '#10b981' : ($log->status === 'Pending' ? '#f59e0b' : '#38bdf8') }};"></div>
                    <div class="timeline-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.45rem;">
                            <span style="font-size:0.83rem;font-weight:700;color:#e2e8f0;">{{ $log->device->merk ?? 'Perangkat' }}</span>
                            <span class="badge {{ $log->status === 'Selesai' ? 'badge-green' : ($log->status === 'Pending' ? 'badge-amber' : 'badge-blue') }}">{{ $log->status }}</span>
                        </div>
                        <p style="font-size:0.78rem;color:#64748b;margin:0 0 0.45rem;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $log->deskripsi }}</p>
                        <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.68rem;color:#475569;font-weight:600;">
                            <span>{{ $log->jenis }}</span>
                            <span>{{ $log->tanggal->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem 0;">
                    <svg style="width:40px;height:40px;margin-bottom:0.5rem;color:#334155;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <p style="font-size:0.83rem;margin:0;font-weight:600;color:#475569;">Belum ada aktivitas</p>
                </div>
                @endforelse
            </div>
            <a href="{{ route('maintenance-logs.index') }}" class="link-btn-neutral" style="margin-top:1rem;">Lihat Semua Log Maintenance</a>
        </div>
    </div>

    @push('scripts')
    <script>
        const statusData = @json($devicesByStatus);
        const typeData = @json($devicesByType);
        const statusColors = { 'Aktif': '#10b981', 'Perlu Diganti': '#8b5cf6', 'Rusak': '#ef4444', 'Maintenance': '#f59e0b', 'Nonaktif': '#475569' };
        const typeColors = ['#38bdf8','#a78bfa','#fbbf24','#34d399','#f87171','#818cf8'];
        Chart.defaults.color = '#64748b';
        Chart.defaults.font.family = "'Inter', sans-serif";
        const tooltipStyle = { backgroundColor: '#1e2736', titleColor: '#f1f5f9', bodyColor: '#94a3b8', borderColor: 'rgba(99,120,150,0.3)', borderWidth: 1, padding: 12, cornerRadius: 10, titleFont: { size: 13, weight: '700' }, bodyFont: { size: 12 }, boxPadding: 6 };
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: { labels: Object.keys(statusData), datasets: [{ data: Object.values(statusData), backgroundColor: Object.keys(statusData).map(k => statusColors[k] || '#475569'), borderColor: '#0d1117', borderWidth: 3 }] },
            options: { responsive: true, maintainAspectRatio: false, cutout: '72%', plugins: { tooltip: tooltipStyle, legend: { position: 'right', labels: { padding: 14, usePointStyle: true, pointStyle: 'circle', font: { size: 11 }, color: '#64748b' } } } }
        });
        new Chart(document.getElementById('typeChart'), {
            type: 'bar',
            data: { labels: Object.keys(typeData), datasets: [{ label: 'Total', data: Object.values(typeData), backgroundColor: typeColors.map(c => c + '33'), borderColor: typeColors, borderWidth: 2, borderRadius: 6, barPercentage: 0.55 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { tooltip: tooltipStyle, legend: { display: false } }, scales: { x: { ticks: { font: { size: 11, weight: '600' }, color: '#64748b' }, grid: { display: false }, border: { color: 'rgba(99,120,150,0.15)' } }, y: { beginAtZero: true, ticks: { font: { size: 11 }, stepSize: 1, padding: 10, color: '#64748b' }, grid: { color: 'rgba(255,255,255,0.04)', borderDash: [4,4] }, border: { display: false } } } }
        });
    </script>
    @endpush
</x-app-layout>
