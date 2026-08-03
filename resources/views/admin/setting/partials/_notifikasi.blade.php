@include('admin.setting.partials._active_note', [
    'message' => 'Notifikasi pengajuan surat baru aktif: dikirim otomatis ke Telegram admin desa. Isi Bot Token & Chat ID di bawah untuk mengaktifkan pengiriman.',
])
<form x-show="activeTab === 'notifikasi'" x-cloak
      action="{{ route('admin.setting.update', 'notifikasi') }}" method="POST"
      class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-pink-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Notifikasi</h2>
                    <p class="text-xs text-gray-500">Konfigurasi pengiriman notifikasi</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            <div x-data="{ open: true }" class="bg-blue-50/50 rounded-xl border border-blue-100/60 overflow-hidden">
                <button @@click="open = !open" type="button" class="w-full flex items-center justify-between p-4 text-left">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        <h3 class="text-sm font-semibold text-gray-800">SMTP Email</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-setting-input name="notif_smtp_host" label="SMTP Host" :value="$settings['notif_smtp_host'] ?? ''" />
                        <x-setting-input name="notif_smtp_port" label="SMTP Port" type="number" :value="$settings['notif_smtp_port'] ?? '587'" />
                        <x-setting-input name="notif_smtp_email" label="Email Pengirim" type="email" :value="$settings['notif_smtp_email'] ?? ''" />
                        <x-setting-input name="notif_smtp_password" label="Password Email" type="password" :value="''" placeholder="••••••••" />
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }" class="bg-green-50/50 rounded-xl border border-green-100/60 overflow-hidden">
                <button @@click="open = !open" type="button" class="w-full flex items-center justify-between p-4 text-left">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                        <h3 class="text-sm font-semibold text-gray-800">WhatsApp Gateway</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-setting-input name="notif_wa_api_key" label="API Key" :value="$settings['notif_wa_api_key'] ?? ''" />
                        <x-setting-input name="notif_wa_nomor" label="Nomor Tujuan" type="tel" :value="$settings['notif_wa_nomor'] ?? ''" />
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }" class="bg-sky-50/50 rounded-xl border border-sky-100/60 overflow-hidden">
                <button @@click="open = !open" type="button" class="w-full flex items-center justify-between p-4 text-left">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                        <h3 class="text-sm font-semibold text-gray-800">Telegram</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-setting-input name="notif_telegram_token" label="Bot Token" :value="$settings['notif_telegram_token'] ?? ''" placeholder="123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11" />
                        <x-setting-input name="notif_telegram_chat_id" label="Chat ID" :value="$settings['notif_telegram_chat_id'] ?? ''" placeholder="-1001234567890" />
                    </div>
                </div>
            </div>
            <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                <input type="hidden" name="notif_reminder_aktif" value="0">
                <input type="checkbox" name="notif_reminder_aktif" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['notif_reminder_aktif'] ?? '1') == '1' ? 'checked' : '' }}>
                <div>
                    <p class="text-sm font-medium text-gray-800">Reminder Aktif</p>
                    <p class="text-xs text-gray-500">Kirim pengingat otomatis ke warga</p>
                </div>
            </label>
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
