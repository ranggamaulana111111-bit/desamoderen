<div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden sticky top-8">
    <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-purple-50/50 to-white">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse-slow"></span>
            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Live Preview</p>
            <span class="ml-auto text-[10px] text-purple-600 bg-purple-100 px-2 py-0.5 rounded-full font-medium">Real-time</span>
        </div>
    </div>
    <div class="p-4">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            {{-- Kop Surat --}}
            <div class="p-4 text-center border-b border-dashed border-gray-200">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <template x-if="preview.logoPemdaPreview">
                        <img :src="preview.logoPemdaPreview" class="h-10 w-auto">
                    </template>
                    <template x-if="!preview.logoPemdaPreview && '{{ data_get($settings, 'logo_pemda') ?? '' }}' && '{{ Storage::disk('public')->exists(data_get($settings, 'logo_pemda') ?? '') }}'">
                        <img src="{{ data_get($settings, 'logo_pemda') ? asset('storage/' . data_get($settings, 'logo_pemda')) : '' }}" class="h-10 w-auto">
                    </template>
                    <template x-if="preview.logoPreview">
                        <img :src="preview.logoPreview" class="h-10 w-auto">
                    </template>
                    <template x-if="!preview.logoPreview && '{{ data_get($settings, 'logo_desa') ?? '' }}' && '{{ Storage::disk('public')->exists(data_get($settings, 'logo_desa') ?? '') }}'">
                        <img src="{{ data_get($settings, 'logo_desa') ? asset('storage/' . data_get($settings, 'logo_desa')) : '' }}" class="h-10 w-auto">
                    </template>
                </div>
                <p class="text-sm font-bold text-gray-900 uppercase" x-text="preview.nama_desa || '{{ data_get($settings, 'nama_desa', 'DESA') }}'"></p>
                <p class="text-[10px] text-gray-500">
                    Kecamatan <span x-text="preview.nama_kecamatan || '{{ data_get($settings, 'nama_kecamatan', '...') }}'"></span>,
                    Kabupaten <span x-text="preview.nama_kabupaten || '{{ data_get($settings, 'nama_kabupaten', '...') }}'"></span>
                </p>
                <p class="text-[9px] text-gray-400 mt-0.5" x-text="preview.alamat_kantor || '{{ data_get($settings, 'alamat_kantor', '') }}'"></p>
                </div>

                {{-- Nomor Surat --}}

                <div class="px-4 py-2 border-b border-dashed border-gray-200">

                <p class="text-xs font-bold text-gray-700">Nomor Surat</p>

                <p class="text-sm font-mono font-bold text-emerald-700" x-text="previewNumber || '{{ data_get($settings, 'format_nomor_surat', '470/0001/DS-KP/2026') }}'"></p>

            </div>

            {{-- TTD & Stempel --}}
            <div class="p-4">
                <div class="flex items-end justify-center gap-6">
                    <div class="text-center">
                        <template x-if="preview.stempelPreview">
                            <img :src="preview.stempelPreview" class="h-16 w-auto mx-auto mb-1">
                        </template>
                        <template x-if="!preview.stempelPreview && '{{ data_get($settings, 'stempel_desa') ?? '' }}' && '{{ Storage::disk('public')->exists(data_get($settings, 'stempel_desa') ?? '') }}'">
                            <img src="{{ data_get($settings, 'stempel_desa') ? asset('storage/' . data_get($settings, 'stempel_desa')) : '' }}" class="h-16 w-auto mx-auto mb-1">
                        </template>
                        <template x-if="!preview.stempelPreview && (!'{{ data_get($settings, 'stempel_desa') ?? '' }}' || !'{{ Storage::disk('public')->exists(data_get($settings, 'stempel_desa') ?? '') }}')">
                            <div class="w-16 h-16 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center mx-auto mb-1">
                                <span class="text-[8px] text-gray-400">Stempel</span>
                            </div>
                        </template>
                        <p class="text-[9px] text-gray-500 font-medium">Stempel</p>
                    </div>
                    <div class="text-center">
                        <template x-if="preview.ttdKadesPreview">
                            <img :src="preview.ttdKadesPreview" class="h-12 w-auto mx-auto mb-1">
                        </template>
                        <template x-if="!preview.ttdKadesPreview && '{{ data_get($settings, 'ttd_kades') ?? '' }}' && '{{ Storage::disk('public')->exists(data_get($settings, 'ttd_kades') ?? '') }}'">
                            <img src="{{ data_get($settings, 'ttd_kades') ? asset('storage/' . data_get($settings, 'ttd_kades')) : '' }}" class="h-12 w-auto mx-auto mb-1">
                        </template>
                        <template x-if="!preview.ttdKadesPreview && (!'{{ data_get($settings, 'ttd_kades') ?? '' }}' || !'{{ Storage::disk('public')->exists(data_get($settings, 'ttd_kades') ?? '') }}')">
                            <div class="w-20 h-10 border-b-2 border-gray-300 flex items-center justify-center mx-auto mb-1">
                                <span class="text-[8px] text-gray-400">TTD</span>
                            </div>
                        </template>
                        <p class="text-[9px] text-gray-500 font-medium" x-text="preview.nama_kades || '{{ $settings['nama_kades'] ?? 'Kepala Desa' }}'"></p>
                        <p class="text-[8px] text-gray-400" x-text="preview.jabatan_kades || '{{ $settings['jabatan_kades'] ?? 'Kepala Desa' }}'"></p>
                    </div>
                </div>
                {{-- QR --}}
                <div class="mt-3 pt-3 border-t border-dashed border-gray-200 text-center">
                    <div class="w-10 h-10 mx-auto bg-gray-100 rounded flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/></svg>
                    </div>
                    <p class="text-[8px] text-gray-400 mt-1">QR Verifikasi</p>
                </div>
            </div>
        </div>
    </div>
</div>
