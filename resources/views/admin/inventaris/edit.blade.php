<x-admin-layout title="Edit Inventaris" maxWidth="max-w-[1200px]">

    <div x-data="{
        namaBarang: '{{ old('nama_barang', addslashes($inventaris->nama_barang)) }}',
        kategori: '{{ old('kategori', $inventaris->kategori) }}',
        nomorInventaris: '{{ old('nomor_inventaris', $inventaris->nomor_inventaris ?? '') }}',
        jumlah: {{ old('jumlah', $inventaris->jumlah) }},
        keterangan: '{{ addslashes(old('keterangan', $inventaris->keterangan ?? '')) }}',
        kondisi: '{{ old('kondisi', $inventaris->kondisi) }}',
        status: '{{ old('status', $inventaris->status) }}',
        lokasi: '{{ old('lokasi', addslashes($inventaris->lokasi ?? '')) }}',
        tahunPerolehan: '{{ old('tahun_perolehan', $inventaris->tahun_perolehan ?? '') }}',
        nilaiPerolehan: '{{ old('nilai_perolehan', $inventaris->nilai_perolehan ?? '') }}',
        filePreview: null,
        fileName: '{{ $inventaris->foto ? basename($inventaris->foto) : '' }}',
        existingFile: '{{ $inventaris->foto ? asset('storage/' . $inventaris->foto) : '' }}',
        get kategoriBadge() {
            return {
                'Peralatan': 'bg-emerald-100 text-emerald-700',
                'Kendaraan': 'bg-teal-100 text-teal-700',
                'Gedung': 'bg-amber-100 text-amber-700',
                'Tanah': 'bg-orange-100 text-orange-700',
                'Furniture': 'bg-violet-100 text-violet-700',
                'Elektronik': 'bg-cyan-100 text-cyan-700',
                'Lainnya': 'bg-gray-100 text-gray-700',
            }[this.kategori] || 'bg-gray-100 text-gray-700';
        },
        get kondisiBadge() {
            return {
                'Baik': 'bg-emerald-100 text-emerald-700',
                'Rusak Ringan': 'bg-amber-100 text-amber-700',
                'Rusak Berat': 'bg-red-100 text-red-700',
                'Perawatan': 'bg-teal-100 text-teal-700',
            }[this.kondisi] || 'bg-gray-100 text-gray-700';
        },
        get statusBadge() {
            return {
                'Digunakan': 'bg-teal-100 text-teal-700',
                'Tersedia': 'bg-emerald-100 text-emerald-700',
                'Disimpan': 'bg-amber-100 text-amber-700',
                'Dihapus': 'bg-red-100 text-red-700',
            }[this.status] || 'bg-gray-100 text-gray-700';
        },
        formatRupiah(val) {
            if (!val) return '-';
            return 'Rp ' + Number(val).toLocaleString('id-ID');
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
                    this.filePreview = null;
                    this.fileName = '';
                }
            } else {
                this.filePreview = null;
                this.fileName = '';
            }
        }
    }">

        <form method="POST" action="{{ route('admin.inventaris.update', $inventaris) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-24 lg:pb-6">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Informasi Barang --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                                Informasi Barang
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">

                            {{-- Kode Inventaris (readonly) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Inventaris</label>
                                <input type="text" value="{{ $inventaris->kode_inventaris }}" readonly
                                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed">
                                <p class="text-[11px] text-gray-400 mt-1">Kode inventaris digenerate otomatis oleh sistem.</p>
                            </div>

                            {{-- Nama Barang --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Barang <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_barang" x-model="namaBarang" required maxlength="255"
                                    placeholder="Contoh: Laptop, Meja Kantor, Motor Dinas"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('nama_barang')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Kategori --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                <input type="hidden" name="kategori" :value="kategori">
                                <div class="inline-flex flex-wrap rounded-xl border border-gray-200 bg-gray-50 p-1 gap-1">
                                    @foreach (['Peralatan', 'Kendaraan', 'Gedung', 'Tanah', 'Furniture', 'Elektronik', 'Lainnya'] as $kat)
                                        <button type="button" @click="kategori = '{{ $kat }}'"
                                            :class="kategori === '{{ $kat }}'
                                                ? 'bg-white shadow-sm text-emerald-700 ring-1 ring-emerald-100'
                                                : 'text-gray-500 hover:text-gray-700'"
                                            class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold transition-all duration-200">
                                            {{ $kat }}
                                        </button>
                                    @endforeach
                                </div>
                                @error('kategori')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Nomor Inventaris --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Inventaris</label>
                                <input type="text" name="nomor_inventaris" x-model="nomorInventaris" maxlength="255"
                                    placeholder="Nomor seri / nomor inventaris (opsional)"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('nomor_inventaris')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Jumlah --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah" x-model="jumlah" required min="1"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('jumlah')
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
                                    placeholder="Deskripsi atau catatan tambahan (opsional)"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition resize-y">{{ old('keterangan', $inventaris->keterangan ?? '') }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Kondisi & Status --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-teal-500 to-cyan-600 mr-2"></span>
                                Kondisi & Status
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">

                            {{-- Kondisi --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kondisi <span class="text-red-500">*</span></label>
                                <input type="hidden" name="kondisi" :value="kondisi">
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                    @foreach (['Baik', 'Rusak Ringan', 'Rusak Berat', 'Perawatan'] as $k)
                                        <button type="button" @click="kondisi = '{{ $k }}'"
                                            :class="kondisi === '{{ $k }}'
                                                ? 'ring-2 ring-emerald-500 bg-emerald-50 border-emerald-200'
                                                : 'border-gray-200 hover:border-gray-300 bg-white'"
                                            class="rounded-xl border p-2.5 text-center text-xs font-semibold transition-all duration-200 cursor-pointer">
                                            {{ $k }}
                                        </button>
                                    @endforeach
                                </div>
                                @error('kondisi')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                                <input type="hidden" name="status" :value="status">
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                    @foreach (['Digunakan', 'Tersedia', 'Disimpan', 'Dihapus'] as $st)
                                        <button type="button" @click="status = '{{ $st }}'"
                                            :class="status === '{{ $st }}'
                                                ? 'ring-2 ring-emerald-500 bg-emerald-50 border-emerald-200'
                                                : 'border-gray-200 hover:border-gray-300 bg-white'"
                                            class="rounded-xl border p-2.5 text-center text-xs font-semibold transition-all duration-200 cursor-pointer">
                                            {{ $st }}
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

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                {{-- Lokasi --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Lokasi</label>
                                    <input type="text" name="lokasi" x-model="lokasi" maxlength="255"
                                        placeholder="Contoh: Ruang Kantor, Gudang"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('lokasi')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                {{-- Tahun Perolehan --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun Perolehan</label>
                                    <input type="number" name="tahun_perolehan" x-model="tahunPerolehan" min="1900" max="2099" placeholder="Contoh: 2026"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('tahun_perolehan')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Nilai & Foto --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-violet-500 to-purple-600 mr-2"></span>
                                Nilai & Foto
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">

                            {{-- Nilai Perolehan --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nilai Perolehan (Rp)</label>
                                <input type="number" name="nilai_perolehan" x-model="nilaiPerolehan" step="0.01" min="0"
                                    placeholder="0"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('nilai_perolehan')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Foto --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Barang</label>

                                {{-- New file preview --}}
                                <div x-show="filePreview" x-transition class="mb-4">
                                    <div class="relative rounded-xl overflow-hidden border border-gray-200">
                                        <img :src="filePreview" class="w-full h-40 object-contain bg-gray-50">
                                        <button type="button" @click="filePreview = null; fileName = ''; existingFile = ''; $refs.fotoInput.value = ''"
                                            class="absolute top-2 right-2 w-8 h-8 rounded-lg bg-black/50 text-white hover:bg-black/70 flex items-center justify-center transition">
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
                                            <p class="text-sm font-semibold text-emerald-800 truncate">{{ $inventaris->foto ? basename($inventaris->foto) : '-' }}</p>
                                            <p class="text-xs text-emerald-600">File saat ini &middot; Upload baru untuk mengganti</p>
                                        </div>
                                        <a href="{{ asset('storage/' . $inventaris->foto) }}" target="_blank"
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
                                            <p class="text-xs font-medium text-gray-400">Klik untuk upload foto</p>
                                            <p class="text-[10px] text-gray-300 mt-0.5">JPG, JPEG, PNG &middot; Maks. 2MB</p>
                                        </div>
                                        <div x-show="filePreview" class="text-center">
                                            <p class="text-xs font-semibold text-emerald-600">Foto dipilih</p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">Klik untuk mengganti</p>
                                        </div>
                                    </div>
                                    <input x-ref="fotoInput" type="file" name="foto" accept=".jpg,.jpeg,.png" class="hidden" @change="handleFile($event)">
                                </label>
                                @error('foto')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
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
                                    <span class="font-mono text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md">{{ $inventaris->kode_inventaris }}</span>
                                    <span :class="kategoriBadge" class="chip text-[11px]" x-text="kategori"></span>
                                    <span :class="kondisiBadge" class="chip text-[11px]" x-text="kondisi"></span>
                                    <span :class="statusBadge" class="chip text-[11px]" x-text="status"></span>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800 leading-snug" x-text="namaBarang || 'Nama Barang'"></h4>
                                <p class="text-[11px] text-gray-500 font-medium">
                                    Jumlah: <span x-text="jumlah || '0'"></span>
                                </p>
                                <p class="text-[11px] text-gray-500 font-medium" x-text="lokasi || 'Lokasi belum ditentukan'"></p>
                                <div class="flex items-center gap-2 text-[11px] text-gray-400 border-t border-gray-100 pt-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span x-text="formatRupiah(nilaiPerolehan)"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sticky Footer Bar --}}
            <div class="fixed bottom-0 left-0 right-0 lg:static bg-white/90 backdrop-blur-md border-t border-gray-200 lg:border-t-0 lg:bg-transparent lg:backdrop-blur-none px-4 lg:px-0 py-3 lg:py-0">
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.inventaris.show', $inventaris) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Perbarui Barang
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-admin-layout>
