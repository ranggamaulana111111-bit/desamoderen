<x-admin-layout title="Pengaturan Desa" maxWidth="max-w-[1440px]">
    @push('styles')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <style>
        .nav-item { transition: all 0.2s cubic-bezier(0.4,0,0.2,1); position: relative; }
        .nav-item:hover { background: rgba(16,185,129,0.08); }
        .nav-item.active { background: rgba(16,185,129,0.12); color: #059669; }
        .nav-item.active::before { content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 3px; height: 20px; background: #10b981; border-radius: 0 3px 3px 0; }
        .nav-item.active .nav-icon { color: #059669; }
        .toast-enter { animation: toastIn 0.3s ease-out; }
        @keyframes toastIn { 0% { opacity: 0; transform: translateY(-12px) scale(0.95); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .setting-card { transition: all 0.2s ease; border: 1px solid rgba(226,232,240,0.8); }
        .setting-card:hover { border-color: rgba(16,185,129,0.2); }
    </style>
    @endpush

    <div x-data="settingApp()" x-init="initApp()">

        {{-- ═══ TOAST NOTIFICATION ═══ --}}
        <div x-show="showToast" x-cloak class="fixed top-4 right-4 z-50 toast-enter" x-transition>
            <div :class="toastType === 'success' ? 'bg-emerald-600' : 'bg-red-600'" class="flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-2xl text-white text-sm font-medium min-w-[300px]">
                <template x-if="toastType === 'success'">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </template>
                <template x-if="toastType === 'error'">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </template>
                <span x-text="toastMessage" class="flex-1"></span>
                <button @click="showToast = false" class="text-white/70 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- ═══ SESSION FLASH → TOAST ═══ --}}
        @if (session('success'))
        <div x-init="showToastMessage('success', '{{ session('success') }}')"></div>
        @endif
        @if (session('error'))
        <div x-init="showToastMessage('error', '{{ session('error') }}')"></div>
        @endif

        {{-- ═══ VALIDATION ERRORS ═══ --}}
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6 animate-fade-in">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                <p class="text-sm font-semibold text-red-800">Terdapat kesalahan pada input</p>
            </div>
            <ul class="ml-7 list-disc list-inside text-sm text-red-600 space-y-0.5">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ═══ MOBILE TAB SELECTOR ═══ --}}
        <div class="lg:hidden mb-4">
            <select x-model="activeTab" @change="switchTab($event.target.value)"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 bg-white">
                @foreach ($categories as $key => $menu)
                <option value="{{ $key }}">{{ $menu['label'] }}</option>
                @endforeach
            </select>
        </div>

        {{-- ═══ THREE-COLUMN LAYOUT ═══ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- ═══ LEFT SIDEBAR ═══ --}}
            <aside class="lg:col-span-3 xl:col-span-2 shrink-0 hidden lg:block">
                <nav class="lg:sticky lg:top-8 space-y-0.5 bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden max-h-[calc(100vh-8rem)] overflow-y-auto hide-scrollbar">
                    @foreach ($categories as $key => $menu)
                    <button @click="switchTab('{{ $key }}')"
                            :class="activeTab === '{{ $key }}' ? 'active bg-emerald-50/50' : ''"
                            class="nav-item w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 text-left">
                        <svg class="nav-icon w-5 h-5 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $menu['icon'] }}"/>
                        </svg>
                        <span class="truncate">{{ $menu['label'] }}</span>
                        @if ($key === 'audit-log')
                        <span class="ml-auto text-[10px] font-medium text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded-full">{{ $auditLogs->count() }}</span>
                        @endif
                    </button>
                    @endforeach
                </nav>
            </aside>

            {{-- ═══ RIGHT CONTENT ═══ --}}
            <div class="lg:col-span-6 xl:col-span-7 min-w-0">
                {{-- Skeleton --}}
                @include('admin.setting.partials._skeleton')

                {{-- Tab Panels --}}
                <div class="space-y-5" x-show="!loading">
                    @include('admin.setting.partials._profil_desa')
                    @include('admin.setting.partials._pemerintahan')
                    @include('admin.setting.partials._ttd_digital')
                    @include('admin.setting.partials._template_surat')
                    @include('admin.setting.partials._nomor_surat')
                    @include('admin.setting.partials._workflow')
                    @include('admin.setting.partials._queue_driver')
                    @include('admin.setting.partials._antrean')
                    @include('admin.setting.partials._notifikasi')
                    @include('admin.setting.partials._analytics')
                    @include('admin.setting.partials._backup')
                    @include('admin.setting.partials._keamanan')
                    @include('admin.setting.partials._integrasi')
                    @include('admin.setting.partials._tampilan')
                    @include('admin.setting.partials._maintenance')
                    @include('admin.setting.partials._audit_log')
                </div>
            </div>

            {{-- ═══ RIGHT PREVIEW PANEL ═══ --}}
            <aside class="lg:col-span-3 xl:col-span-3 shrink-0">
                <div class="lg:sticky lg:top-8">
                    @include('admin.setting.partials._preview_panel')
                </div>
            </aside>

        </div>
    </div>

    @push('scripts')
    <script>
        function updateWidgetAktif(el) {
            const checks = document.querySelectorAll('input[type="checkbox"][value]');
            const vals = [];
            checks.forEach(c => { if (c.checked && c.value) vals.push(c.value); });
            document.getElementById('analytics_widget_aktif').value = vals.join(',');
        }

        function settingApp() {
            const urlParams = new URLSearchParams(window.location.search);
            const tabFromUrl = urlParams.get('tab') || 'profil-desa';

            return {
                activeTab: tabFromUrl,
                saving: false,
                loading: true,
                showToast: false,
                toastMessage: '',
                toastType: 'success',
                previewNumber: '',

                preview: Object.assign({
                    logoPreview: null,
                    stempelPreview: null,
                    ttdKadesPreview: null,
                    ttd_digital_aktif: {{ ($settings['ttd_digital_aktif'] ?? '1') == '1' ? 'true' : 'false' }},
                    qr_verifikasi_aktif: {{ ($settings['qr_verifikasi_aktif'] ?? '1') == '1' ? 'true' : 'false' }},
                }, @json($previewDefaults)),

                initApp() {
                    this.updatePreviewNumber();
                    const self = this;
                    this.loading = false;

                    const watchFields = ['format_nomor_surat', 'nomor_prefix', 'nomor_padding', 'nomor_suffix'];
                    watchFields.forEach(field => {
                        this.$watch('preview.' + field, () => self.updatePreviewNumber());
                    });
                },

                switchTab(tab) {
                    this.activeTab = tab;
                    history.replaceState(null, '', '?tab=' + tab);
                    document.querySelector('main')?.scrollTo({ top: 0, behavior: 'smooth' });
                },

                showToastMessage(type, message) {
                    this.toastType = type;
                    this.toastMessage = message;
                    this.showToast = true;
                    setTimeout(() => { this.showToast = false; }, 4000);
                },

                updatePreviewNumber() {
                    const format = this.preview.format_nomor_surat || '470 / {id} / DS-KP / {tahun}';
                    const padding = parseInt(this.preview.nomor_padding) || 4;
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const id = '1';
                    const paddedId = String(id).padStart(padding, '0');
                    this.previewNumber = format
                        .replace('{kode_surat}', 'SKTM')
                        .replace('{id}', paddedId)
                        .replace('{tahun}', year)
                        .replace('{bulan}', month);
                },

                updatePreviewLogo(ref) {
                    if (ref && ref.files && ref.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.preview.logoPreview = e.target.result; };
                        reader.readAsDataURL(ref.files[0]);
                    }
                },

                updatePreviewStempel(ref) {
                    if (ref && ref.files && ref.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.preview.stempelPreview = e.target.result; };
                        reader.readAsDataURL(ref.files[0]);
                    }
                },

                updatePreviewTtdKades(ref) {
                    if (ref && ref.files && ref.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.preview.ttdKadesPreview = e.target.result; };
                        reader.readAsDataURL(ref.files[0]);
                    }
                },
            }
        }
    </script>
    @endpush
</x-admin-layout>
