<form x-show="activeTab === 'pemerintahan'" x-cloak
      action="{{ route('admin.setting.update', 'pemerintahan') }}" method="POST"
      enctype="multipart/form-data" class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-teal-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Pemerintahan Desa</h2>
                    <p class="text-xs text-gray-500">Data pejabat dan perangkat desa</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-4">

            {{-- Kepala Desa --}}
            <div x-data="{ open: true }" class="bg-emerald-50/50 rounded-xl border border-emerald-100/60 overflow-hidden">
                <button @click="open = !open" type="button" class="w-full flex items-center justify-between p-4 text-left">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold">KD</div>
                        <h3 class="text-sm font-semibold text-gray-800">Kepala Desa</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <x-setting-input name="nama_kades" label="Nama" :value="$settings['nama_kades'] ?? ''" required x-model="preview.nama_kades" />
                        <x-setting-input name="nip_kades" label="NIP" :value="$settings['nip_kades'] ?? ''" />
                        <x-setting-input name="nik_kades" label="NIK" :value="$settings['nik_kades'] ?? ''" />
                        <x-setting-input name="jabatan_kades" label="Jabatan" :value="$settings['jabatan_kades'] ?? ''" required x-model="preview.jabatan_kades" />
                        <x-setting-input name="periode_kades_mulai" label="Periode Mulai" :value="$settings['periode_kades_mulai'] ?? ''" />
                        <x-setting-input name="periode_kades_selesai" label="Periode Selesai" :value="$settings['periode_kades_selesai'] ?? ''" />
                        <x-setting-upload name="foto_kades" label="Foto" :value="$settings['foto_kades'] ?? ''" accept="image/png,image/jpeg" />
                    </div>
                </div>
            </div>

            {{-- Sekretaris Desa --}}
            <div x-data="{ open: false }" class="bg-cyan-50/50 rounded-xl border border-cyan-100/60 overflow-hidden">
                <button @click="open = !open" type="button" class="w-full flex items-center justify-between p-4 text-left">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center text-sm font-bold">SD</div>
                        <h3 class="text-sm font-semibold text-gray-800">Sekretaris Desa</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-setting-input name="nama_sekdes" label="Nama" :value="$settings['nama_sekdes'] ?? ''" required x-model="preview.nama_sekdes" />
                        <x-setting-input name="nip_sekdes" label="NIP" :value="$settings['nip_sekdes'] ?? ''" />
                        <x-setting-input name="nik_sekdes" label="NIK" :value="$settings['nik_sekdes'] ?? ''" />
                    </div>
                </div>
            </div>

            {{-- Kaur --}}
            <div x-data="{ open: false }" class="bg-amber-50/50 rounded-xl border border-amber-100/60 overflow-hidden">
                <button @click="open = !open" type="button" class="w-full flex items-center justify-between p-4 text-left">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-bold">KR</div>
                        <h3 class="text-sm font-semibold text-gray-800">Kaur (Kepala Urusan)</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4 space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-3 bg-white/60 rounded-lg">
                        <h4 class="col-span-full text-xs font-semibold text-amber-700 uppercase tracking-wider">Kaur Keuangan</h4>
                        <x-setting-input name="kaur_keuangan_nama" label="Nama" :value="$settings['kaur_keuangan_nama'] ?? ''" />
                        <x-setting-input name="kaur_keuangan_nik" label="NIK" :value="$settings['kaur_keuangan_nik'] ?? ''" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-3 bg-white/60 rounded-lg">
                        <h4 class="col-span-full text-xs font-semibold text-amber-700 uppercase tracking-wider">Kaur Perencanaan</h4>
                        <x-setting-input name="kaur_perencanaan_nama" label="Nama" :value="$settings['kaur_perencanaan_nama'] ?? ''" />
                        <x-setting-input name="kaur_perencanaan_nik" label="NIK" :value="$settings['kaur_perencanaan_nik'] ?? ''" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-3 bg-white/60 rounded-lg">
                        <h4 class="col-span-full text-xs font-semibold text-amber-700 uppercase tracking-wider">Kaur TU & Umum</h4>
                        <x-setting-input name="kaur_tu_nama" label="Nama" :value="$settings['kaur_tu_nama'] ?? ''" />
                        <x-setting-input name="kaur_tu_nik" label="NIK" :value="$settings['kaur_tu_nik'] ?? ''" />
                    </div>
                </div>
            </div>

            {{-- Kasi --}}
            <div x-data="{ open: false }" class="bg-teal-50/50 rounded-xl border border-teal-100/60 overflow-hidden">
                <button @click="open = !open" type="button" class="w-full flex items-center justify-between p-4 text-left">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-sm font-bold">KS</div>
                        <h3 class="text-sm font-semibold text-gray-800">Kasi (Kepala Seksi)</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4 space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-3 bg-white/60 rounded-lg">
                        <h4 class="col-span-full text-xs font-semibold text-teal-700 uppercase tracking-wider">Kasi Pemerintahan</h4>
                        <x-setting-input name="kasi_pemerintahan_nama" label="Nama" :value="$settings['kasi_pemerintahan_nama'] ?? ''" />
                        <x-setting-input name="kasi_pemerintahan_nik" label="NIK" :value="$settings['kasi_pemerintahan_nik'] ?? ''" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-3 bg-white/60 rounded-lg">
                        <h4 class="col-span-full text-xs font-semibold text-teal-700 uppercase tracking-wider">Kasi Kesra</h4>
                        <x-setting-input name="kasi_kesra_nama" label="Nama" :value="$settings['kasi_kesra_nama'] ?? ''" />
                        <x-setting-input name="kasi_kesra_nik" label="NIK" :value="$settings['kasi_kesra_nik'] ?? ''" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-3 bg-white/60 rounded-lg">
                        <h4 class="col-span-full text-xs font-semibold text-teal-700 uppercase tracking-wider">Kasi Pelayanan</h4>
                        <x-setting-input name="kasi_pelayanan_nama" label="Nama" :value="$settings['kasi_pelayanan_nama'] ?? ''" />
                        <x-setting-input name="kasi_pelayanan_nik" label="NIK" :value="$settings['kasi_pelayanan_nik'] ?? ''" />
                    </div>
                </div>
            </div>

            {{-- BPD --}}
            <div x-data="{ open: false }" class="bg-purple-50/50 rounded-xl border border-purple-100/60 overflow-hidden">
                <button @click="open = !open" type="button" class="w-full flex items-center justify-between p-4 text-left">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-bold">BP</div>
                        <h3 class="text-sm font-semibold text-gray-800">BPD (Badan Permusyawaratan Desa)</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-setting-input name="bpd_ketua_nama" label="Ketua BPD" :value="$settings['bpd_ketua_nama'] ?? ''" />
                        <x-setting-input name="bpd_wakil_nama" label="Wakil BPD" :value="$settings['bpd_wakil_nama'] ?? ''" />
                        <x-setting-input name="bpd_sekretaris_nama" label="Sekretaris BPD" :value="$settings['bpd_sekretaris_nama'] ?? ''" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                        <x-setting-input name="bpd_ketua_nik" label="NIK Ketua" :value="$settings['bpd_ketua_nik'] ?? ''" />
                        <x-setting-input name="bpd_wakil_nik" label="NIK Wakil" :value="$settings['bpd_wakil_nik'] ?? ''" />
                        <x-setting-input name="bpd_sekretaris_nik" label="NIK Sekretaris" :value="$settings['bpd_sekretaris_nik'] ?? ''" />
                    </div>
                </div>
            </div>

            {{-- Camat & Operator --}}
            <div x-data="{ open: false }" class="bg-rose-50/50 rounded-xl border border-rose-100/60 overflow-hidden">
                <button @click="open = !open" type="button" class="w-full flex items-center justify-between p-4 text-left">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-sm font-bold">CM</div>
                        <h3 class="text-sm font-semibold text-gray-800">Camat & Operator</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-setting-input name="nama_camat" label="Nama Camat" :value="$settings['nama_camat'] ?? ''" />
                        <x-setting-input name="nip_camat" label="NIP Camat" :value="$settings['nip_camat'] ?? ''" />
                        <x-setting-input name="nama_operator" label="Nama Operator" :value="$settings['nama_operator'] ?? ''" />
                    </div>
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
