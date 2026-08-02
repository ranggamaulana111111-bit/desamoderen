<x-admin-layout title="Detail Berita" maxWidth="max-w-[1200px]">
    @if (session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 animate-fade-in">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Hero Foto --}}
            @if ($beritum->foto)
                <div class="widget-card overflow-hidden">
                    <img src="{{ asset('storage/' . $beritum->foto) }}" alt="{{ $beritum->judul }}"
                        class="w-full h-64 sm:h-80 object-cover">
                </div>
            @endif

            {{-- Konten --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <h3 class="section-header">
                        <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                        Konten Berita
                    </h3>
                </div>
                <div class="widget-card-body">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight mb-4">{{ $beritum->judul }}</h1>
                    <div class="prose prose-sm prose-gray max-w-none text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $beritum->konten }}</div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Info Berita --}}
            <div class="widget-card lg:sticky lg:top-6">
                <div class="widget-card-header">
                    <h3 class="section-header">
                        <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-blue-500 to-indigo-600 mr-2"></span>
                        Informasi
                    </h3>
                </div>
                <div class="widget-card-body space-y-4">
                    {{-- Status --}}
                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0
                            {{ $beritum->status === 'publish' ? 'bg-emerald-100' : 'bg-gray-100' }}">
                            <svg class="w-4.5 h-4.5 {{ $beritum->status === 'publish' ? 'text-emerald-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                @if ($beritum->status === 'publish')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                @endif
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Status</p>
                            <p class="text-sm font-bold {{ $beritum->status === 'publish' ? 'text-emerald-700' : 'text-gray-600' }}">
                                {{ ucfirst($beritum->status) }}
                            </p>
                        </div>
                    </div>

                    {{-- Penulis --}}
                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                        <div class="w-9 h-9 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                            <svg class="w-4.5 h-4.5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Penulis</p>
                            <p class="text-sm font-bold text-gray-800">{{ $beritum->user->name }}</p>
                        </div>
                    </div>

                    {{-- Tanggal Dibuat --}}
                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                            <svg class="w-4.5 h-4.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Dibuat</p>
                            <p class="text-sm font-bold text-gray-800">{{ $beritum->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    {{-- Terakhir Diupdate --}}
                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                            <svg class="w-4.5 h-4.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Diupdate</p>
                            <p class="text-sm font-bold text-gray-800">{{ $beritum->updated_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    {{-- Slug --}}
                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                        <div class="w-9 h-9 rounded-lg bg-gray-200 flex items-center justify-center shrink-0">
                            <svg class="w-4.5 h-4.5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Slug</p>
                            <p class="text-xs font-bold text-gray-800 font-mono">{{ $beritum->slug }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <h3 class="section-header">
                        <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-violet-500 to-purple-600 mr-2"></span>
                        Aksi
                    </h3>
                </div>
                <div class="widget-card-body space-y-3">
                    <a href="{{ route('admin.berita.edit', $beritum) }}"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        Edit Berita
                    </a>
                    <a href="{{ route('berita.show', $beritum->slug) }}" target="_blank"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        Lihat Publik
                    </a>
                    <form action="{{ route('admin.berita.destroy', $beritum) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-50 text-red-600 text-sm font-semibold hover:bg-red-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            Hapus Berita
                        </button>
                    </form>
                </div>
            </div>

            {{-- Kembali --}}
            <a href="{{ route('admin.berita.index') }}"
                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</x-admin-layout>
