<x-admin-layout title="Laporan Desa Kuantitatif" maxWidth="max-w-[1600px]">
    @push('styles')
    <style>
        .stat-micro .stat-icon { transition: transform .3s cubic-bezier(.16,1,.3,1); }
        .stat-micro:hover .stat-icon { transform: scale(1.1) rotate(-3deg); }
    </style>
    @endpush

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 a-fade-up">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Laporan Desa Kuantitatif</h1>
            <p class="text-gray-500 mt-1 text-sm">Kelola laporan kuantitatif desa untuk periodik dan khusus.</p>
        </div>
        <a href="{{ route('admin.laporan.create') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-200 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Buat Laporan Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 animate-fade-in">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm a-fade-up d1">
            <div class="flex items-center gap-3">
                <div class="stat-icon w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Total Laporan</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm a-fade-up d2">
            <div class="flex items-center gap-3">
                <div class="stat-icon w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $stats['draft'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Draf</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm a-fade-up d3">
            <div class="flex items-center gap-3">
                <div class="stat-icon w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $stats['finalisasi'] }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Finalisasi</p>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="widget-card mb-6 a-fade-up d4">
        <div class="widget-card-body">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau nomor laporan..."
                        class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                </div>
                <select name="status" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="finalisasi" {{ request('status') === 'finalisasi' ? 'selected' : '' }}>Finalisasi</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                <select name="tipe_periode" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                    <option value="">Semua Periode</option>
                    <option value="bulanan" {{ request('tipe_periode') === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="kuartal" {{ request('tipe_periode') === 'kuartal' ? 'selected' : '' }}>Kuartal</option>
                    <option value="tahunan" {{ request('tipe_periode') === 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                    <option value="khusus" {{ request('tipe_periode') === 'khusus' ? 'selected' : '' }}>Khusus</option>
                </select>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-sm hover:shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
                @if (request()->hasAny(['search', 'status', 'tipe_periode']))
                    <a href="{{ route('admin.laporan.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="widget-card a-fade-up d5">
        <div class="widget-card-header">
            <h3 class="text-sm font-semibold text-gray-700">Daftar Laporan</h3>
            <span class="chip chip-brand">{{ $laporan->total() }} laporan</span>
        </div>
        @if ($laporan->isNotEmpty())
            <div class="widget-card-body-compact">
                <div class="overflow-x-auto">
                    <table class="table-enhanced">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Judul</th>
                                <th>Periode</th>
                                <th class="hidden md:table-cell">Modul</th>
                                <th>Status</th>
                                <th class="hidden lg:table-cell">Format</th>
                                <th class="hidden sm:table-cell">Dibuat Oleh</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $item)
                                @php
                                    $statusChip = match($item->status) {
                                        'draft' => 'bg-amber-50 text-amber-700 border border-amber-100',
                                        'finalisasi' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                        'archived' => 'bg-gray-50 text-gray-600 border border-gray-200',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-200',
                                    };
                                    $statusDot = match($item->status) {
                                        'draft' => 'bg-amber-500',
                                        'finalisasi' => 'bg-emerald-500',
                                        'archived' => 'bg-gray-400',
                                        default => 'bg-gray-400',
                                    };
                                @endphp
                                <tr class="group hover:bg-gray-50/50 transition-colors">
                                    <td>
                                        <span class="font-mono text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-100">{{ $item->nomor_laporan ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.laporan.show', $item) }}" class="flex items-center gap-3 group/link">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4.5 h-4.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate group-hover/link:text-emerald-600 transition-colors max-w-[220px]">{{ $item->judul }}</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-xs font-medium text-gray-500 whitespace-nowrap">{{ $item->periode_label ?? '-' }}</span>
                                    </td>
                                    <td class="hidden md:table-cell">
                                        <span class="chip chip-brand text-[11px]">{{ implode(', ', $item->module_labels ?? []) }}</span>
                                    </td>
                                    <td>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $statusChip }}">
                                            <span class="pulse-dot {{ $statusDot }}"></span>
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="hidden lg:table-cell">
                                        <span class="text-xs font-medium text-gray-500 whitespace-nowrap">{{ $item->format_pdf === 'laporan_institusional' ? 'Institusional' : 'Surat Resmi' }}</span>
                                    </td>
                                    <td class="hidden sm:table-cell">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-[9px] font-bold flex-shrink-0">
                                                {{ strtoupper(substr($item->creator->name ?? 'A', 0, 1)) }}
                                            </div>
                                            <span class="text-xs font-medium text-gray-600 truncate max-w-[120px]">{{ $item->creator->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-xs text-gray-400 whitespace-nowrap">{{ $item->created_at?->locale('id')->translatedFormat('d M Y') ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('admin.laporan.show', $item) }}"
                                                class="text-blue-700 bg-blue-50 hover:bg-blue-600 hover:text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-all duration-200"
                                                title="Lihat">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            </a>
                                            @if ($item->status === 'draft')
                                                <a href="{{ route('admin.laporan.edit', $item) }}"
                                                    class="text-emerald-700 bg-emerald-50 hover:bg-emerald-600 hover:text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-all duration-200"
                                                    title="Edit">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.laporan.pdf', $item) }}"
                                                class="text-violet-700 bg-violet-50 hover:bg-violet-600 hover:text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-all duration-200"
                                                title="PDF">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                            </a>
                                            @if ($item->status === 'draft')
                                                <form action="{{ route('admin.laporan.destroy', $item) }}" method="POST" class="inline"
                                                    onsubmit="return confirm('Hapus laporan ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-700 bg-red-50 hover:bg-red-600 hover:text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg transition-all duration-200"
                                                        title="Hapus">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($laporan->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">
                    {{ $laporan->links() }}
                </div>
            @endif
        @else
            <div class="empty-state py-12">
                <div class="empty-state-icon bg-gray-100">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <p class="text-sm text-gray-400">Belum ada laporan.</p>
                <a href="{{ route('admin.laporan.create') }}" class="mt-3 text-xs font-semibold text-emerald-600 hover:text-emerald-700">Buat Laporan Baru &rarr;</a>
            </div>
        @endif
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
