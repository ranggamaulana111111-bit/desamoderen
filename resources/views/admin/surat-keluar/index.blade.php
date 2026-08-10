<x-admin-layout title="Surat Keluar" maxWidth="max-w-[1440px]">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Surat Keluar</h1>
            <p class="text-gray-500 mt-1 text-sm">Kelola data surat keluar desa.</p>
        </div>
        <a href="{{ route('admin.surat-keluar.create') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-200 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Surat
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bento-card-static p-4 stat-micro">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Total</p>
                    <p class="text-xl font-bold text-gray-900 count-up">{{ $total }}</p>
                </div>
            </div>
        </div>
        <div class="bento-card-static p-4 stat-micro">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Hari Ini</p>
                    <p class="text-xl font-bold text-gray-900 count-up">{{ $hariIni }}</p>
                </div>
            </div>
        </div>
        <div class="bento-card-static p-4 stat-micro">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Minggu Ini</p>
                    <p class="text-xl font-bold text-gray-900 count-up">{{ $mingguIni }}</p>
                </div>
            </div>
        </div>
        <div class="bento-card-static p-4 stat-micro">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Bulan Ini</p>
                    <p class="text-xl font-bold text-gray-900 count-up">{{ $bulanIni }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="widget-card mb-6">
        <div class="widget-card-body">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor agenda, tujuan, perihal..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                </div>
                <select name="status" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition bg-white">
                    <option value="">Semua Status</option>
                    <option value="dikirim" {{ request('status') === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-sm hover:shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Filter
                </button>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="widget-card">
        <div class="overflow-x-auto">
            <table class="table-enhanced min-w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-left">No. Agenda</th>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Tujuan</th>
                        <th class="px-6 py-4 text-left">Perihal</th>
                        <th class="px-6 py-4 text-left">Jenis</th>
                        <th class="px-6 py-4 text-left">Sifat</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($surat as $item)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-100">{{ $item->nomor_agenda }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-xs whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_kirim)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-700 max-w-[180px] truncate">{{ $item->tujuan }}</td>
                            <td class="px-6 py-4 text-gray-700 max-w-[200px] truncate">{{ $item->perihal }}</td>
                            <td class="px-6 py-4">
                                <span class="chip chip-brand text-[11px]">{{ $item->jenis_surat }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $sifatColors = [
                                        'Biasa' => 'bg-gray-100 text-gray-600',
                                        'Segera' => 'bg-amber-100 text-amber-700',
                                        'Rahasia' => 'bg-red-100 text-red-700',
                                        'Penting' => 'bg-blue-100 text-blue-700',
                                    ];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $sifatColors[$item->sifat_surat] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $item->sifat_surat }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusConfig = [
                                        'dikirim' => ['bg-emerald-50 text-emerald-700 border-emerald-100', 'bg-emerald-500'],
                                        'diproses' => ['bg-blue-50 text-blue-700 border-blue-100', 'bg-blue-500'],
                                        'selesai' => ['bg-violet-50 text-violet-700 border-violet-100', 'bg-violet-500'],
                                        'ditolak' => ['bg-red-50 text-red-700 border-red-100', 'bg-red-500'],
                                    ];
                                    [$chipClass, $dotClass] = $statusConfig[$item->status] ?? ['bg-gray-50 text-gray-600 border-gray-100', 'bg-gray-400'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $chipClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.surat-keluar.show', $item) }}"
                                        class="inline-flex items-center gap-1 text-blue-600 hover:text-white text-xs font-semibold bg-blue-50 hover:bg-blue-600 px-3 py-1.5 rounded-lg transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Lihat
                                    </a>
                                    <a href="{{ route('admin.surat-keluar.edit', $item) }}"
                                        class="inline-flex items-center gap-1 text-emerald-600 hover:text-white text-xs font-semibold bg-emerald-50 hover:bg-emerald-600 px-3 py-1.5 rounded-lg transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.surat-keluar.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus surat keluar ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-red-500 hover:text-white text-xs font-semibold bg-red-50 hover:bg-red-600 px-3 py-1.5 rounded-lg transition-all duration-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16">
                                <div class="empty-state">
                                    <div class="empty-state-icon bg-gray-100">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    </div>
                                    <p class="text-sm text-gray-400 font-medium">Belum ada surat keluar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($surat->hasPages())
            <div class="px-6 py-4 border-t border-gray-100/60">
                {{ $surat->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>
