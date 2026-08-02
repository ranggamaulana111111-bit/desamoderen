<x-admin-layout title="Detail Event" maxWidth="max-w-[1200px]">
    @push('styles')
    <style>
        .info-row { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.625rem 0; }
        .info-row:not(:last-child) { border-bottom: 1px solid rgba(226,232,240,.5); }
        .dark .info-row:not(:last-child) { border-bottom-color: rgba(51,65,85,.4); }
        .info-row .icon-box { width: 2rem; height: 2rem; border-radius: 0.625rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .participant-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; transition: all .2s ease; border-radius: 0.75rem; }
        .participant-item:hover { background: rgba(16,185,129,.03); }
        .dark .participant-item:hover { background: rgba(16,185,129,.06); }
        .participant-item:not(:last-child) { border-bottom: 1px solid rgba(226,232,240,.4); }
        .dark .participant-item:not(:last-child) { border-bottom-color: rgba(51,65,85,.4); }
        .timeline-step { display: flex; flex-direction: column; align-items: center; position: relative; flex: 1; }
        .timeline-step .step-circle { width: 2.5rem; height: 2.5rem; border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; position: relative; z-index: 2; transition: all .4s cubic-bezier(.16,1,.3,1); }
        .timeline-step .step-label { font-size: 0.65rem; font-weight: 600; text-align: center; margin-top: 0.5rem; line-height: 1.2; max-width: 6rem; }
        .timeline-connector { position: absolute; top: 1.25rem; left: calc(50% + 1.5rem); width: calc(100% - 3rem); height: 2px; z-index: 1; }
        @media (max-width: 1023px) {
            .timeline-step { flex-direction: row; gap: 0.75rem; }
            .timeline-step .step-label { margin-top: 0; text-align: left; }
            .timeline-connector { display: none; }
            .timeline-mobile-line { position: absolute; left: 1.25rem; top: 2.5rem; width: 2px; height: calc(100% - 2.5rem); }
        }
    </style>
    @endpush

    {{-- Hero Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 via-slate-900 to-navy-900 p-6 sm:p-8 mb-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-teal-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="flex-1 min-w-0">
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-medium transition-colors mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Kalender
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">{{ $event->judul }}</h1>
                <p class="text-white/60 text-sm mt-1">Agenda kegiatan Pemerintah Desa</p>
            </div>
            <div class="shrink-0">
                @php
                    $heroBadge = match($event->status) {
                        'akan_datang' => ['bg-blue-500/20 text-blue-300 border-blue-500/30', 'Akan Datang'],
                        'berlangsung' => ['bg-emerald-500/20 text-emerald-300 border-emerald-500/30', 'Berlangsung'],
                        'selesai' => ['bg-gray-500/20 text-gray-300 border-gray-500/30', 'Selesai'],
                        default => ['bg-gray-500/20 text-gray-300 border-gray-500/30', $event->status],
                    };
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border {{ $heroBadge[0] }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                    {{ $heroBadge[1] }}
                </span>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3 mt-5 relative">
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $event->tanggal->locale('id')->translatedFormat('l, d F Y') }}
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }} - {{ $event->waktu_selesai ? \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') : 'Selesai' }} WIB
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $event->tempat ?? '-' }}
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                {{ ucfirst($event->jenis) }}
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-500/10 dark:to-teal-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Two-Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Informasi Event --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Informasi Event</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body">
                    <div class="space-y-1">
                        <div class="info-row">
                            <div class="icon-box bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Judul</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 text-right">{{ $event->judul }}</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Event</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 capitalize text-right">{{ $event->jenis }}</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 text-right">{{ $event->tanggal->locale('id')->translatedFormat('l, d F Y') }}</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jam</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 text-right">{{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }} - {{ $event->waktu_selesai ? \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') : 'Selesai' }} WIB</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 text-right">{{ $event->tempat ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-cyan-50 dark:bg-cyan-500/10 text-cyan-600 dark:text-cyan-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Target Peserta</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 text-right">
                                    @if ($event->rt_target && $event->rw_target)
                                        RT {{ $event->rt_target }} / RW {{ $event->rw_target }}
                                    @elseif ($event->rw_target)
                                        RW {{ $event->rw_target }}
                                    @else
                                        Semua Warga
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="icon-box bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0 flex items-center justify-between">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</span>
                                @php
                                    $statusBadge = match($event->status) {
                                        'akan_datang' => 'bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300',
                                        'berlangsung' => 'bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-300',
                                        'selesai' => 'bg-gray-100 text-gray-800 dark:bg-gray-500/20 dark:text-gray-300',
                                        default => 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-300',
                                    };
                                    $statusLabel = match($event->status) {
                                        'akan_datang' => 'Akan Datang',
                                        'berlangsung' => 'Berlangsung',
                                        'selesai' => 'Selesai',
                                        default => str_replace('_', ' ', $event->status),
                                    };
                                @endphp
                                <span class="badge-status {{ $statusBadge }}">{{ $statusLabel }}</span>
                            </div>
                        </div>
                    </div>
                    @if ($event->deskripsi)
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-start gap-3">
                                <div class="icon-box bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                                </div>
                                <div class="flex-1">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">Deskripsi</span>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $event->deskripsi }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Timeline Event --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Timeline Event</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body">
                    @php
                        $stepMap = ['draft' => 1, 'akan_datang' => 2, 'berlangsung' => 3, 'selesai' => 4];
                        $currentStep = $stepMap[$event->status] ?? 1;
                        $steps = [
                            ['label' => 'Draft', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                            ['label' => 'Dipublikasikan', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['label' => 'Sedang Berlangsung', 'icon' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z'],
                            ['label' => 'Selesai', 'icon' => 'M5 13l4 4L19 7'],
                        ];
                    @endphp
                    {{-- Desktop Horizontal --}}
                    <div class="hidden lg:flex items-start justify-between px-2">
                        @foreach ($steps as $i => $step)
                            <div class="timeline-step">
                                @if ($i > 0)
                                    <div class="timeline-connector">
                                        <div class="h-full w-full rounded-full {{ $currentStep > $i ? 'bg-emerald-500' : 'bg-gray-200 dark:bg-gray-600' }}"></div>
                                    </div>
                                @endif
                                @php
                                    $isComplete = $currentStep > $i + 1;
                                    $isActive = $currentStep === $i + 1;
                                @endphp
                                <div class="step-circle {{ $isComplete ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : ($isActive ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30 ring-4 ring-emerald-500/20' : 'bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500') }}">
                                    @if ($isComplete)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/></svg>
                                    @endif
                                </div>
                                <div class="step-label {{ $isComplete || $isActive ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400 dark:text-gray-500' }}">{{ $step['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                    {{-- Mobile Vertical --}}
                    <div class="lg:hidden space-y-1 relative">
                        <div class="timeline-mobile-line bg-gray-200 dark:bg-gray-600"></div>
                        @foreach ($steps as $i => $step)
                            @php
                                $isComplete = $currentStep > $i + 1;
                                $isActive = $currentStep === $i + 1;
                            @endphp
                            <div class="flex items-center gap-4 py-3 relative">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold z-10 {{ $isComplete ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : ($isActive ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30 ring-4 ring-emerald-500/20' : 'bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500') }}">
                                    @if ($isComplete)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <span>{{ $i + 1 }}</span>
                                    @endif
                                </div>
                                <span class="text-sm font-semibold {{ $isComplete || $isActive ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400 dark:text-gray-500' }}">{{ $step['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Target Peserta --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Target Peserta</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body">
                    <div class="flex flex-wrap items-center gap-3">
                        @php
                            $targetLabel = $event->rt_target && $event->rw_target
                                ? "RT {$event->rt_target} / RW {$event->rw_target}"
                                : ($event->rw_target ? "RW {$event->rw_target}" : 'Semua Warga');
                        @endphp
                        <span class="chip bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-500/20 px-3 py-1.5 text-sm">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            {{ $targetLabel }}
                        </span>
                        <span class="chip bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-500/20 px-3 py-1.5 text-sm">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            {{ $event->peserta->count() }} Peserta
                        </span>
                    </div>
                </div>
            </div>

            {{-- Daftar Peserta dengan Alpine.js Search + Filter --}}
            <div class="widget-card" x-data="{ search: '', filter: '' }">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Daftar Peserta</h3>
                        <span class="count-badge">{{ $event->peserta->count() }}</span>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" x-model="search" placeholder="Cari peserta..." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                        </div>
                        <select x-model="filter" class="text-sm border border-gray-200 dark:border-gray-600 rounded-xl px-3 py-2 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                            <option value="">Semua Status</option>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="absen">Absen</option>
                            <option value="null">Belum Respon</option>
                        </select>
                    </div>
                </div>
                @if ($event->peserta->isNotEmpty())
                    <div class="divide-y divide-gray-100 dark:divide-gray-700/60">
                        @foreach ($event->peserta as $p)
                            @php
                                $cBadge = match($p->konfirmasi) {
                                    'hadir' => 'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-300',
                                    'izin' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-300',
                                    'absen' => 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-300',
                                    default => 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400',
                                };
                                $cLabel = match($p->konfirmasi) {
                                    'hadir' => 'Hadir',
                                    'izin' => 'Izin',
                                    'absen' => 'Absen',
                                    default => 'Belum Respon',
                                };
                                $initials = strtoupper(substr($p->user->name, 0, 2));
                                $avatarColors = ['bg-emerald-500', 'bg-blue-500', 'bg-purple-500', 'bg-amber-500', 'bg-rose-500', 'bg-cyan-500', 'bg-indigo-500'];
                                $avatarColor = $avatarColors[crc32($p->user->id) % count($avatarColors)];
                            @endphp
                            <div class="participant-item"
                                 x-show="(search === '' || '{{ strtolower($p->user->name) }}'.includes(search.toLowerCase()) || '{{ $p->user->nik }}'.includes(search)) && (filter === '' || filter === '{{ $p->konfirmasi ?? 'null' }}')">
                                <div class="w-10 h-10 rounded-full {{ $avatarColor }} text-white flex items-center justify-center text-sm font-bold flex-shrink-0 shadow-sm">
                                    {{ $initials }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $p->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $p->user->nik }} &middot; {{ $p->user->rt ?? '-' }}/{{ $p->user->rw ?? '-' }}</p>
                                </div>
                                <span class="chip {{ $cBadge }} px-2.5 py-1 text-xs">{{ $cLabel }}</span>
                            </div>
                        @endforeach
                        <div x-show="(search !== '' || filter !== '') && $el.parentElement.querySelectorAll('.participant-item:not([style*=\"display: none\"])').length === 0"
                             class="empty-state">
                            <div class="empty-state-icon bg-gray-100 dark:bg-gray-700">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <p class="text-sm text-gray-400">Tidak ada peserta yang cocok.</p>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon bg-gray-100 dark:bg-gray-700">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857"/></svg>
                        </div>
                        <p class="text-sm text-gray-400">Belum ada peserta.</p>
                    </div>
                @endif
            </div>

            {{-- Ringkasan Kehadiran --}}
            @php
                $totalPeserta = $event->peserta->count();
                $hadir = $event->peserta->where('konfirmasi', 'hadir')->count();
                $izin = $event->peserta->where('konfirmasi', 'izin')->count();
                $absen = $event->peserta->where('konfirmasi', 'absen')->count();
                $belum = $event->peserta->whereNull('konfirmasi')->count();
                $hadirPct = $totalPeserta > 0 ? round(($hadir / $totalPeserta) * 100) : 0;
                $izinPct = $totalPeserta > 0 ? round(($izin / $totalPeserta) * 100) : 0;
                $absenPct = $totalPeserta > 0 ? round(($absen / $totalPeserta) * 100) : 0;
                $belumPct = $totalPeserta > 0 ? round(($belum / $totalPeserta) * 100) : 0;
            @endphp
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Ringkasan Kehadiran</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">
                        <div class="stat-micro bg-emerald-50 dark:bg-emerald-500/10 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 count-up">{{ $totalPeserta }}</p>
                            <p class="text-xs font-medium text-emerald-600/70 dark:text-emerald-400/70 mt-1">Total</p>
                        </div>
                        <div class="stat-micro bg-green-50 dark:bg-green-500/10 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400 count-up">{{ $hadir }}</p>
                            <p class="text-xs font-medium text-green-600/70 dark:text-green-400/70 mt-1">Hadir</p>
                        </div>
                        <div class="stat-micro bg-yellow-50 dark:bg-yellow-500/10 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 count-up">{{ $izin }}</p>
                            <p class="text-xs font-medium text-yellow-600/70 dark:text-yellow-400/70 mt-1">Izin</p>
                        </div>
                        <div class="stat-micro bg-gray-100 dark:bg-gray-700 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-gray-500 dark:text-gray-300 count-up">{{ $belum }}</p>
                            <p class="text-xs font-medium text-gray-500/70 dark:text-gray-300/70 mt-1">Belum Respon</p>
                        </div>
                    </div>
                    @if ($totalPeserta > 0)
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-medium text-green-600 dark:text-green-400">Hadir</span>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">{{ $hadirPct }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-bar-fill bg-green-500" style="width: {{ $hadirPct }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-medium text-yellow-600 dark:text-yellow-400">Izin</span>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">{{ $izinPct }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-bar-fill bg-yellow-500" style="width: {{ $izinPct }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-medium text-red-600 dark:text-red-400">Absen</span>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">{{ $absenPct }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-bar-fill bg-red-500" style="width: {{ $absenPct }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Belum Respon</span>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">{{ $belumPct }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $belumPct }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endif
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
                    <a href="{{ route('admin.events.edit', $event) }}"
                        class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Event
                    </a>
                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-red-500/20 hover:shadow-lg hover:shadow-red-500/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus Event
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
                        <div class="icon-box bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 widget-icon-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Dibuat</p>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $event->created_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="info-row !py-2.5">
                        <div class="icon-box bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 widget-icon-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Diubah</p>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $event->updated_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="info-row !py-2.5">
                        <div class="icon-box bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 widget-icon-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Operator</p>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $event->user->name }}</p>
                        </div>
                    </div>
                    <div class="info-row !py-2.5">
                        <div class="icon-box bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 widget-icon-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jumlah Peserta</p>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $event->peserta->count() }}</p>
                        </div>
                    </div>
                    <div class="info-row !py-2.5">
                        <div class="icon-box bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 widget-icon-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status</p>
                            <span class="badge-status {{ $statusBadge }} mt-0.5">{{ $statusLabel }}</span>
                        </div>
                    </div>
                    <div class="info-row !py-2.5">
                        <div class="icon-box bg-cyan-50 dark:bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 widget-icon-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Kategori</p>
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 capitalize">{{ $event->jenis }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
        <p class="text-xs text-gray-400 dark:text-gray-500 text-center">Prodesa &mdash; Sistem Informasi Pemerintahan Desa</p>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('participantFilter', () => ({
                search: '',
                filter: '',
            }));
        });
    </script>
    @endpush
</x-admin-layout>
