<form x-show="activeTab === 'backup'" x-cloak
      action="{{ route('admin.setting.update', 'backup') }}" method="POST"
      class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-lime-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-lime-100 text-lime-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Backup</h2>
                    <p class="text-xs text-gray-500">Konfigurasi backup database dan storage</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            <div class="rounded-xl border border-cyan-100 bg-cyan-50/60 p-4 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Backup Sekarang</p>
                    <p class="text-xs text-gray-500">Buat snapshot database & file storage secara manual.</p>
                </div>
                <form action="{{ route('admin.setting.backupRun') }}" method="POST" @submit="saving = true">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white font-medium text-sm px-5 py-2.5 rounded-xl transition shadow-sm" :disabled="saving">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                        <span x-text="saving ? 'Membuat...' : 'Buat Backup'"></span>
                    </button>
                </form>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Frekuensi Backup</label>
                    <select name="backup_frekuensi" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                        <option value="harian" {{ ($settings['backup_frekuensi'] ?? 'harian') === 'harian' ? 'selected' : '' }}>Harian</option>
                        <option value="mingguan" {{ ($settings['backup_frekuensi'] ?? '') === 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                        <option value="bulanan" {{ ($settings['backup_frekuensi'] ?? '') === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </div>
                <x-setting-input name="backup_retensi_hari" label="Retensi (hari)" type="number" :value="$settings['backup_retensi_hari'] ?? '30'" />
            </div>
            <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                <input type="hidden" name="backup_auto" value="0">
                <input type="checkbox" name="backup_auto" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['backup_auto'] ?? '1') == '1' ? 'checked' : '' }}>
                <div>
                    <p class="text-sm font-medium text-gray-800">Auto Backup</p>
                    <p class="text-xs text-gray-500">Backup otomatis sesuai jadwal</p>
                </div>
            </label>
            <div>
                <p class="text-sm font-medium text-gray-700 mb-2">Penyimpanan Cloud</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-teal-50/50 transition opacity-70">
                        <input type="hidden" name="backup_google_drive" value="0">
                        <input type="checkbox" name="backup_google_drive" value="1" class="w-4 h-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500" {{ ($settings['backup_google_drive'] ?? '0') == '1' ? 'checked' : '' }}>
                        <svg class="w-5 h-5 text-teal-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 19h20L12 2z"/></svg>
                        <span class="text-sm text-gray-700">Google Drive</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-teal-50/50 transition opacity-70">
                        <input type="hidden" name="backup_dropbox" value="0">
                        <input type="checkbox" name="backup_dropbox" value="1" class="w-4 h-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500" {{ ($settings['backup_dropbox'] ?? '0') == '1' ? 'checked' : '' }}>
                        <svg class="w-5 h-5 text-teal-500" fill="currentColor" viewBox="0 0 24 24"><path d="M6 2l6 4-6 4-6-4 6-4zm12 0l6 4-6 4-6-4 6-4zM6 10l6 4-6 4-6-4 6-4zm12 0l6 4-6 4-6-4 6-4zM6 18l6 4-6 4-6-4 6-4zm12 0l6 4-6 4-6-4 6-4z"/></svg>
                        <span class="text-sm text-gray-700">Dropbox</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-teal-50/50 transition opacity-70">
                        <input type="hidden" name="backup_onedrive" value="0">
                        <input type="checkbox" name="backup_onedrive" value="1" class="w-4 h-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500" {{ ($settings['backup_onedrive'] ?? '0') == '1' ? 'checked' : '' }}>
                        <svg class="w-5 h-5 text-teal-500" fill="currentColor" viewBox="0 0 24 24"><path d="M21.5 13.5c0 2.8-2.2 5-5 5H7c-3.3 0-6-2.7-6-6s2.7-6 6-6c.5 0 1 .1 1.5.2C9.5 4.3 12 3 14.5 3c3.9 0 7 3.1 7 7v3.5z"/></svg>
                        <span class="text-sm text-gray-700">OneDrive</span>
                    </label>
                </div>
                <p class="text-xs text-amber-600 mt-2"><strong>Catatan:</strong> sinkronisasi cloud tersedia pada rilis berikutnya. Backup saat ini disimpan lokal di server.</p>
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

<div x-show="activeTab === 'backup'" x-cloak class="mt-6 bg-white rounded-2xl shadow-sm overflow-hidden animate-fade-in">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-900">Riwayat Backup</h3>
    </div>
    <div class="divide-y divide-gray-100">
        @forelse($backups as $backup)
        <div class="px-6 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <svg class="w-5 h-5 text-lime-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $backup['filename'] }}</p>
                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::createFromTimestamp($backup['created_at'])->translatedFormat('d M Y, H:i') }} &middot; {{ $backup['size_human'] }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('admin.setting.backupDownload', $backup['filename']) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-cyan-700 bg-cyan-50 hover:bg-cyan-100 px-3 py-2 rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Unduh
                </a>
                <form action="{{ route('admin.setting.backupDelete', $backup['filename']) }}" method="POST" onsubmit="return confirm('Hapus backup {{ $backup['filename'] }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="px-6 py-10 text-center">
            <p class="text-sm text-gray-500">Belum ada backup. Klik "Buat Backup" untuk membuat yang pertama.</p>
        </div>
        @endforelse
    </div>
</div>
