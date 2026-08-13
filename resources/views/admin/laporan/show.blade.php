<x-admin-layout title="Detail Laporan Desa" maxWidth="max-w-[1440px]">

    @php
        $statusBadge = $laporan->isFinalized()
            ? 'bg-emerald-100 text-emerald-700 border border-emerald-200'
            : 'bg-amber-100 text-amber-700 border border-amber-200';
        $statusLabel = $laporan->isFinalized() ? 'Finalisasi' : 'Draft';
        $isKepalaDesa = auth()->user()->hasRole('Kepala Desa');
        $moduleLabels = $laporan->module_labels ?? [];
    @endphp

    {{-- Hero Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 via-slate-900 to-navy-900 p-6 sm:p-8 mb-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-teal-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="flex-1 min-w-0">
                <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-medium transition-colors mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">{{ $laporan->judul }}</h1>
                <p class="text-white/60 text-sm mt-1 font-mono">{{ $laporan->nomor_laporan }}</p>
            </div>

            <div class="shrink-0 flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $statusBadge }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ $statusLabel }}
                </span>
                @if ($laporan->format_pdf)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        PDF
                    </span>
                @endif
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 mt-5 relative">
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                {{ $laporan->periode_label }}
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                {{ ucfirst(str_replace('_', ' ', $laporan->tipe_periode)) }}
            </span>
        </div>
    </div>

    {{-- Two-Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Module Summary --}}
            @if (count($moduleLabels) > 0)
                <div class="widget-card a-fade-up d1">
                    <div class="widget-card-header">
                        <div class="section-header mb-0">
                            <h3>Modul Laporan</h3>
                            <div class="shimmer-line"></div>
                        </div>
                    </div>
                    <div class="widget-card-body">
                        <div class="flex flex-wrap gap-2">
                            @foreach ($moduleLabels as $label)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $label }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Naratif Sections --}}
            @forelse ($laporan->konten_naratif as $index => $section)
                <div class="widget-card a-fade-up" style="transition-delay: {{ ($loop->index + 2) * 0.05 }}s" x-data="{ open: true, dataOpen: false }">
                    <div class="widget-card-header">
                        <div class="section-header mb-0 cursor-pointer select-none" @click="open = !open">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"/>
                                    </svg>
                                </div>
                                <h3>{{ $section['judul'] ?? 'Bagian ' . ($loop->index + 1) }}</h3>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="shimmer-line"></div>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="widget-card-body" x-show="open" x-collapse x-cloak>
                        {{-- Narrative Text --}}
                        @if (!empty($section['teks']))
                            <div class="prose prose-sm prose-gray max-w-none text-gray-700 leading-relaxed mb-4">
                                @foreach (explode("\n\n", $section['teks']) as $paragraph)
                                    @if (trim($paragraph) !== '')
                                        <p class="mb-3">{!! nl2br(e($paragraph)) !!}</p>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        {{-- Data Table --}}
                        @if (!empty($section['data']) && is_array($section['data']))
                            <div class="mt-4 border border-gray-200 rounded-xl overflow-hidden">
                                <button type="button"
                                    @click="dataOpen = !dataOpen"
                                    class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 hover:bg-gray-100 transition-colors text-left">
                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Data Ringkasan ({{ count($section['data']) }} field)
                                    </span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': dataOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                </button>
                                <div x-show="dataOpen" x-collapse x-cloak>
                                    <table class="w-full text-sm">
                                        <tbody>
                                            @foreach ($section['data'] as $key => $value)
                                                <tr class="{{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                                    <td class="px-4 py-2.5 font-medium text-gray-500 uppercase tracking-wider text-xs w-1/3">{{ $key }}</td>
                                                    <td class="px-4 py-2.5 text-gray-800 font-semibold text-right">
                                                        @if (is_numeric($value) && str_contains(strtolower($key), ['anggaran', 'pendapatan', 'belanja', 'realisasi', 'sisa', 'dana', 'harga', 'nilai', 'biaya']))
                                                            Rp {{ number_format((float) $value, 0, ',', '.') }}
                                                        @elseif (is_numeric($value) && str_contains(strtolower($key), ['persentase', 'rasio', 'target', 'pencapaian', '%']))
                                                            {{ number_format((float) $value, 1, ',', '.') }}%
                                                        @elseif (is_bool($value))
                                                            {{ $value ? 'Ya' : 'Tidak' }}
                                                        @elseif (is_null($value) || $value === '')
                                                            -
                                                        @else
                                                            {{ $value }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="widget-card">
                    <div class="widget-card-body">
                        <div class="empty-state">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            <p class="text-sm font-medium text-gray-400">Belum ada konten naratif</p>
                        </div>
                    </div>
                </div>
            @endforelse

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Panel Aksi --}}
            <div class="widget-card a-fade-up d1 lg:sticky lg:top-6">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Panel Aksi</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body space-y-3">

                    @if ($laporan->isDraft())
                        <a href="{{ route('admin.laporan.edit', $laporan) }}"
                            class="flex items-center justify-center gap-2 w-full border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                            Edit Laporan
                        </a>
                        <a href="{{ route('admin.laporan.pdf', $laporan) }}"
                            class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            Generate PDF
                        </a>
                        @if ($isKepalaDesa)
                            <form method="POST" action="{{ route('admin.laporan.finalize', $laporan) }}"
                                onsubmit="return confirm('Apakah Anda yakin ingin memfinalisasi laporan ini? Laporan yang sudah finalisasi tidak dapat diubah.')">
                                @csrf
                                <button type="submit"
                                    class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-violet-500/20 hover:shadow-lg hover:shadow-violet-500/30 transition-all w-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Finalisasi Laporan
                                </button>
                            </form>
                        @endif
                    @else
                        @if ($laporan->pdf_path)
                            <a href="{{ asset('storage/' . $laporan->pdf_path) }}" target="_blank"
                                class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                Download PDF
                            </a>
                        @endif
                        @if ($isKepalaDesa)
                            <form method="POST" action="{{ route('admin.laporan.restore', $laporan) }}"
                                onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan laporan ini ke status draft?')">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="flex items-center justify-center gap-2 w-full border border-amber-300 bg-amber-50 hover:bg-amber-100 text-amber-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                                    Kembalikan ke Draft
                                </button>
                            </form>
                        @endif
                    @endif

                    <a href="{{ route('admin.laporan.index') }}"
                        class="flex items-center justify-center gap-2 w-full border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-semibold transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>

            {{-- Info Panel --}}
            <div class="widget-card a-fade-up d2">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Informasi</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body space-y-1">
                    {{-- Dibuat Oleh --}}
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Dibuat Oleh</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $laporan->creator?->name ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Tanggal Dibuat --}}
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Tanggal Dibuat</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $laporan->created_at->locale('id')->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                    </div>

                    {{-- Diubah --}}
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Diubah</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $laporan->updated_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if ($laporan->isFinalized())
                        {{-- Finalisasi Oleh --}}
                        <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 dark:border-gray-700">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Finalisasi Oleh</p>
                                <p class="text-xs font-semibold text-gray-800">{{ $laporan->approver?->name ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- Tanggal Finalisasi --}}
                        <div class="flex items-center gap-3 py-2.5">
                            <div class="w-8 h-8 rounded-lg bg-cyan-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Tanggal Finalisasi</p>
                                <p class="text-xs font-semibold text-gray-800">{{ $laporan->approved_at->locale('id')->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 py-2.5">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Status Finalisasi</p>
                                <p class="text-xs font-semibold text-gray-400 italic">Belum difinalisasi</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('v');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
            document.querySelectorAll('.a-fade-up,.a-fade-in,.a-scale').forEach(function (el) {
                observer.observe(el);
            });
        });
    </script>
    @endpush

</x-admin-layout>
