<form x-show="activeTab === 'integrasi'" x-cloak
      action="{{ route('admin.setting.update', 'integrasi') }}" method="POST"
      class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-violet-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Integrasi</h2>
                    <p class="text-xs text-gray-500">Layanan eksternal dan API</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            <div x-data="{ open: true }" class="border border-gray-200 rounded-xl overflow-hidden">
                <button @@click="open = !open" type="button" class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 text-left">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-violet-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                        <h3 class="text-sm font-semibold text-gray-800">Google Maps</h3>
                        @if(!empty($settings['integrasi_maps_api_key']))
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                        @else
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">Belum diatur</span>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="p-4">
                    <x-setting-input name="integrasi_maps_api_key" label="Google Maps API Key" :value="$settings['integrasi_maps_api_key'] ?? ''" />
                </div>
            </div>
            <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden">
                <button @@click="open = !open" type="button" class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 text-left">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-violet-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
                        <h3 class="text-sm font-semibold text-gray-800">reCAPTCHA</h3>
                        @if(!empty($settings['integrasi_recaptcha_key']) && !empty($settings['integrasi_recaptcha_secret']))
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                        @else
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">Belum diatur</span>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                 <div x-show="open" x-collapse class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-setting-input name="integrasi_recaptcha_key" label="Site Key" :value="$settings['integrasi_recaptcha_key'] ?? ''" />
                        <x-setting-input name="integrasi_recaptcha_secret" label="Secret Key" type="password" :value="$settings['integrasi_recaptcha_secret'] ?? ''" placeholder="••••••••" />
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden">
                <button @@click="open = !open" type="button" class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 text-left">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-violet-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                        <h3 class="text-sm font-semibold text-gray-800">Cloudflare Turnstile</h3>
                        @if(!empty($settings['integrasi_turnstile_site_key']) && !empty($settings['integrasi_turnstile_secret_key']))
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                        @else
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">Belum diatur</span>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-setting-input name="integrasi_turnstile_site_key" label="Site Key" :value="$settings['integrasi_turnstile_site_key'] ?? ''" />
                        <x-setting-input name="integrasi_turnstile_secret_key" label="Secret Key" type="password" :value="$settings['integrasi_turnstile_secret_key'] ?? ''" placeholder="••••••••" />
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Turnstile diprioritaskan di atas reCAPTCHA saat Site/Secret Key terisi. Cocok untuk domain di balik Cloudflare Tunnel / proxy.</p>
                </div>
            </div>
            <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden">
                <button @@click="open = !open" type="button" class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 text-left">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-violet-500" fill="currentColor" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h9zm-9-2h10V8H12v8z"/></svg>
                        <h3 class="text-sm font-semibold text-gray-800">Midtrans</h3>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">Cadangan</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-setting-input name="integrasi_midtrans_server_key" label="Server Key" :value="$settings['integrasi_midtrans_server_key'] ?? ''" />
                        <x-setting-input name="integrasi_midtrans_client_key" label="Client Key" :value="$settings['integrasi_midtrans_client_key'] ?? ''" />
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Environment</label>
                            <select name="integrasi_midtrans_environment" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                                <option value="sandbox" {{ ($settings['integrasi_midtrans_environment'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                                <option value="production" {{ ($settings['integrasi_midtrans_environment'] ?? '') === 'production' ? 'selected' : '' }}>Production</option>
                            </select>
                        </div>
                    </div>
                    <p class="text-xs text-amber-600 mt-3"><strong>Catatan:</strong> integrasi pembayaran Midtrans membutuhkan modul pembayaran (pungutan, donasi, dll.) yang akan tersedia pada rilis berikutnya. Kunci dapat disimpan terlebih dahulu.</p>
                </div>
            </div>
            <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden">
                <button @@click="open = !open" type="button" class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 text-left">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <h3 class="text-sm font-semibold text-gray-800">Webhook</h3>
                        @if(!empty($settings['integrasi_webhook_url']))
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                        @else
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">Belum diatur</span>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="p-4">
                    <x-setting-input name="integrasi_webhook_url" label="Webhook URL" type="url" :value="$settings['integrasi_webhook_url'] ?? ''" placeholder="https://hook.example.com/notify" />
                    <p class="text-xs text-gray-500 mt-2">Event yang dikirim: <code class="text-violet-600">pengajuan.created</code> (saat warga mengajukan surat) dan <code class="text-violet-600">pengajuan.updated</code> (setiap perubahan status persetujuan).</p>
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
