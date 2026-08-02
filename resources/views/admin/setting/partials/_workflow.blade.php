<form x-show="activeTab === 'workflow'" x-cloak
      action="{{ route('admin.setting.update', 'workflow') }}" method="POST"
      class="animate-fade-in" @submit="saving = true">
    @csrf
    <div class="setting-card bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-rose-50/50 to-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Workflow Approval</h2>
                    <p class="text-xs text-gray-500">Alur persetujuan pengajuan surat</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <label class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                    <input type="hidden" name="workflow_operator" value="0">
                    <input type="checkbox" name="workflow_operator" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['workflow_operator'] ?? '1') == '1' ? 'checked' : '' }}>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Approval Operator</p>
                        <p class="text-xs text-gray-500">Verifikasi awal</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                    <input type="hidden" name="workflow_sekdes" value="0">
                    <input type="checkbox" name="workflow_sekdes" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['workflow_sekdes'] ?? '1') == '1' ? 'checked' : '' }}>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Approval Sekdes</p>
                        <p class="text-xs text-gray-500">Verifikasi sekretaris</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                    <input type="hidden" name="workflow_kades" value="0">
                    <input type="checkbox" name="workflow_kades" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['workflow_kades'] ?? '1') == '1' ? 'checked' : '' }}>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Approval Kades</p>
                        <p class="text-xs text-gray-500">Finalisasi kepala desa</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                    <input type="hidden" name="workflow_reminder" value="0">
                    <input type="checkbox" name="workflow_reminder" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['workflow_reminder'] ?? '1') == '1' ? 'checked' : '' }}>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Reminder</p>
                        <p class="text-xs text-gray-500">Pengingat otomatis</p>
                    </div>
                </label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <x-setting-input name="workflow_revision_limit" label="Batas Revisi" type="number" :value="$settings['workflow_revision_limit'] ?? '3'" />
                <x-setting-input name="workflow_sla_jam" label="SLA Approval (jam)" type="number" :value="$settings['workflow_sla_jam'] ?? '48'" />
                <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                    <input type="hidden" name="workflow_auto_complete" value="0">
                    <input type="checkbox" name="workflow_auto_complete" value="1" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" {{ ($settings['workflow_auto_complete'] ?? '0') == '1' ? 'checked' : '' }}>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Auto Complete</p>
                        <p class="text-xs text-gray-500">Selesai otomatis</p>
                    </div>
                </label>
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
