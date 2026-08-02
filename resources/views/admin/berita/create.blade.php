<x-admin-layout title="Tambah Berita" maxWidth="max-w-[1200px]">

    <div x-data="{
        judul: '{{ old('judul') }}',
        konten: '{{ addslashes(old('konten')) }}',
        status: '{{ old('status', 'draft') }}',
        fotoPreview: null,
        get statusLabel() {
            return this.status === 'publish' ? 'Publish' : 'Draft';
        },
        get statusColor() {
            return this.status === 'publish' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600';
        },
        get wordCount() {
            return this.konten ? this.konten.trim().split(/\s+/).filter(w => w).length : 0;
        },
        get charCount() {
            return this.konten ? this.konten.length : 0;
        },
        previewFoto(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (ev) => { this.fotoPreview = ev.target.result; };
                reader.readAsDataURL(file);
            } else {
                this.fotoPreview = null;
            }
        }
    }">

        <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-24 lg:pb-6">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Konten --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                                Konten Berita
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">

                            {{-- Judul --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Berita</label>
                                <input type="text" name="judul" x-model="judul" required maxlength="255"
                                    placeholder="Masukkan judul berita"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('judul')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Konten --}}
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-sm font-semibold text-gray-700">Konten</label>
                                    <div class="flex items-center gap-3 text-[10px] font-medium text-gray-400">
                                        <span x-text="wordCount + ' kata'"></span>
                                        <span class="text-gray-300">|</span>
                                        <span x-text="charCount + ' karakter'"></span>
                                    </div>
                                </div>
                                <textarea name="konten" x-model="konten" rows="12" required
                                    placeholder="Tulis konten berita di sini..."
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm leading-relaxed focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition resize-y">{{ old('konten') }}</textarea>
                                @error('konten')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-blue-500 to-indigo-600 mr-2"></span>
                                Foto Berita
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            {{-- Preview --}}
                            <div x-show="fotoPreview" x-transition class="mb-4">
                                <div class="relative rounded-xl overflow-hidden border border-gray-200">
                                    <img :src="fotoPreview" class="w-full h-48 object-cover">
                                    <button type="button" @click="fotoPreview = null; $refs.fotoInput.value = ''"
                                        class="absolute top-2 right-2 w-8 h-8 rounded-lg bg-black/50 text-white hover:bg-black/70 flex items-center justify-center transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Upload --}}
                            <label class="block">
                                <div class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-emerald-300 hover:bg-emerald-50/30 transition-all"
                                    :class="fotoPreview ? 'border-emerald-200 bg-emerald-50/20' : ''">
                                    <div x-show="!fotoPreview">
                                        <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z"/></svg>
                                        <p class="text-xs font-medium text-gray-400">Klik untuk upload foto</p>
                                        <p class="text-[10px] text-gray-300 mt-0.5">Maks. 2MB, format gambar</p>
                                    </div>
                                    <div x-show="fotoPreview" class="text-center">
                                        <p class="text-xs font-semibold text-emerald-600">Foto dipilih</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">Klik untuk mengganti</p>
                                    </div>
                                </div>
                                <input x-ref="fotoInput" type="file" name="foto" accept="image/*" class="hidden" @change="previewFoto($event)">
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
                                <div x-show="fotoPreview" x-transition>
                                    <img :src="fotoPreview" class="w-full h-32 object-cover rounded-lg mb-3">
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span :class="statusColor" class="chip text-[11px]" x-text="statusLabel"></span>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800 leading-snug" x-text="judul || 'Judul Berita'"></h4>
                                <p x-show="konten" class="text-xs text-gray-500 leading-relaxed line-clamp-4" x-text="konten"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-violet-500 to-purple-600 mr-2"></span>
                                Status Publikasi
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <input type="hidden" name="status" :value="status">
                            <div class="inline-flex rounded-xl border border-gray-200 bg-gray-50 p-1 gap-1 w-full">
                                <button type="button" @click="status = 'draft'"
                                    :class="status === 'draft'
                                        ? 'bg-white shadow-sm text-gray-700 ring-1 ring-gray-200'
                                        : 'text-gray-500 hover:text-gray-700'"
                                    class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-200">
                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                    Draft
                                </button>
                                <button type="button" @click="status = 'publish'"
                                    :class="status === 'publish'
                                        ? 'bg-white shadow-sm text-emerald-700 ring-1 ring-emerald-100'
                                        : 'text-gray-500 hover:text-gray-700'"
                                    class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-200">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Publish
                                </button>
                            </div>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Tips --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-sky-500 to-blue-600 mr-2"></span>
                                Tips
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <ul class="space-y-3">
                                <li class="flex items-start gap-2.5 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Gunakan judul yang menarik dan jelas</span>
                                </li>
                                <li class="flex items-start gap-2.5 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Foto berita meningkatkan engagement pembaca</span>
                                </li>
                                <li class="flex items-start gap-2.5 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-blue-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Draft hanya terlihat oleh admin, Publish akan tampil di halaman publik</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sticky Footer Bar --}}
            <div class="fixed bottom-0 left-0 right-0 lg:static bg-white/90 backdrop-blur-md border-t border-gray-200 lg:border-t-0 lg:bg-transparent lg:backdrop-blur-none px-4 lg:px-0 py-3 lg:py-0">
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.berita.index') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Simpan Berita
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-admin-layout>
