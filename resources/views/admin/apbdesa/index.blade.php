<x-admin-layout title="APBDesa" maxWidth="max-w-[1440px]">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">APBDesa</h1>
            <p class="text-gray-500 mt-1 text-sm">Anggaran Pendapatan dan Belanja Desa.</p>
        </div>
        <a href="{{ route('admin.apbdesa.create') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-200 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Data
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-micro bg-white border border-gray-200/80 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_anggaran'], 0, ',', '.') }}</p>
                    <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wide">Total Anggaran</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white border border-gray-200/80 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_realisasi'], 0, ',', '.') }}</p>
                    <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wide">Total Realisasi</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white border border-gray-200/80 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ round($stats['persentase']) }}%</p>
                    <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wide">Persentase</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white border border-gray-200/80 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L12 12.75 6.429 9.75m11.142 0l4.179 2.25-9.75 5.25-9.75-5.25 4.179-2.25"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['jumlah_items'] }}</p>
                    <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wide">Jumlah Item</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="widget-card mb-6">
        <div class="px-5 py-4">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari bidang atau uraian..."
                        class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                </div>
                <select name="tahun" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                    <option value="">Semua Tahun</option>
                    @foreach ($tahunList as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                <select name="kategori" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                    <option value="">Semua Kategori</option>
                    <option value="Pendapatan" {{ request('kategori') === 'Pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                    <option value="Belanja" {{ request('kategori') === 'Belanja' ? 'selected' : '' }}>Belanja</option>
                </select>
                <select name="status" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="Draft" {{ request('status') === 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Disetujui" {{ request('status') === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Direvisi" {{ request('status') === 'Direvisi' ? 'selected' : '' }}>Direvisi</option>
                    <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-sm hover:shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filter
                </button>
                @if (request()->hasAny(['search', 'tahun', 'kategori', 'status']))
                    <a href="{{ route('admin.apbdesa.index') }}"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="widget-card">
        <div class="overflow-x-auto">
            <table class="table-enhanced min-w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-5 py-4 text-left">Tahun</th>
                        <th class="px-5 py-4 text-center">Kategori</th>
                        <th class="px-5 py-4 text-left">Bidang</th>
                        <th class="px-5 py-4 text-left">Uraian</th>
                        <th class="px-5 py-4 text-right">Anggaran</th>
                        <th class="px-5 py-4 text-right">Realisasi</th>
                        <th class="px-5 py-4 text-right">Sisa</th>
                        <th class="px-5 py-4 text-center">Status</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($apbdesa as $item)
                        @php
                            $sisa = $item->anggaran - $item->realisasi;
                        @endphp
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <span class="font-mono text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg">{{ $item->tahun }}</span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $kategoriBadge = match($item->kategori) {
                                        'Pendapatan' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                        'Belanja' => 'bg-rose-50 text-rose-700 border border-rose-100',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-100',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $kategoriBadge }}">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-gray-600">{{ $item->bidang }}</td>
                            <td class="px-5 py-4 text-gray-600 max-w-[200px] truncate">{{ $item->uraian }}</td>
                            <td class="px-5 py-4 text-right font-semibold text-gray-900 whitespace-nowrap">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                            <td class="px-5 py-4 text-right font-semibold text-gray-900 whitespace-nowrap">Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                            <td class="px-5 py-4 text-right font-semibold whitespace-nowrap {{ $sisa >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                Rp {{ number_format($sisa, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $statusBadge = match($item->status) {
                                        'Draft' => 'bg-gray-50 text-gray-600 border border-gray-100',
                                        'Disetujui' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                        'Direvisi' => 'bg-amber-50 text-amber-700 border border-amber-100',
                                        'Ditolak' => 'bg-red-50 text-red-700 border border-red-100',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-100',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $statusBadge }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.apbdesa.show', $item) }}"
                                        class="inline-flex items-center gap-1 text-teal-600 hover:text-white text-xs font-semibold bg-teal-50 hover:bg-teal-600 px-2.5 py-1.5 rounded-lg transition-all duration-200"
                                        title="Detail">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.apbdesa.edit', $item) }}"
                                        class="inline-flex items-center gap-1 text-emerald-600 hover:text-white text-xs font-semibold bg-emerald-50 hover:bg-emerald-600 px-2.5 py-1.5 rounded-lg transition-all duration-200"
                                        title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.apbdesa.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data APBDesa ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-red-500 hover:text-white text-xs font-semibold bg-red-50 hover:bg-red-600 px-2.5 py-1.5 rounded-lg transition-all duration-200"
                                            title="Hapus">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16">
                                <div class="empty-state">
                                    <div class="empty-state-icon bg-gray-100">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9.75m0-3H6m3 3H6m3-6H6m3 6H6m9-9h.008v.008H16.5V5.25zm0 3h.008v.008H16.5V8.25z"/></svg>
                                    </div>
                                    <p class="text-sm text-gray-400 font-medium">Belum ada data APBDesa</p>
                                    <a href="{{ route('admin.apbdesa.create') }}" class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Data APBDesa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($apbdesa->hasPages())
            <div class="px-5 py-4 border-t border-gray-100/60">
                {{ $apbdesa->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>
