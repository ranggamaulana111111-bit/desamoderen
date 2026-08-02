<x-admin-layout title="Edit Surat Keluar" maxWidth="max-w-[1200px]">

    <div x-data="{
        tanggalKirim: '{{ old('tanggal_kirim', $surat->tanggal_kirim) }}',
        tujuan: '{{ old('tujuan', addslashes($surat->tujuan)) }}',
        perihal: '{{ old('perihal', addslashes($surat->perihal)) }}',
        jenisSurat: '{{ old('jenis_surat', $surat->jenis_surat) }}',
        sifatSurat: '{{ old('sifat_surat', $surat->sifat_surat) }}',
        status: '{{ old('status', $surat->status) }}',
        filePreview: {{ $surat->file_path ? (in_array(pathinfo($surat->file_path, PATHINFO_EXTENSION), ['jpg','jpeg','png']) ? "'" . asset('storage/' . $surat->file_path) . "'" : "'pdf'") : 'null' }},
        existingFile: '{{ $surat->file_path }}',
        fileName: '',
        get sifatColor() {
            const colors = { 'Biasa': 'bg-gray-100 text-gray-600', 'Segera': 'bg-amber-100 text-amber-700', 'Rahasia': 'bg-red-100 text-red-700', 'Penting': 'bg-blue-100 text-blue-700' };
            return colors[this.sifatSurat] || 'bg-gray-100 text-gray-600';
        },
        get statusLabel() {
            const labels = { 'dikirim': 'Dikirim', 'diproses': 'Diproses', 'selesai': 'Selesai', 'ditolak': 'Ditolak' };
            return labels[this.status] || 'Dikirim';
        },
        get statusColor() {
            const colors = { 'dikirim': 'bg-emerald-100 text-emerald-700', 'diproses': 'bg-blue-100 text-blue-700', 'selesai': 'bg-violet-100 text-violet-700', 'ditolak': 'bg-red-100 text-red-700' };
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
                this.existingFile = '';
            }
        },
        removeFile() {
            this.filePreview = null;
            this.existingFile = '';
            this.fileName = '';
            this.$refs.fileInput.value = '';
        }
    }">

        <form method="POST" action="{{ route('admin.surat-keluar.update', $surat) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                                <input type="text" value="{{ $surat->nomor_agenda }}" readonly
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm bg-gray-50 text-gray-500 font-mono cursor-not-allowed">
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
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-blue-500 to-indigo-600 mr-2"></span>
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
                            {{-- Image Preview (new or existing) --}}
                            <div x-show="filePreview && filePreview !== 'pdf'" x-transition class="mb-4">
                                <div class="relative rounded-xl overflow-hidden border border-gray-200">
                                    <img :src="filePreview" class="w-full h-48 object-cover">
                                    <button type="button" @click="removeFile()"
                                        class="absolute top-2 right-2 w-8 h-8 rounded-lg bg-black/50 text-white hover:bg-black/70 flex items-center justify-center transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent px-4 py-2">
                                        <p x-show="existingFile" class="text-[10px] text-white/80">File saat ini — pilih file baru untuk mengganti</p>
                                        <p x-show="!existingFile" class="text-[10px] text-white/80">File baru dipilih</p>
                                    </div>
                                </div>
                            </div>

                            {{-- PDF Preview --}}
                            <div x-show="filePreview === 'pdf'" x-transition class="mb-4">
                                <div class="flex items-center gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-700 truncate" x-text="fileName || '{{ basename($surat->file_path ?? '') }}'"></p>
                                        <p x-show="existingFile" class="text-[10px] text-gray-400">File PDF saat ini</p>
                                        <p x-show="!existingFile" class="text-[10px] text-gray-400">File PDF baru dipilih</p>
                                    </div>
                                    <button type="button" @click="removeFile()"
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
                                        <p class="text-xs font-medium text-gray-400">Klik untuk upload file baru</p>
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
                                    <span class="font-mono text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">{{ $surat->nomor_agenda }}</span>
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

                    {{-- Info --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-gray-400 to-gray-500 mr-2"></span>
                                Informasi
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-3">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Dibuat: {{ $surat->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                                <span>Diupdate: {{ $surat->updated_at->locale('id')->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                <span>Oleh: {{ $surat->creator?->name ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sticky Footer Bar --}}
            <div class="fixed bottom-0 left-0 right-0 lg:static bg-white/90 backdrop-blur-md border-t border-gray-200 lg:border-t-0 lg:bg-transparent lg:backdrop-blur-none px-4 lg:px-0 py-3 lg:py-0">
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.surat-keluar.show', $surat) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Lihat Detail
                    </a>
                    <a href="{{ route('admin.surat-keluar.index') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-admin-layout>
