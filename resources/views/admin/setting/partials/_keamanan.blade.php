<form x-show="activeTab === 'keamanan'" x-cloak
      action="{{ route('admin.setting.update', 'keamanan') }}" method="POST"
      class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-red-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Keamanan</h2>
                    <p class="text-xs text-gray-500">Pengaturan keamanan sistem</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <x-setting-input name="security_session_timeout" label="Session Timeout (menit)" type="number" :value="$settings['security_session_timeout'] ?? '120'" />
                <x-setting-input name="security_rate_limit" label="Rate Limit Login (per menit)" type="number" :value="$settings['security_rate_limit'] ?? '5'" />
                <x-setting-input name="security_audit_log_retensi" label="Retensi Audit Log (hari)" type="number" :value="$settings['security_audit_log_retensi'] ?? '365'" />
                <x-setting-input name="security_password_min_length" label="Min. Panjang Password" type="number" :value="$settings['security_password_min_length'] ?? '8'" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                    <input type="hidden" name="security_captcha_aktif" value="0">
                    <input type="checkbox" name="security_captcha_aktif" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['security_captcha_aktif'] ?? '1') == '1' ? 'checked' : '' }}>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Captcha Login</p>
                        <p class="text-xs text-gray-500">Soal keamanan pada halaman login, daftar & lupa password</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                    <input type="hidden" name="security_2fa_wajib" value="0">
                    <input type="checkbox" name="security_2fa_wajib" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['security_2fa_wajib'] ?? '0') == '1' ? 'checked' : '' }}>
                    <div>
                        <p class="text-sm font-medium text-gray-800">2FA Wajib</p>
                        <p class="text-xs text-gray-500">Autentikasi dua faktor</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                    <input type="hidden" name="security_password_policy" value="0">
                    <input type="checkbox" name="security_password_policy" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['security_password_policy'] ?? '1') == '1' ? 'checked' : '' }}>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Password Policy</p>
                        <p class="text-xs text-gray-500">Password wajib kombinasi huruf & angka</p>
                    </div>
                </label>
            </div>
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                <p class="text-xs text-amber-700 leading-relaxed"><strong>Catatan:</strong> Modul 2FA akan tersedia pada rilis berikutnya. Pengaturan IP Whitelist berlaku untuk seluruh halaman admin &mdash; pastikan alamat IP Anda sendiri disertakan agar tidak terkunci.</p>
            </div>
            <x-setting-textarea name="security_ip_whitelist" label="IP Whitelist (satu per baris atau dipisah koma)" :value="$settings['security_ip_whitelist'] ?? ''" rows="3" />
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
