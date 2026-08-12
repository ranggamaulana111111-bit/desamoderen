<x-admin-layout :title="$mode === 'create' ? 'Tambah Template Surat' : 'Edit Template Surat'">
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
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50/50 to-white">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
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
                            <p class="text-xs text-gray-500">Gunakan <code class="bg-gray-100 px-1 rounded">{nama_field}</code> sebagai placeholder</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <textarea name="body_template" rows="12"
                              placeholder="Yth. Kepala Desa Kumpay,&#10;&#10;Dengan ini menerangkan bahwa atas nama:&#10;&#10;Nama : {nama_lengkap}&#10;NIK : {nik}&#10;Alamat : {alamat_lengkap}&#10;&#10;Adalah benar warga Desa Kumpay yang berdomisili di alamat tersebut.&#10;&#10;Surat keterangan ini dibuat untuk keperluan: {keperluan}"
                              class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm font-mono leading-relaxed focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('body_template') border-red-300 @enderror">{{ old('body_template', $template->body_template ?? '') }}</textarea>
                    @error('body_template')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror

                    {{-- Placeholder help --}}
                    <div x-show="fields.length > 0" class="mt-3 flex flex-wrap gap-1.5">
                        <span class="text-[10px] text-gray-400 mr-1">Available:</span>
                        <template x-for="(f, i) in fields" :key="'ph-'+i">
                            <button type="button" @click="insertPlaceholder(f.key)"
                                    class="text-[10px] font-mono bg-purple-50 text-purple-600 hover:bg-purple-100 px-1.5 py-0.5 rounded transition cursor-pointer" x-text="'{'+f.key+'}'"></button>
                        </template>
                    </div>
                    <div class="mt-3 p-3 rounded-xl bg-gray-50 border border-gray-200">
                        <span class="text-[10px] text-gray-400 mr-1">Dari Pengaturan Desa:</span>
                        <div class="flex flex-wrap gap-1.5 mt-1.5">
                            @foreach ([
                                'nama_desa' => 'Nama Desa',
                                'nama_kecamatan' => 'Nama Kecamatan',
                                'nama_kabupaten' => 'Nama Kabupaten',
                                'kecamatan' => 'Alias Kecamatan',
                                'kabupaten' => 'Alias Kabupaten',
                                'jabatan_kades' => 'Jabatan Kepala Desa',
                                'nama_kades' => 'Nama Kepala Desa',
                                'nip_kades' => 'NIP Kepala Desa',
                                'jenis_kelamin_label' => 'JK (label)',
                                'status_janda_label' => 'Status Janda/Duda',
                                'jenis_akta_label' => 'Akta (label)',
                            ] as $key => $label)
                                <button type="button" @click="insertPlaceholder('{{ $key }}')"
                                        title="{{ $label }}"
                                        class="text-[10px] font-mono bg-blue-50 text-blue-600 hover:bg-blue-100 px-1.5 py-0.5 rounded transition cursor-pointer">{'{{ $key }}'}</button>
                            @endforeach
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

                init() {
                    if (!Array.isArray(this.fields)) this.fields = [];
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
                    const ta = document.querySelector('textarea[name="body_template"]');
                    const pos = ta.selectionStart;
                    const text = ta.value;
                    ta.value = text.substring(0, pos) + '{' + key + '}' + text.substring(pos);
                    ta.focus();
                    ta.setSelectionRange(pos + key.length + 2, pos + key.length + 2);
                },
            }
        }
    </script>
    @endpush
</x-admin-layout>
