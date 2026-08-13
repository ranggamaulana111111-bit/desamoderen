@props(['title' => 'Dashboard', 'maxWidth' => 'max-w-[1440px]'])

@php
    $themeSettings = app(\App\Services\ThemeSettingsService::class)->getForUser();
@endphp

<!DOCTYPE html>
<html lang="id" class="overflow-x-clip" x-data="themeManager()" x-init="init()" :class="{ 'dark': resolvedTheme === 'dark' }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - Prodesa</title>
    <script>
        window.__THEME = @json($themeSettings);
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#ecfdf5', 100:'#d1fae5', 200:'#a7f3d0', 300:'#6ee7b7', 400:'#34d399', 500:'#10b981', 600:'#059669', 700:'#047857', 800:'#065f46', 900:'#064e3b' },
                        navy: { 800:'#1e293b', 900:'#0f172a', 950:'#020617' },
                        sidebar: { DEFAULT: '#052e22', hover: '#065f46' },
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out forwards',
                        'slide-up': 'slideUp 0.5s ease-out forwards',
                        'slide-left': 'slideLeft 0.5s ease-out forwards',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                        'shimmer': 'shimmer 1.5s ease-in-out infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'counter': 'counter 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { opacity: '0', transform: 'translateY(24px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        slideLeft: { '0%': { opacity: '0', transform: 'translateX(16px)' }, '100%': { opacity: '1', transform: 'translateX(0)' } },
                        shimmer: { '0%': { backgroundPosition: '-200% 0' }, '100%': { backgroundPosition: '200% 0' } },
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-6px)' } },
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @include('components.favicon')
    @include('components.fonts')
    <x-pwa-assets />
    <style>
        [x-cloak] { display: none !important; }
        :root {
            --brand-50:#ecfdf5; --brand-100:#d1fae5; --brand-200:#a7f3d0; --brand-300:#6ee7b7;
            --brand-400:#34d399; --brand-500:#10b981; --brand-600:#059669; --brand-700:#047857;
            --brand-800:#065f46; --brand-900:#064e3b;
            --teal-500:#14b8a6; --teal-600:#0d9488;
            --cyan-500:#06b6d4; --cyan-600:#0891b2;
            --navy-800:#1e293b; --navy-900:#0f172a;
            --gradient-brand: linear-gradient(135deg, #059669, #0891b2);
            --gradient-hero: linear-gradient(160deg, #0a1a12 0%, #0d2818 20%, #0f3423 40%, #0a3040 65%, #0c2d48 85%, #0f172a 100%);
            --gradient-card: linear-gradient(145deg, #0f172a, #1e293b);
            --shadow-soft: 0 4px 24px -4px rgba(0,0,0,.08);
            --shadow-elevated: 0 20px 60px rgba(0,0,0,.12), 0 4px 12px rgba(0,0,0,.06);
            --shadow-card: 0 1px 3px rgba(0,0,0,.04), 0 8px 24px rgba(0,0,0,.06);
            --shadow-hover: 0 12px 40px rgba(0,0,0,.1), 0 4px 12px rgba(0,0,0,.05);
            --ease-out-expo: cubic-bezier(.16, 1, .3, 1);
        }

        body { background: #f5f5f0; }
        .dark body, body.dark { background: #0f172a !important; }

        .font-sans { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif !important; }

        /* ── Glass System ── */
        .glass { background: rgba(255,255,255,.06); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,.1); }
        .glass-strong { background: rgba(255,255,255,.1); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,.15); }
        .glass-dark { background: rgba(0,0,0,.2); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,.08); }
        .glass-light { background: rgba(255,255,255,.82); backdrop-filter: blur(32px) saturate(200%); border: 1px solid rgba(255,255,255,.5); }

        /* ── Bento Cards ── */
        .bento-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(226,232,240,.8);
            box-shadow: var(--shadow-card);
            transition: all .4s var(--ease-out-expo);
        }
        .bento-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(16,185,129,.2);
        }
        .dark .bento-card { background: #1e293b; border-color: rgba(51,65,85,.6); }
        .dark .bento-card:hover { border-color: rgba(16,185,129,.3); box-shadow: 0 12px 40px rgba(0,0,0,.3); }

        .bento-card-static { border: 1px solid rgba(226,232,240,.8); border-radius: 20px; }
        .dark .bento-card-static { border-color: rgba(51,65,85,.6); background: #1e293b; }
        .bento-card-static:hover { box-shadow: 0 4px 12px -4px rgba(0,0,0,.06); }

        .glass-header {
            background: rgba(245,245,240,.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(226,232,240,.6);
        }
        .dark .glass-header { background: rgba(15,23,42,.85); border-bottom-color: rgba(51,65,85,.4); }

        /* ── Buttons ── */
        .btn-primary {
            background: var(--gradient-brand);
            color: #fff; font-weight: 600; font-size: 14px;
            padding: 10px 20px; border-radius: 14px;
            box-shadow: 0 8px 24px rgba(5,150,105,.25);
            transition: all .3s var(--ease-out-expo);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(5,150,105,.35); }
        .btn-primary:active { transform: scale(.97); }

        .btn-ghost {
            background: rgba(0,0,0,.04); color: #475569;
            font-weight: 600; font-size: 13px; padding: 8px 16px;
            border-radius: 12px; border: 1px solid transparent;
            transition: all .2s var(--ease-out-expo);
        }
        .btn-ghost:hover { background: rgba(0,0,0,.08); border-color: rgba(0,0,0,.06); }
        .dark .btn-ghost { background: rgba(255,255,255,.06); color: #94a3b8; }
        .dark .btn-ghost:hover { background: rgba(255,255,255,.1); color: #e2e8f0; }

        /* ── Status Badges ── */
        .badge-status {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 9999px;
            font-size: 11px; font-weight: 600; border: 1px solid transparent;
            white-space: nowrap;
        }
        .bg-submitted { background: #ccfbf1; color: #0f766e; border-color: rgba(20,184,166,.2); }
        .bg-verified { background: #eef2ff; color: #4f46e5; border-color: rgba(99,102,241,.2); }
        .bg-approved_operator { background: #ecfeff; color: #0891b2; border-color: rgba(6,182,212,.2); }
        .bg-approved_sekdes { background: #f5f3ff; color: #7c3aed; border-color: rgba(139,92,246,.2); }
        .bg-approved_kades { background: #ecfdf5; color: #059669; border-color: rgba(16,185,129,.2); }
        .bg-completed { background: #f0fdf4; color: #16a34a; border-color: rgba(34,197,94,.2); }
        .bg-rejected { background: #fef2f2; color: #dc2626; border-color: rgba(239,68,68,.2); }
        .bg-revision { background: #fffbeb; color: #d97706; border-color: rgba(245,158,11,.2); }
        .dark .bg-submitted { background: rgba(20,184,166,.15); color: #5eead4; }
        .dark .bg-verified { background: rgba(99,102,241,.15); color: #818cf8; }
        .dark .bg-approved_operator { background: rgba(6,182,212,.15); color: #22d3ee; }
        .dark .bg-approved_sekdes { background: rgba(139,92,246,.15); color: #a78bfa; }
        .dark .bg-approved_kades { background: rgba(16,185,129,.15); color: #34d399; }
        .dark .bg-completed { background: rgba(34,197,94,.15); color: #4ade80; }
        .dark .bg-rejected { background: rgba(239,68,68,.15); color: #f87171; }
        .dark .bg-revision { background: rgba(245,158,11,.15); color: #fbbf24; }

        /* ── Quick Action ── */
        .quick-action {
            transition: all .3s var(--ease-out-expo);
            position: relative;
            overflow: hidden;
        }
        .quick-action::after {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at var(--x, 50%) var(--y, 50%), rgba(16,185,129,.08), transparent 60%);
            opacity: 0; transition: opacity .4s ease;
        }
        .quick-action:hover::after { opacity: 1; }
        .quick-action:hover { transform: scale(1.04) translateY(-3px); box-shadow: var(--shadow-hover); }
        .quick-action:active { transform: scale(.97); }

        /* ── Section Header ── */
        .section-bar {
            display: flex; align-items: center; gap: 6px;
            margin-bottom: 12px; padding: 0 4px;
        }
        .section-bar::before {
            content: ''; width: 3px; height: 16px;
            border-radius: 9999px;
            background: linear-gradient(to bottom, var(--brand-400), var(--brand-600));
        }
        .section-bar h3 {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .05em; color: #334155;
        }
        .dark .section-bar h3 { color: #94a3b8; }
        .section-bar .count-badge {
            margin-left: auto;
            font-size: 10px; font-weight: 700;
            color: var(--gold-700, #a9882e); background: var(--gold-300, #efdda3);
            padding: 2px 8px; border-radius: 9999px;
            border: 1px solid var(--gold-400, #e7cd78);
        }

        /* ── Progress ── */
        .progress-track { height: 6px; border-radius: 9999px; background: rgba(0,0,0,.06); overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 9999px; background: var(--gradient-brand); transition: width 1.2s var(--ease-out-expo); }
        .dark .progress-track { background: rgba(255,255,255,.08); }

        /* ── Timeline ── */
        .timeline-line {
            position: absolute; top: 28px; left: 11.5px;
            width: 2px; height: calc(100% - 20px);
            background: linear-gradient(to bottom, #e2e8f0, transparent);
        }
        .dark .timeline-line { background: linear-gradient(to bottom, #334155, transparent); }
        .timeline-item:last-child .timeline-line { display: none; }

        /* ── Animations ── */
        .a-fade-up { opacity: 0; transform: translateY(28px); transition: all .7s var(--ease-out-expo); }
        .a-fade-up.v { opacity: 1; transform: translateY(0); }
        .a-fade-in { opacity: 0; transition: opacity .7s ease; }
        .a-fade-in.v { opacity: 1; }
        .a-scale { opacity: 0; transform: scale(.92); transition: all .6s var(--ease-out-expo); }
        .a-scale.v { opacity: 1; transform: scale(1); }

        .d1{transition-delay:.05s} .d2{transition-delay:.1s} .d3{transition-delay:.15s} .d4{transition-delay:.2s} .d5{transition-delay:.25s}
        .d6{transition-delay:.3s} .d7{transition-delay:.35s} .d8{transition-delay:.4s} .d9{transition-delay:.45s} .d10{transition-delay:.5s}

        .interact { transition: all .3s var(--ease-out-expo); cursor: pointer; }
        .interact:hover { transform: translateY(-2px); }
        .interact:active { transform: scale(.97); transition-duration: .1s; }

        /* ── Count Up ── */
        .count-up { font-variant-numeric: tabular-nums; }

        /* ── Skeleton ── */
        .skeleton {
            background: linear-gradient(90deg, #e2e8f0 25%, #f8fafc 50%, #e2e8f0 75%);
            background-size: 200% 100%; animation: shimmer 1.5s ease-in-out infinite;
        }
        .dark .skeleton { background: linear-gradient(90deg, #334155 25%, #1e293b 50%, #334155 75%); background-size: 200% 100%; }

        .health-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
        .health-dot.ok { background: #10b981; box-shadow: 0 0 8px rgba(16,185,129,.4); }
        .health-dot.fail { background: #ef4444; box-shadow: 0 0 8px rgba(239,68,68,.4); }
        .health-dot.warn { background: #f59e0b; box-shadow: 0 0 8px rgba(245,158,11,.4); }

        /* ── Notification Dot ── */
        .notification-dot { animation: pulse-dot 2s ease-in-out infinite; }
        @keyframes pulse-dot { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .dark ::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); }

        /* ── Section Header (Section Bar) ── */
        .section-header {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 1rem; padding: 0 2px;
        }
        .section-header::before {
            content: ''; width: 3px; height: 18px;
            border-radius: 9999px;
            background: linear-gradient(180deg, var(--brand-400), var(--brand-600));
        }
        .section-header h3 {
            font-size: 12px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .06em; color: #475569;
        }
        .dark .section-header h3 { color: #94a3b8; }
        .section-header .shimmer-line {
            flex: 1; height: 1px;
            background: linear-gradient(90deg, rgba(0,0,0,.06), transparent);
        }
        .dark .section-header .shimmer-line { background: linear-gradient(90deg, rgba(255,255,255,.06), transparent); }

        /* ── Stat Card Micro ── */
        .stat-micro {
            transition: all .3s var(--ease-out-expo);
            position: relative; overflow: hidden;
        }
        .stat-micro::after {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at var(--x, 50%) var(--y, 50%), rgba(16,185,129,.06), transparent 60%);
            opacity: 0; transition: opacity .4s ease;
        }
        .stat-micro:hover::after { opacity: 1; }
        .stat-micro:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); }

        /* ── Mini Sparkline ── */
        .sparkline-bar {
            display: inline-block; min-width: 3px; border-radius: 2px;
            background: rgba(255,255,255,.35); transition: height .6s var(--ease-out-expo);
        }

        /* ── Pulse Dot ── */
        .pulse-dot {
            width: 8px; height: 8px; border-radius: 50%; display: inline-block; flex-shrink: 0;
        }
        .pulse-dot.ok { background: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,.15); }
        .pulse-dot.warn { background: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .pulse-dot.error { background: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.15); }
        .pulse-dot.active { animation: pulse-ring 2s ease-in-out infinite; }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(16,185,129,.4); }
            70% { box-shadow: 0 0 0 6px rgba(16,185,129,0); }
            100% { box-shadow: 0 0 0 0 rgba(16,185,129,0); }
        }

        /* ── Progress Bar Enhanced ── */
        .progress-bar {
            height: 6px; border-radius: 9999px; background: rgba(0,0,0,.06); overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%; border-radius: 9999px;
            background: var(--gradient-brand); transition: width 1s var(--ease-out-expo);
        }
        .progress-bar-sm { height: 4px; }
        .progress-bar-lg { height: 8px; }
        .dark .progress-bar { background: rgba(255,255,255,.08); }

        /* ── Empty State ── */
        .empty-state {
            display: flex; flex-direction: column; align-items: center;
            padding: 2rem 1rem; text-align: center;
        }
        .empty-state-icon {
            width: 3rem; height: 3rem; border-radius: 9999px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: .75rem;
        }

        /* ── Widget Card Standard ── */
        .widget-card {
            background: #fff; border-radius: 20px;
            border: 1px solid rgba(226,232,240,.8);
            box-shadow: var(--shadow-card); overflow: hidden;
            transition: all .4s var(--ease-out-expo);
        }
        .widget-card:hover {
            border-color: rgba(16,185,129,.15);
            box-shadow: var(--shadow-hover);
        }
        .dark .widget-card { background: #1e293b; border-color: rgba(51,65,85,.6); }
        .dark .widget-card:hover { border-color: rgba(16,185,129,.2); }

        .widget-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 1.25rem; border-bottom: 1px solid rgba(226,232,240,.6);
        }
        .dark .widget-card-header { border-bottom-color: rgba(51,65,85,.4); }

        .widget-card-body { padding: 1.25rem; }
        .widget-card-body-compact { padding: 0; }

        /* ── Widget Icon Badge ── */
        .widget-icon {
            width: 2rem; height: 2rem; border-radius: .625rem;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .widget-icon-sm { width: 1.5rem; height: 1.5rem; border-radius: .5rem; }
        .widget-icon-lg { width: 2.25rem; height: 2.25rem; border-radius: .625rem; }

        /* ── Avatar Premium ── */
        .avatar-premium {
            display: flex; align-items: center; justify-content: center;
            border-radius: 9999px; font-weight: 700;
            background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
            color: #475569; border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }
        .avatar-premium-brand {
            background: linear-gradient(135deg, var(--brand-400), var(--brand-600));
            color: #fff; border-color: rgba(255,255,255,.2);
            box-shadow: 0 4px 12px rgba(16,185,129,.25);
        }

        /* ── Chip / Tag ── */
        .chip {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 8px; border-radius: 9999px;
            font-size: 10px; font-weight: 600; white-space: nowrap;
        }
        .chip-brand { background: var(--gold-300, #efdda3); color: var(--gold-700, #a9882e); border: 1px solid var(--gold-400, #e7cd78); }

        /* ── Table Enhanced ── */
        .table-enhanced { width: 100%; font-size: 13px; }
        .table-enhanced thead th {
            padding: .625rem 1rem; text-align: left;
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .05em; color: #94a3b8;
            border-bottom: 1px solid rgba(226,232,240,.6);
        }
        .table-enhanced tbody td {
            padding: .75rem 1rem; border-bottom: 1px solid rgba(226,232,240,.4);
        }
        .table-enhanced tbody tr { transition: background .2s ease; }
        .table-enhanced tbody tr:hover { background: rgba(16,185,129,.02); }
        .dark .table-enhanced tbody tr:hover { background: rgba(16,185,129,.05); }

        /* ── Responsive Table → Card List (Breakpoint: < md 768px) ── */
        @media (max-width: 767px) {
            .table-enhanced { display: block; }
            .table-enhanced thead { display: none; }
            .table-enhanced tbody { display: block; }
            .table-enhanced tbody tr {
                display: block;
                margin: 0 0 12px;
                padding: 6px 16px;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                box-shadow: 0 1px 3px rgba(0,0,0,.05);
            }
            .dark .table-enhanced tbody tr { background: #1e293b; border-color: #334155; }
            .table-enhanced tbody td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                flex-wrap: wrap;
                padding: 10px 0;
                border-bottom: 1px dashed rgba(226,232,240,.5);
            }
            .dark .table-enhanced tbody td { border-bottom-color: rgba(51,65,85,.5); }
            .table-enhanced tbody tr td:last-child { border-bottom: 0; }
            .table-enhanced tbody td::before {
                content: attr(data-label);
                color: #64748b;
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .05em;
                text-align: left;
                flex-shrink: 0;
            }
            .dark .table-enhanced tbody td::before { color: #94a3b8; }

            /* Touch target minimum 44x44px pada Card List */
            .table-enhanced tbody td a,
            .table-enhanced tbody td button {
                min-height: 44px;
                min-width: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* ── Dark Mode Overrides ── */
        .dark .bg-white { background-color: #1e293b; }
        .dark .bg-gray-50 { background-color: #1e293b; }
        .dark .bg-gray-50\/50 { background-color: rgba(30,41,59,.5); }
        .dark .bg-gray-50\/80 { background-color: rgba(30,41,59,.8); }
        .dark .bg-gray-100 { background-color: #334155; }
        .dark .bg-gray-200 { background-color: #475569; }
        .dark .bg-white\/70 { background-color: rgba(30,41,59,.7); }
        .dark .bg-white\/85 { background-color: rgba(30,41,59,.85); }

        .dark .text-gray-900 { color: #f1f5f9; }
        .dark .text-gray-800 { color: #e2e8f0; }
        .dark .text-gray-700 { color: #cbd5e1; }
        .dark .text-gray-600 { color: #94a3b8; }
        .dark .text-gray-500 { color: #94a3b8; }
        .dark .text-gray-400 { color: #64748b; }
        .dark .text-gray-300 { color: #475569; }

        .dark .border-gray-50 { border-color: #334155; }
        .dark .border-gray-100 { border-color: #334155; }
        .dark .border-gray-200 { border-color: #334155; }
        .dark .border-gray-200\/60 { border-color: rgba(51,65,85,.6); }
        .dark .border-gray-100\/50 { border-color: rgba(51,65,85,.5); }

        .dark .divide-gray-50 > :not([hidden]) ~ :not([hidden]) { border-color: #334155; }
        .dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]) { border-color: #334155; }

        .dark .hover\:bg-gray-50:hover { background-color: #1e293b; }
        .dark .hover\:bg-gray-50\/50:hover { background-color: rgba(30,41,59,.5); }
        .dark .hover\:bg-gray-100:hover { background-color: #334155; }
        .dark .hover\:bg-white:hover { background-color: #334155; }

        .dark .ring-white { --tw-ring-color: #1e293b; }
        .dark .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0,0,0,.3); }

        .dark .bg-emerald-50 { background-color: rgba(16,185,129,.15); }
        .dark .bg-teal-50 { background-color: rgba(20,184,166,.15); }
        .dark .bg-amber-50 { background-color: rgba(245,158,11,.15); }
        .dark .bg-red-50 { background-color: rgba(239,68,68,.15); }
        .dark .bg-purple-50 { background-color: rgba(139,92,246,.15); }
        .dark .bg-pink-50 { background-color: rgba(236,72,153,.15); }
        .dark .bg-cyan-50 { background-color: rgba(6,182,212,.15); }
        .dark .bg-teal-50 { background-color: rgba(20,184,166,.15); }
        .dark .bg-cyan-50 { background-color: rgba(6,182,212,.15); }
        .dark .bg-green-50 { background-color: rgba(34,197,94,.15); }
        .dark .bg-slate-50 { background-color: #0f172a; }

        .dark .ring-emerald-200 { --tw-ring-color: rgba(16,185,129,.3); }
        .dark .bg-emerald-500 { background-color: #10b981; }
        .dark .bg-red-100 { background-color: rgba(239,68,68,.25); }
        .dark .bg-green-100 { background-color: rgba(34,197,94,.25); }

        .dark input[type="text"], .dark textarea, .dark select {
            background-color: #0f172a; border-color: #334155; color: #f1f5f9;
        }
        .dark input::placeholder, .dark textarea::placeholder { color: #64748b; }

        .dark thead tr { background-color: rgba(30,41,59,.8); }
        .dark tbody tr:hover { background-color: rgba(30,41,59,.5); }

        .density-compact { font-size: .8125rem; }
        .density-compact .bento-card { padding: .75rem; }
        .density-compact .bento-card-static { padding: .75rem; }
        .density-loose { font-size: .9375rem; }
        .density-loose .bento-card { padding: 1.75rem; }
        .density-loose .bento-card-static { padding: 1.75rem; }
    </style>
    @stack('styles')
    @include('components.design-tokens')
</head>
<body class="bg-[#f5f5f0] dark:bg-slate-900 font-sans antialiased text-slate-700 overflow-x-clip transition-colors duration-300"
      :class="{ 'density-compact': density === 'compact', 'density-loose': density === 'loose' }">

    @include('admin.components.sidebar')

    <main class="flex-1 overflow-y-auto pt-16 md:pt-0 min-h-screen">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="{{ $maxWidth }} mx-auto">
                <x-alert />
                {{ $slot }}
            </div>
        </div>
    </main>

    <x-theme-settings-modal />

    @push('scripts')
    <script>
        function themeManager() {
            return {
                theme: window.__THEME?.theme || 'light',
                density: window.__THEME?.density || 'comfortable',
                accentColor: window.__THEME?.accent_color || 'emerald',
                accentHex: window.__THEME?.accent_hex || '#10b981',
                sidebarCollapsed: window.__THEME?.sidebar_collapsed || false,
                resolvedTheme: window.__THEME?.theme || 'light',
                settingsOpen: false,
                saving: false,
                accentColors: {
                    emerald: '#10b981', blue: '#3b82f6', purple: '#8b5cf6',
                    indigo: '#6366f1', amber: '#f59e0b', cyan: '#06b6d4', rose: '#f43f5e',
                },
                init() {
                    this.resolveTheme();
                    this.applyAccent();
                    this.$watch('theme', () => { this.resolveTheme(); this.saveSettings(); });
                    this.$watch('density', () => this.saveSettings());
                    this.$watch('accentColor', (val) => {
                        this.accentHex = this.accentColors[val];
                        this.applyAccent();
                        this.saveSettings();
                    });
                },
                resolveTheme() {
                    this.resolvedTheme = this.theme === 'system'
                        ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
                        : this.theme;
                },
                applyAccent() {
                    document.documentElement.style.setProperty('--accent', this.accentHex);
                },
                async saveSettings() {
                    this.saving = true;
                    try {
                        const resp = await fetch('/admin/widgets/theme/settings', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({ theme: this.theme, density: this.density, accent_color: this.accentColor }),
                        });
                        const data = await resp.json();
                        if (data.settings) this.accentHex = data.settings.accent_hex;
                    } catch (e) { console.error('Theme save failed', e); }
                    finally { this.saving = false; }
                }
            }
        }
    </script>
    @endpush

    <script>
        document.addEventListener('DOMContentLoaded', () => { initResponsiveTables(); });
        document.addEventListener('alpine:initialized', initResponsiveTables);
        window.addEventListener('resize', initResponsiveTables);
        function initResponsiveTables() {
            document.querySelectorAll('.table-enhanced').forEach(table => {
                const headRow = table.querySelector('thead tr');
                const headers = headRow ? Array.prototype.slice.call(headRow.children) : [];
                table.querySelectorAll('tbody tr').forEach(row => {
                    Array.prototype.slice.call(row.children).forEach((td, i) => {
                        const label = headers[i] ? (headers[i].textContent || '').trim() : '';
                        td.setAttribute('data-label', label || 'Kolom ' + (i + 1));
                    });
                });
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
