<x-admin-layout title="Detail Surat Keluar" maxWidth="max-w-[1200px]">

    @if (session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 animate-fade-in">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Detail Surat --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <h3 class="section-header">
                        <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                        Detail Surat Keluar
                    </h3>
                </div>
                <div class="widget-card-body space-y-5">
                    {{-- Nomor Agenda --}}
                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-4">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Nomor Agenda</p>
                            <p class="text-sm font-bold font-mono text-emerald-700">{{ $surat->nomor_agenda }}</p>
                        </div>
                    </div>

                    {{-- Grid Info --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide mb-1">Tanggal Kirim</p>
                            <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($surat->tanggal_kirim)->locale('id')->translatedFormat('d M Y') }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide mb-1">Tujuan</p>
                            <p class="text-sm font-bold text-gray-800">{{ $surat->tujuan }}</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide mb-1">Jenis Surat</p>
                            <span class="chip chip-brand text-[11px]">{{ $surat->jenis_surat }}</span>
                        </div>
                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide mb-1">Sifat Surat</p>
                            @php
                                $sifatColors = [
                                    'Biasa' => 'bg-gray-100 text-gray-600',
                                    'Segera' => 'bg-amber-100 text-amber-700',
                                    'Rahasia' => 'bg-red-100 text-red-700',
                                    'Penting' => 'bg-blue-100 text-blue-700',
                                ];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $sifatColors[$surat->sifat_surat] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $surat->sifat_surat }}
                            </span>
                        </div>
                    </div>

                    {{-- Perihal --}}
                    <div class="rounded-xl bg-gray-50 p-4">
                        <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide mb-1">Perihal</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $surat->perihal }}</p>
                    </div>

                    {{-- File --}}
                    @if ($surat->file_path)
                        <div class="rounded-xl bg-gray-50 p-4">
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide mb-2">Lampiran</p>
                            @if (in_array(pathinfo($surat->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                <img src="{{ asset('storage/' . $surat->file_path) }}" alt="Lampiran" class="rounded-lg max-h-64 object-contain border border-gray-200">
                            @else
                                <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-3 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition text-sm font-semibold text-gray-700">
                                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    Lihat Lampiran (PDF)
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Status --}}
            <div class="widget-card lg:sticky lg:top-6">
                <div class="widget-card-header">
                    <h3 class="section-header">
                        <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-blue-500 to-indigo-600 mr-2"></span>
                        Status
                    </h3>
                </div>
                <div class="widget-card-body space-y-4">
                    @php
                        $statusConfig = [
                            'dikirim' => ['bg-emerald-50 text-emerald-700 border-emerald-100', 'bg-emerald-500', 'Surat telah dikirim dan menunggu proses'],
                            'diproses' => ['bg-blue-50 text-blue-700 border-blue-100', 'bg-blue-500', 'Surat sedang dalam proses'],
                            'selesai' => ['bg-violet-50 text-violet-700 border-violet-100', 'bg-violet-500', 'Surat telah selesai diproses'],
                            'ditolak' => ['bg-red-50 text-red-700 border-red-100', 'bg-red-500', 'Surat telah ditolak'],
                        ];
                        [$chipClass, $dotClass, $statusDesc] = $statusConfig[$surat->status] ?? ['bg-gray-50 text-gray-600 border-gray-100', 'bg-gray-400', ''];
                    @endphp
                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 {{ $chipClass }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Status</p>
                            <p class="text-sm font-bold {{ explode(' ', $chipClass)[1] }}">{{ ucfirst($surat->status) }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $statusDesc }}</p>

                    {{-- Creator --}}
                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                        <div class="w-9 h-9 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Dibuat Oleh</p>
                            <p class="text-sm font-bold text-gray-800">{{ $surat->creator?->name ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Timestamps --}}
                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Dibuat</p>
                            <p class="text-sm font-bold text-gray-800">{{ $surat->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-xl bg-gray-50 p-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Diupdate</p>
                            <p class="text-sm font-bold text-gray-800">{{ $surat->updated_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
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
                    <a href="{{ route('admin.surat-keluar.edit', $surat) }}"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        Edit Surat
                    </a>
                    @if ($surat->file_path)
                        <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Download Lampiran
                        </a>
                    @endif
                    <form action="{{ route('admin.surat-keluar.destroy', $surat) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus surat keluar ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-50 text-red-600 text-sm font-semibold hover:bg-red-600 hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            Hapus Surat
                        </button>
                    </form>
                </div>
            </div>

            {{-- Kembali --}}
            <a href="{{ route('admin.surat-keluar.index') }}"
                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</x-admin-layout>
