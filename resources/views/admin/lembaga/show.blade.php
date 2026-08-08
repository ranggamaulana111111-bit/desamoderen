<x-admin-layout title="Detail Lembaga" maxWidth="max-w-[1200px]">

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.lembaga.index') }}" class="text-sm text-slate-500 hover:text-brand-600 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $lembaga->nama }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.lembaga.edit', $lembaga) }}" class="btn-ghost inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                Ubah
            </a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bento-card p-6">
            <div class="rounded-2xl bg-gradient-to-br from-brand-500 to-teal-600 p-6 text-white shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-2xl font-bold">
                        {{ strtoupper(substr($lembaga->nama, 0, 1)) }}
                    </div>
                    <span class="badge-status {{ $lembaga->status === 'aktif' ? 'bg-completed' : 'bg-rejected' }}">{{ $lembaga->status_label }}</span>
                </div>
                <p class="font-bold text-xl leading-tight">{{ $lembaga->nama }}</p>
                <p class="text-sm text-white/70 mt-0.5">{{ $lembaga->jenis_label }}</p>
            </div>

            <div class="mt-5 space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-slate-400">Singkatan</span><span class="font-semibold text-slate-700">{{ $lembaga->singkatan ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Ketua</span><span class="font-semibold text-slate-700">{{ $lembaga->ketua ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">No. HP</span><span class="font-semibold text-slate-700">{{ $lembaga->no_hp ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Email</span><span class="font-semibold text-slate-700">{{ $lembaga->email ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Alamat</span><span class="font-semibold text-slate-700 text-right">{{ $lembaga->alamat ?? '-' }}</span></div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="grid sm:grid-cols-3 gap-4">
                <div class="bento-card p-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Akun Pengurus</p>
                    <p class="text-2xl font-bold text-slate-900 mt-2">{{ $lembaga->users_count }}</p>
                </div>
                <div class="bento-card p-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Berita</p>
                    <p class="text-2xl font-bold text-slate-900 mt-2">{{ $lembaga->berita_count }}</p>
                </div>
                <div class="bento-card p-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Event</p>
                    <p class="text-2xl font-bold text-slate-900 mt-2">{{ $lembaga->events_count }}</p>
                </div>
            </div>

            @if($pengurus)
            <div class="bento-card p-6">
                <div class="section-header"><h3>Akun Login Pengurus</h3><div class="shimmer-line"></div></div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-bold">
                        {{ $pengurus->avatar_initials }}
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">{{ $pengurus->name }}</p>
                        <p class="text-xs text-slate-500">Role: Lembaga · NIK: {{ $pengurus->nik }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="bento-card p-6">
                <div class="section-header"><h3>Akun Login Pengurus</h3><div class="shimmer-line"></div></div>
                <p class="text-sm text-amber-600">Belum ada akun pengurus. <a href="{{ route('admin.lembaga.edit', $lembaga) }}" class="underline">Tambahkan akun</a> agar lembaga bisa mengunggah konten.</p>
            </div>
            @endif

            <div class="bento-card p-6">
                <div class="section-header"><h3>Deskripsi</h3><div class="shimmer-line"></div></div>
                <p class="text-sm text-slate-600 leading-relaxed">{{ $lembaga->deskripsi ?? 'Belum ada deskripsi.' }}</p>
            </div>
        </div>
    </div>

</x-admin-layout>
