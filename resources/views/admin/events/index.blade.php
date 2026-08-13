<x-admin-layout title="Kalender Event" maxWidth="max-w-[1440px]">
    @push('styles')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <style>
        .fc { font-family: 'Montserrat', ui-sans-serif, system-ui, sans-serif !important; }
        .fc .fc-toolbar-title { font-size: 1.1rem; font-weight: 700; }
        .fc .fc-button { border-radius: 10px; font-weight: 600; font-size: 12px; padding: 6px 14px; }
        .fc .fc-button-primary { background: linear-gradient(135deg, #059669, #0891b2); border: none; }
        .fc .fc-button-primary:hover { background: linear-gradient(135deg, #047857, #0e7490); }
        .fc .fc-button-primary:not(:disabled).fc-button-active { background: #047857; }
        .fc .fc-daygrid-day-number { font-size: 13px; font-weight: 500; }
        .fc .fc-event { border-radius: 6px; font-size: 11px; font-weight: 600; padding: 2px 6px; border: none; }
        .fc .fc-daygrid-day.fc-day-today { background: rgba(16,185,129,0.06) !important; }
        .fc .fc-col-header-cell-cushion { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; }
    </style>
    @endpush

    {{-- ═══ HEADER ═══ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kalender Event</h1>
            <p class="text-sm text-gray-500 mt-0.5">Kelola seluruh kegiatan pemerintah desa</p>
        </div>
        <a href="{{ route('admin.events.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Event Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 animate-fade-in">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ═══ STAT CARDS ═══ --}}
    @php
        $totalEvents = $events->total();
        $upcomingCount = \App\Models\Event::where('status', 'akan_datang')->count();
        $ongoingCount = \App\Models\Event::where('status', 'berlangsung')->count();
        $completedCount = \App\Models\Event::where('status', 'selesai')->count();
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $totalEvents }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Total Event</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $upcomingCount }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Akan Datang</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $ongoingCount }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Berlangsung</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-400 to-gray-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $completedCount }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Selesai</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ CALENDAR ═══ --}}
    <div class="widget-card mb-6">
        <div class="widget-card-header">
            <h3 class="text-sm font-semibold text-gray-700">Kalender</h3>
            <div class="flex items-center gap-3 text-[10px] font-semibold">
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> Musrenbang</span>
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Rapat</span>
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-teal-500"></span> Lainnya</span>
            </div>
        </div>
        <div class="widget-card-body">
            <div id="calendar"></div>
        </div>
    </div>

    {{-- ═══ EVENT LIST ═══ --}}
    <div class="widget-card">
        <div class="widget-card-header">
            <h3 class="text-sm font-semibold text-gray-700">Semua Event</h3>
            <span class="chip chip-brand">{{ $totalEvents }} event</span>
        </div>
        @if ($events->isNotEmpty())
            <div class="widget-card-body-compact">
                <div class="overflow-x-auto">
                    <table class="table-enhanced">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th class="hidden sm:table-cell">Jenis</th>
                                <th>Tanggal</th>
                                <th class="hidden md:table-cell">Target</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                @php
                                    $dot = match($event->status) {
                                        'akan_datang' => 'bg-teal-500',
                                        'berlangsung' => 'bg-emerald-500',
                                        'selesai' => 'bg-gray-400',
                                        default => 'bg-gray-400',
                                    };
                                    $chip = match($event->status) {
                                        'akan_datang' => 'bg-teal-50 text-teal-700 border border-teal-100',
                                        'berlangsung' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                        'selesai' => 'bg-gray-50 text-gray-600 border border-gray-200',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-200',
                                    };
                                    $jenisIcon = match($event->jenis) {
                                        'musrenbangdes' => ['M3.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', 'text-violet-600', 'bg-violet-50'],
                                        'rapat' => ['M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z', 'text-green-600', 'bg-green-50'],
                                        'kegiatan' => ['M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z', 'text-teal-600', 'bg-teal-50'],
                                        default => ['M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'text-amber-600', 'bg-amber-50'],
                                    };
                                @endphp
                                <tr class="group hover:bg-gray-50/50 transition-colors">
                                    <td>
                                        <a href="{{ route('admin.events.show', $event) }}" class="flex items-center gap-3 group/link">
                                            <div class="w-9 h-9 rounded-xl {{ $jenisIcon[2] }} flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 {{ $jenisIcon[1] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $jenisIcon[0] }}"/></svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate group-hover/link:text-emerald-600 transition-colors">{{ $event->judul }}</p>
                                                <p class="text-[10px] text-gray-400 sm:hidden capitalize">{{ $event->jenis }}</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="hidden sm:table-cell">
                                        <span class="text-xs font-medium text-gray-500 capitalize">{{ $event->jenis }}</span>
                                    </td>
                                    <td class="text-gray-500 whitespace-nowrap text-sm">{{ $event->tanggal->locale('id')->translatedFormat('d M Y') }}</td>
                                    <td class="text-gray-500 text-sm hidden md:table-cell">
                                        @if ($event->rt_target && $event->rw_target)
                                            RT {{ $event->rt_target }}/RW {{ $event->rw_target }}
                                        @elseif ($event->rw_target)
                                            RW {{ $event->rw_target }}
                                        @else
                                            <span class="text-gray-400">Semua Warga</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="chip {{ $chip }}">
                                            <span class="pulse-dot {{ $dot }}"></span>
                                            {{ str_replace('_', ' ', $event->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('admin.events.show', $event) }}" class="text-emerald-700 bg-emerald-50 hover:bg-emerald-600 hover:text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-all">
                                                Detail
                                            </a>
                                            <a href="{{ route('admin.events.edit', $event) }}" class="text-amber-700 bg-amber-50 hover:bg-amber-600 hover:text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-all">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="inline"
                                                onsubmit="return confirm('Hapus event ini?')">
                                                @csrf @method('DELETE')
                                                <button class="text-red-700 bg-red-50 hover:bg-red-600 hover:text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-all">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($events->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">
                    {{ $events->links() }}
                </div>
            @endif
        @else
            <div class="empty-state py-12">
                <div class="empty-state-icon bg-gray-100">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <p class="text-sm text-gray-400">Belum ada event.</p>
                <a href="{{ route('admin.events.create') }}" class="mt-3 text-xs font-semibold text-emerald-600 hover:text-emerald-700">Buat Event Baru →</a>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {!! $eventsCalendarJson !!},
                locale: 'id',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek',
                },
                buttonIcons: {
                    prev: 'chevron-left',
                    next: 'chevron-right',
                },
                dayMaxEvents: 3,
                moreLinkText: function(n) {
                    return '+' + n + ' lainnya';
                },
                eventDidMount: function(info) {
                    info.el.title = info.event.title;
                },
            });
            calendar.render();
        });
    </script>
    @endpush
</x-admin-layout>
