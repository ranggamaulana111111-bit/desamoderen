<div x-show="activeTab === 'audit-log'" x-cloak class="animate-fade-in">
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-stone-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-stone-100 text-stone-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Audit Log</h2>
                    <p class="text-xs text-gray-500">Riwayat perubahan konfigurasi desa</p>
                </div>
            </div>
        </div>

        {{-- Versioning Bar --}}
        @include('admin.setting.partials._versioning_bar')

        {{-- Audit Log Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="px-5 py-3.5 text-left font-medium text-gray-500 text-[11px] uppercase tracking-wider">User</th>
                        <th class="px-5 py-3.5 text-left font-medium text-gray-500 text-[11px] uppercase tracking-wider">Aksi</th>
                        <th class="px-5 py-3.5 text-left font-medium text-gray-500 text-[11px] uppercase tracking-wider hidden md:table-cell">Deskripsi</th>
                        <th class="px-5 py-3.5 text-left font-medium text-gray-500 text-[11px] uppercase tracking-wider hidden lg:table-cell">IP & Browser</th>
                        <th class="px-5 py-3.5 text-left font-medium text-gray-500 text-[11px] uppercase tracking-wider hidden lg:table-cell">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($auditLogs as $log)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600">
                                    {{ $log->user?->name ? substr($log->user->name, 0, 1) : 'S' }}
                                </div>
                                <span class="text-sm font-medium text-gray-800">{{ $log->user?->name ?? 'System' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold 
                                {{ str_starts_with($log->aksi, 'rollback') ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                                {{ $log->aksi }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-600 text-sm hidden md:table-cell max-w-xs truncate">{{ $log->deskripsi }}</td>
                        <td class="px-5 py-3.5 text-gray-400 text-xs hidden lg:table-cell">
                            <span class="text-[10px]">{{ $log->ip_address ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-400 text-xs hidden lg:table-cell whitespace-nowrap">{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center">
                            <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            <p class="text-sm text-gray-400 font-medium">Belum ada log perubahan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
