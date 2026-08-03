@include('admin.setting.partials._reserved_note')
<form x-show="activeTab === 'queue-driver'" x-cloak
      action="{{ route('admin.setting.update', 'queue-driver') }}" method="POST"
      class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-slate-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
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
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Driver Queue</label>
                <select name="queue_driver" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
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
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm px-5 py-2.5 rounded-xl transition shadow-sm hover:shadow" :disabled="saving">
                <svg x-show="!saving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                <span x-text="saving ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
            </button>
        </div>
    </div>
</form>
