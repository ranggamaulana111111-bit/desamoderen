<x-admin-layout title="Detail Surat Masuk" maxWidth="max-w-[1200px]">

    @php
        $statusBadge = match($surat->status) {
            'diterima' => 'bg-teal-100 text-teal-700 border border-teal-200',
            'diproses' => 'bg-amber-100 text-amber-700 border border-amber-200',
            'selesai' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
            'ditolak' => 'bg-red-100 text-red-700 border border-red-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };
        $statusLabel = match($surat->status) {
            'diterima' => 'Diterima',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => ucfirst($surat->status),
        };
        $sifatBadge = match($surat->sifat_surat) {
            'Segera' => 'bg-amber-50 text-amber-700 border border-amber-100',
            'Rahasia' => 'bg-red-50 text-red-700 border border-red-100',
            'Penting' => 'bg-teal-50 text-teal-700 border border-teal-100',
            default => 'bg-gray-50 text-gray-600 border border-gray-100',
        };
    @endphp

    {{-- Hero Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 via-slate-900 to-navy-900 p-6 sm:p-8 mb-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-teal-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="flex-1 min-w-0">
                <a href="{{ route('admin.surat-masuk.index') }}" class="inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-medium transition-colors mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">{{ $surat->perihal }}</h1>
                <p class="text-white/60 text-sm mt-1">{{ $surat->pengirim }}</p>
            </div>
            <div class="shrink-0">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $statusBadge }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ $statusLabel }}
                </span>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3 mt-5 relative">
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                {{ $surat->nomor_agenda }}
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                {{ $surat->nomor_surat }}
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $surat->tanggal_terima?->locale('id')->translatedFormat('l, d F Y') ?? '-' }}
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                {{ $surat->jenis_surat }}
            </span>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $sifatBadge }}">
                {{ $surat->sifat_surat }}
            </span>
        </div>
    </div>

    {{-- Two-Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Detail Surat --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Detail Surat</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body">
                    <div class="space-y-1">
                        @php
                            $infoRows = [
                                ['label' => 'Nomor Agenda', 'value' => $surat->nomor_agenda, 'color' => 'emerald', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                                ['label' => 'Nomor Surat', 'value' => $surat->nomor_surat, 'color' => 'teal', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                ['label' => 'Pengirim', 'value' => $surat->pengirim, 'color' => 'purple', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                                ['label' => 'Tanggal Terima', 'value' => $surat->tanggal_terima?->locale('id')->translatedFormat('d F Y') ?? '-', 'color' => 'amber', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                                ['label' => 'Tanggal Surat', 'value' => $surat->tanggal_surat?->locale('id')->translatedFormat('d F Y') ?? '-', 'color' => 'cyan', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                                ['label' => 'Jenis Surat', 'value' => $surat->jenis_surat, 'color' => 'rose', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                                ['label' => 'Sifat Surat', 'value' => $surat->sifat_surat, 'color' => 'cyan', 'icon' => 'M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5'],
                            ];
                        @endphp
                        @foreach ($infoRows as $row)
                            <div class="flex items-center gap-3 py-2.5 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-700' : '' }}">
                                <div class="w-8 h-8 rounded-lg bg-{{ $row['color'] }}-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-{{ $row['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $row['icon'] }}"/></svg>
                                </div>
                                <div class="flex-1 min-w-0 flex items-center justify-between">
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $row['label'] }}</span>
                                    <span class="text-sm font-semibold text-gray-900 text-right">{{ $row['value'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Keterangan --}}
            @if ($surat->keterangan)
                <div class="widget-card">
                    <div class="widget-card-header">
                        <div class="section-header mb-0">
                            <h3>Keterangan</h3>
                            <div class="shimmer-line"></div>
                        </div>
                    </div>
                    <div class="widget-card-body">
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $surat->keterangan }}</p>
                    </div>
                </div>
            @endif

            {{-- Lampiran --}}
            @if ($surat->file_path)
                <div class="widget-card">
                    <div class="widget-card-header">
                        <div class="section-header mb-0">
                            <h3>Lampiran</h3>
                            <div class="shimmer-line"></div>
                        </div>
                    </div>
                    <div class="widget-card-body">
                        @php
                            $ext = pathinfo($surat->file_path, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                        @endphp
                        @if ($isImage)
                            <div class="rounded-xl overflow-hidden border border-gray-200">
                                <img src="{{ asset('storage/' . $surat->file_path) }}" alt="Lampiran surat"
                                    class="w-full max-h-96 object-contain bg-gray-50">
                            </div>
                        @else
                            <div class="flex items-center gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ basename($surat->file_path) }}</p>
                                    <p class="text-xs text-gray-500">File {{ strtoupper($ext) }}</p>
                                </div>
                                <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-semibold hover:bg-emerald-100 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                    Buka
                                </a>
                            </div>
                        @endif
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
                    <a href="{{ route('admin.surat-masuk.edit', $surat) }}"
                        class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        Edit Surat
                    </a>
                    @if ($surat->file_path)
                        <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank"
                            class="flex items-center justify-center gap-2 w-full border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Download Lampiran
                        </a>
                    @endif
                    <form method="POST" action="{{ route('admin.surat-masuk.destroy', $surat) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat masuk ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-red-500/20 hover:shadow-lg hover:shadow-red-500/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus Surat
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
                            <p class="text-xs font-semibold text-gray-800">{{ $surat->created_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Diubah</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $surat->updated_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Operator</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $surat->creator?->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 py-2.5">
                        <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Status</p>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $statusBadge }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kembali --}}
            <a href="{{ route('admin.surat-masuk.index') }}"
                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

</x-admin-layout>
