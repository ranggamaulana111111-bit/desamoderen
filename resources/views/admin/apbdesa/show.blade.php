<x-admin-layout title="Detail APBDesa" maxWidth="max-w-[1200px]">

    @php
        $statusBadge = match($apbdesa->status) {
            'draft' => 'bg-gray-100 text-gray-600 border border-gray-200',
            'aktif' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
            'selesai' => 'bg-blue-100 text-blue-700 border border-blue-200',
            'dibatalkan' => 'bg-red-100 text-red-700 border border-red-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };
        $statusLabel = match($apbdesa->status) {
            'draft' => 'Draft',
            'aktif' => 'Aktif',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst($apbdesa->status),
        };
        $kategoriBadge = match($apbdesa->kategori) {
            'pembangunan' => 'bg-blue-100 text-blue-700 border border-blue-200',
            'pelayanan' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
            'pemerintahan' => 'bg-purple-100 text-purple-700 border border-purple-200',
            'kemasyrakatan' => 'bg-amber-100 text-amber-700 border border-amber-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };
        $sisaAnggaran = $apbdesa->anggaran - $apbdesa->realisasi;
        $sisaColor = $sisaAnggaran < 0 ? 'red' : 'emerald';
    @endphp

    {{-- Hero Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 via-slate-900 to-navy-900 p-6 sm:p-8 mb-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-teal-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="flex-1 min-w-0">
                <a href="{{ route('admin.apbdesa.index') }}" class="inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-medium transition-colors mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">{{ $apbdesa->bidang }}</h1>
                <p class="text-white/60 text-sm mt-1">{{ $apbdesa->uraian }}</p>
            </div>
            <div class="shrink-0 flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $kategoriBadge }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ ucfirst($apbdesa->kategori) }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $statusBadge }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ $statusLabel }}
                </span>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3 mt-5 relative">
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                {{ $apbdesa->tahun }}
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Rp {{ number_format($apbdesa->anggaran, 0, ',', '.') }}
            </span>
        </div>
    </div>

    {{-- Two-Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Detail Anggaran --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Detail Anggaran</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body">
                    <div class="space-y-1">
                        @php
                            $infoRows = [
                                ['label' => 'Tahun', 'value' => $apbdesa->tahun, 'color' => 'emerald', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                                ['label' => 'Kategori', 'value' => ucfirst($apbdesa->kategori), 'color' => 'blue', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                                ['label' => 'Bidang', 'value' => $apbdesa->bidang, 'color' => 'purple', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z'],
                                ['label' => 'Uraian', 'value' => $apbdesa->uraian, 'color' => 'amber', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                                ['label' => 'Anggaran', 'value' => 'Rp ' . number_format($apbdesa->anggaran, 0, ',', '.'), 'color' => 'emerald', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['label' => 'Realisasi', 'value' => 'Rp ' . number_format($apbdesa->realisasi, 0, ',', '.'), 'color' => 'cyan', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['label' => 'Sisa Anggaran', 'value' => 'Rp ' . number_format($sisaAnggaran, 0, ',', '.'), 'color' => $sisaColor, 'icon' => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z'],
                                ['label' => 'Sumber Dana', 'value' => $apbdesa->sumber_dana, 'color' => 'rose', 'icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z'],
                                ['label' => 'Status', 'value' => $statusLabel, 'color' => 'indigo', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z'],
                            ];
                        @endphp
                        @foreach ($infoRows as $row)
                            <div class="flex items-center gap-3 py-2.5 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-700' : '' }}">
                                <div class="w-8 h-8 rounded-lg bg-{{ $row['color'] }}-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-{{ $row['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $row['icon'] }}"/></svg>
                                </div>
                                <div class="flex-1 min-w-0 flex items-center justify-between">
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $row['label'] }}</span>
                                    @if ($row['label'] === 'Status')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $statusBadge }}">
                                            {{ $row['value'] }}
                                        </span>
                                    @elseif ($row['label'] === 'Sisa Anggaran')
                                        <span class="text-sm font-semibold text-{{ $sisaColor }}-600 text-right">{{ $row['value'] }}</span>
                                    @else
                                        <span class="text-sm font-semibold text-gray-900 text-right">{{ $row['value'] }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Keterangan --}}
            @if ($apbdesa->keterangan)
                <div class="widget-card">
                    <div class="widget-card-header">
                        <div class="section-header mb-0">
                            <h3>Keterangan</h3>
                            <div class="shimmer-line"></div>
                        </div>
                    </div>
                    <div class="widget-card-body">
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $apbdesa->keterangan }}</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Panel Aksi --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Panel Aksi</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body space-y-3">
                    <a href="{{ route('admin.apbdesa.edit', $apbdesa) }}"
                        class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        Edit APBDesa
                    </a>
                    <form method="POST" action="{{ route('admin.apbdesa.destroy', $apbdesa) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data APBDesa ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-red-500/20 hover:shadow-lg hover:shadow-red-500/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus APBDesa
                        </button>
                    </form>
                </div>
            </div>

            {{-- Info Sidebar --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Informasi</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body space-y-1">
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Dibuat</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $apbdesa->created_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Diubah</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $apbdesa->updated_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 py-2.5">
                        <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Operator</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $apbdesa->creator?->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kembali --}}
            <a href="{{ route('admin.apbdesa.index') }}"
                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

</x-admin-layout>
