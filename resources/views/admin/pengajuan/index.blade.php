<x-admin-layout title="Pelayanan Surat" maxWidth="max-w-[1440px]">
    {{-- Quick Stats --}}
    @php
        $statusConfig = [
            '' => ['label' => 'Semua', 'icon' => 'M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z', 'gradient' => 'from-slate-400 to-slate-600', 'bg' => 'slate'],
            'submitted' => ['label' => 'Diajukan', 'icon' => 'M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z', 'gradient' => 'from-blue-400 to-indigo-500', 'bg' => 'blue'],
            'verified' => ['label' => 'Diverifikasi', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'gradient' => 'from-indigo-400 to-purple-500', 'bg' => 'indigo'],
            'approved_operator' => ['label' => 'Operator', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'gradient' => 'from-purple-400 to-violet-500', 'bg' => 'purple'],
            'approved_sekdes' => ['label' => 'Sekdes', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'gradient' => 'from-cyan-400 to-teal-500', 'bg' => 'cyan'],
            'approved_kades' => ['label' => 'Kades', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'gradient' => 'from-emerald-400 to-green-500', 'bg' => 'emerald'],
            'completed' => ['label' => 'Selesai', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'gradient' => 'from-green-400 to-emerald-500', 'bg' => 'green'],
            'rejected' => ['label' => 'Ditolak', 'icon' => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'gradient' => 'from-red-400 to-rose-500', 'bg' => 'red'],
        ];
        $currentStatus = request('status', '');
    @endphp

    {{-- Status Filter Tabs --}}
    <div class="flex flex-wrap gap-2 mb-6">
        @foreach ($statusConfig as $key => $cfg)
            @php $count = $stats[$key === '' ? 'all' : $key] ?? 0; @endphp
            <a href="{{ route('admin.pengajuan.index', array_filter(['status' => $key ?: null, 'jenis' => request('jenis'), 'search' => request('search')])) }}"
               class="group stat-micro inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-200
                   {{ $currentStatus === $key
                       ? "bg-gradient-to-r {$cfg['gradient']} text-white shadow-lg shadow-{$cfg['bg']}-500/20"
                       : "bg-white text-gray-600 border border-gray-200/60 hover:border-{$cfg['bg']}-200 hover:shadow-md" }}">
                <svg class="w-4 h-4 {{ $currentStatus === $key ? 'text-white/80' : "text-{$cfg['bg']}-500" }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cfg['icon'] }}"/>
                </svg>
                {{ $cfg['label'] }}
                <span class="{{ $currentStatus === $key ? 'bg-white/20 text-white' : "bg-{$cfg['bg']}-50 text-{$cfg['bg']}-600" }} px-1.5 py-0.5 rounded-full text-[10px] min-w-[20px] text-center">{{ $count }}</span>
            </a>
        @endforeach
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200/60 text-emerald-700 text-sm font-medium flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Search & Filter Bar --}}
    <div class="widget-card mb-6">
        <div class="widget-card-body-compact">
            <form action="{{ route('admin.pengajuan.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="hidden" name="status" value="{{ $currentStatus }}">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pemohon..."
                        class="w-full text-sm border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-gray-50/50 transition">
                </div>
                <div class="relative">
                    <select name="jenis"
                        class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-gray-50/50 pr-10 appearance-none transition">
                        <option value="">Semua Jenis</option>
                        @foreach ($letterConfigs as $lc)
                            <option value="{{ $lc->jenis_surat }}" {{ request('jenis') === $lc->jenis_surat ? 'selected' : '' }}>{{ $lc->label }}</option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Cari
                </button>
            </form>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="widget-card">
        <div class="overflow-x-auto">
            <table class="table-enhanced min-w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-left">Pemohon</th>
                        <th class="px-6 py-4 text-left">Jenis Surat</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($pengajuan as $item)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-400 to-teal-500 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                        {{ strtoupper(substr($item->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 group-hover:text-emerald-700 transition">{{ $item->user->name ?? '-' }}</p>
                                        <p class="text-[11px] text-gray-400">ID #{{ $item->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="chip bg-gray-50 text-gray-700 border border-gray-100 capitalize">{{ str_replace('_', ' ', $item->jenis_surat) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $item->status_color }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-60"></span>
                                    {{ $item->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap text-xs">
                                {{ $item->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    @can('letter.view')
                                    <a href="{{ route('admin.pengajuan.show', $item) }}"
                                        class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-white text-xs font-semibold bg-emerald-50 hover:bg-emerald-600 px-3 py-1.5 rounded-lg transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Detail
                                    </a>
                                    @endcan
                                    @if ($item->status === 'completed')
                                    @can('letter.print')
                                    <a href="{{ route('admin.pengajuan.cetak', $item) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 text-green-600 hover:text-white text-xs font-semibold bg-green-50 hover:bg-green-600 px-3 py-1.5 rounded-lg transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/></svg>
                                        Cetak
                                    </a>
                                    @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    </div>
                                    <p class="text-sm text-gray-400 font-medium">Belum ada pengajuan surat</p>
                                    <p class="text-xs text-gray-300 mt-1">Pengajuan akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pengajuan->hasPages())
            <div class="px-6 py-4 border-t border-gray-100/60">
                {{ $pengajuan->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
