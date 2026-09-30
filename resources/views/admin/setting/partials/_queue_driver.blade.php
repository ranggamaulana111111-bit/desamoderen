<form x-show="activeTab === 'queue-driver'" x-cloak
      action="{{ route('admin.setting.update', 'queue-driver') }}" method="POST"
      class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card" data-acc="slate">
        <div class="setting-head">
            <div class="flex items-center gap-3">
                <div class="setting-head-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Queue Driver</h2>
                    <p class="text-xs text-gray-500">Konfigurasi driver dan worker antrean</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            <div>
                <label class="setting-label">Driver Queue</label>
                <select name="queue_driver" class="setting-input">
                    <option value="database" {{ ($settings['queue_driver'] ?? 'database') === 'database' ? 'selected' : '' }}>Database</option>
                    <option value="redis" {{ ($settings['queue_driver'] ?? '') === 'redis' ? 'selected' : '' }}>Redis</option>
                    <option value="sync" {{ ($settings['queue_driver'] ?? '') === 'sync' ? 'selected' : '' }}>Sync (Direct)</option>
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <x-setting-input name="queue_retry" label="Maks Retry" type="number" :value="$settings['queue_retry'] ?? '3'" />
                <x-setting-input name="queue_timeout" label="Timeout (detik)" type="number" :value="$settings['queue_timeout'] ?? '300'" />
                <x-setting-input name="queue_worker_count" label="Jumlah Worker" type="number" :value="$settings['queue_worker_count'] ?? '1'" />
            </div>
        </div>
        <div class="setting-foot">
            <button type="submit" class="btn-save" :disabled="saving">
                <svg x-show="!saving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                <span x-text="saving ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
            </button>
        </div>
    </div>
</form>
