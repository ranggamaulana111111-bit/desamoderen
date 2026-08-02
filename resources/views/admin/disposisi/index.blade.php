<x-admin-layout title="Disposisi" maxWidth="max-w-[1600px]">
    @push('styles')
    <style>
        .stat-micro .stat-icon { transition: transform .3s cubic-bezier(.16,1,.3,1); }
        .stat-micro:hover .stat-icon { transform: scale(1.1) rotate(-3deg); }
    </style>
    @endpush

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Disposisi Surat</h1>
            <p class="text-sm text-gray-500 mt-0.5">Kelola disposisi surat masuk</p>
        </div>
        <a href="{{ route('admin.disposisi.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Disposisi
        </a>
    </div>

    @if (session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="stat-icon w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $total }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Total</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="stat-icon w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $hariIni }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="stat-icon w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $deadlineLewat }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Deadline Lewat</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="stat-icon w-10 h-10 rounded-xl bg-gradient-to-br from-slate-400 to-gray-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xl font-extrabold text-gray-900">{{ $selesai }}</p>
                    <p class="text-[10px] text-gray-500 font-medium">Selesai</p>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="widget-card mb-6">
        <div class="widget-card-body">
            <form method="GET" action="{{ route('admin.disposisi.index') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengirim atau perihal..."
                        class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                </div>
                <select name="status" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="Diteruskan" {{ request('status') === 'Diteruskan' ? 'selected' : '' }}>Diteruskan</option>
                    <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm transition-all hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="widget-card">
        <div class="widget-card-header">
            <h3 class="text-sm font-semibold text-gray-700">Daftar Disposisi</h3>
            <span class="chip chip-brand">{{ $disposisi->total() }} disposisi</span>
        </div>
        @if ($disposisi->isNotEmpty())
            <div class="widget-card-body-compact">
                <div class="overflow-x-auto">
                    <table class="table-enhanced">
                        <thead>
                            <tr>
                                <th>Surat Masuk</th>
                                <th class="hidden md:table-cell">Tujuan</th>
                                <th class="hidden lg:table-cell">Sifat</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($disposisi as $d)
                                @php
                                    $sifatChip = match($d->sifat_disposisi) {
                                        'Segera' => 'bg-red-50 text-red-700 border border-red-100',
                                        'Rahasia' => 'bg-purple-50 text-purple-700 border border-purple-100',
                                        'Penting' => 'bg-amber-50 text-amber-700 border border-amber-100',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-200',
                                    };
                                    $sifatDot = match($d->sifat_disposisi) {
                                        'Segera' => 'bg-red-500',
                                        'Rahasia' => 'bg-purple-500',
                                        'Penting' => 'bg-amber-500',
                                        default => 'bg-gray-400',
                                    };
                                    $statusChip = match($d->status) {
                                        'Diproses' => 'bg-blue-50 text-blue-700 border border-blue-100',
                                        'Selesai' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-200',
                                    };
                                    $statusDot = match($d->status) {
                                        'Diproses' => 'bg-blue-500',
                                        'Selesai' => 'bg-emerald-500',
                                        default => 'bg-gray-400',
                                    };
                                    $isOverdue = \Carbon\Carbon::parse($d->deadline)->isPast() && $d->status !== 'Selesai';
                                @endphp
                                <tr class="group hover:bg-gray-50/50 transition-colors">
                                    <td>
                                        <a href="{{ route('admin.disposisi.show', $d) }}" class="flex items-center gap-3 group/link">
                                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4.5 h-4.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate group-hover/link:text-emerald-600 transition-colors">{{ $d->suratMasuk->pengirim ?? '-' }}</p>
                                                <p class="text-[10px] text-gray-400 truncate max-w-[200px]">{{ $d->suratMasuk->perihal ?? '-' }}</p>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="hidden md:table-cell">
                                        <span class="text-xs font-medium text-gray-600">{{ $d->tujuanUser->name ?? '-' }}</span>
                                    </td>
                                    <td class="hidden lg:table-cell">
                                        <span class="chip {{ $sifatChip }}">
                                            <span class="pulse-dot {{ $sifatDot }}"></span>
                                            {{ $d->sifat_disposisi }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-xs font-medium {{ $isOverdue ? 'text-red-600 font-bold' : 'text-gray-500' }} whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($d->deadline)->format('d M Y, H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="chip {{ $statusChip }}">
                                            <span class="pulse-dot {{ $statusDot }}"></span>
                                            {{ $d->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('admin.disposisi.show', $d) }}" class="text-emerald-700 bg-emerald-50 hover:bg-emerald-600 hover:text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-all">
                                                Detail
                                            </a>
                                            <a href="{{ route('admin.disposisi.edit', $d) }}" class="text-amber-700 bg-amber-50 hover:bg-amber-600 hover:text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-all">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.disposisi.destroy', $d) }}" class="inline"
                                                onsubmit="return confirm('Hapus disposisi ini?')">
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
            @if ($disposisi->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">
                    {{ $disposisi->links() }}
                </div>
            @endif
        @else
            <div class="empty-state py-12">
                <div class="empty-state-icon bg-gray-100">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <p class="text-sm text-gray-400">Belum ada disposisi.</p>
                <a href="{{ route('admin.disposisi.create') }}" class="mt-3 text-xs font-semibold text-emerald-600 hover:text-emerald-700">Buat Disposisi Baru &rarr;</a>
            </div>
        @endif
    </div>
</x-admin-layout>
