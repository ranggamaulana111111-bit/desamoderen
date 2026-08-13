<x-admin-layout title="Pengambilan Surat" maxWidth="max-w-[1440px]">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Pengambilan Surat</h1>
            <p class="text-gray-500 text-sm">Scan QR Code antrean warga untuk memproses pengambilan dokumen.</p>
        </div>
        <div class="flex items-center gap-2 text-xs">
            <span class="inline-flex items-center gap-1.5 bg-amber-50 border border-amber-200 text-amber-700 px-3 py-1.5 rounded-lg font-medium">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span x-text="clock"></span>
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6" x-data="pickupApp()" x-init="init()">
        {{-- ═══ SCAN PANEL ═══ --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="widget-card">
                <div class="widget-card-header">
                    <h2 class="text-sm font-semibold text-gray-700">Scan QR Code</h2>
                    <span class="text-[10px] text-gray-400">Kamera petugas</span>
                </div>
                <div class="widget-card-body">
                    <div id="qr-reader" class="rounded-xl overflow-hidden bg-slate-900" style="min-height:200px"></div>
                    <p x-show="scanError" x-cloak x-transition.opacity class="mt-2 text-center text-[11px] font-medium" :class="scanErrorType === 'warning' ? 'text-amber-500' : 'text-red-500'" x-text="scanError"></p>
                    <p class="text-[11px] text-gray-400 mt-2 text-center">Arahkan kamera ke QR Code di layar HP warga</p>
                    <div class="flex items-center justify-center gap-2 mt-2">
                        <button type="button" @click="startScan()" class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-brand-600 hover:bg-brand-700 px-3 py-1.5 rounded-lg transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V6a3 3 0 00-3-3H6a3 3 0 00-3 3v12a3 3 0 003 3h6a3 3 0 003-3v-3m-9-3h1.5m3.75 0H12m-9 0V6m18 6H9m9 0V9m3 0h-3"/></svg>
                            Mulai Scan
                        </button>
                        <button type="button" @click="stopScan()" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors">
                            Hentikan
                        </button>
                    </div>
                </div>
            </div>

            <div class="widget-card">
                <div class="widget-card-header">
                    <h2 class="text-sm font-semibold text-gray-700">Cari Manual</h2>
                    <span class="text-[10px] text-gray-400">Nomor antrean / kode QR</span>
                </div>
                <div class="widget-card-body">
                    <form class="flex gap-2" @@submit.prevent="cariManual()">
                        <input type="text" x-model="manualQuery" placeholder="Contoh: AQ/20260804/001"
                               class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-500">
                        <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 px-4 py-2 rounded-lg transition-colors" :disabled="loading">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                            Cari
                        </button>
                    </form>
                    <p x-show="manualError" x-cloak x-text="manualError" class="text-[11px] text-red-500 mt-2"></p>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                            Pilih dari antrean menunggu
                            <template x-if="manualQuery.trim()"><span class="normal-case text-gray-500">— hasil untuk "<span x-text="manualQuery"></span>"</span></template>
                        </p>
                        <template x-for="a in filteredList" :key="a.id">
                            <button type="button" @@click="pilihAntrean(a)" class="w-full text-left flex items-center justify-between gap-2 px-3 py-2 rounded-lg hover:bg-gray-50 border border-gray-100 mb-1.5 transition-colors group">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-gray-800 truncate" x-text="a.nomor_antrean"></p>
                                    <p class="text-[10px] text-gray-400 truncate" x-text="a.pemohon + ' • ' + a.jenis_surat"></p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-brand-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </template>
                        <p x-show="filteredList.length === 0 && manualQuery.trim() === ''" class="text-xs text-gray-400 text-center py-3">Tidak ada antrean menunggu hari ini.</p>
                        <p x-show="filteredList.length === 0 && manualQuery.trim() !== ''" class="text-xs text-gray-400 text-center py-3">Tidak ditemukan antrean yang cocok dengan "<span x-text="manualQuery"></span>".</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ RESULT + LIST ═══ --}}
        <div class="lg:col-span-3 space-y-6">
            <div class="widget-card" x-show="antrean" x-cloak>
                <div class="widget-card-header">
                    <h2 class="text-sm font-semibold text-gray-700">Detail Antrean</h2>
                    <template x-if="antrean">
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold px-2.5 py-1 rounded-full"
                              :class="statusBadge(antrean.status)">
                            <span x-text="statusLabel(antrean.status)"></span>
                        </span>
                    </template>
                </div>
                <div class="widget-card-body">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Nomor Antrean</p>
                            <p class="text-2xl font-extrabold text-gray-900 font-mono" x-text="antrean?.nomor_antrean"></p>
                        </div>
                        <template x-if="antrean && antrean.status === 'menunggu'">
                            <div class="flex items-center gap-2">
                                @can('queue.manage')
                                <button type="button" @@click="proses()" :disabled="processing"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-5 py-2.5 rounded-xl transition-all shadow-sm hover:shadow" :class="processing ? 'opacity-50 cursor-not-allowed' : ''">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span x-text="processing ? 'Memproses...' : 'Serahkan Dokumen'"></span>
                                </button>
                                <button type="button" @@click="lewat()" :disabled="processing"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 px-4 py-2.5 rounded-xl transition-all" :class="processing ? 'opacity-50 cursor-not-allowed' : ''">
                                    Tandai Lewat
                                </button>
                                @else
                                <p class="text-[11px] text-gray-400">Anda tidak memiliki izin queue.manage untuk memproses.</p>
                                @endcan
                            </div>
                        </template>
                    </div>

                    <template x-if="antrean">
                        <div class="rounded-xl border border-gray-100 divide-y divide-gray-100 bg-white overflow-hidden">
                            <div class="flex items-center gap-3 px-4 py-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Pemohon</p>
                                    <p class="text-sm font-bold text-gray-900" x-text="antrean.pemohon"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 px-4 py-3">
                                <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">NIK</p>
                                    <p class="text-sm font-bold text-gray-900 font-mono" x-text="antrean.nik"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 px-4 py-3">
                                <div class="w-9 h-9 rounded-xl bg-teal-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Jenis Surat</p>
                                    <p class="text-sm font-bold text-gray-900 capitalize" x-text="antrean.jenis_surat"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 px-4 py-3">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Jadwal</p>
                                    <p class="text-sm font-bold text-gray-900" x-text="antrean.tanggal_ambil + ' • ' + antrean.jam_mulai + ' - ' + antrean.jam_selesai"></p>
                                </div>
                            </div>
                            <template x-if="antrean.nomor_surat">
                                <div class="flex items-center gap-3 px-4 py-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-50 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">Nomor Surat</p>
                                        <p class="text-sm font-bold text-gray-900 font-mono" x-text="antrean.nomor_surat"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="!antrean && !loading">
                        <div class="text-center py-10">
                            <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9.75L12 3l9 6.75V21a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 21V9.75z"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-600">Belum ada antrean dipilih</p>
                            <p class="text-xs text-gray-400 mt-1">Scan QR atau cari nomor antrean untuk memulai.</p>
                        </div>
                    </template>
                </div>
            </div>

            <div class="widget-card" x-show="toast" x-cloak x-transition.opacity.duration.300ms>
                <div class="widget-card-body">
                    <div class="flex items-center gap-3 rounded-xl px-4 py-3" :class="toast?.type === 'success' ? 'bg-emerald-50 border border-emerald-200' : 'bg-red-50 border border-red-200'">
                        <template x-if="toast?.type === 'success'">
                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </template>
                        <template x-if="toast?.type !== 'success'">
                            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </template>
                        <p class="text-sm font-semibold" :class="toast?.type === 'success' ? 'text-emerald-700' : 'text-red-700'" x-text="toast?.message"></p>
                    </div>
                </div>
            </div>

            <div class="widget-card">
                <div class="widget-card-header">
                    <h2 class="text-sm font-semibold text-gray-700">Antrean Hari Ini</h2>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-1 rounded-full" x-text="'Menunggu: ' + menunggu.length"></span>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-full" x-text="'Diambil: ' + diambil.length"></span>
                        <span class="text-[10px] font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full" x-text="'Lewat: ' + lewat.length"></span>
                        <button type="button" @@click="refreshList()" class="text-[10px] font-semibold text-gray-500 hover:text-brand-600 inline-flex items-center gap-1 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Muat Ulang
                        </button>
                    </div>
                </div>
                <div class="widget-card-body-compact">
                    <div class="overflow-x-auto">
                        <table class="table-enhanced">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Pemohon</th>
                                    <th>Surat</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="a in mergedList" :key="a.id">
                                    <tr class="group hover:bg-gray-50/50 transition-colors">
                                        <td class="text-gray-800 font-mono text-xs font-bold" x-text="a.nomor_antrean"></td>
                                        <td class="text-gray-800 text-sm font-medium" x-text="a.pemohon"></td>
                                        <td class="text-gray-600 text-xs capitalize" x-text="a.jenis_surat"></td>
                                        <td class="text-gray-500 text-xs" x-text="a.jam_mulai"></td>
                                        <td>
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full" :class="statusBadge(a.status)">
                                                <span x-text="statusLabel(a.status)"></span>
                                            </span>
                                        </td>
                                        <td class="text-right whitespace-nowrap">
                                            <button type="button" @@click="pilihAntrean(a)" class="text-xs font-semibold text-brand-600 hover:text-brand-700 hover:bg-brand-50 px-2.5 py-1.5 rounded-lg transition-colors">Detail</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <p x-show="mergedList.length === 0" class="text-sm text-gray-400 text-center py-8">Tidak ada antrean hari ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('vendor/html5-qrcode/html5-qrcode.min.js') }}"></script>
    <script>
        function pickupApp() {
            return {
                csrf: '{{ csrf_token() }}',
                clock: '',
                timer: null,

                scanner: null,
                scanning: false,
                scanError: '',
                scanErrorType: 'error',

                manualQuery: '',
                manualError: '',
                loading: false,

                menunggu: @json($menunggu),
                diambil: @json($diambil),
                lewat: @json($lewat),

                antrean: null,
                processing: false,
                toast: null,

                get mergedList() {
                    return [...this.menunggu, ...this.diambil, ...this.lewat]
                        .sort((a, b) => (a.jam_mulai || '').localeCompare(b.jam_mulai || ''));
                },

                get filteredList() {
                    const q = this.manualQuery.trim().toLowerCase();
                    if (!q) return this.menunggu;
                    return this.menunggu.filter(a => {
                        return [a.nomor_antrean, a.kode_qr]
                            .some(v => String(v || '').toLowerCase() === q);
                    });
                },

                init() {
                    this.updateClock();
                    this.timer = setInterval(() => this.updateClock(), 1000);
                },

                updateClock() {
                    this.clock = new Date().toLocaleString('id-ID', {
                        weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
                        hour: '2-digit', minute: '2-digit'
                    });
                },

                async startScan() {
                    if (this.scanning) return;
                    if (typeof Html5Qrcode === 'undefined') {
                        this.scanError = 'Library pemindai QR belum termuat. Coba muat ulang halaman.';
                        this.scanErrorType = 'error';
                        this.showToast('error', 'Library pemindai QR belum termuat. Muat ulang halaman.');
                        return;
                    }
                    if (!window.isSecureContext && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
                        this.scanError = 'Akses kamera hanya berjalan di HTTPS (atau localhost). Pastikan situs diakses melalui https://.';
                        this.scanErrorType = 'warning';
                        this.showToast('warning', 'Kamera membutuhkan HTTPS. Gunakan tautan https:// atau cari manual.');
                        return;
                    }
                    this.scanError = '';
                    this.scanErrorType = 'error';
                    try {
                        const cameras = await Html5Qrcode.getCameras();
                        if (!cameras || cameras.length === 0) {
                            this.scanError = 'Kamera tidak ditemukan. Gunakan pencarian manual.';
                            this.showToast('error', 'Kamera tidak ditemukan. Gunakan pencarian manual.');
                            return;
                        }
                        await this.stopScan(true);
                        const backCam = cameras.find(c => /back|environment|rear|belakang/i.test(c.label || ''));
                        const camId = (backCam || cameras[0]).id;
                        this.scanner = new Html5Qrcode('qr-reader');
                        await this.scanner.start(camId, {
                            fps: 10,
                            qrbox: { width: 240, height: 240 },
                            aspectRatio: 1.0,
                        }, (text) => {
                            this.handleScanResult(text);
                        });
                        this.scanning = true;
                    } catch (e) {
                        const msg = e?.message || 'izin kamera ditolak.';
                        this.scanError = 'Gagal mengakses kamera: ' + msg;
                        this.scanErrorType = 'error';
                        this.showToast('error', 'Gagal mengakses kamera: ' + msg);
                    }
                },

                async stopScan(silent = false) {
                    if (this.scanner) {
                        try { await this.scanner.stop(); } catch (e) {}
                        try { this.scanner.clear(); } catch (e) {}
                        this.scanner = null;
                    }
                    this.scanning = false;
                    if (!silent) this.showToast('info', 'Scan dihentikan.');
                },

                async handleScanResult(text) {
                    if (this.loading || this.processing) return;
                    await this.stopScan(true);
                    this.loading = true;
                    this.manualError = '';
                    this.scanError = '';
                    try {
                        await this.cari(text);
                    } finally {
                        this.loading = false;
                    }
                    if (this.antrean) {
                        this.scanError = 'QR terdeteksi. Antrean berhasil dipilih.';
                        this.scanErrorType = 'warning';
                    } else if (this.manualError) {
                        this.scanError = this.manualError;
                        this.manualError = '';
                        this.showToast('error', this.scanError);
                        setTimeout(() => this.startScan(), 1500);
                    }
                },

                async cariManual() {
                    if (!this.manualQuery.trim()) return;
                    this.loading = true;
                    this.manualError = '';
                    await this.cari(this.manualQuery.trim());
                    this.loading = false;
                },

                async cari(query) {
                    try {
                        const res = await fetch('{{ route('admin.queue.pickup.cari') }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrf, 'Accept': 'application/json' },
                            body: JSON.stringify({ query }),
                        });
                        const data = await res.json();
                        if (!res.ok) {
                            this.manualError = data?.errors?.query?.[0] || data?.message || 'Antrean tidak ditemukan.';
                            return;
                        }
                        this.antrean = data.antrean;
                        this.toast = null;
                    } catch (e) {
                        this.manualError = 'Terjadi kesalahan koneksi.';
                    }
                },

                pilihAntrean(a) {
                    this.antrean = a;
                    this.toast = null;
                    this.manualError = '';
                    this.stopScan(true);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                async proses() {
                    if (!this.antrean || this.processing) return;
                    this.processing = true;
                    try {
                        const res = await fetch('{{ route('admin.queue.pickup.proses', ['antrean' => '__ID__']) }}'.replace('__ID__', this.antrean.id), {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': this.csrf, 'Accept': 'application/json' },
                        });
                        const data = await res.json();
                        if (!res.ok) {
                            this.showToast('error', data?.message || 'Gagal memproses antrean.');
                            return;
                        }
                        this.antrean = data.antrean;
                        this.showToast('success', 'Dokumen ' + this.antrean.nomor_antrean + ' berhasil diserahkan kepada ' + this.antrean.pemohon + '.');
                        this.menunggu = this.menunggu.filter(a => a.id !== this.antrean.id);
                        this.diambil = [data.antrean, ...this.diambil].slice(0, 10);
                    } catch (e) {
                        this.showToast('error', 'Terjadi kesalahan koneksi.');
                    } finally {
                        this.processing = false;
                    }
                },

                async lewat() {
                    if (!this.antrean || this.processing) return;
                    this.processing = true;
                    try {
                        const res = await fetch('{{ route('admin.queue.pickup.lewat', ['antrean' => '__ID__']) }}'.replace('__ID__', this.antrean.id), {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': this.csrf, 'Accept': 'application/json' },
                        });
                        const data = await res.json();
                        if (!res.ok) {
                            this.showToast('error', data?.message || 'Gagal menandai antrean.');
                            return;
                        }
                        this.antrean = data.antrean;
                        this.showToast('success', 'Antrean ' + this.antrean.nomor_antrean + ' ditandai lewat.');
                        this.menunggu = this.menunggu.filter(a => a.id !== this.antrean.id);
                        this.lewat = [data.antrean, ...this.lewat].slice(0, 10);
                    } catch (e) {
                        this.showToast('error', 'Terjadi kesalahan koneksi.');
                    } finally {
                        this.processing = false;
                    }
                },

                async refreshList() {
                    window.location.reload();
                },

                statusBadge(status) {
                    if (status === 'diambil') return 'bg-emerald-50 text-emerald-700 border border-emerald-200';
                    if (status === 'lewat') return 'bg-red-50 text-red-600 border border-red-200';
                    return 'bg-amber-50 text-amber-700 border border-amber-200';
                },

                statusLabel(status) {
                    if (status === 'diambil') return 'Diambil';
                    if (status === 'lewat') return 'Lewat';
                    return 'Menunggu';
                },

                showToast(type, message) {
                    this.toast = { type, message };
                    setTimeout(() => { this.toast = null; }, 4000);
                },
            };
        }
    </script>
    @endpush
</x-admin-layout>
