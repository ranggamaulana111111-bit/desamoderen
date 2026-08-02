<form x-show="activeTab === 'profil-desa'" x-cloak
      action="{{ route('admin.setting.update', 'profil-desa') }}" method="POST"
      enctype="multipart/form-data" class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-emerald-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Profil Desa</h2>
                    <p class="text-xs text-gray-500">Identitas dan informasi umum desa</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-setting-input name="nama_desa" label="Nama Desa" :value="$settings['nama_desa'] ?? ''" required x-model="preview.nama_desa" />
                <x-setting-input name="nama_provinsi" label="Provinsi" :value="$settings['nama_provinsi'] ?? ''" required x-model="preview.nama_provinsi" />
                <x-setting-input name="nama_kabupaten" label="Kabupaten" :value="$settings['nama_kabupaten'] ?? ''" required x-model="preview.nama_kabupaten" />
                <x-setting-input name="nama_kecamatan" label="Kecamatan" :value="$settings['nama_kecamatan'] ?? ''" required x-model="preview.nama_kecamatan" />
                <x-setting-input name="kode_desa" label="Kode Desa" :value="$settings['kode_desa'] ?? ''" />
                <x-setting-input name="kode_pos" label="Kode Pos" :value="$settings['kode_pos'] ?? ''" required />
            </div>
            <x-setting-textarea name="alamat_kantor" label="Alamat Kantor" :value="$settings['alamat_kantor'] ?? ''" required x-model="preview.alamat_kantor" />
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <x-setting-input name="website_desa" label="Website" type="url" :value="$settings['website_desa'] ?? ''" />
                <x-setting-input name="email_desa" label="Email Desa" type="email" :value="$settings['email_desa'] ?? ''" required />
                <x-setting-input name="telepon_desa" label="Telepon" type="tel" :value="$settings['telepon_desa'] ?? ''" required />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <x-setting-upload name="logo_desa" label="Logo Desa" :value="$settings['logo_desa'] ?? ''" accept="image/png,image/jpeg"
                    x-ref="logo_desa" @change="updatePreviewLogo($refs.logo_desa)" />
                <x-setting-upload name="banner_desa" label="Banner Desa" :value="$settings['banner_desa'] ?? ''" accept="image/png,image/jpeg" />
                <x-setting-upload name="foto_kantor" label="Foto Kantor" :value="$settings['foto_kantor'] ?? ''" accept="image/png,image/jpeg" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-setting-input name="latitude" label="Latitude (Google Maps)" type="number" step="any" :value="$settings['latitude'] ?? ''" x-model="preview.latitude" />
                <x-setting-input name="longitude" label="Longitude (Google Maps)" type="number" step="any" :value="$settings['longitude'] ?? ''" x-model="preview.longitude" />
            </div>
            <x-setting-textarea name="deskripsi_desa" label="Deskripsi Desa" :value="$settings['deskripsi_desa'] ?? ''" rows="3" />
            <x-setting-input name="motto_desa" label="Motto Desa" :value="$settings['motto_desa'] ?? ''" x-model="preview.motto_desa" />
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
