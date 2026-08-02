<div x-show="activeTab === 'template-surat'" x-cloak class="animate-fade-in">
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-cyan-50/50 to-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">Template Surat</h2>
                        <p class="text-xs text-gray-500">Daftar template surat yang tersedia</p>
                    </div>
                </div>
                <a href="{{ route('admin.letter-config.index') }}" class="inline-flex items-center gap-2 text-xs font-medium text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    Kelola Template
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($letterTemplates as $template)
                <div class="relative group rounded-xl border border-gray-200 bg-white p-4 hover:shadow-md hover:border-emerald-200 transition">
                    <div class="flex items-start justify-between mb-2">
                        <span class="text-[10px] font-mono text-gray-400 bg-gray-100 px-2 py-0.5 rounded">{{ $template->jenis_surat }}</span>
                        <span class="w-2 h-2 rounded-full {{ $template->is_active ? 'bg-green-500' : 'bg-gray-300' }}" title="{{ $template->is_active ? 'Aktif' : 'Nonaktif' }}"></span>
                    </div>
                    <p class="text-sm font-semibold text-gray-800">{{ $template->label }}</p>
                    <p class="text-[11px] text-gray-500 mt-1">Kode: {{ $template->kode_klasifikasi ?? '-' }} &middot; {{ $template->masa_berlaku_bulan ?? 0 }} bln &middot; {{ count($template->fields ?? []) }} field</p>
                </div>
                @empty
                <div class="col-span-full text-center py-8">
                    <svg class="w-10 h-10 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    <p class="text-sm text-gray-400 font-medium">Belum ada template surat</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
