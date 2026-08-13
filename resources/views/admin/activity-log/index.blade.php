<x-admin-layout title="Log Aktivitas" maxWidth="max-w-[1440px]">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Log Aktivitas</h1>
            <p class="text-gray-500 mt-1 text-sm">Riwayat seluruh aktivitas di sistem.</p>
        </div>
        @if ($logs->total() > 0)
        <form method="POST" action="{{ route('admin.activity-log.destroyAll') }}"
            onsubmit="return confirm('Yakin ingin menghapus seluruh log aktivitas?')" class="self-start">
            @csrf @method('DELETE')
            <input type="hidden" name="tipe" value="{{ request('tipe') }}">
            <button type="submit"
                class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-600 hover:text-white px-4 py-2.5 rounded-xl border border-red-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                Hapus Semua
            </button>
        </form>
        @endif
    </div>

    {{-- Filter Bar --}}
    <div class="widget-card mb-6">
        <div class="widget-card-body-compact">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas..."
                        class="w-full text-sm border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-gray-50/50 transition">
                </div>
                <div class="relative">
                    <select name="tipe" class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-gray-50/50 pr-10 appearance-none transition">
                        <option value="">Semua Tipe</option>
                        @foreach ($types as $type)
                            <option value="{{ $type }}" {{ request('tipe') === $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Filter
                </button>
            </form>
        </div>
    </div>

    <div class="widget-card">
        <div class="overflow-x-auto">
            <table class="table-enhanced min-w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-left">Waktu</th>
                        <th class="px-6 py-4 text-left">User</th>
                        <th class="px-6 py-4 text-left">Aksi</th>
                        <th class="px-6 py-4 text-left">Deskripsi</th>
                        <th class="px-6 py-4 text-left">Tipe</th>
                        <th class="px-6 py-4 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($logs as $log)
                        @php
                            $aksiColor = match(true) {
                                str_contains($log->aksi, 'create') => 'emerald',
                                str_contains($log->aksi, 'approve') || str_contains($log->aksi, 'update') => 'teal',
                                str_contains($log->aksi, 'delete') || str_contains($log->aksi, 'reject') => 'red',
                                str_contains($log->aksi, 'login') => 'purple',
                                default => 'gray',
                            };
                        @endphp
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">{{ $log->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-{{ $aksiColor }}-400 to-{{ $aksiColor }}-500 flex items-center justify-center text-white text-[10px] font-bold shadow-sm">
                                        {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <span class="text-gray-900 font-medium text-xs">{{ $log->user->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-{{ $aksiColor }}-50 text-{{ $aksiColor }}-700 border border-{{ $aksiColor }}-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-{{ $aksiColor }}-500"></span>
                                    {{ str_replace('_', ' ', $log->aksi) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 max-w-md truncate text-xs">{{ $log->deskripsi }}</td>
                            <td class="px-6 py-4">
                                @if ($log->tipe)
                                    <span class="chip bg-gray-50 text-gray-500 border border-gray-100">{{ $log->tipe }} #{{ $log->target_id }}</span>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <form method="POST" action="{{ route('admin.activity-log.destroy', $log) }}"
                                        onsubmit="return confirm('Hapus log ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 text-red-600 hover:text-white text-xs font-semibold bg-red-50 hover:bg-red-600 px-3 py-1.5 rounded-lg transition-all duration-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                    </div>
                                    <p class="text-sm text-gray-400 font-medium">Belum ada log aktivitas</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-100/60">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
