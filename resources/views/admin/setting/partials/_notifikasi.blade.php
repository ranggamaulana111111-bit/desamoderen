@if(!$telegramConfigured)
    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 mb-5">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
            <p class="text-sm text-amber-700 font-medium">Telegram belum terkonfigurasi. Isi <strong>Bot Token</strong> dan <strong>Chat ID</strong> di bawah, lalu simpan untuk mengaktifkan notifikasi.</p>
        </div>
    </div>
@endif
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
            <div x-data="{ open: true }" class="bg-cyan-50/50 rounded-xl border border-cyan-100/60 overflow-hidden">
                <button @@click="open = !open" type="button" class="w-full flex items-center justify-between p-4 text-left">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                        <h3 class="text-sm font-semibold text-gray-800">Telegram</h3>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="px-4 pb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-setting-input name="notif_telegram_token" label="Bot Token" :value="$settings['notif_telegram_token'] ?? ''" placeholder="123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11" />
                        <x-setting-input name="notif_telegram_chat_id" label="Chat ID" :value="$settings['notif_telegram_chat_id'] ?? ''" placeholder="-1001234567890" />
                    </div>
                    <div class="mt-4">
                        <form action="{{ route('admin.setting.notifyTest') }}" method="POST" class="flex items-center gap-3">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-cyan-700 bg-cyan-100 hover:bg-cyan-200 px-4 py-2 rounded-xl transition" {{ $telegramConfigured ? '' : 'disabled title="Konfigurasi Telegram terlebih dahulu"' }}>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                                Kirim Pesan Uji
                            </button>
                            <span class="text-xs text-gray-500">Mengirim pesan tes ke chat ID Telegram yang dikonfigurasi.</span>
                        </form>
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
