@props(['type' => 'Lainnya', 'class' => 'w-5 h-5'])

@php
    $type = strtolower($type);
    $icons = [
        'router' => [
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />',
            'color' => 'text-cyan-400',
            'bg' => 'from-cyan-500/10 to-blue-600/5',
        ],
        'switch' => [
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />',
            'color' => 'text-indigo-400',
            'bg' => 'from-indigo-500/10 to-indigo-600/5',
        ],
        'access point' => [
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />',
            'color' => 'text-purple-400',
            'bg' => 'from-purple-500/10 to-purple-600/5',
        ],
        'modem' => [
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />',
            'color' => 'text-emerald-400',
            'bg' => 'from-emerald-500/10 to-emerald-600/5',
        ],
        'server' => [
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />',
            'color' => 'text-amber-400',
            'bg' => 'from-amber-500/10 to-amber-600/5',
        ],
        'firewall' => [
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />',
            'color' => 'text-rose-400',
            'bg' => 'from-rose-500/10 to-rose-600/5',
        ],
        'lainnya' => [
            'path' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />',
            'color' => 'text-slate-400',
            'bg' => 'from-slate-500/10 to-slate-600/5',
        ],
    ];

    $selected = $icons[$type] ?? $icons['lainnya'];
    
    // If a color class is already present in attributes, don't use the default color
    $hasColor = str_contains($attributes->get('class', ''), 'text-');
    $colorClass = $hasColor ? '' : $selected['color'];
@endphp

<svg {{ $attributes->merge(['class' => "$class $colorClass"]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
    {!! $selected['path'] !!}
</svg>

