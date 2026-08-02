<x-admin-layout title="Template Surat">
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-600 font-medium">Template Surat</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Template Surat</h1>
                <p class="text-sm text-gray-500 mt-0.5">Kelola template surat dinamis untuk pengajuan warga</p>
            </div>
            <a href="{{ route('admin.letter-config.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm px-4 py-2.5 rounded-xl transition shadow-sm hover:shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Tambah Template
            </a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-2xl font-bold text-gray-900">{{ $templates->count() }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Total Template</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-2xl font-bold text-emerald-600">{{ $templates->where('is_active')->count() }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Aktif</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-2xl font-bold text-gray-400">{{ $templates->where('is_active', false)->count() }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Nonaktif</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-2xl font-bold text-blue-600">{{ $templates->sum(fn($t) => count($t->fields ?? [])) }}</p>
                <p class="text-xs text-gray-500 mt-0.5">Total Field</p>
            </div>
        </div>

        {{-- Template Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse ($templates as $template)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-md hover:border-emerald-200 transition group">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold">{{ substr($template->kode_klasifikasi, 0, 2) }}</span>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $template->label }}</p>
                                <p class="text-[11px] font-mono text-gray-400">{{ $template->jenis_surat }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium {{ $template->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $template->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                            {{ $template->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-4 text-[11px] text-gray-500 mb-3">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A1.875 1.875 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                            {{ $template->kode_klasifikasi }}
                        </span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span>{{ $template->masa_berlaku_bulan }} bulan</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span>{{ count($template->fields ?? []) }} field</span>
                    </div>

                    @if (!empty($template->body_template))
                    <div class="bg-gray-50 rounded-lg p-3 mb-3 max-h-16 overflow-hidden relative">
                        <p class="text-[10px] text-gray-500 leading-relaxed line-clamp-3">{{ Str::limit(strip_tags($template->body_template), 120) }}</p>
                        <div class="absolute bottom-0 left-0 right-0 h-6 bg-gradient-to-t from-gray-50 to-transparent"></div>
                    </div>
                    @endif
                </div>

                <div class="px-5 py-3 bg-gray-50/80 border-t border-gray-100 flex items-center justify-between">
                    <form action="{{ route('admin.letter-config.toggle', $template) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-[11px] font-medium transition {{ $template->is_active ? 'text-amber-600 hover:text-amber-700' : 'text-emerald-600 hover:text-emerald-700' }}">
                            {{ $template->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.letter-config.edit', $template) }}" class="inline-flex items-center gap-1 text-[11px] font-medium text-blue-600 hover:text-blue-700 transition">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.letter-config.destroy', $template) }}" method="POST" onsubmit="return confirm('Hapus template {{ addslashes($template->label) }}? Semua pengajuan terkait tidak akan terpengaruh.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 text-[11px] font-medium text-red-500 hover:text-red-600 transition">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16">
                <svg class="w-14 h-14 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                <p class="text-gray-500 font-medium">Belum ada template surat</p>
                <p class="text-sm text-gray-400 mt-1">Klik "Tambah Template" untuk membuat template baru</p>
            </div>
            @endforelse
        </div>
    </div>
</x-admin-layout>
