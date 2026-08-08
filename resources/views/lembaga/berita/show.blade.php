<x-lembaga-layout title="{{ $berita->judul }}">

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('lembaga.berita.index') }}" class="text-sm text-slate-500 hover:text-brand-600 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $berita->judul }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('lembaga.berita.edit', $berita) }}" class="btn-ghost inline-flex items-center gap-2">Ubah</a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bento-card overflow-hidden">
                @if($berita->foto)
                    <img src="{{ asset('storage/'.$berita->foto) }}" alt="" class="w-full h-72 object-cover">
                @endif
                <div class="p-6 sm:p-8">
                    <div class="flex items-center gap-3 text-xs text-slate-400 mb-5">
                        <span class="badge-status {{ 'bg-'.$berita->status }}">{{ $berita->status === 'publish' ? 'Tayang' : 'Draf' }}</span>
                        <span>{{ $berita->created_at->translatedFormat('d M Y H:i') }}</span>
                        <span>·</span>
                        <span>oleh {{ $berita->user?->name }}</span>
                    </div>
                    <div class="prose max-w-none text-slate-700 text-sm leading-7 whitespace-pre-line">{{ $berita->konten }}</div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bento-card p-6">
                <div class="section-header"><h3>Informasi</h3><div class="shimmer-line"></div></div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-slate-400">Lembaga</span><span class="font-semibold text-slate-700">{{ $lembaga->nama }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Status</span><span class="font-semibold text-slate-700">{{ $berita->status === 'publish' ? 'Dipublikasikan' : 'Draf' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Dilihat</span><span class="font-semibold text-slate-700">{{ number_format($berita->dilihat) }} kali</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Dibuat</span><span class="font-semibold text-slate-700">{{ $berita->created_at->translatedFormat('d M Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Diperbarui</span><span class="font-semibold text-slate-700">{{ $berita->updated_at->translatedFormat('d M Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Penulis</span><span class="font-semibold text-slate-700">{{ $berita->user?->name }}</span></div>
                </div>
            </div>

            <div class="bento-card p-6">
                <form action="{{ route('lembaga.berita.destroy', $berita) }}" method="POST" onsubmit="return confirm('Hapus berita ini? Tindakan tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 text-red-600 font-semibold text-sm px-4 py-2.5 hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        Hapus Berita
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-lembaga-layout>
