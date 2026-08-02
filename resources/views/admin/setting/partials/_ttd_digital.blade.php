<form x-show="activeTab === 'ttd-digital'" x-cloak
      action="{{ route('admin.setting.update', 'ttd-digital') }}" method="POST"
      enctype="multipart/form-data" class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-purple-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Tanda Tangan Digital</h2>
                    <p class="text-xs text-gray-500">Konfigurasi tanda tangan, stempel, dan QR verifikasi</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-5">
                    <x-setting-upload name="stempel_desa" label="Stempel Desa (PNG Transparan)" :value="$settings['stempel_desa'] ?? ''" accept="image/png"
                        x-ref="stempel_desa" @change="updatePreviewStempel($refs.stempel_desa)" />
                    <x-setting-upload name="ttd_kades" label="TTD Kepala Desa (PNG Transparan)" :value="$settings['ttd_kades'] ?? ''" accept="image/png"
                        x-ref="ttd_kades" @change="updatePreviewTtdKades($refs.ttd_kades)" />
                    <x-setting-upload name="ttd_sekdes" label="TTD Sekretaris Desa (PNG Transparan)" :value="$settings['ttd_sekdes'] ?? ''" accept="image/png" />
                    <x-setting-input name="qr_sertifikat" label="Nomor Sertifikat QR" :value="$settings['qr_sertifikat'] ?? ''" x-model="preview.qr_sertifikat" />
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition flex-1">
                            <input type="hidden" name="ttd_digital_aktif" value="0">
                            <input type="checkbox" name="ttd_digital_aktif" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['ttd_digital_aktif'] ?? '1') == '1' ? 'checked' : '' }} x-model="preview.ttd_digital_aktif">
                            <div>
                                <p class="text-sm font-medium text-gray-800">TTD Digital Aktif</p>
                                <p class="text-xs text-gray-500">Tanda tangan otomatis pada PDF</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition flex-1">
                            <input type="hidden" name="qr_verifikasi_aktif" value="0">
                            <input type="checkbox" name="qr_verifikasi_aktif" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['qr_verifikasi_aktif'] ?? '1') == '1' ? 'checked' : '' }} x-model="preview.qr_verifikasi_aktif">
                            <div>
                                <p class="text-sm font-medium text-gray-800">QR Verifikasi Aktif</p>
                                <p class="text-xs text-gray-500">Kode QR pada dokumen</p>
                            </div>
                        </label>
                    </div>
                </div>
                <div>
                    @include('admin.setting.partials._preview_panel')
                </div>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm px-5 py-2.5 rounded-xl transition shadow-sm hover:shadow" :disabled="saving">
                <svg x-show="!saving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                <span x-text="saving ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
            </button>
        </div>
    </div>
</form>
