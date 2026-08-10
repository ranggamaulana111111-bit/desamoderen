<x-admin-layout title="Inventaris & Aset" maxWidth="max-w-[1440px]">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Inventaris & Aset</h1>
            <p class="text-gray-500 mt-1 text-sm">Kelola data inventaris dan aset desa.</p>
        </div>
        <a href="{{ route('admin.inventaris.create') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-200 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Barang
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-micro bg-white border border-gray-200/80 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-600 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wide">Total Barang</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white border border-gray-200/80 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_nilai'], 0, ',', '.') }}</p>
                    <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wide">Total Nilai</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white border border-gray-200/80 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['baiks'] }}</p>
                    <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wide">Kondisi Baik</p>
                </div>
            </div>
        </div>
        <div class="stat-micro bg-white border border-gray-200/80 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['rusaks'] }}</p>
                    <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wide">Rusak / Perawatan</p>
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode, nama barang, atau lokasi..."
                        class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                </div>
                <select name="kategori" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                    <option value="">Semua Kategori</option>
                    <option value="Peralatan" {{ request('kategori') === 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                    <option value="Kendaraan" {{ request('kategori') === 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                    <option value="Gedung" {{ request('kategori') === 'Gedung' ? 'selected' : '' }}>Gedung</option>
                    <option value="Tanah" {{ request('kategori') === 'Tanah' ? 'selected' : '' }}>Tanah</option>
                    <option value="Furniture" {{ request('kategori') === 'Furniture' ? 'selected' : '' }}>Furniture</option>
                    <option value="Elektronik" {{ request('kategori') === 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                    <option value="Lainnya" {{ request('kategori') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                <select name="kondisi" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                    <option value="">Semua Kondisi</option>
                    <option value="Baik" {{ request('kondisi') === 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ request('kondisi') === 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ request('kondisi') === 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    <option value="Perawatan" {{ request('kondisi') === 'Perawatan' ? 'selected' : '' }}>Perawatan</option>
                </select>
                <select name="status" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="Digunakan" {{ request('status') === 'Digunakan' ? 'selected' : '' }}>Digunakan</option>
                    <option value="Tersedia" {{ request('status') === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Disimpan" {{ request('status') === 'Disimpan' ? 'selected' : '' }}>Disimpan</option>
                    <option value="Dihapus" {{ request('status') === 'Dihapus' ? 'selected' : '' }}>Dihapus</option>
                </select>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-sm hover:shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filter
                </button>
                @if (request()->hasAny(['search', 'kategori', 'kondisi', 'status']))
                    <a href="{{ route('admin.inventaris.index') }}"
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
                        <th class="px-5 py-4 text-left">Kode</th>
                        <th class="px-5 py-4 text-left">Nama Barang</th>
                        <th class="px-5 py-4 text-center">Kategori</th>
                        <th class="px-5 py-4 text-center">Kondisi</th>
                        <th class="px-5 py-4 text-center">Jumlah</th>
                        <th class="px-5 py-4 text-left">Lokasi</th>
                        <th class="px-5 py-4 text-right">Nilai Perolehan</th>
                        <th class="px-5 py-4 text-center">Status</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($inventaris as $item)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <span class="font-mono text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg">{{ $item->kode }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-900 group-hover:text-emerald-700 transition max-w-[200px] truncate">{{ $item->nama_barang }}</p>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $kategoriBadge = match($item->kategori) {
                                        'Peralatan' => 'bg-blue-50 text-blue-700 border border-blue-100',
                                        'Kendaraan' => 'bg-violet-50 text-violet-700 border border-violet-100',
                                        'Gedung' => 'bg-amber-50 text-amber-700 border border-amber-100',
                                        'Tanah' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                        'Furniture' => 'bg-cyan-50 text-cyan-700 border border-cyan-100',
                                        'Elektronik' => 'bg-indigo-50 text-indigo-700 border border-indigo-100',
                                        'Lainnya' => 'bg-gray-50 text-gray-600 border border-gray-100',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-100',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $kategoriBadge }}">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $kondisiBadge = match($item->kondisi) {
                                        'Baik' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                        'Rusak Ringan' => 'bg-amber-50 text-amber-700 border border-amber-100',
                                        'Rusak Berat' => 'bg-red-50 text-red-700 border border-red-100',
                                        'Perawatan' => 'bg-orange-50 text-orange-700 border border-orange-100',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-100',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $kondisiBadge }}">
                                    {{ $item->kondisi }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center text-gray-700 font-medium">{{ $item->jumlah }}</td>
                            <td class="px-5 py-4 text-gray-600 max-w-[150px] truncate">{{ $item->lokasi }}</td>
                            <td class="px-5 py-4 text-right font-semibold text-gray-900 whitespace-nowrap">Rp {{ number_format($item->nilai_perolehan, 0, ',', '.') }}</td>
                            <td class="px-5 py-4 text-center">
                                @php
                                    $statusBadge = match($item->status) {
                                        'Digunakan' => 'bg-blue-50 text-blue-700 border border-blue-100',
                                        'Tersedia' => 'bg-emerald-50 text-emerald-700 border border-emerald-100',
                                        'Disimpan' => 'bg-gray-100 text-gray-600 border border-gray-200',
                                        'Dihapus' => 'bg-red-50 text-red-700 border border-red-100',
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
                                    <a href="{{ route('admin.inventaris.show', $item) }}"
                                        class="inline-flex items-center gap-1 text-blue-600 hover:text-white text-xs font-semibold bg-blue-50 hover:bg-blue-600 px-2.5 py-1.5 rounded-lg transition-all duration-200"
                                        title="Detail">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.inventaris.edit', $item) }}"
                                        class="inline-flex items-center gap-1 text-emerald-600 hover:text-white text-xs font-semibold bg-emerald-50 hover:bg-emerald-600 px-2.5 py-1.5 rounded-lg transition-all duration-200"
                                        title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.inventaris.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus barang inventaris ini?')">
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
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                                    </div>
                                    <p class="text-sm text-gray-400 font-medium">Belum ada inventaris</p>
                                    <a href="{{ route('admin.inventaris.create') }}" class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Barang Inventaris
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($inventaris->hasPages())
            <div class="px-5 py-4 border-t border-gray-100/60">
                {{ $inventaris->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>
