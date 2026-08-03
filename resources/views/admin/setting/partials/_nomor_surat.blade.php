<form x-show="activeTab === 'nomor-surat'" x-cloak
      action="{{ route('admin.setting.update', 'nomor-surat') }}" method="POST"
      class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-amber-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Nomor Surat</h2>
                    <p class="text-xs text-gray-500">Format dan pola penomoran surat resmi</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            <x-setting-input name="format_nomor_surat" label="Format Nomor Surat" :value="$settings['format_nomor_surat'] ?? ''" required x-model="preview.format_nomor_surat" />
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <x-setting-input name="nomor_prefix" label="Prefix" :value="$settings['nomor_prefix'] ?? '470'" x-model="preview.nomor_prefix" />
                <x-setting-input name="nomor_suffix" label="Suffix (Kode Desa)" :value="$settings['nomor_suffix'] ?? 'DS-KP'" x-model="preview.nomor_suffix" />
                <x-setting-input name="nomor_padding" label="Padding (digit)" type="number" :value="$settings['nomor_padding'] ?? '4'" x-model="preview.nomor_padding" />
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Reset Setiap</label>
                    <select name="nomor_reset" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white" x-model="preview.nomor_reset">
                        <option value="tahunan" {{ ($settings['nomor_reset'] ?? 'tahunan') === 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                        <option value="bulanan" {{ ($settings['nomor_reset'] ?? '') === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        <option value="harian" {{ ($settings['nomor_reset'] ?? '') === 'harian' ? 'selected' : '' }}>Harian</option>
                    </select>
                </div>
            </div>
            <div class="bg-gradient-to-r from-amber-50 to-white rounded-xl p-5 border border-amber-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Preview Nomor Surat</p>
                    <span class="text-[10px] text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full font-medium">Live</span>
                </div>
                <p class="text-lg font-mono font-bold text-amber-700" x-text="previewNumber"></p>
                <p class="text-[10px] text-gray-400 mt-1">Variabel: <code>{kode_surat}</code> <code>{no}</code> <code>{id}</code> <code>{prefix}</code> <code>{suffix}</code> <code>{tahun}</code> <code>{bulan}</code> <code>{hari}</code></p>
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
