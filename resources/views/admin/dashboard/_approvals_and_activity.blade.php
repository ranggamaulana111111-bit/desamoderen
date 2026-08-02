@if (!empty($approvals) && $approvals['total'] > 0)
<div class="grid grid-cols-1 xl:grid-cols-12 gap-5 animate-slide-up" style="animation-delay: 0.25s">
    <div class="xl:col-span-7 bento-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-800">Approval Center</h2>
                    <p class="text-xs text-gray-400">{{ $approvals['total'] }} menunggu tindakan {{ auth()->user()->role_label }}</p>
                </div>
            </div>
            @can('letter.view')
            <a href="{{ route('admin.pengajuan.index') }}" class="text-xs font-medium text-emerald-600 hover:text-emerald-700 flex items-center gap-1 bg-emerald-50 px-3 py-1.5 rounded-lg transition hover:bg-emerald-100">Lihat Semua <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a>
            @endcan
        </div>
        <div class="divide-y divide-gray-50" x-data="{ rejectModal: false, rejectId: null }">
            @forelse ($approvals['items'] as $item)
            <div class="flex items-center gap-3.5 px-5 py-3.5 hover:bg-gray-50/50 transition group">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 shrink-0 shadow-sm ring-2 ring-white">
                    {{ $item['user_avatar'] }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $item['user_name'] }}</p>
                        <span class="text-[10px] text-gray-400">•</span>
                        <p class="text-xs text-gray-500 truncate capitalize">{{ $item['jenis_surat'] }}</p>
                    </div>
                    <div class="flex items-center gap-2.5 mt-1">
                        <span class="badge-status {{ $item['status_color'] }}">{{ $item['status_label'] }}</span>
                        <span class="text-[11px] text-gray-400">{{ $item['created_at'] }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                    <form action="{{ route('admin.pengajuan.approve', $item['id']) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="w-8 h-8 rounded-lg bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 transition flex items-center justify-center" title="Setujui">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </button>
                    </form>
                    <button type="button" @click="rejectId = {{ $item['id'] }}; rejectModal = true" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition flex items-center justify-center" title="Tolak">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <a href="{{ $item['url'] }}" class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition flex items-center justify-center" title="Detail">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="px-5 py-12 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-gray-400 font-medium">Semua pengajuan sudah diproses</p>
                <p class="text-xs text-gray-300 mt-1">Tidak ada approval yang menunggu</p>
            </div>
            @endforelse

            {{-- Reject Modal with Catatan --}}
            <div x-show="rejectModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-transition.opacity>
                <div @click.outside="rejectModal = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6" x-transition.scale>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Tolak Pengajuan</h3>
                            <p class="text-xs text-gray-500">Berikan alasan penolakan</p>
                        </div>
                    </div>
                    <form :action="'{{ url('admin/pengajuan') }}/' + rejectId + '/reject'" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="catatan" class="block text-xs font-medium text-gray-700 mb-1.5">Catatan Penolakan <span class="text-red-500">*</span></label>
                            <textarea name="catatan" id="catatan" rows="3" required placeholder="Masukkan alasan penolakan..."
                                class="w-full px-3.5 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition resize-none"></textarea>
                        </div>
                        <div class="flex items-center gap-2 justify-end">
                            <button type="button" @click="rejectModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-xl transition shadow-sm">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="xl:col-span-5 bento-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Aktivitas Terbaru</h2>
                <p class="text-xs text-gray-400">Real-time activity log</p>
            </div>
        </div>
        <div class="max-h-[400px] overflow-y-auto">
            @forelse ($activities as $act)
            <div class="flex items-start gap-3.5 px-5 py-3.5 timeline-item hover:bg-gray-50/50 transition">
                <div class="relative shrink-0">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 shadow-sm ring-2 ring-white">
                        {{ $act['user_avatar'] }}
                    </div>
                    <div class="timeline-line"></div>
                </div>
                <div class="flex-1 min-w-0 pt-1">
                    <p class="text-sm text-gray-700 leading-snug">{{ $act['deskripsi'] }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs font-medium text-gray-500">{{ $act['user_name'] }}</span>
                        <span class="text-[10px] text-gray-400">•</span>
                        <span class="text-[10px] text-gray-400">{{ $act['waktu'] }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-5 py-12 text-center">
                <svg class="w-10 h-10 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-gray-400 font-medium">Belum ada aktivitas</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endif
