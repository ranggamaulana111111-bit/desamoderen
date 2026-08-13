<x-admin-layout title="Detail Disposisi" maxWidth="max-w-[1200px]">
    @push('styles')
    <style>
        .info-row { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.625rem 0; }
        .info-row:not(:last-child) { border-bottom: 1px solid rgba(226,232,240,.5); }
        .info-row .icon-box { width: 2rem; height: 2rem; border-radius: 0.625rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    </style>
    @endpush

    {{-- Hero Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 via-slate-900 to-navy-900 p-6 sm:p-8 mb-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-teal-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="flex-1 min-w-0">
                <a href="{{ route('admin.disposisi.index') }}" class="inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-medium transition-colors mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar Disposisi
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">Disposisi Surat</h1>
                <p class="text-white/60 text-sm mt-1">{{ $disposisi->suratMasuk->pengirim ?? '-' }} &mdash; {{ $disposisi->suratMasuk->perihal ?? '-' }}</p>
            </div>
            <div class="shrink-0 flex items-center gap-2">
                @php
                    $heroStatus = match($disposisi->status) {
                        'Diproses' => ['bg-teal-500/20 text-teal-300 border-teal-500/30', 'Diproses'],
                        'Selesai' => ['bg-emerald-500/20 text-emerald-300 border-emerald-500/30', 'Selesai'],
                        default => ['bg-gray-500/20 text-gray-300 border-gray-500/30', 'Diteruskan'],
                    };
                    $heroSifat = match($disposisi->sifat_disposisi) {
                        'Segera' => ['bg-red-500/20 text-red-300 border-red-500/30', 'Segera'],
                        'Rahasia' => ['bg-purple-500/20 text-purple-300 border-purple-500/30', 'Rahasia'],
                        'Penting' => ['bg-amber-500/20 text-amber-300 border-amber-500/30', 'Penting'],
                        default => ['bg-gray-500/20 text-gray-300 border-gray-500/30', 'Biasa'],
                    };
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $heroSifat[0] }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ $heroSifat[1] }}
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $heroStatus[0] }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ $heroStatus[1] }}
                </span>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3 mt-5 relative">
            <span class="chip border border-white/10 bg-white/5 text-white/80">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                {{ $disposisi->tujuanUser->name ?? '-' }}
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Deadline: {{ \Carbon\Carbon::parse($disposisi->deadline)->locale('id')->translatedFormat('l, d F Y H:i') }}
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $disposisi->created_at->locale('id')->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Two-Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Informasi Disposisi --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Informasi Disposisi</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body">
                    <div class="space-y-1">
                        <div class="info-row">
                            <div class="icon-box bg-cyan-50 text-cyan-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Surat Masuk</span>
                                <span class="text-sm font-semibold text-gray-900 text-right">{{ $disposisi->suratMasuk->pengirim ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-teal-50 text-teal-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</span>
                                <span class="text-sm font-semibold text-gray-900 text-right">{{ $disposisi->suratMasuk->perihal ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-emerald-50 text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</span>
                                <span class="text-sm font-semibold text-gray-900 text-right">{{ $disposisi->tujuanUser->name ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-amber-50 text-amber-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Sifat</span>
                                @php
                                    $sifatBadge = match($disposisi->sifat_disposisi) {
                                        'Segera' => 'bg-red-100 text-red-700',
                                        'Rahasia' => 'bg-purple-100 text-purple-700',
                                        'Penting' => 'bg-amber-100 text-amber-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="badge-status {{ $sifatBadge }}">{{ $disposisi->sifat_disposisi }}</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-rose-50 text-rose-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</span>
                                @php
                                    $isOverdue = \Carbon\Carbon::parse($disposisi->deadline)->isPast() && $disposisi->status !== 'Selesai';
                                @endphp
                                <span class="text-sm font-semibold {{ $isOverdue ? 'text-red-600' : 'text-gray-900' }} text-right">
                                    {{ \Carbon\Carbon::parse($disposisi->deadline)->locale('id')->translatedFormat('l, d F Y H:i') }}
                                    @if ($isOverdue)
                                        <span class="text-[10px] font-bold text-red-500 block">Deadline terlewati</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-cyan-50 text-cyan-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</span>
                                @php
                                    $statusBadge = match($disposisi->status) {
                                        'Diproses' => 'bg-teal-100 text-teal-700',
                                        'Selesai' => 'bg-emerald-100 text-emerald-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="badge-status {{ $statusBadge }}">{{ $disposisi->status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Isi Disposisi --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Isi Disposisi</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body">
                    <div class="rounded-xl bg-gray-50 border border-gray-100 p-4">
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $disposisi->isi_disposisi }}</p>
                    </div>
                </div>
            </div>
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
                    <a href="{{ route('admin.disposisi.edit', $disposisi) }}"
                        class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Disposisi
                    </a>
                    <form method="POST" action="{{ route('admin.disposisi.destroy', $disposisi) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus disposisi ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-red-500/20 hover:shadow-lg hover:shadow-red-500/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus Disposisi
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
                    <div class="info-row !py-2.5">
                        <div class="icon-box bg-emerald-50 text-emerald-600 widget-icon-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Dibuat</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $disposisi->created_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="info-row !py-2.5">
                        <div class="icon-box bg-amber-50 text-amber-600 widget-icon-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Diubah</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $disposisi->updated_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="info-row !py-2.5">
                        <div class="icon-box bg-purple-50 text-purple-600 widget-icon-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Dibuat Oleh</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $disposisi->creator->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="mt-8 pt-6 border-t border-gray-200">
        <p class="text-xs text-gray-400 text-center">Prodesa &mdash; Sistem Informasi Pemerintahan Desa</p>
    </div>
</x-admin-layout>
