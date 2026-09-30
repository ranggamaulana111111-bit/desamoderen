<div class="setting-card" data-acc="purple">
    <div class="setting-head setting-head-sm">
        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-2.5">
                <div class="setting-head-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Pratinjai Surat</h2>
                    <p class="text-[10px] text-gray-500">Kop &amp; nomor surat</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-purple-700 bg-purple-50 border border-purple-200">
                <span class="relative flex h-1.5 w-1.5">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-purple-400 opacity-75"></span>
                    <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-purple-500"></span>
                </span>
                Real-time
            </span>
        </div>
    </div>

    <div class="p-4">
        <div class="paper overflow-hidden">

            {{-- ── Kop Surat ── --}}
            <div class="px-5 pt-5 pb-4 text-center">
                <div class="flex items-start justify-center gap-3 mb-3">
                    <template x-if="preview.logoPemdaPreview">
                        <img :src="preview.logoPemdaPreview" alt="Logo Pemda" class="h-11 w-auto">
                    </template>
                    <template x-if="!preview.logoPemdaPreview && '{{ data_get($settings, 'logo_pemda') ?? '' }}' && '{{ Storage::disk('public')->exists(data_get($settings, 'logo_pemda') ?? '') }}')">
                        <img src="{{ data_get($settings, 'logo_pemda') ? asset('storage/' . data_get($settings, 'logo_pemda')) : '' }}" alt="Logo Pemda" class="h-11 w-auto">
                    </template>
                    <template x-if="preview.logoPreview">
                        <img :src="preview.logoPreview" alt="Logo Desa" class="h-11 w-auto">
                    </template>
                    <template x-if="!preview.logoPreview && '{{ data_get($settings, 'logo_desa') ?? '' }}' && '{{ Storage::disk('public')->exists(data_get($settings, 'logo_desa') ?? '') }}')">
                        <img src="{{ data_get($settings, 'logo_desa') ? asset('storage/' . data_get($settings, 'logo_desa')) : '' }}" alt="Logo Desa" class="h-11 w-auto">
                    </template>
                </div>

                <p class="text-[13px] font-extrabold uppercase tracking-wide text-gray-900 leading-tight" x-text="preview.nama_desa || '{{ data_get($settings, 'nama_desa', 'DESA') }}'"></p>
                <p class="mt-0.5 text-[9.5px] font-medium text-gray-600">
                    Kecamatan <span x-text="preview.nama_kecamatan || '{{ data_get($settings, 'nama_kecamatan', '...') }}'"></span>,
                    Kabupaten <span x-text="preview.nama_kabupaten || '{{ data_get($settings, 'nama_kabupaten', '...') }}'"></span>
                </p>
                <p class="mt-0.5 text-[8.5px] text-gray-400" x-text="preview.alamat_kantor || '{{ data_get($settings, 'alamat_kantor', '') }}'"></p>

                <div class="mt-3 mx-auto flex items-end gap-1" aria-hidden="true">
                    <span class="h-[3px] flex-1 rounded-full bg-gradient-to-r from-transparent via-gray-800 to-gray-800"></span>
                    <span class="h-[1.5px] w-8 shrink-0 rounded-full bg-gray-800"></span>
                </div>
            </div>

            {{-- ── Nomor Surat ── --}}
            <div class="px-5 py-3.5 paper-tear">
                <div class="flex items-end justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-[8.5px] font-bold uppercase tracking-widest text-gray-400">Nomor</p>
                        <p class="mt-0.5 font-mono text-[12.5px] font-bold leading-tight text-emerald-700 break-all" x-text="previewNumber || '{{ data_get($settings, 'format_nomor_surat', '470/0001/DS-KP/2026') }}'"></p>
                    </div>
                    <div class="shrink-0 text-right">
                        <p class="text-[8.5px] font-bold uppercase tracking-widest text-gray-400">Lampiran</p>
                        <p class="mt-0.5 text-[10px] font-semibold text-gray-500">1 (satu) berkas</p>
                    </div>
                </div>
            </div>

            {{-- ── Body placeholder ── --}}
            <div class="px-5 py-4 space-y-1.5" aria-hidden="true">
                <div class="h-1.5 w-[92%] rounded-full bg-gray-200"></div>
                <div class="h-1.5 w-full rounded-full bg-gray-100"></div>
                <div class="h-1.5 w-[85%] rounded-full bg-gray-100"></div>
                <div class="h-1.5 w-[70%] rounded-full bg-gray-100"></div>
            </div>

            {{-- ── TTD & Stempel ── --}}
            <div class="px-5 pb-4 pt-1">
                <div class="flex items-end justify-center gap-7">
                    <div class="text-center">
                        <template x-if="preview.stempelPreview">
                            <img :src="preview.stempelPreview" alt="Stempel" class="h-16 w-auto mx-auto mb-1">
                        </template>
                        <template x-if="!preview.stempelPreview && '{{ data_get($settings, 'stempel_desa') ?? '' }}' && '{{ Storage::disk('public')->exists(data_get($settings, 'stempel_desa') ?? '') }}')">
                            <img src="{{ data_get($settings, 'stempel_desa') ? asset('storage/' . data_get($settings, 'stempel_desa')) : '' }}" alt="Stempel" class="h-16 w-auto mx-auto mb-1">
                        </template>
                        <template x-if="!preview.stempelPreview && (!'{{ data_get($settings, 'stempel_desa') ?? '' }}' || !'{{ Storage::disk('public')->exists(data_get($settings, 'stempel_desa') ?? '') }}')">
                            <div class="w-16 h-16 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center mx-auto mb-1 bg-red-50/30">
                                <span class="text-[8px] font-medium text-gray-400">Stempel</span>
                            </div>
                        </template>
                        <p class="text-[8.5px] font-semibold text-gray-500">Stempel Desa</p>
                    </div>

                    <div class="text-center">
                        <template x-if="preview.ttdKadesPreview">
                            <img :src="preview.ttdKadesPreview" alt="TTD" class="h-11 w-auto mx-auto mb-1">
                        </template>
                        <template x-if="!preview.ttdKadesPreview && '{{ data_get($settings, 'ttd_kades') ?? '' }}' && '{{ Storage::disk('public')->exists(data_get($settings, 'ttd_kades') ?? '') }}')">
                            <img src="{{ data_get($settings, 'ttd_kades') ? asset('storage/' . data_get($settings, 'ttd_kades')) : '' }}" alt="TTD" class="h-11 w-auto mx-auto mb-1">
                        </template>
                        <template x-if="!preview.ttdKadesPreview && (!'{{ data_get($settings, 'ttd_kades') ?? '' }}' || !'{{ Storage::disk('public')->exists(data_get($settings, 'ttd_kades') ?? '') }}')">
                            <div class="w-24 h-11 border-b-2 border-dashed border-gray-300 flex items-center justify-center mx-auto mb-1">
                                <span class="text-[8px] font-medium text-gray-400">TTD</span>
                            </div>
                        </template>
                        <p class="text-[9px] font-bold text-gray-800 underline decoration-gray-300 underline-offset-2" x-text="preview.nama_kades || '{{ $settings['nama_kades'] ?? 'Kepala Desa' }}'"></p>
                        <p class="text-[8px] text-gray-500" x-text="preview.jabatan_kades || '{{ $settings['jabatan_kades'] ?? 'Kepala Desa' }}'"></p>
                    </div>
                </div>
            </div>

            {{-- ── QR Verifikasi ── --}}
            <div class="px-5 py-3.5 paper-tear flex items-center gap-3">
                <div class="w-11 h-11 shrink-0 rounded-lg bg-gray-900 flex items-center justify-center p-1">
                    <svg class="w-full h-full text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm8-2h3v3h-3v-3zm5 0h3v3h-3v-3zm-5 5h3v3h-3v-3zm5 0h3v3h-3v-3z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[9px] font-bold uppercase tracking-widest text-gray-700">QR Verifikasi</p>
                    <p class="mt-0.5 text-[8.5px] leading-snug text-gray-400">Pindai untuk memeriksa keaslian dokumen secara publik.</p>
                </div>
            </div>
        </div>

        {{-- ── Live chips ── --}}
        <div class="mt-4 grid grid-cols-2 gap-2">
            <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-purple-50/70 border border-purple-100" data-acc="purple">
                <span class="w-1.5 h-1.5 rounded-full bg-purple-500 shrink-0"></span>
                <span class="text-[10px] font-semibold text-purple-700">Kop surat aktif</span>
            </div>
            <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-50/70 border border-emerald-100" data-acc="emerald">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                <span class="text-[10px] font-semibold text-emerald-700">Penomoran otomatis</span>
            </div>
        </div>
    </div>
</div>
