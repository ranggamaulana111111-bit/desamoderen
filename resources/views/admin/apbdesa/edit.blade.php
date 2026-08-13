<x-admin-layout title="Edit APBDesa" maxWidth="max-w-[1200px]">

    <div x-data="{
        tahun: '{{ old('tahun', $apbdesa->tahun) }}',
        kategori: '{{ old('kategori', $apbdesa->kategori) }}',
        bidang: '{{ old('bidang', addslashes($apbdesa->bidang)) }}',
        uraian: '{{ old('uraian', addslashes($apbdesa->uraian)) }}',
        anggaran: {{ old('anggaran', $apbdesa->anggaran) }},
        realisasi: {{ old('realisasi', $apbdesa->realisasi) }},
        sumberDana: '{{ old('sumber_dana', addslashes($apbdesa->sumber_dana ?? '')) }}',
        keterangan: '{{ addslashes(old('keterangan', $apbdesa->keterangan ?? '')) }}',
        status: '{{ old('status', $apbdesa->status) }}',
        get sisa() { return this.anggaran - this.realisasi; },
        get formattedAnggaran() { return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(this.anggaran); },
        get formattedRealisasi() { return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(this.realisasi); },
        get formattedSisa() { return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(this.sisa); },
        get kategoriBadge() { return this.kategori === 'Pendapatan' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'; },
        get statusBadge() {
            return {
                'Draft': 'bg-gray-100 text-gray-700',
                'Direvisi': 'bg-amber-100 text-amber-700',
                'Disetujui': 'bg-emerald-100 text-emerald-700',
                'Ditolak': 'bg-red-100 text-red-700',
            }[this.status] || 'bg-gray-100 text-gray-700';
        }
    }">

        <form method="POST" action="{{ route('admin.apbdesa.update', $apbdesa) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-24 lg:pb-6">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Data Anggaran --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                                Data Anggaran
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">

                            {{-- Tahun --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun <span class="text-red-500">*</span></label>
                                <input type="number" name="tahun" x-model="tahun" required min="2000" max="2099" step="1"
                                    placeholder="Contoh: 2026"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('tahun')
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
                                <div class="inline-flex rounded-xl border border-gray-200 bg-gray-50 p-1 gap-1">
                                    @foreach (['Pendapatan', 'Belanja'] as $kat)
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

                            {{-- Bidang --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bidang <span class="text-red-500">*</span></label>
                                <input type="text" name="bidang" x-model="bidang" required maxlength="255"
                                    placeholder="Contoh: Pendapatan Asli Desa"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('bidang')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Uraian --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Uraian <span class="text-red-500">*</span></label>
                                <input type="text" name="uraian" x-model="uraian" required maxlength="500"
                                    placeholder="Uraian item anggaran"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('uraian')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Detail Keuangan --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-teal-500 to-cyan-600 mr-2"></span>
                                Detail Keuangan
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Anggaran <span class="text-red-500">*</span></label>
                                    <input type="number" name="anggaran" x-model.number="anggaran" required step="0.01" min="0"
                                        placeholder="0"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('anggaran')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Realisasi</label>
                                    <input type="number" name="realisasi" x-model.number="realisasi" step="0.01" min="0"
                                        placeholder="0"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('realisasi')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Sumber Dana --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sumber Dana</label>
                                <input type="text" name="sumber_dana" x-model="sumberDana" maxlength="255"
                                    placeholder="Sumber dana (opsional)"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('sumber_dana')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Status & Keterangan --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-amber-500 to-orange-600 mr-2"></span>
                                Status & Keterangan
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">

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

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                                <input type="hidden" name="status" :value="status">
                                <div class="inline-flex rounded-xl border border-gray-200 bg-gray-50 p-1 gap-1">
                                    @foreach (['Draft', 'Direvisi'] as $st)
                                        <button type="button" @click="status = '{{ $st }}'"
                                            :class="status === '{{ $st }}'
                                                ? 'bg-white shadow-sm text-emerald-700 ring-1 ring-emerald-100'
                                                : 'text-gray-500 hover:text-gray-700'"
                                            class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold transition-all duration-200">
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
                                    <span class="font-mono text-[10px] font-semibold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md" x-text="tahun || 'Tahun'"></span>
                                    <span :class="kategoriBadge" class="chip text-[11px]" x-text="kategori"></span>
                                    <span :class="statusBadge" class="chip text-[11px]" x-text="status"></span>
                                </div>
                                <p class="text-[11px] text-gray-500 font-medium" x-text="bidang || 'Bidang'"></p>
                                <h4 class="text-sm font-bold text-gray-800 leading-snug truncate" x-text="uraian || 'Uraian item anggaran'"></h4>
                                <div class="space-y-1.5 pt-2 border-t border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] text-gray-400">Anggaran</span>
                                        <span class="text-xs font-bold text-gray-800" x-text="formattedAnggaran"></span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] text-gray-400">Realisasi</span>
                                        <span class="text-xs font-semibold text-teal-600" x-text="formattedRealisasi"></span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-[11px] text-gray-400">Sisa</span>
                                        <span class="text-xs font-semibold" :class="sisa >= 0 ? 'text-emerald-600' : 'text-red-600'" x-text="formattedSisa"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sticky Footer Bar --}}
            <div class="fixed bottom-0 left-0 right-0 lg:static bg-white/90 backdrop-blur-md border-t border-gray-200 lg:border-t-0 lg:bg-transparent lg:backdrop-blur-none px-4 lg:px-0 py-3 lg:py-0">
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.apbdesa.show', $apbdesa) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Perbarui Data
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-admin-layout>
