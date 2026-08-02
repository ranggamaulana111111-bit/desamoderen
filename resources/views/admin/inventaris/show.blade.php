<x-admin-layout title="Detail Inventaris" maxWidth="max-w-[1200px]">

    @php
        $kondisiBadge = match($inventaris->kondisi) {
            'Baik' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
            'Rusak Ringan' => 'bg-amber-100 text-amber-700 border border-amber-200',
            'Rusak Berat' => 'bg-red-100 text-red-700 border border-red-200',
            'Perawatan' => 'bg-blue-100 text-blue-700 border border-blue-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };
        $statusBadge = match($inventaris->status) {
            'Digunakan' => 'bg-blue-100 text-blue-700 border border-blue-200',
            'Tersedia' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
            'Disimpan' => 'bg-amber-100 text-amber-700 border border-amber-200',
            'Dihapus' => 'bg-red-100 text-red-700 border border-red-200',
            default => 'bg-gray-100 text-gray-600 border border-gray-200',
        };
    @endphp

    {{-- Hero Header --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-800 via-slate-900 to-navy-900 p-6 sm:p-8 mb-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-teal-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="flex-1 min-w-0">
                <a href="{{ route('admin.inventaris.index') }}" class="inline-flex items-center gap-1.5 text-white/70 hover:text-white text-sm font-medium transition-colors mb-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-white truncate">{{ $inventaris->nama_barang }}</h1>
                <p class="text-white/60 text-sm mt-1">{{ $inventaris->kode_inventaris }}</p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3 mt-5 relative">
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                {{ $inventaris->kode_inventaris }}
            </span>
            <span class="chip border border-white/10 bg-white/5 text-white/80 hover:bg-white/10 transition-colors">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                {{ $inventaris->kategori }}
            </span>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $kondisiBadge }}">
                {{ $inventaris->kondisi }}
            </span>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $statusBadge }}">
                {{ $inventaris->status }}
            </span>
        </div>
    </div>

    {{-- Two-Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- Detail Barang --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Detail Barang</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body">
                    <div class="space-y-1">
                        @php
                            $infoRows = [
                                ['label' => 'Kode Inventaris', 'value' => $inventaris->kode_inventaris, 'color' => 'emerald', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
                                ['label' => 'Nama Barang', 'value' => $inventaris->nama_barang, 'color' => 'blue', 'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z'],
                                ['label' => 'Kategori', 'value' => $inventaris->kategori, 'color' => 'purple', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                                ['label' => 'Nomor Inventaris', 'value' => $inventaris->nomor_inventaris ?? '-', 'color' => 'amber', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                ['label' => 'Jumlah', 'value' => $inventaris->jumlah, 'color' => 'cyan', 'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z'],
                                ['label' => 'Lokasi', 'value' => $inventaris->lokasi ?? '-', 'color' => 'rose', 'icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z'],
                                ['label' => 'Tahun Perolehan', 'value' => $inventaris->tahun_perolehan ?? '-', 'color' => 'indigo', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                                ['label' => 'Nilai Perolehan', 'value' => $inventaris->nilai_perolehan ? 'Rp ' . number_format($inventaris->nilai_perolehan, 0, ',', '.') : '-', 'color' => 'emerald', 'icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                ['label' => 'Kondisi', 'value' => $inventaris->kondisi, 'color' => 'amber', 'icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z'],
                                ['label' => 'Status', 'value' => $inventaris->status, 'color' => 'blue', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ];
                        @endphp
                        @foreach ($infoRows as $row)
                            <div class="flex items-center gap-3 py-2.5 {{ !$loop->last ? 'border-b border-gray-100 dark:border-gray-700' : '' }}">
                                <div class="w-8 h-8 rounded-lg bg-{{ $row['color'] }}-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-{{ $row['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $row['icon'] }}"/></svg>
                                </div>
                                <div class="flex-1 min-w-0 flex items-center justify-between">
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $row['label'] }}</span>
                                    <span class="text-sm font-semibold text-gray-900 text-right">{{ $row['value'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Keterangan --}}
            @if ($inventaris->keterangan)
                <div class="widget-card">
                    <div class="widget-card-header">
                        <div class="section-header mb-0">
                            <h3>Keterangan</h3>
                            <div class="shimmer-line"></div>
                        </div>
                    </div>
                    <div class="widget-card-body">
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $inventaris->keterangan }}</p>
                    </div>
                </div>
            @endif

            {{-- Foto --}}
            @if ($inventaris->foto)
                <div class="widget-card">
                    <div class="widget-card-header">
                        <div class="section-header mb-0">
                            <h3>Foto</h3>
                            <div class="shimmer-line"></div>
                        </div>
                    </div>
                    <div class="widget-card-body">
                        @php
                            $ext = pathinfo($inventaris->foto, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']);
                        @endphp
                        @if ($isImage)
                            <div class="rounded-xl overflow-hidden border border-gray-200">
                                <img src="{{ asset('storage/' . $inventaris->foto) }}" alt="Foto inventaris"
                                    class="w-full max-h-96 object-contain bg-gray-50">
                            </div>
                        @else
                            <div class="flex items-center gap-4 rounded-xl border border-gray-200 bg-gray-50 p-4">
                                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ basename($inventaris->foto) }}</p>
                                    <p class="text-xs text-gray-500">File {{ strtoupper($ext) }}</p>
                                </div>
                                <a href="{{ asset('storage/' . $inventaris->foto) }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-semibold hover:bg-emerald-100 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                    Buka
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- Panel Aksi --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Panel Aksi</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body space-y-3">
                    <a href="{{ route('admin.inventaris.edit', $inventaris) }}"
                        class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        Edit Inventaris
                    </a>
                    @if ($inventaris->foto)
                        <a href="{{ asset('storage/' . $inventaris->foto) }}" target="_blank"
                            class="flex items-center justify-center gap-2 w-full border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Download Foto
                        </a>
                    @endif
                    <form method="POST" action="{{ route('admin.inventaris.destroy', $inventaris) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus inventaris ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md shadow-red-500/20 hover:shadow-lg hover:shadow-red-500/30 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus Inventaris
                        </button>
                    </form>
                </div>
            </div>

            {{-- Informasi --}}
            <div class="widget-card">
                <div class="widget-card-header">
                    <div class="section-header mb-0">
                        <h3>Informasi</h3>
                        <div class="shimmer-line"></div>
                    </div>
                </div>
                <div class="widget-card-body space-y-1">
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Dibuat</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $inventaris->created_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-100 dark:border-gray-700">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Diubah</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $inventaris->updated_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 py-2.5">
                        <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Operator</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $inventaris->creator?->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kembali --}}
            <a href="{{ route('admin.inventaris.index') }}"
                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

</x-admin-layout>
