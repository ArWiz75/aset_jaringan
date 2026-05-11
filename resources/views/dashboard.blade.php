<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <style>
        .dash-card {
            background: rgba(15,23,42,0.5); backdrop-filter: blur(16px);
            border: 1px solid rgba(148,163,184,0.08); border-radius: 10px;
            padding: 0.85rem; position: relative; overflow: hidden;
            transition: all 0.3s;
        }
        .dash-card:hover { border-color: rgba(148,163,184,0.15); }
        .dash-card .card-glow {
            position: absolute; top: -30px; right: -30px; width: 100px; height: 100px;
            border-radius: 50%; filter: blur(40px); opacity: 0.15; transition: opacity 0.5s;
        }
        .dash-card:hover .card-glow { opacity: 0.25; }

        .welcome-banner {
            background: linear-gradient(135deg, rgba(15,23,42,0.7), rgba(30,58,95,0.5));
            backdrop-filter: blur(16px); border: 1px solid rgba(148,163,184,0.08);
            border-radius: 10px; padding: 1rem; position: relative; overflow: hidden; margin-bottom: 0.75rem;
        }
        .welcome-banner::before {
            content: ''; position: absolute; top: -50%; right: -20%;
            width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(56,189,248,0.08), transparent 70%);
            pointer-events: none;
        }

        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.5rem; margin-bottom: 0.75rem; }
        @media (max-width: 1024px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px) { .stat-grid { grid-template-columns: 1fr; } }

        .stat-value { font-size: 1.5rem; font-weight: 800; color: white; letter-spacing: -0.02em; }
        .stat-label { font-size: 0.7rem; font-weight: 500; color: #64748b; margin-bottom: 0.15rem; }
        .stat-footer { font-size: 0.65rem; color: #475569; margin-top: 0.5rem; }
        .stat-footer span { font-weight: 600; }

        .stat-icon {
            width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;
            transition: transform 0.3s;
        }
        .dash-card:hover .stat-icon { transform: scale(1.1); }

        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 0.5rem; }
        @media (max-width: 1280px) { .content-grid { grid-template-columns: 1fr; } }

        .chart-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; }
        @media (max-width: 768px) { .chart-row { grid-template-columns: 1fr; } }

        .card-title { font-size: 0.85rem; font-weight: 700; color: white; }
        .card-subtitle { font-size: 0.7rem; color: #475569; margin-top: 2px; }

        .timeline-dot {
            position: absolute; left: -6px; top: 5px; width: 10px; height: 10px;
            border-radius: 50%; border: 2px solid #0f172a;
        }
        .timeline-item {
            position: relative; padding-left: 1rem; padding-bottom: 0.5rem;
            border-left: 2px solid rgba(148,163,184,0.1);
        }
        .timeline-item:last-child { border-left-color: transparent; padding-bottom: 0; }
        .timeline-card {
            background: rgba(255,255,255,0.03); border: 1px solid rgba(148,163,184,0.06);
            border-radius: 12px; padding: 0.75rem; transition: border-color 0.25s;
        }
        .timeline-card:hover { border-color: rgba(148,163,184,0.15); }

        .badge {
            font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
            padding: 2px 8px; border-radius: 6px;
        }
        .badge-green { color: #34d399; background: rgba(16,185,129,0.12); }
        .badge-amber { color: #fbbf24; background: rgba(245,158,11,0.12); }
        .badge-blue { color: #60a5fa; background: rgba(59,130,246,0.12); }

        .progress-bar-bg { width: 100%; height: 4px; background: rgba(148,163,184,0.1); border-radius: 99px; }
        .progress-bar-fill { height: 4px; border-radius: 99px; background: linear-gradient(90deg, #38bdf8, #4a6fa5); }

        .link-btn {
            display: block; text-align: center; font-size: 0.75rem; font-weight: 600;
            padding: 0.5rem; border-radius: 10px; text-decoration: none; transition: all 0.25s;
            border: 1px solid rgba(56,189,248,0.15); color: #38bdf8;
            background: rgba(56,189,248,0.05);
        }
        .link-btn:hover { background: rgba(56,189,248,0.1); border-color: rgba(56,189,248,0.3); }

        .link-btn-neutral {
            display: block; text-align: center; font-size: 0.75rem; font-weight: 600;
            padding: 0.6rem; border-radius: 10px; text-decoration: none; transition: all 0.25s;
            border: 1px solid rgba(148,163,184,0.1); color: #94a3b8;
            background: rgba(255,255,255,0.03);
        }
        .link-btn-neutral:hover { background: rgba(255,255,255,0.06); color: white; border-color: rgba(148,163,184,0.2); }

        .live-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.04); border: 1px solid rgba(148,163,184,0.08);
            padding: 0.4rem 0.85rem; border-radius: 10px;
        }
        .live-dot { position: relative; display: flex; width: 10px; height: 10px; }
        .live-dot .ping { position: absolute; inset: 0; border-radius: 50%; background: #34d399; opacity: 0.75; animation: ping 1.5s cubic-bezier(0,0,0.2,1) infinite; }
        .live-dot .core { position: relative; width: 10px; height: 10px; border-radius: 50%; background: #10b981; }
        @keyframes ping { 75%, 100% { transform: scale(2); opacity: 0; } }

        .loc-item { text-decoration: none; display: block; margin-bottom: 0.6rem; }
        .loc-name { font-size: 0.75rem; font-weight: 600; color: #94a3b8; transition: color 0.2s; }
        .loc-item:hover .loc-name { color: #38bdf8; }
        .loc-count {
            font-size: 0.65rem; font-weight: 700; color: white;
            background: rgba(255,255,255,0.06); padding: 1px 6px; border-radius: 4px;
        }
    </style>

    {{-- Welcome Banner --}}
    <div class="welcome-banner">
        <div style="position:relative;z-index:1;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:0.75rem;">
            <div>
                <h1 style="font-size:1.15rem;font-weight:800;color:white;margin:0 0 0.25rem;">
                    Halo, <span style="background:linear-gradient(135deg,#38bdf8,#818cf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">{{ auth()->user()->name }}</span> 👋
                </h1>
                <p style="font-size:0.7rem;color:#64748b;margin:0;max-width:500px;line-height:1.5;">
                    Ringkasan status aset jaringan daerah saat ini. Pantau performa dan kondisi perangkat secara real-time.
                </p>
            </div>
            <div class="live-badge">
                <div class="live-dot"><span class="ping"></span><span class="core"></span></div>
                <div>
                    <div style="font-size:0.7rem;font-weight:700;color:white;text-transform:uppercase;letter-spacing:0.05em;">System Live</div>
                    <div style="font-size:0.6rem;color:#475569;font-weight:500;">{{ now()->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stat-grid">
        <div class="dash-card">
            <div class="card-glow" style="background:#38bdf8;"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;">
                <div>
                    <div class="stat-label">Total Perangkat</div>
                    <div class="stat-value">{{ $totalDevices }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(56,189,248,0.1);border:1px solid rgba(56,189,248,0.15);">
                    <svg style="width:20px;height:20px;color:#38bdf8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Tersebar di <span style="color:#38bdf8;">{{ $totalLocations }}</span> Lokasi OPD</div>
        </div>

        <div class="dash-card">
            <div class="card-glow" style="background:#10b981;"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;">
                <div>
                    <div class="stat-label">Perangkat Aktif</div>
                    <div class="stat-value">{{ $activeDevices }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.15);">
                    <svg style="width:20px;height:20px;color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <div class="stat-footer"><span style="color:#10b981;">{{ $totalDevices > 0 ? round(($activeDevices/$totalDevices)*100) : 0 }}%</span> dari total perangkat</div>
        </div>

        <div class="dash-card">
            <div class="card-glow" style="background:#f59e0b;"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;">
                <div>
                    <div class="stat-label">Dalam Perbaikan</div>
                    <div class="stat-value">{{ $maintenanceDevices }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.15);">
                    <svg style="width:20px;height:20px;color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Terdapat <span style="color:#f59e0b;">{{ $pendingMaintenance }}</span> log pending</div>
        </div>

        <div class="dash-card">
            <div class="card-glow" style="background:#f43f5e;"></div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;">
                <div>
                    <div class="stat-label">Perangkat Rusak</div>
                    <div class="stat-value">{{ $brokenDevices }}</div>
                </div>
                <div class="stat-icon" style="background:rgba(244,63,94,0.1);border:1px solid rgba(244,63,94,0.15);">
                    <svg style="width:20px;height:20px;color:#f43f5e;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Perlu <span style="color:#f43f5e;">tindakan</span> segera</div>
        </div>
    </div>

    {{-- Charts + Activity --}}
    <div class="content-grid">
        <div style="display:flex;flex-direction:column;gap:0.5rem;">
            {{-- Type Chart --}}
            <div class="dash-card" style="padding:1rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.6rem;">
                    <div>
                        <div class="card-title">Distribusi Tipe Perangkat</div>
                        <div class="card-subtitle">Komposisi infrastruktur jaringan saat ini</div>
                    </div>
                </div>
                <div style="position:relative;height:180px;width:100%;">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>

            <div class="chart-row">
                {{-- Status Chart --}}
                <div class="dash-card" style="padding:1rem;">
                    <div style="margin-bottom:1rem;">
                        <div class="card-title">Status Kesehatan</div>
                        <div class="card-subtitle">Proporsi kondisi perangkat</div>
                    </div>
                    <div style="position:relative;height:160px;width:100%;display:flex;justify-content:center;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                {{-- Top Locations --}}
                <div class="dash-card" style="padding:1rem;display:flex;flex-direction:column;">
                    <div style="margin-bottom:0.85rem;">
                        <div class="card-title">Top Lokasi</div>
                        <div class="card-subtitle">OPD dengan perangkat terbanyak</div>
                    </div>
                    <div style="flex:1;overflow-y:auto;">
                        @foreach($devicesPerLocation->take(4) as $loc)
                        <a href="{{ route('opd-locations.show', $loc) }}" class="loc-item">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                                <span class="loc-name">{{ $loc->nama }}</span>
                                <span class="loc-count">{{ $loc->devices_count }}</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width:{{ $totalDevices > 0 ? ($loc->devices_count / $totalDevices) * 100 : 0 }}%"></div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <a href="{{ route('opd-locations.index') }}" class="link-btn" style="margin-top:0.75rem;">Lihat Semua</a>
                </div>
            </div>
        </div>

        {{-- Activity Timeline --}}
        <div class="dash-card" style="padding:1rem;display:flex;flex-direction:column;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
                <div>
                    <div class="card-title">Aktivitas Maintenance</div>
                    <div class="card-subtitle">Log perbaikan terbaru</div>
                </div>
            </div>
            <div style="flex:1;">
                @forelse($recentMaintenance as $log)
                <div class="timeline-item">
                    <div class="timeline-dot" style="background:{{ $log->status === 'Selesai' ? '#10b981' : ($log->status === 'Pending' ? '#f59e0b' : '#3b82f6') }};"></div>
                    <div class="timeline-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.35rem;">
                            <span style="font-size:0.75rem;font-weight:700;color:#cbd5e1;">{{ $log->device->merk ?? 'Perangkat' }}</span>
                            <span class="badge {{ $log->status === 'Selesai' ? 'badge-green' : ($log->status === 'Pending' ? 'badge-amber' : 'badge-blue') }}">{{ $log->status }}</span>
                        </div>
                        <p style="font-size:0.7rem;color:#64748b;margin:0 0 0.35rem;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $log->deskripsi }}</p>
                        <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.6rem;color:#475569;font-weight:500;">
                            <span>{{ $log->jenis }}</span>
                            <span>{{ $log->tanggal->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem 0;color:#475569;">
                    <svg style="width:40px;height:40px;margin-bottom:0.5rem;color:#1e293b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <p style="font-size:0.7rem;margin:0;">Belum ada aktivitas</p>
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
        const statusColors = { 'Aktif': '#10b981', 'Rusak': '#f43f5e', 'Maintenance': '#f59e0b', 'Nonaktif': '#64748b' };
        const typeColors = ['rgba(56,189,248,0.8)','rgba(139,92,246,0.8)','rgba(245,158,11,0.8)','rgba(16,185,129,0.8)','rgba(244,63,94,0.8)','rgba(59,130,246,0.8)'];

        Chart.defaults.color = '#64748b';
        Chart.defaults.font.family = "'Inter', sans-serif";

        const tooltipStyle = {
            backgroundColor: 'rgba(15,23,42,0.95)', titleColor: '#fff', bodyColor: '#94a3b8',
            borderColor: 'rgba(148,163,184,0.1)', borderWidth: 1, padding: 12, cornerRadius: 8,
        };

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData),
                datasets: [{ data: Object.values(statusData), backgroundColor: Object.keys(statusData).map(k => statusColors[k] || '#64748b'), borderColor: '#0f172a', borderWidth: 2 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '70%',
                plugins: { tooltip: tooltipStyle, legend: { position: 'right', labels: { padding: 16, usePointStyle: true, pointStyle: 'circle', font: { size: 11 }, color: '#94a3b8' } } }
            }
        });

        new Chart(document.getElementById('typeChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(typeData),
                datasets: [{ label: 'Total', data: Object.values(typeData), backgroundColor: typeColors, borderColor: typeColors.map(c=>c.replace('0.8','1')), borderWidth: 1, borderRadius: 6, barPercentage: 0.6 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { tooltip: tooltipStyle, legend: { display: false } },
                scales: {
                    x: { ticks: { font: { size: 11, weight: '500' }, color: '#64748b' }, grid: { display: false } },
                    y: { beginAtZero: true, ticks: { font: { size: 11 }, stepSize: 1, padding: 10, color: '#64748b' }, grid: { color: 'rgba(148,163,184,0.08)', borderDash: [4,4] }, border: { display: false } }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
