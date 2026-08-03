@include('admin.setting.partials._active_note', [
    'message' => 'Pengaturan ini sudah terhubung ke dashboard Analitik & Laporan (default filter, widget aktif, refresh interval, dan cache).',
])
<form x-show="activeTab === 'analytics'" x-cloak
      action="{{ route('admin.setting.update', 'analytics') }}" method="POST"
      class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-orange-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Analytics Dashboard</h2>
                    <p class="text-xs text-gray-500">Pengaturan dashboard analitik</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <x-setting-input name="analytics_refresh_interval" label="Refresh Interval (detik)" type="number" :value="$settings['analytics_refresh_interval'] ?? '300'" />
                <x-setting-input name="analytics_cache_ttl" label="Cache TTL (detik)" type="number" :value="$settings['analytics_cache_ttl'] ?? '3600'" />
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Default Filter</label>
                    <select name="analytics_default_filter" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                        <option value="7" {{ ($settings['analytics_default_filter'] ?? '30') == '7' ? 'selected' : '' }}>7 Hari</option>
                        <option value="30" {{ ($settings['analytics_default_filter'] ?? '30') == '30' ? 'selected' : '' }}>30 Hari</option>
                        <option value="90" {{ ($settings['analytics_default_filter'] ?? '') == '90' ? 'selected' : '' }}>90 Hari</option>
                        <option value="365" {{ ($settings['analytics_default_filter'] ?? '') == '365' ? 'selected' : '' }}>1 Tahun</option>
                    </select>
                </div>
                <x-setting-input name="analytics_retention_hari" label="Retensi Data (hari)" type="number" :value="$settings['analytics_retention_hari'] ?? '365'" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Widget Aktif</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @php
                        $activeWidgets = explode(',', $settings['analytics_widget_aktif'] ?? 'overview,trends,popular,processing,users,status');
                    @endphp
                    @foreach ([
                        'overview' => 'Ringkasan',
                        'trends' => 'Tren Pengajuan',
                        'popular' => 'Surat Populer',
                        'processing' => 'Waktu Proses',
                        'users' => 'Pertumbuhan User',
                        'status' => 'Status Distribusi',
                    ] as $val => $label)
                    <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                        <input type="checkbox" value="{{ $val }}" class="w-3.5 h-3.5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                            {{ in_array($val, $activeWidgets) ? 'checked' : '' }}
                            onchange="updateWidgetAktif(this)">
                        <span class="text-xs text-gray-700">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                <input type="hidden" name="analytics_widget_aktif" id="analytics_widget_aktif" value="{{ $settings['analytics_widget_aktif'] ?? 'overview,trends,popular,processing,users,status' }}">
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
