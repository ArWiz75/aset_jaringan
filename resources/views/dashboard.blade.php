<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <style>
        .dash-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0; border-radius: 8px;
            padding: 1.25rem; position: relative; overflow: hidden;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .dash-card .card-glow { display: none; }

        .welcome-banner {
            background-color: #1e40af; /* Professional Dark Blue */
            border-radius: 8px; padding: 1.5rem; position: relative; overflow: hidden; margin-bottom: 1rem;
        }
        .welcome-banner::before {
            content: ''; position: absolute; top: -50%; right: -20%;
            width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%);
            pointer-events: none;
        }

        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1rem; }
        @media (max-width: 1024px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px) { .stat-grid { grid-template-columns: 1fr; } }

        .stat-value { font-size: 1.75rem; font-weight: 700; color: #0f172a; margin-top: 0.25rem; }
        .stat-label { font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0; }
        .stat-footer { font-size: 0.75rem; color: #64748b; margin-top: 0.75rem; }
        .stat-footer span { font-weight: 600; }

        .stat-icon {
            width: 42px; height: 42px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
        }

        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; }
        @media (max-width: 1280px) { .content-grid { grid-template-columns: 1fr; } }

        .chart-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media (max-width: 768px) { .chart-row { grid-template-columns: 1fr; } }

        .card-title { font-size: 1rem; font-weight: 700; color: #0f172a; }
        .card-subtitle { font-size: 0.8rem; color: #64748b; margin-top: 4px; }

        .timeline-dot {
            position: absolute; left: -5px; top: 6px; width: 12px; height: 12px;
            border-radius: 50%; border: 2px solid #ffffff;
        }
        .timeline-item {
            position: relative; padding-left: 1.25rem; padding-bottom: 1.25rem;
            border-left: 2px solid #e2e8f0;
        }
        .timeline-item:last-child { border-left-color: transparent; padding-bottom: 0; }
        .timeline-card {
            background-color: #f8fafc; border: 1px solid #e2e8f0;
            border-radius: 8px; padding: 1rem;
        }

        .badge {
            font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
            padding: 4px 8px; border-radius: 6px; letter-spacing: 0.05em;
        }
        .badge-green { color: #059669; background-color: #d1fae5; }
        .badge-amber { color: #d97706; background-color: #fef3c7; }
        .badge-blue { color: #2563eb; background-color: #dbeafe; }

        .progress-bar-bg { width: 100%; height: 6px; background-color: #e2e8f0; border-radius: 99px; }
        .progress-bar-fill { height: 6px; border-radius: 99px; background-color: #2563eb; }

        .link-btn {
            display: block; text-align: center; font-size: 0.85rem; font-weight: 600;
            padding: 0.6rem; border-radius: 6px; text-decoration: none; transition: all 0.2s;
            border: 1px solid #bfdbfe; color: #2563eb;
            background-color: #eff6ff;
        }
        .link-btn:hover { background-color: #dbeafe; }

        .link-btn-neutral {
            display: block; text-align: center; font-size: 0.85rem; font-weight: 600;
            padding: 0.6rem; border-radius: 6px; text-decoration: none; transition: all 0.2s;
            border: 1px solid #e2e8f0; color: #475569;
            background-color: #f8fafc;
        }
        .link-btn-neutral:hover { background-color: #f1f5f9; color: #0f172a; }

        .live-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background-color: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
            padding: 0.4rem 0.85rem; border-radius: 6px;
        }
        .live-dot { position: relative; display: flex; width: 10px; height: 10px; }
        .live-dot .ping { position: absolute; inset: 0; border-radius: 50%; background-color: #6ee7b7; opacity: 0.75; animation: ping 1.5s cubic-bezier(0,0,0.2,1) infinite; }
        .live-dot .core { position: relative; width: 10px; height: 10px; border-radius: 50%; background-color: #10b981; }
        @keyframes ping { 75%, 100% { transform: scale(2); opacity: 0; } }

        .loc-item { text-decoration: none; display: block; margin-bottom: 0.85rem; }
        .loc-name { font-size: 0.85rem; font-weight: 600; color: #334155; }
        .loc-item:hover .loc-name { color: #2563eb; }
        .loc-count {
            font-size: 0.75rem; font-weight: 700; color: #0f172a;
            background-color: #f1f5f9; padding: 2px 8px; border-radius: 4px;
        }
    </style>

    {{-- Welcome Banner --}}
    <div class="welcome-banner">
        <div style="position:relative;z-index:1;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:0.75rem;">
            <div>
                <h1 style="font-size:1.25rem;font-weight:800;color:#ffffff;margin:0 0 0.25rem;">
                    Halo, {{ auth()->user()->name }} 👋
                </h1>
                <p style="font-size:0.85rem;color:#bfdbfe;margin:0;max-width:500px;line-height:1.5;">
                    Ringkasan status aset jaringan daerah saat ini. Pantau performa dan kondisi perangkat secara real-time.
                </p>
            </div>
            <div class="live-badge">
                <div class="live-dot"><span class="ping"></span><span class="core"></span></div>
                <div>
                    <div style="font-size:0.7rem;font-weight:700;color:#ffffff;text-transform:uppercase;letter-spacing:0.05em;">System Live</div>
                    <div style="font-size:0.65rem;color:#bfdbfe;font-weight:500;">{{ now()->translatedFormat('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stat-grid">
        <div class="dash-card">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;">
                <div>
                    <div class="stat-label">Total Perangkat</div>
                    <div class="stat-value">{{ $totalDevices }}</div>
                </div>
                <div class="stat-icon" style="background-color:#eff6ff;color:#2563eb;">
                    <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Tersebar di <span style="color:#2563eb;">{{ $totalLocations }}</span> Lokasi OPD</div>
        </div>

        <div class="dash-card">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;">
                <div>
                    <div class="stat-label">Perangkat Aktif</div>
                    <div class="stat-value">{{ $activeDevices }}</div>
                </div>
                <div class="stat-icon" style="background-color:#ecfdf5;color:#059669;">
                    <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <div class="stat-footer"><span style="color:#059669;">{{ $totalDevices > 0 ? round(($activeDevices/$totalDevices)*100) : 0 }}%</span> dari total perangkat</div>
        </div>

        <div class="dash-card">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;">
                <div>
                    <div class="stat-label">Dalam Perbaikan</div>
                    <div class="stat-value">{{ $maintenanceDevices }}</div>
                </div>
                <div class="stat-icon" style="background-color:#fef3c7;color:#d97706;">
                    <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Terdapat <span style="color:#d97706;">{{ $pendingMaintenance }}</span> log pending</div>
        </div>

        <div class="dash-card">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;position:relative;z-index:1;">
                <div>
                    <div class="stat-label">Perangkat Rusak</div>
                    <div class="stat-value">{{ $brokenDevices }}</div>
                </div>
                <div class="stat-icon" style="background-color:#fee2e2;color:#dc2626;">
                    <svg style="width:24px;height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="stat-footer">Perlu <span style="color:#dc2626;">tindakan</span> segera</div>
        </div>
    </div>

    {{-- Charts + Activity --}}
    <div class="content-grid">
        <div style="display:flex;flex-direction:column;gap:1rem;">
            {{-- Type Chart --}}
            <div class="dash-card">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <div>
                        <div class="card-title">Distribusi Tipe Perangkat</div>
                        <div class="card-subtitle">Komposisi infrastruktur jaringan saat ini</div>
                    </div>
                </div>
                <div style="position:relative;height:200px;width:100%;">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>

            <div class="chart-row">
                {{-- Status Chart --}}
                <div class="dash-card">
                    <div style="margin-bottom:1rem;">
                        <div class="card-title">Status Kesehatan</div>
                        <div class="card-subtitle">Proporsi kondisi perangkat</div>
                    </div>
                    <div style="position:relative;height:180px;width:100%;display:flex;justify-content:center;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                {{-- Top Locations --}}
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
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width:{{ $totalDevices > 0 ? ($loc->devices_count / $totalDevices) * 100 : 0 }}%"></div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <a href="{{ route('opd-locations.index') }}" class="link-btn" style="margin-top:1rem;">Lihat Semua</a>
                </div>
            </div>
        </div>

        {{-- Activity Timeline --}}
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
                    <div class="timeline-dot" style="background-color:{{ $log->status === 'Selesai' ? '#10b981' : ($log->status === 'Pending' ? '#f59e0b' : '#3b82f6') }};"></div>
                    <div class="timeline-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.5rem;">
                            <span style="font-size:0.85rem;font-weight:700;color:#0f172a;">{{ $log->device->merk ?? 'Perangkat' }}</span>
                            <span class="badge {{ $log->status === 'Selesai' ? 'badge-green' : ($log->status === 'Pending' ? 'badge-amber' : 'badge-blue') }}">{{ $log->status }}</span>
                        </div>
                        <p style="font-size:0.8rem;color:#475569;margin:0 0 0.5rem;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $log->deskripsi }}</p>
                        <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.7rem;color:#64748b;font-weight:600;">
                            <span>{{ $log->jenis }}</span>
                            <span>{{ $log->tanggal->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem 0;color:#64748b;">
                    <svg style="width:40px;height:40px;margin-bottom:0.5rem;color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <p style="font-size:0.85rem;margin:0;font-weight:500;">Belum ada aktivitas</p>
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
        const statusColors = { 'Aktif': '#10b981', 'Rusak': '#e11d48', 'Maintenance': '#d97706', 'Nonaktif': '#94a3b8' };
        const typeColors = ['#60a5fa','#a78bfa','#fbbf24','#34d399','#fb7185','#3b82f6'];

        Chart.defaults.color = '#64748b';
        Chart.defaults.font.family = "'Inter', sans-serif";

        const tooltipStyle = {
            backgroundColor: '#ffffff', titleColor: '#0f172a', bodyColor: '#475569',
            borderColor: '#e2e8f0', borderWidth: 1, padding: 12, cornerRadius: 8,
            titleFont: { size: 13, family: "'Inter', sans-serif" },
            bodyFont: { size: 12, family: "'Inter', sans-serif" },
            boxPadding: 6
        };

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(statusData),
                datasets: [{ data: Object.values(statusData), backgroundColor: Object.keys(statusData).map(k => statusColors[k] || '#94a3b8'), borderColor: '#ffffff', borderWidth: 2 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, cutout: '75%',
                plugins: { tooltip: tooltipStyle, legend: { position: 'right', labels: { padding: 16, usePointStyle: true, pointStyle: 'circle', font: { size: 12 }, color: '#475569' } } }
            }
        });

        new Chart(document.getElementById('typeChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(typeData),
                datasets: [{ label: 'Total', data: Object.values(typeData), backgroundColor: typeColors, borderColor: typeColors, borderWidth: 1, borderRadius: 4, barPercentage: 0.5 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { tooltip: tooltipStyle, legend: { display: false } },
                scales: {
                    x: { ticks: { font: { size: 12, weight: '500' }, color: '#64748b' }, grid: { display: false } },
                    y: { beginAtZero: true, ticks: { font: { size: 12 }, stepSize: 1, padding: 10, color: '#64748b' }, grid: { color: '#f1f5f9', borderDash: [4,4] }, border: { display: false } }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
