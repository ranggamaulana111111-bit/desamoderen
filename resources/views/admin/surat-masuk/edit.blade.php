<x-admin-layout title="Edit Surat Masuk" maxWidth="max-w-[1200px]">

    <div x-data="{
        tanggalTerima: '{{ old('tanggal_terima', $surat->tanggal_terima?->format('Y-m-d') ?? '') }}',
        tanggalSurat: '{{ old('tanggal_surat', $surat->tanggal_surat?->format('Y-m-d') ?? '') }}',
        nomorSurat: '{{ old('nomor_surat', $surat->nomor_surat) }}',
        pengirim: '{{ old('pengirim', $surat->pengirim) }}',
        perihal: '{{ old('perihal', $surat->perihal) }}',
        jenisSurat: '{{ old('jenis_surat', $surat->jenis_surat) }}',
        sifatSurat: '{{ old('sifat_surat', $surat->sifat_surat) }}',
        status: '{{ old('status', $surat->status) }}',
        keterangan: '{{ addslashes(old('keterangan', $surat->keterangan)) }}',
        filePreview: null,
        fileName: '{{ $surat->file_path ? basename($surat->file_path) : '' }}',
        existingFile: '{{ $surat->file_path ? asset('storage/' . $surat->file_path) : '' }}',
        get sifatBadge() {
            return {
                'Biasa': 'bg-gray-100 text-gray-700',
                'Segera': 'bg-amber-100 text-amber-700',
                'Rahasia': 'bg-red-100 text-red-700',
                'Penting': 'bg-blue-100 text-blue-700',
            }[this.sifatSurat] || 'bg-gray-100 text-gray-700';
        },
        get statusBadge() {
            return {
                'diterima': 'bg-blue-100 text-blue-700',
                'diproses': 'bg-amber-100 text-amber-700',
                'selesai': 'bg-emerald-100 text-emerald-700',
                'ditolak': 'bg-red-100 text-red-700',
            }[this.status] || 'bg-blue-100 text-blue-700';
        },
        get statusLabel() {
            return { 'diterima': 'Diterima', 'diproses': 'Diproses', 'selesai': 'Selesai', 'ditolak': 'Ditolak' }[this.status] || 'Diterima';
        },
        handleFile(e) {
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

        <form method="POST" action="{{ route('admin.surat-masuk.update', $surat) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-24 lg:pb-6">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Informasi Surat --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                                Informasi Surat
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">

                            {{-- Nomor Agenda (readonly) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Agenda</label>
                                <input type="text" value="{{ $surat->nomor_agenda }}" readonly
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed">
                            </div>

                            {{-- Nomor Surat --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Surat <span class="text-red-500">*</span></label>
                                <input type="text" name="nomor_surat" x-model="nomorSurat" required maxlength="255"
                                    placeholder="Contoh: 001/SM/2026"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('nomor_surat')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Pengirim --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pengirim <span class="text-red-500">*</span></label>
                                <input type="text" name="pengirim" x-model="pengirim" required maxlength="255"
                                    placeholder="Nama instansi atau pengirim surat"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('pengirim')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Perihal --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Perihal <span class="text-red-500">*</span></label>
                                <input type="text" name="perihal" x-model="perihal" required maxlength="500"
                                    placeholder="Perihal / subjek surat"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('perihal')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Keterangan --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                                <textarea name="keterangan" x-model="keterangan" rows="3"
                                    placeholder="Catatan tambahan (opsional)"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition resize-y"></textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal & Jenis --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-blue-500 to-indigo-600 mr-2"></span>
                                Tanggal & Klasifikasi
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Terima <span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_terima" x-model="tanggalTerima" required
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('tanggal_terima')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Surat <span class="text-red-500">*</span></label>
                                    <input type="date" name="tanggal_surat" x-model="tanggalSurat" required
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('tanggal_surat')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Jenis Surat --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Surat <span class="text-red-500">*</span></label>
                                <input type="hidden" name="jenis_surat" :value="jenisSurat">
                                <div class="inline-flex rounded-xl border border-gray-200 bg-gray-50 p-1 gap-1">
                                    @foreach (['Masuk', 'Keluar', 'Internal'] as $jenis)
                                        <button type="button" @click="jenisSurat = '{{ $jenis }}'"
                                            :class="jenisSurat === '{{ $jenis }}'
                                                ? 'bg-white shadow-sm text-emerald-700 ring-1 ring-emerald-100'
                                                : 'text-gray-500 hover:text-gray-700'"
                                            class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold transition-all duration-200">
                                            {{ $jenis }}
                                        </button>
                                    @endforeach
                                </div>
                                @error('jenis_surat')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Sifat Surat --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Sifat Surat <span class="text-red-500">*</span></label>
                                <input type="hidden" name="sifat_surat" :value="sifatSurat">
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                    @foreach (['Biasa', 'Segera', 'Rahasia', 'Penting'] as $sifat)
                                        <button type="button" @click="sifatSurat = '{{ $sifat }}'"
                                            :class="sifatSurat === '{{ $sifat }}'
                                                ? 'ring-2 ring-emerald-500 bg-emerald-50 border-emerald-200'
                                                : 'border-gray-200 hover:border-gray-300 bg-white'"
                                            class="rounded-xl border p-2.5 text-center text-xs font-semibold transition-all duration-200 cursor-pointer">
                                            {{ $sifat }}
                                        </button>
                                    @endforeach
                                </div>
                                @error('sifat_surat')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Upload File --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-violet-500 to-purple-600 mr-2"></span>
                                Lampiran File
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            {{-- New file preview --}}
                            <div x-show="filePreview && filePreview !== 'pdf'" x-transition class="mb-4">
                                <div class="relative rounded-xl overflow-hidden border border-gray-200">
                                    <img :src="filePreview" class="w-full h-40 object-contain bg-gray-50">
                                    <button type="button" @click="filePreview = null; fileName = ''; $refs.fileInput.value = ''"
                                        class="absolute top-2 right-2 w-8 h-8 rounded-lg bg-black/50 text-white hover:bg-black/70 flex items-center justify-center transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div x-show="filePreview === 'pdf'" x-transition class="mb-4">
                                <div class="flex items-center gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4">
                                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate" x-text="fileName"></p>
                                        <p class="text-xs text-gray-500">File PDF</p>
                                    </div>
                                    <button type="button" @click="filePreview = null; fileName = ''; $refs.fileInput.value = ''"
                                        class="text-gray-400 hover:text-red-500 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Existing file info --}}
                            <div x-show="!filePreview && existingFile" x-transition class="mb-4">
                                <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-emerald-800 truncate">{{ $surat->file_path ? basename($surat->file_path) : '-' }}</p>
                                        <p class="text-xs text-emerald-600">File saat ini &middot; Upload baru untuk mengganti</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $surat->file_path) }}" target="_blank"
                                        class="text-emerald-600 hover:text-emerald-800 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                    </a>
                                </div>
                            </div>

                            <label class="block">
                                <div class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-emerald-300 hover:bg-emerald-50/30 transition-all"
                                    :class="filePreview ? 'border-emerald-200 bg-emerald-50/20' : ''">
                                    <div x-show="!filePreview">
                                        <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                        <p class="text-xs font-medium text-gray-400">Klik untuk upload file baru</p>
                                        <p class="text-[10px] text-gray-300 mt-0.5">PDF, JPG, PNG &middot; Maks. 5MB</p>
                                    </div>
                                    <div x-show="filePreview" class="text-center">
                                        <p class="text-xs font-semibold text-emerald-600">File dipilih</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">Klik untuk mengganti</p>
                                    </div>
                                </div>
                                <input x-ref="fileInput" type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" class="hidden" @change="handleFile($event)">
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
                                    <span class="font-mono text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md">{{ $surat->nomor_agenda }}</span>
                                    <span :class="sifatBadge" class="chip text-[11px]" x-text="sifatSurat"></span>
                                    <span :class="statusBadge" class="chip text-[11px]" x-text="statusLabel"></span>
                                </div>
                                <p class="text-[11px] text-gray-500 font-medium" x-text="nomorSurat || 'Nomor surat'"></p>
                                <h4 class="text-sm font-bold text-gray-800 leading-snug" x-text="pengirim || 'Nama Pengirim'"></h4>
                                <p class="text-xs text-gray-500" x-text="perihal || 'Perihal surat'"></p>
                                <div class="flex items-center gap-2 text-[11px] text-gray-400 border-t border-gray-100 pt-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span x-text="tanggalTerima || 'Tanggal terima'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-amber-500 to-orange-600 mr-2"></span>
                                Status
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <input type="hidden" name="status" :value="status">
                            <div class="grid grid-cols-2 gap-2">
                                @foreach (['diterima', 'diproses', 'selesai', 'ditolak'] as $st)
                                    <button type="button" @click="status = '{{ $st }}'"
                                        :class="status === '{{ $st }}'
                                            ? 'ring-2 ring-emerald-500 bg-emerald-50 border-emerald-200 text-emerald-700'
                                            : 'border-gray-200 hover:border-gray-300 bg-white text-gray-500'"
                                        class="rounded-xl border p-2 text-center text-xs font-semibold transition-all duration-200 cursor-pointer">
                                        {{ ucfirst($st) }}
                                    </button>
                                @endforeach
                            </div>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sticky Footer Bar --}}
            <div class="fixed bottom-0 left-0 right-0 lg:static bg-white/90 backdrop-blur-md border-t border-gray-200 lg:border-t-0 lg:bg-transparent lg:backdrop-blur-none px-4 lg:px-0 py-3 lg:py-0">
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.surat-masuk.show', $surat) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Perbarui Surat
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-admin-layout>
