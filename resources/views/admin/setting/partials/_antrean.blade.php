<form x-show="activeTab === 'antrean'" x-cloak
      action="{{ route('admin.setting.update', 'antrean') }}" method="POST"
      class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-teal-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Antrean Pelayanan</h2>
                    <p class="text-xs text-gray-500">Jam layanan dan konfigurasi antrean</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <x-setting-input name="antrean_jam_mulai" label="Jam Mulai" type="time" :value="$settings['antrean_jam_mulai'] ?? '09:00'" required />
                <x-setting-input name="antrean_jam_selesai" label="Jam Selesai" type="time" :value="$settings['antrean_jam_selesai'] ?? '12:00'" required />
                <x-setting-input name="antrean_jam_istirahat" label="Jam Istirahat" :value="$settings['antrean_jam_istirahat'] ?? '12:00-13:00'" />
                <x-setting-input name="antrean_kuota_per_slot" label="Kuota per Slot" type="number" :value="$settings['antrean_kuota_per_slot'] ?? '1'" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <x-setting-input name="antrean_durasi_slot" label="Durasi Slot (menit)" type="number" :value="$settings['antrean_durasi_slot'] ?? '15'" />
                <x-setting-input name="antrean_hari_aktif" label="Hari Aktif (pisahkan koma)" :value="$settings['antrean_hari_aktif'] ?? 'Senin,Selasa,Rabu,Kamis,Jumat'" />
                <x-setting-input name="antrean_hari_libur" label="Hari Libur (tanggal)" :value="$settings['antrean_hari_libur'] ?? ''" placeholder="2026-01-01,2026-12-25" />
                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                    <input type="hidden" name="antrean_auto_close" value="0">
                    <input type="checkbox" name="antrean_auto_close" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['antrean_auto_close'] ?? '0') == '1' ? 'checked' : '' }}>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Auto Close</p>
                        <p class="text-xs text-gray-500">Tutup otomatis saat kuota habis</p>
                    </div>
                </label>
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
