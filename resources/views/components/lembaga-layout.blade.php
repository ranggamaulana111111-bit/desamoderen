@props(['title' => 'Dashboard Lembaga', 'maxWidth' => 'max-w-[1400px]'])

<!DOCTYPE html>
<html lang="id" class="overflow-x-clip">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - Prodesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#ecfdf5', 100:'#d1fae5', 200:'#a7f3d0', 300:'#6ee7b7', 400:'#34d399', 500:'#10b981', 600:'#059669', 700:'#047857', 800:'#065f46', 900:'#064e3b' },
                        navy: { 800:'#1e293b', 900:'#0f172a', 950:'#020617' },
                        sidebar: { DEFAULT: '#0f1a2e', hover: '#162544' },
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out forwards',
                        'slide-up': 'slideUp 0.5s ease-out forwards',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { opacity: '0', transform: 'translateY(24px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-6px)' } },
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
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
            --gradient-brand: linear-gradient(135deg, #059669, #0891b2);
            --gradient-hero: linear-gradient(160deg, #0a1a12 0%, #0d2818 20%, #0f3423 40%, #0a3040 65%, #0c2d48 85%, #0f172a 100%);
            --shadow-soft: 0 4px 24px -4px rgba(0,0,0,.08);
            --shadow-card: 0 1px 3px rgba(0,0,0,.04), 0 8px 24px rgba(0,0,0,.06);
            --shadow-hover: 0 12px 40px rgba(0,0,0,.1), 0 4px 12px rgba(0,0,0,.05);
            --ease-out-expo: cubic-bezier(.16, 1, .3, 1);
        }

        body { background: #f5f5f0; }
        .font-sans { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif !important; }

        .glass { background: rgba(255,255,255,.06); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,.1); }
        .glass-header {
            background: rgba(245,245,240,.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(226,232,240,.6);
        }

        .bento-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(226,232,240,.8);
            box-shadow: var(--shadow-card);
            transition: all .4s var(--ease-out-expo);
        }
        .bento-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-hover); border-color: rgba(16,185,129,.2); }
        .bento-card-static { border: 1px solid rgba(226,232,240,.8); border-radius: 20px; }

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

        .badge-status {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 9999px;
            font-size: 11px; font-weight: 600; border: 1px solid transparent;
            white-space: nowrap;
        }
        .bg-publish { background: #ecfdf5; color: #059669; border-color: rgba(16,185,129,.2); }
        .bg-draft { background: #f1f5f9; color: #64748b; border-color: rgba(148,163,184,.2); }
        .bg-akan_datang { background: #eff6ff; color: #1d4ed8; border-color: rgba(59,130,246,.2); }
        .bg-berlangsung { background: #fef3c7; color: #b45309; border-color: rgba(245,158,11,.2); }
        .bg-selesai { background: #f0fdf4; color: #16a34a; border-color: rgba(34,197,94,.2); }

        .section-header { display: flex; align-items: center; gap: 8px; margin-bottom: 1rem; padding: 0 2px; }
        .section-header::before { content: ''; width: 3px; height: 18px; border-radius: 9999px; background: linear-gradient(180deg, var(--brand-400), var(--brand-600)); }
        .section-header h3 { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #475569; }
        .section-header .shimmer-line { flex: 1; height: 1px; background: linear-gradient(90deg, rgba(0,0,0,.06), transparent); }

        .stat-micro { transition: all .3s var(--ease-out-expo); position: relative; overflow: hidden; }
        .stat-micro:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); }

        .table-enhanced { width: 100%; font-size: 13px; }
        .table-enhanced thead th { padding: .625rem 1rem; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; border-bottom: 1px solid rgba(226,232,240,.6); }
        .table-enhanced tbody td { padding: .75rem 1rem; border-bottom: 1px solid rgba(226,232,240,.4); }
        .table-enhanced tbody tr { transition: background .2s ease; }
        .table-enhanced tbody tr:hover { background: rgba(16,185,129,.02); }

        @media (max-width: 767px) {
            .table-enhanced { display: block; }
            .table-enhanced thead { display: none; }
            .table-enhanced tbody { display: block; }
            .table-enhanced tbody tr { display: block; margin: 0 0 12px; padding: 6px 16px; background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,.05); }
            .table-enhanced tbody td { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; padding: 10px 0; border-bottom: 1px dashed rgba(226,232,240,.5); }
            .table-enhanced tbody tr td:last-child { border-bottom: 0; }
            .table-enhanced tbody td::before { content: attr(data-label); color: #64748b; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; text-align: left; flex-shrink: 0; }
        }

        .a-fade-up { opacity: 0; transform: translateY(28px); transition: all .7s var(--ease-out-expo); }
        .a-fade-up.v { opacity: 1; transform: translateY(0); }
        .d1{transition-delay:.05s} .d2{transition-delay:.1s} .d3{transition-delay:.15s} .d4{transition-delay:.2s}

        .interact { transition: all .3s var(--ease-out-expo); cursor: pointer; }
        .interact:hover { transform: translateY(-2px); }
        .interact:active { transform: scale(.97); transition-duration: .1s; }

        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f5f5f0] font-sans antialiased text-slate-700 overflow-x-clip">

    @include('lembaga.components.sidebar')

    <div class="flex min-h-screen">
        <div class="hidden lg:block w-[260px] shrink-0"></div>
        <main class="flex-1 overflow-y-auto pt-16 md:pt-0 min-h-screen">
            <div class="p-4 sm:p-6 lg:p-8">
                <div class="{{ $maxWidth }} mx-auto">
                    <x-alert />
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

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
