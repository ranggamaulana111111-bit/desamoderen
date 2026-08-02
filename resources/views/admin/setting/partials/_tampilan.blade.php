<form x-show="activeTab === 'tampilan'" x-cloak
      action="{{ route('admin.setting.update', 'tampilan') }}" method="POST"
      enctype="multipart/form-data" class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-fuchsia-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-fuchsia-100 text-fuchsia-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v4m0 0h-4m4 0l-5-5"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Tampilan</h2>
                    <p class="text-xs text-gray-500">Personalisasi tampilan aplikasi</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Warna Aksen</label>
                    <div class="flex gap-3 flex-wrap">
                        @php $currentAccent = $settings['tampilan_accent_color'] ?? 'emerald'; @endphp
                        @foreach (['emerald' => '#10b981', 'blue' => '#3b82f6', 'purple' => '#8b5cf6', 'rose' => '#f43f5e', 'amber' => '#f59e0b', 'cyan' => '#06b6d4', 'indigo' => '#6366f1', 'orange' => '#f97316'] as $val => $color)
                        <label class="cursor-pointer" title="{{ $val }}">
                            <input type="radio" name="tampilan_accent_color" value="{{ $val }}" class="sr-only peer" {{ $currentAccent === $val ? 'checked' : '' }}>
                            <span class="block w-8 h-8 rounded-xl border-2 border-transparent peer-checked:border-gray-400 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-gray-300 transition shadow-sm hover:scale-110" style="background: {{ $color }}"></span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                    <input type="hidden" name="tampilan_dark_mode" value="0">
                    <input type="checkbox" name="tampilan_dark_mode" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['tampilan_dark_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Dark Mode</p>
                        <p class="text-xs text-gray-500">Tampilan gelap untuk seluruh aplikasi</p>
                    </div>
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Style Sidebar</label>
                <select name="tampilan_sidebar_style" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                    <option value="default" {{ ($settings['tampilan_sidebar_style'] ?? 'default') === 'default' ? 'selected' : '' }}>Default (Full Label)</option>
                    <option value="compact" {{ ($settings['tampilan_sidebar_style'] ?? '') === 'compact' ? 'selected' : '' }}>Compact</option>
                    <option value="icon-only" {{ ($settings['tampilan_sidebar_style'] ?? '') === 'icon-only' ? 'selected' : '' }}>Icon Only</option>
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <x-setting-upload name="logo_login" label="Logo Login" :value="$settings['logo_login'] ?? ''" accept="image/png,image/jpeg,image/svg" />
                <x-setting-upload name="logo_sidebar" label="Logo Sidebar" :value="$settings['logo_sidebar'] ?? ''" accept="image/png,image/jpeg,image/svg" />
                <x-setting-upload name="favicon" label="Favicon" :value="$settings['favicon'] ?? ''" accept="image/png,image/x-icon,image/svg" />
                <x-setting-upload name="background_login" label="Background Login" :value="$settings['background_login'] ?? ''" accept="image/png,image/jpeg" />
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
