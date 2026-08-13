<x-admin-layout :title="$mode === 'create' ? 'Tambah Template Surat' : 'Edit Template Surat'">
    @php
        $systemPlaceholders = collect([
            'nama_desa' => 'Nama Desa',
            'nama_kecamatan' => 'Nama Kecamatan',
            'nama_kabupaten' => 'Nama Kabupaten',
            'alamat_kantor' => 'Alamat Kantor Desa',
            'nama_kades' => 'Nama Kepala Desa',
            'jabatan_kades' => 'Jabatan Kepala Desa',
            'nip_kades' => 'NIP Kepala Desa',
            'nama_sekdes' => 'Nama Sekretaris Desa',
            'nip_sekdes' => 'NIP Sekretaris Desa',
            'kecamatan' => 'Alias Kecamatan',
            'kabupaten' => 'Alias Kabupaten',
            'jenis_kelamin_label' => 'Jenis Kelamin (label)',
            'status_janda_label' => 'Status Janda/Duda',
            'jenis_akta_label' => 'Jenis Akta (label)',
        ])->map(fn ($label, $key) => [
            'key' => $key,
            'label' => $label,
            'value' => in_array($key, ['jenis_kelamin_label', 'status_janda_label', 'jenis_akta_label'])
                ? ['jenis_kelamin_label' => 'Perempuan', 'status_janda_label' => 'Janda', 'jenis_akta_label' => 'Akta Kelahiran'][$key]
                : (config('village.'.$key) ?? ''),
        ])->values()->all();
    @endphp
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Header --}}
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('admin.letter-config.index') }}" class="hover:text-emerald-600 transition">Template Surat</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-600 font-medium">{{ $mode === 'create' ? 'Tambah Baru' : 'Edit' }}</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $mode === 'create' ? 'Tambah Template Surat' : 'Edit: ' . $template->label }}</h1>
        </div>

        <form x-data="letterConfigForm()" x-init="init()" method="POST"
              action="{{ $mode === 'create' ? route('admin.letter-config.store') : route('admin.letter-config.update', $template) }}"
              class="space-y-6">
            @csrf
            @if ($mode === 'edit')
                @method('PUT')
            @endif

            <input type="hidden" name="fields_json" :value="JSON.stringify(fields)">

            {{-- ═══ INFO DASAR ═══ --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-teal-50/50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-900">Informasi Dasar</h2>
                            <p class="text-xs text-gray-500">Identitas dan pengaturan template surat</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Surat <span class="text-red-500">*</span></label>
                        <input type="text" name="jenis_surat" value="{{ old('jenis_surat', $template->jenis_surat ?? '') }}" required
                               placeholder="contoh: sktm, sku, domisili"
                               class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis_surat') border-red-300 @enderror"
                               {{ $mode === 'edit' ? 'readonly class="w-full rounded-xl border border-gray-200 px-3.5 py-2.5 text-sm bg-gray-50 text-gray-500 cursor-not-allowed"' : '' }}>
                        <p class="text-[11px] text-gray-400 mt-1">Identifier unik (huruf, angka, dash). {{ $mode === 'edit' ? 'Tidak bisa diubah.' : '' }}</p>
                        @error('jenis_surat')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Label <span class="text-red-500">*</span></label>
                        <input type="text" name="label" value="{{ old('label', $template->label ?? '') }}" required
                               placeholder="contoh: Surat Keterangan Tidak Mampu (SKTM)"
                               class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('label') border-red-300 @enderror">
                        @error('label')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Klasifikasi <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_klasifikasi" value="{{ old('kode_klasifikasi', $template->kode_klasifikasi ?? '') }}" required
                               placeholder="contoh: 460, 471"
                               class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kode_klasifikasi') border-red-300 @enderror">
                        @error('kode_klasifikasi')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Masa Berlaku (bulan) <span class="text-red-500">*</span></label>
                        <input type="number" name="masa_berlaku_bulan" value="{{ old('masa_berlaku_bulan', $template->masa_berlaku_bulan ?? 3) }}" required min="0" max="255"
                               class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masa_berlaku_bulan') border-red-300 @enderror">
                        <p class="text-[11px] text-gray-400 mt-1">0 = tidak kadaluarsa</p>
                        @error('masa_berlaku_bulan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition w-fit">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ ($template->is_active ?? true) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <div>
                                <p class="text-sm font-medium text-gray-800">Aktif</p>
                                <p class="text-xs text-gray-500">Template ini tersedia untuk warga</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- ═══ BODY TEMPLATE ═══ --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-50/50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-900">Isi Surat (Body Template)</h2>
                            <p class="text-xs text-gray-500">Tulis kalimat surat & sisipkan <code class="bg-gray-100 px-1 rounded text-purple-600">{nama_field}</code> sebagai data warga. Preview menampilkan hasil dengan contoh data.</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                        {{-- Editor --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">Penulis Template</label>
                            <div class="relative border border-gray-300 rounded-xl overflow-hidden bg-white">
                                <div x-ref="bodyHl" aria-hidden="true"
                                     class="absolute inset-0 overflow-hidden pointer-events-none p-4 font-mono text-[13px] leading-relaxed whitespace-pre-wrap text-gray-800"
                                     x-html="highlightedBody"></div>
                                <textarea name="body_template" rows="12" x-model="bodyTemplate" x-ref="bodyTa" @scroll="syncScroll()"
                                          placeholder="Yth. Kepala Desa Kumpay,&#10;&#10;Dengan ini menerangkan bahwa atas nama:&#10;&#10;Nama : {nama_lengkap}&#10;NIK : {nik}&#10;Alamat : {alamat_lengkap}&#10;&#10;Adalah benar warga Desa Kumpay yang berdomisili di alamat tersebut.&#10;&#10;Surat keterangan ini dibuat untuk keperluan: {keperluan}"
                                          class="relative w-full resize-y bg-transparent p-4 font-mono text-[13px] leading-relaxed whitespace-pre-wrap focus:outline-none rounded-xl"
                                          style="color: transparent; caret-color: #059669;"></textarea>
                            </div>
                            @error('body_template')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

                            {{-- Warnings --}}
                            <div class="mt-3 space-y-2">
                                <div x-show="unknownPlaceholders.length > 0" class="flex items-start gap-2.5 p-3 rounded-xl bg-red-50 border border-red-200">
                                    <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                    <div>
                                        <p class="text-xs font-semibold text-red-700">Placeholder tidak dikenal</p>
                                        <p class="text-[11px] text-red-600 mt-0.5"><span class="font-mono" x-text="unknownPlaceholdersText"></span> — tidak cocok dengan field atau pengaturan desa. Periksa ejaan atau klik tombol placeholder di bawah.</p>
                                    </div>
                                </div>
                                <div x-show="unusedFields.length > 0" class="flex items-start gap-2.5 p-3 rounded-xl bg-amber-50 border border-amber-200">
                                    <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                                    <div>
                                        <p class="text-xs font-semibold text-amber-700">Field belum dipakai</p>
                                        <p class="text-[11px] text-amber-600 mt-0.5"><span class="font-mono" x-text="unusedFieldsText"></span> — field terdefinisi tapi belum muncul di isi surat.</p>
                                    </div>
                                </div>
                                <div x-show="unknownPlaceholders.length === 0 && unusedFields.length === 0 && bodyTemplate.trim() !== ''" class="flex items-center gap-2 p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-[11px] text-emerald-700">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Semua placeholder valid.
                                </div>
                            </div>
                        </div>

                        {{-- Live preview --}}
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Preview Hasil Surat</label>
                                <span class="inline-flex items-center gap-1 text-[10px] text-gray-400">
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span> contoh data
                                </span>
                            </div>
                            <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 h-full min-h-[300px]">
                                <div class="bg-white rounded-lg border border-gray-200 shadow-sm px-5 py-4 text-sm leading-relaxed text-gray-800" x-html="previewBody"></div>
                                <p class="text-[10px] text-gray-400 mt-2">Placeholder diisi otomatis dengan contoh data. Tanda <span class="text-red-500 font-semibold">merah</span> berarti placeholder belum dikenali.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Placeholder reference --}}
                    <div class="mt-4 p-3 rounded-xl bg-gray-50 border border-gray-200">
                        <div class="flex items-center gap-2 mb-2.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/></svg>
                            <span class="text-xs font-semibold text-gray-700">Placeholder</span>
                            <span class="text-[10px] text-gray-400">— klik untuk menyisipkan di posisi kursor</span>
                        </div>
                        <div x-show="fields.length > 0" class="mb-3">
                            <p class="text-[10px] font-semibold text-purple-500 tracking-wide mb-1.5">FIELD FORMULIR (diisi warga)</p>
                            <div class="flex flex-wrap gap-1.5">
                                <template x-for="(f, i) in fields" :key="'ph-'+i">
                                    <button type="button" @click="insertPlaceholder(f.key)"
                                            :title="(f.label || f.key) + ' (tipe: ' + f.type + ')'"
                                            class="group inline-flex items-center gap-1.5 text-[11px] font-mono bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200/70 px-2 py-1 rounded-lg transition">
                                        <span x-text="'{'+f.key+'}'"></span>
                                        <span class="text-purple-300">|</span>
                                        <span class="font-sans text-[10px] text-purple-500 group-hover:text-purple-600" x-text="f.label || f.key"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-semibold text-teal-500 tracking-wide mb-1.5">DARI PENGATURAN DESA / SISTEM</p>
                            <div class="flex flex-wrap gap-1.5">
                                <template x-for="(s, i) in systemPlaceholders" :key="'sys-'+i">
                                    <button type="button" @click="insertPlaceholder(s.key)"
                                            :title="s.label + (s.value ? ' → ' + s.value : '')"
                                            class="group inline-flex items-center gap-1.5 text-[11px] font-mono bg-teal-50 text-teal-700 hover:bg-teal-100 border border-teal-200/70 px-2 py-1 rounded-lg transition">
                                        <span x-text="'{'+s.key+'}'"></span>
                                        <span class="text-teal-300">|</span>
                                        <span class="font-sans text-[10px] text-teal-500 group-hover:text-teal-600" x-text="s.label"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ FIELD DEFINITIONS ═══ --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50/50 to-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-semibold text-gray-900">Field Formulir</h2>
                                <p class="text-xs text-gray-500">Definisikan field yang diisi warga saat pengajuan</p>
                            </div>
                        </div>
                        <button type="button" @click="addField()" class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            Tambah Field
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    {{-- Empty state --}}
                    <div x-show="fields.length === 0" class="text-center py-8 border-2 border-dashed border-gray-200 rounded-xl">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <p class="text-sm text-gray-400">Belum ada field. Klik "Tambah Field" untuk menambahkan.</p>
                    </div>

                    {{-- Field list --}}
                    <div class="space-y-3">
                        <template x-for="(field, index) in fields" :key="'field-'+index">
                            <div class="border border-gray-200 rounded-xl p-4 bg-gray-50/50 hover:bg-white transition">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold text-gray-400">#<span x-text="index + 1"></span></span>
                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="moveField(index, -1)" :disabled="index === 0"
                                                class="text-gray-400 hover:text-gray-600 disabled:opacity-30 disabled:cursor-not-allowed transition" title="Geser naik">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
                                        </button>
                                        <button type="button" @click="moveField(index, 1)" :disabled="index === fields.length - 1"
                                                class="text-gray-400 hover:text-gray-600 disabled:opacity-30 disabled:cursor-not-allowed transition" title="Geser bawah">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                        </button>
                                        <button type="button" @click="removeField(index)"
                                                class="text-red-400 hover:text-red-600 transition" title="Hapus field">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-medium text-gray-500 mb-1">Key (snake_case) <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="field.key" required placeholder="nama_lengkap"
                                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-mono">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-medium text-gray-500 mb-1">Label <span class="text-red-500">*</span></label>
                                        <input type="text" x-model="field.label" required placeholder="Nama Lengkap"
                                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-medium text-gray-500 mb-1">Tipe <span class="text-red-500">*</span></label>
                                        <select x-model="field.type"
                                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                            <option value="text">Text</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="number">Number</option>
                                            <option value="date">Date</option>
                                            <option value="time">Time</option>
                                            <option value="select">Select</option>
                                        </select>
                                    </div>
                                    <div class="flex items-end gap-3">
                                        <label class="flex items-center gap-2 cursor-pointer pb-2">
                                            <input type="checkbox" x-model="field.required"
                                                   class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                            <span class="text-[11px] font-medium text-gray-600">Wajib</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3">
                                    <div>
                                        <label class="block text-[11px] font-medium text-gray-500 mb-1">Validasi (rules)</label>
                                        <input type="text" x-model="field.rules" placeholder="string|max:100"
                                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-mono text-[12px]">
                                    </div>
                                    <div x-show="field.type === 'select'">
                                        <label class="block text-[11px] font-medium text-gray-500 mb-1">Opsi (koma pemisah)</label>
                                        <input type="text" x-model="field.options" placeholder="Laki-laki,Perempuan"
                                               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pb-8">
                <a href="{{ route('admin.letter-config.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm px-6 py-2.5 rounded-xl transition shadow-sm hover:shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                    {{ $mode === 'create' ? 'Simpan Template' : 'Perbarui Template' }}
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function letterConfigForm() {
            return {
                fields: @json($template->fields ?? []),
                systemPlaceholders: @js($systemPlaceholders),
                bodyTemplate: @js(old('body_template', $template->body_template ?? '')),

                init() {
                    if (!Array.isArray(this.fields)) this.fields = [];
                    this.$watch('bodyTemplate', () => this.$nextTick(() => this.syncScroll()));
                },

                get knownKeys() {
                    const keys = (this.fields || []).map(f => f.key).filter(Boolean);
                    (this.systemPlaceholders || []).forEach(s => keys.push(s.key));
                    return keys;
                },

                get highlightedBody() {
                    return this.escapeHtml(this.bodyTemplate || '')
                        .replace(/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/g, (m, key) => {
                            const known = this.knownKeys.includes(key);
                            const cls = known
                                ? 'inline-block bg-purple-100 text-purple-700 rounded px-0.5'
                                : 'inline-block bg-red-100 text-red-600 rounded px-0.5';
                            return `<span class="${cls}">${m}</span>`;
                        });
                },

                get previewBody() {
                    const text = this.bodyTemplate || '';
                    if (!text.trim()) {
                        return '<p class="text-gray-400 italic">Template masih kosong. Mulailah menulis di kolom kiri.</p>';
                    }
                    const replaced = this.escapeHtml(text)
                        .replace(/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/g, (m, key) => {
                            if (this.knownKeys.includes(key)) {
                                return this.escapeHtml(this.sampleValue(key));
                            }
                            return `<span class="bg-red-100 text-red-600 rounded px-0.5 font-medium">${m}?</span>`;
                        });
                    return replaced.split(/\n{2,}/)
                        .map(p => `<p class="mb-3 whitespace-pre-wrap">${p}</p>`)
                        .join('');
                },

                get unknownPlaceholders() {
                    const used = [];
                    const re = /\{([a-zA-Z_][a-zA-Z0-9_]*)\}/g;
                    let m;
                    while ((m = re.exec(this.bodyTemplate || ''))) used.push(m[1]);
                    return [...new Set(used)].filter(k => !this.knownKeys.includes(k));
                },

                get unknownPlaceholdersText() {
                    return this.unknownPlaceholders.map(k => '{' + k + '}').join(', ');
                },

                get unusedFields() {
                    const body = this.bodyTemplate || '';
                    return (this.fields || []).filter(f => f.key && !body.includes('{' + f.key + '}'));
                },

                get unusedFieldsText() {
                    return this.unusedFields.map(f => '{' + f.key + '}').join(', ');
                },

                escapeHtml(str) {
                    return String(str).replace(/[&<>"']/g, c => ({
                        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
                    }[c]));
                },

                sampleValue(key) {
                    const field = (this.fields || []).find(f => f.key === key);
                    if (!field) {
                        const sys = (this.systemPlaceholders || []).find(s => s.key === key);
                        return (sys && sys.value) ? sys.value : key;
                    }
                    const lower = key.toLowerCase();
                    if (lower === 'nama_lengkap') return 'Budi Santoso';
                    if (lower === 'nik') return '3273xxxxxxxxxxxx';
                    if (lower === 'tempat_lahir') return 'Bandung';
                    if (lower === 'tgl_lahir') return '1 Januari 1990';
                    if (lower.includes('tanggal') || lower.startsWith('tgl_')) return '13 Agustus 2026';
                    if (lower.includes('tahun')) return '2020';
                    if (lower.includes('penghasilan')) return '2.500.000';
                    if (lower === 'anak_ke') return '1';
                    if (lower === 'rt' || lower === 'rw') return '02';
                    if (lower.includes('nama')) return 'Nama Contoh';
                    if (lower.includes('alamat')) return 'Kp. Kumpay RT 02 RW 01, Desa Kumpay';
                    if (lower.includes('pekerjaan')) return 'Petani';
                    if (lower.includes('keperluan') || lower.includes('alasan')) return 'Keperluan administrasi';
                    if (lower.includes('agama')) return 'Islam';
                    if (lower.includes('kewarganegaraan')) return 'WNI';
                    if (lower.includes('perkawinan')) return 'Belum Kawin';
                    if (lower.includes('jenis_kelamin')) return 'Laki-laki';
                    if (lower.includes('jenis_akta')) return 'kelahiran';
                    switch (field.type) {
                        case 'number': return '123456';
                        case 'date': return '13 Agustus 2026';
                        case 'time': return '09:00 WIB';
                        case 'select': {
                            const opts = (field.options || '').split(',').map(s => s.trim()).filter(Boolean);
                            return opts[0] || 'Pilihan';
                        }
                        case 'textarea': return 'Contoh isian teks\nuntuk menggambarkan kalimat yang lebih panjang di dalam surat.';
                        default: return 'Contoh nilai';
                    }
                },

                addField() {
                    this.fields.push({
                        key: '',
                        label: '',
                        type: 'text',
                        required: false,
                        rules: 'string|max:255',
                        options: '',
                    });
                },

                removeField(index) {
                    this.fields.splice(index, 1);
                },

                moveField(index, direction) {
                    const newIndex = index + direction;
                    if (newIndex < 0 || newIndex >= this.fields.length) return;
                    const item = this.fields.splice(index, 1)[0];
                    this.fields.splice(newIndex, 0, item);
                },

                insertPlaceholder(key) {
                    if (!key) return;
                    const ta = this.$refs.bodyTa;
                    if (!ta) return;
                    const pos = ta.selectionStart;
                    const text = ta.value;
                    this.bodyTemplate = text.substring(0, pos) + '{' + key + '}' + text.substring(pos);
                    this.$nextTick(() => {
                        ta.focus();
                        ta.setSelectionRange(pos + key.length + 2, pos + key.length + 2);
                    });
                },

                syncScroll() {
                    const ta = this.$refs.bodyTa;
                    const hl = this.$refs.bodyHl;
                    if (ta && hl) {
                        hl.scrollTop = ta.scrollTop;
                        hl.scrollLeft = ta.scrollLeft;
                    }
                },
            }
        }
    </script>
    @endpush
</x-admin-layout>
