<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - {{ config('village.nama_desa', 'Desa Kumpay') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($berita->konten), 160) }}">
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b' },
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out forwards',
                        'slide-up': 'slideUp 0.5s ease-out forwards',
                        'scale-in': 'scaleIn 0.4s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { opacity: '0', transform: 'translateY(24px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        scaleIn: { '0%': { opacity: '0', transform: 'scale(0.9)' }, '100%': { opacity: '1', transform: 'scale(1)' } },
                    }
                }
            }
        }
    </script>
    @include('components.favicon')
    @include('components.fonts')
    <style>
        .font-sans { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif !important; }
        .a1{animation-delay:.05s} .a2{animation-delay:.1s} .a3{animation-delay:.15s} .a4{animation-delay:.2s}
        .a5{animation-delay:.25s} .a6{animation-delay:.3s} .a7{animation-delay:.35s} .a8{animation-delay:.4s}
        .section-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(226,232,240,0.8);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 8px 24px rgba(0,0,0,0.06);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .section-card:hover {
            box-shadow: 0 12px 40px rgba(0,0,0,0.1), 0 4px 12px rgba(0,0,0,0.05);
            border-color: rgba(16,185,129,0.2);
        }
        .gradient-hero {
            background: linear-gradient(160deg, #064e3b 0%, #065f46 25%, #047857 50%, #0d9488 75%, #0f766e 100%);
        }
        .glass-nav {
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(226,232,240,0.6);
        }
        .prose-berita { line-height: 1.85; }
        .prose-berita p { margin-bottom: 1.25em; }
        .prose-berita h2 { font-size: 1.25rem; font-weight: 700; margin-top: 2em; margin-bottom: 0.75em; color: #111827; }
        .prose-berita h3 { font-size: 1.1rem; font-weight: 600; margin-top: 1.5em; margin-bottom: 0.5em; color: #1f2937; }
        .prose-berita ul, .prose-berita ol { margin: 1em 0; padding-left: 1.5em; }
        .prose-berita li { margin-bottom: 0.5em; }
        .prose-berita blockquote { border-left: 3px solid #10b981; padding-left: 1em; margin: 1.5em 0; color: #6b7280; font-style: italic; }
        .prose-berita a { color: #059669; text-decoration: underline; text-underline-offset: 2px; }
        .prose-berita a:hover { color: #047857; }
    </style>
    @include('components.design-tokens')
</head>
<body class="bg-gray-50 font-sans antialiased">

    {{-- ═══ NAVBAR ═══ --}}
    <nav class="glass-nav fixed top-0 left-0 right-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-lg shadow-brand-500/20">
                    <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <span class="text-lg font-bold text-gray-800">Pro<span class="text-brand-600">desa</span></span>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#berita" class="text-sm text-gray-500 hover:text-brand-600 font-medium transition hidden sm:block">Berita</a>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-brand-600 font-medium transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    Kembali
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-20 pb-8">

        {{-- ═══ HERO ═══ --}}
        <div class="opacity-0 animate-slide-up a1">
            <div class="max-w-5xl mx-auto px-4 sm:px-6">
                <div class="gradient-hero rounded-3xl overflow-hidden relative">
                    @if ($berita->foto)
                        <img src="{{ asset('storage/' . $berita->foto) }}" alt="{{ $berita->judul }}" class="w-full h-64 sm:h-80 lg:h-96 object-cover opacity-40">
                    @else
                        <div class="w-full h-48 sm:h-64"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 lg:p-10">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/20 text-white backdrop-blur-sm border border-white/10">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                Berita Desa
                            </span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white leading-tight mb-3">{{ $berita->judul }}</h1>
                        <div class="flex flex-wrap items-center gap-3 text-white/70 text-sm">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                <span>{{ $berita->created_at->locale('id')->translatedFormat('d MMMM Y') }}</span>
                            </div>
                            <span class="text-white/30">|</span>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                <span>{{ $berita->user?->name ?? 'Admin' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ CONTENT ═══ --}}
        <div class="max-w-5xl mx-auto px-4 sm:px-6 mt-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Main Content --}}
                <div class="lg:col-span-8 opacity-0 animate-slide-up a2">
                    <article class="section-card p-6 sm:p-8 lg:p-10">
                        <div class="prose prose-gray max-w-none prose-berita text-gray-600">
                            {!! nl2br(e($berita->konten)) !!}
                        </div>

                        {{-- Share / Back --}}
                        <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Dipublikasikan {{ $berita->created_at->locale('id')->translatedFormat('d MMMM Y, H:i') }} WIB
                            </div>
                            <a href="{{ route('home') }}#berita"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                                Kembali ke Berita
                            </a>
                        </div>
                    </article>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-4 space-y-6 opacity-0 animate-slide-up a3">

                    {{-- Info Panel --}}
                    <div class="section-card p-6">
                        <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-gradient-to-b from-brand-500 to-teal-600"></span>
                            Informasi Berita
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                                <div class="w-8 h-8 rounded-lg bg-brand-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Tanggal</p>
                                    <p class="text-xs font-bold text-gray-800">{{ $berita->created_at->locale('id')->translatedFormat('d MMMM Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                                <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Penulis</p>
                                    <p class="text-xs font-bold text-gray-800">{{ $berita->user?->name ?? 'Admin' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Kategori</p>
                                    <p class="text-xs font-bold text-gray-800">Berita Desa</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Desa Info --}}
                    <div class="section-card p-6">
                        <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="w-1 h-5 rounded-full bg-gradient-to-b from-blue-500 to-indigo-600"></span>
                            {{ config('village.nama_desa', 'Desa Kumpay') }}
                        </h3>
                        <div class="space-y-3 text-xs text-gray-500">
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-brand-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                <span>{{ config('village.alamat_kantor', '-') }}, Kec. {{ config('village.nama_kecamatan', '-') }}, Kab. {{ config('village.nama_kabupaten', '-') }}</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                <span>{{ config('village.email_desa', '-') }}</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                <span>{{ config('village.telepon_desa', '-') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Back --}}
                    <a href="{{ route('home') }}#berita"
                        class="section-card p-4 flex items-center justify-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700 transition group">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>

        {{-- ═══ FOOTER ═══ --}}
        <footer class="mt-12 opacity-0 animate-fade-in a4">
            <div class="max-w-5xl mx-auto px-4 sm:px-6">
                <div class="text-center py-8 border-t border-gray-200/60">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-lg shadow-brand-500/20">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-600 tracking-wider">PRO<span class="text-brand-600">DESA</span></span>
                    </div>
                    <p class="text-xs text-gray-400">Digital Government Platform</p>
                    <div class="flex items-center justify-center gap-2 mt-3 text-[11px] text-gray-400">
                        <span>{{ config('village.nama_desa', 'Desa') }}</span>
                        <span class="text-gray-300">&middot;</span>
                        <span>Kec. {{ config('village.nama_kecamatan', '-') }}</span>
                        <span class="text-gray-300">&middot;</span>
                        <span>Kab. {{ config('village.nama_kabupaten', '-') }}</span>
                    </div>
                    <p class="text-[10px] text-gray-300 mt-2">&copy; {{ date('Y') }} Prodesa &middot; RanggaDev ACCESS</p>
                </div>
            </div>
        </footer>

    </main>

</body>
</html>
