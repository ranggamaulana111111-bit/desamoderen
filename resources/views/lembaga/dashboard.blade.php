<x-lembaga-layout title="Dashboard {{ $lembaga->nama }}">

    <div class="rounded-3xl bg-gradient-to-r from-brand-600 via-emerald-600 to-teal-600 p-6 sm:p-8 text-white relative overflow-hidden mb-6">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full"></div>
        <div class="absolute right-20 -bottom-16 w-56 h-56 bg-white/5 rounded-full"></div>
        <div class="relative flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-white/70 text-xs font-semibold uppercase tracking-wider mb-1">Selamat datang kembali</p>
                <h1 class="text-2xl sm:text-3xl font-bold">{{ $lembaga->nama }}</h1>
                <p class="text-white/80 text-sm mt-1">{{ $lembaga->jenis_label }}{{ $lembaga->ketua ? ' · Ketua: '.$lembaga->ketua : '' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('lembaga.berita.create') }}" class="inline-flex items-center gap-2 bg-white text-brand-700 font-semibold text-sm px-5 py-2.5 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Tulis Berita
                </a>
                <a href="{{ route('lembaga.events.create') }}" class="inline-flex items-center gap-2 bg-white/15 border border-white/30 text-white font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-white/25 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    Buat Event
                </a>
            </div>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bento-card p-5 stat-micro">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Berita</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $stats['berita_total'] }}</p>
        </div>
        <div class="bento-card p-5 stat-micro">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Event</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $stats['event_total'] }}</p>
        </div>
        <div class="bento-card p-5 stat-micro">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Berita Bulan Ini</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $stats['berita_bulan'] }}</p>
        </div>
        <div class="bento-card p-5 stat-micro">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Event Bulan Ini</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $stats['event_bulan'] }}</p>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bento-card p-5 stat-micro">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Dilihat</p>
            <p class="text-3xl font-bold text-brand-600 mt-2">{{ number_format($stats['dilihat_total']) }}</p>
            <p class="text-xs text-slate-400 mt-1">dari berita yang tayang</p>
        </div>
        <div class="bento-card p-5 stat-micro">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Draf Belum Terbit</p>
            <p class="text-3xl font-bold text-amber-600 mt-2">{{ $stats['draft_total'] }}</p>
            <a href="{{ route('lembaga.berita.index', ['status' => 'draft']) }}" class="text-xs font-semibold text-brand-600 hover:underline mt-1 inline-block">Kelola draf →</a>
        </div>
        <div class="bento-card p-5 stat-micro">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Berita Terpopuler</p>
            <p class="text-2xl font-bold text-slate-900 mt-2 truncate">{{ $topBerita->first()?->judul ?? 'Belum ada' }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $topBerita->first() ? number_format($topBerita->first()->dilihat).' kali dilihat' : 'Publikasikan berita untuk mulai dihitung' }}</p>
        </div>
        <div class="bento-card p-5 stat-micro">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Rata-rata / Berita</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $stats['berita_total'] > 0 ? number_format($stats['dilihat_total'] / $stats['berita_total']) : 0 }}</p>
            <p class="text-xs text-slate-400 mt-1">kali dibaca per berita</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bento-card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="section-header !mb-0"><h3>Berita Terpopuler</h3></div>
                <a href="{{ route('lembaga.berita.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($topBerita as $index => $berita)
                <div class="flex items-center gap-4 px-6 py-3.5">
                    <span class="w-6 h-6 rounded-lg bg-brand-50 text-brand-700 text-xs font-bold flex items-center justify-center shrink-0">{{ $index + 1 }}</span>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-slate-800 text-sm truncate">{{ $berita->judul }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $berita->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-sm font-bold text-slate-700 shrink-0">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ number_format($berita->dilihat) }}
                    </span>
                </div>
                @empty
                <div class="px-6 py-10 text-center">
                    <p class="text-sm font-semibold text-slate-600">Belum ada berita tayang</p>
                    <p class="text-xs text-slate-400 mt-1">Berita yang dibaca publik akan tampil di sini.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="bento-card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="section-header !mb-0"><h3>Event Terbaru</h3></div>
                <a href="{{ route('lembaga.events.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentEvents as $event)
                <a href="{{ route('lembaga.events.show', $event) }}" class="flex items-start gap-3 px-6 py-4 hover:bg-brand-50/40 transition">
                    <div class="w-14 h-14 rounded-xl bg-slate-50 flex flex-col items-center justify-center shrink-0 ring-1 ring-slate-100">
                        <span class="text-lg font-bold text-brand-600 leading-none">{{ $event->tanggal->format('d') }}</span>
                        <span class="text-[10px] font-semibold text-slate-400 uppercase">{{ $event->tanggal->translatedFormat('M') }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-800 text-sm truncate">{{ $event->judul }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="badge-status bg-akan_datang">{{ $event->jenis }}</span>
                            <span class="badge-status {{ 'bg-'.$event->status }}">{{ str_replace('_', ' ', $event->status) }}</span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="px-6 py-10 text-center">
                    <p class="text-sm font-semibold text-slate-600">Belum ada event</p>
                    <p class="text-xs text-slate-400 mt-1">Buat event kegiatan lembaga Anda.</p>
                    <a href="{{ route('lembaga.events.create') }}" class="inline-block mt-3 text-xs font-bold text-brand-600 hover:underline">+ Buat event pertama</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</x-lembaga-layout>
