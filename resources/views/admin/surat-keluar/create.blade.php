<x-admin-layout title="Tambah Surat Keluar" maxWidth="max-w-[1200px]">

    <div x-data="{
        tanggalKirim: '{{ old('tanggal_kirim', date('Y-m-d')) }}',
        tujuan: '{{ old('tujuan') }}',
        perihal: '{{ old('perihal') }}',
        jenisSurat: '{{ old('jenis_surat') }}',
        sifatSurat: '{{ old('sifat_surat') }}',
        status: '{{ old('status', 'dikirim') }}',
        filePreview: null,
        fileName: '',
        get sifatColor() {
            const colors = { 'Biasa': 'bg-gray-100 text-gray-600', 'Segera': 'bg-amber-100 text-amber-700', 'Rahasia': 'bg-red-100 text-red-700', 'Penting': 'bg-teal-100 text-teal-700' };
            return colors[this.sifatSurat] || 'bg-gray-100 text-gray-600';
        },
        get statusLabel() {
            const labels = { 'dikirim': 'Dikirim', 'diproses': 'Diproses', 'selesai': 'Selesai', 'ditolak': 'Ditolak' };
            return labels[this.status] || 'Dikirim';
        },
        get statusColor() {
            const colors = { 'dikirim': 'bg-emerald-100 text-emerald-700', 'diproses': 'bg-teal-100 text-teal-700', 'selesai': 'bg-violet-100 text-violet-700', 'ditolak': 'bg-red-100 text-red-700' };
            return colors[this.status] || 'bg-emerald-100 text-emerald-700';
        },
        previewFile(e) {
            const file = e.target.files[0];
            if (file) {
                this.fileName = file.name;
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (ev) => { this.filePreview = ev.target.result; };
                    reader.readAsDataURL(file);
                } else {
                    this.filePreview = 'pdf';
                }
            } else {
                this.filePreview = null;
                this.fileName = '';
            }
        }
    }">

        <form method="POST" action="{{ route('admin.surat-keluar.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-24 lg:pb-6">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Info Surat --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                                Informasi Surat
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">

                            {{-- Nomor Agenda --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Agenda</label>
                                <input type="text" value="{{ $nomorAgenda }}" readonly
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm bg-gray-50 text-gray-500 font-mono cursor-not-allowed">
                                <p class="text-[10px] text-gray-400 mt-1.5">Nomor agenda digenerate otomatis oleh sistem.</p>
                            </div>

                            {{-- Tanggal Kirim --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Kirim <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_kirim" x-model="tanggalKirim" required
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('tanggal_kirim')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Tujuan --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tujuan <span class="text-red-500">*</span></label>
                                <input type="text" name="tujuan" x-model="tujuan" required maxlength="255"
                                    placeholder="Masukkan tujuan surat"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('tujuan')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Perihal --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Perihal <span class="text-red-500">*</span></label>
                                <input type="text" name="perihal" x-model="perihal" required maxlength="255"
                                    placeholder="Masukkan perihal surat"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('perihal')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Jenis & Sifat --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-teal-500 to-cyan-600 mr-2"></span>
                                Klasifikasi
                            </h3>
                        </div>
                        <div class="widget-card-body grid grid-cols-1 sm:grid-cols-2 gap-5">
                            {{-- Jenis Surat --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Surat <span class="text-red-500">*</span></label>
                                <select name="jenis_surat" x-model="jenisSurat" required
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition bg-white">
                                    <option value="">Pilih Jenis</option>
                                    <option value="Masuk">Masuk</option>
                                    <option value="Keluar">Keluar</option>
                                    <option value="Internal">Internal</option>
                                </select>
                                @error('jenis_surat')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Sifat Surat --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sifat Surat <span class="text-red-500">*</span></label>
                                <select name="sifat_surat" x-model="sifatSurat" required
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition bg-white">
                                    <option value="">Pilih Sifat</option>
                                    <option value="Biasa">Biasa</option>
                                    <option value="Segera">Segera</option>
                                    <option value="Rahasia">Rahasia</option>
                                    <option value="Penting">Penting</option>
                                </select>
                                @error('sifat_surat')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- File Upload --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-violet-500 to-purple-600 mr-2"></span>
                                Lampiran
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            {{-- Preview --}}
                            <div x-show="filePreview && filePreview !== 'pdf'" x-transition class="mb-4">
                                <div class="relative rounded-xl overflow-hidden border border-gray-200">
                                    <img :src="filePreview" class="w-full h-48 object-cover">
                                    <button type="button" @click="filePreview = null; fileName = ''; $refs.fileInput.value = ''"
                                        class="absolute top-2 right-2 w-8 h-8 rounded-lg bg-black/50 text-white hover:bg-black/70 flex items-center justify-center transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div x-show="filePreview === 'pdf'" x-transition class="mb-4">
                                <div class="flex items-center gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-700 truncate" x-text="fileName"></p>
                                        <p class="text-[10px] text-gray-400">File PDF dipilih</p>
                                    </div>
                                    <button type="button" @click="filePreview = null; fileName = ''; $refs.fileInput.value = ''"
                                        class="text-gray-400 hover:text-red-500 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Upload --}}
                            <label class="block">
                                <div class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-emerald-300 hover:bg-emerald-50/30 transition-all"
                                    :class="filePreview ? 'border-emerald-200 bg-emerald-50/20' : ''">
                                    <div x-show="!filePreview">
                                        <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                        <p class="text-xs font-medium text-gray-400">Klik untuk upload file</p>
                                        <p class="text-[10px] text-gray-300 mt-0.5">PDF, JPG, PNG - Maks. 5MB</p>
                                    </div>
                                    <div x-show="filePreview" class="text-center">
                                        <p class="text-xs font-semibold text-emerald-600">File dipilih</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">Klik untuk mengganti</p>
                                    </div>
                                </div>
                                <input x-ref="fileInput" type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" class="hidden" @change="previewFile($event)">
                            </label>
                            @error('file')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- Preview --}}
                    <div class="widget-card lg:sticky lg:top-6">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-teal-500 to-cyan-600 mr-2"></span>
                                Preview
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <div class="rounded-xl border border-gray-100 bg-gradient-to-br from-gray-50 to-white p-4 space-y-3">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-mono text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">{{ $nomorAgenda }}</span>
                                    <span :class="statusColor" class="chip text-[11px]" x-text="statusLabel"></span>
                                </div>
                                <div x-show="sifatSurat" class="flex items-center gap-2">
                                    <span :class="sifatColor" class="chip text-[11px]" x-text="sifatSurat"></span>
                                    <span x-show="jenisSurat" class="chip chip-brand text-[11px]" x-text="jenisSurat"></span>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800 leading-snug" x-text="perihal || 'Perihal Surat'"></h4>
                                <p x-show="tujuan" class="text-xs text-gray-500">
                                    <span class="font-medium text-gray-600">Tujuan:</span> <span x-text="tujuan"></span>
                                </p>
                                <p x-show="tanggalKirim" class="text-xs text-gray-400">
                                    <span x-text="new Date(tanggalKirim).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-violet-500 to-purple-600 mr-2"></span>
                                Status
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <select name="status" x-model="status"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition bg-white">
                                <option value="dikirim">Dikirim</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tips --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-cyan-500 to-teal-600 mr-2"></span>
                                Tips
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <ul class="space-y-3">
                                <li class="flex items-start gap-2.5 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-teal-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Nomor agenda dihasilkan otomatis oleh sistem</span>
                                </li>
                                <li class="flex items-start gap-2.5 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-teal-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Lampiran bersifat opsional, dapat ditambahkan nanti</span>
                                </li>
                                <li class="flex items-start gap-2.5 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-teal-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Format file: PDF, JPG, PNG (maks. 5MB)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sticky Footer Bar --}}
            <div class="fixed bottom-0 left-0 right-0 lg:static bg-white/90 backdrop-blur-md border-t border-gray-200 lg:border-t-0 lg:bg-transparent lg:backdrop-blur-none px-4 lg:px-0 py-3 lg:py-0">
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.surat-keluar.index') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Simpan Surat
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-admin-layout>
