<x-admin-layout title="Edit Laporan Desa" maxWidth="max-w-[1600px]">

    <div x-data="{
        judul: @js(old('judul', $laporan->judul)),
        formatPdf: @js(old('format_pdf', $laporan->format_pdf)),
        sections: @js(collect($laporan->konten_naratif)->map(fn($v, $k) => [
            'key' => $k,
            'judul' => old('konten_naratif.' . $k . '.judul', $v['judul'] ?? ''),
            'teks' => old('konten_naratif.' . $k . '.teks', $v['teks'] ?? ''),
            'data' => $v['data'] ?? [],
        ])->values()->all()),
        openPanels: [],
        togglePanel(idx) {
            this.openPanels.includes(idx)
                ? this.openPanels = this.openPanels.filter(i => i !== idx)
                : this.openPanels.push(idx);
        },
        isDraft: @js($laporan->isDraft()),
        get statusLabel() {
            return this.isDraft ? 'Draft' : 'Finalisasi';
        },
        get statusColor() {
            return this.isDraft ? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300';
        }
    }">

        <form method="POST" action="{{ route('admin.laporan.update', $laporan) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-24 lg:pb-6">

                {{-- LEFT COLUMN: Section Editors --}}
                <div class="lg:col-span-9 space-y-6">

                    {{-- Header Info --}}
                    <div class="widget-card a-fade-up">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                                Informasi Laporan
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                    <span class="font-mono text-xs font-semibold text-gray-700">{{ $laporan->nomor_laporan }}</span>
                                </div>
                                <span class="w-px h-4 bg-gray-200"></span>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                    <span class="text-xs font-medium">{{ $laporan->periode_label }}</span>
                                </div>
                                <span class="w-px h-4 bg-gray-200"></span>
                                <span :class="statusColor" class="chip text-[11px]" x-text="statusLabel"></span>
                            </div>
                            @if (!$laporan->isDraft())
                                <div class="mt-3 flex items-center gap-2 rounded-lg bg-amber-50 border border-amber-200 px-3 py-2">
                                    <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                    <span class="text-xs font-semibold text-amber-700">Laporan ini sudah difinalisasi. Hubungi Kepala Desa untuk mengembalikan ke status draft.</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Judul Laporan --}}
                    <div class="widget-card a-fade-up d1">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-blue-500 to-indigo-600 mr-2"></span>
                                Judul Laporan
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-4">

                            {{-- Judul --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Laporan <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" x-model="judul" required maxlength="255"
                                    placeholder="Masukkan judul laporan"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('judul')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Format PDF --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Format PDF <span class="text-red-500">*</span></label>
                                <select name="format_pdf" x-model="formatPdf" required
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition bg-white">
                                    <option value="surat_resmi">Surat Resmi</option>
                                    <option value="laporan_institusional">Laporan Institusional</option>
                                </select>
                                @error('format_pdf')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section Editors --}}
                    @foreach ($modules as $moduleKey)
                        @php
                            $sectionIdx = $loop->index;
                            $sectionData = $laporan->konten_naratif[$moduleKey] ?? null;
                            $moduleLabel = $moduleLabels[$moduleKey] ?? $moduleKey;
                            $moduleIcon = $moduleIcons[$moduleKey] ?? 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z';
                            $gradientColors = [
                                'emerald' => 'from-emerald-500 to-teal-600',
                                'blue' => 'from-blue-500 to-indigo-600',
                                'violet' => 'from-violet-500 to-purple-600',
                                'amber' => 'from-amber-500 to-orange-600',
                                'rose' => 'from-rose-500 to-pink-600',
                                'cyan' => 'from-cyan-500 to-sky-600',
                                'teal' => 'from-teal-500 to-emerald-600',
                                'slate' => 'from-slate-400 to-slate-600',
                                'lime' => 'from-lime-500 to-green-600',
                            ];
                            $colorKeys = array_keys($gradientColors);
                            $gradient = $gradientColors[$colorKeys[$loop->index % count($colorKeys)]];
                        @endphp

                        <div class="widget-card a-fade-up d{{ min($sectionIdx + 2, 10) }}"
                             x-data="{ open: {{ $sectionIdx < 3 ? 'true' : 'false' }} }">

                            <div class="widget-card-header cursor-pointer select-none" @click="open = !open">
                                <h3 class="section-header mb-0">
                                    <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b {{ $gradient }} mr-2"></span>
                                    {{ $moduleLabel }}
                                </h3>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                </div>
                            </div>

                            <div x-show="open" x-collapse x-cloak>
                                <div class="widget-card-body">
                                    {{-- Hidden input for judul --}}
                                    <input type="hidden" name="konten_naratif[{{ $moduleKey }}][judul]" :value="sections[{{ $sectionIdx }}].judul">

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                                        {{-- LEFT: Narrative Text --}}
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between">
                                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Teks Naratif</label>
                                                <span class="text-[10px] text-gray-400" x-text="(sections[{{ $sectionIdx }}].teks || '').split(/\s+/).filter(w => w).length + ' kata'"></span>
                                            </div>
                                            <textarea
                                                name="konten_naratif[{{ $moduleKey }}][teks]"
                                                x-model="sections[{{ $sectionIdx }}].teks"
                                                rows="8"
                                                required
                                                placeholder="Tuliskan narasi untuk modul {{ $moduleLabel }}..."
                                                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm leading-relaxed focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition resize-y"></textarea>
                                        </div>

                                        {{-- RIGHT: Data Summary --}}
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between">
                                                <label class="text-xs font-bold text-gray-500 uppercase tracking-wide">Ringkasan Data</label>
                                                <button type="button" @click="togglePanel({{ $sectionIdx }})"
                                                    class="text-[10px] text-emerald-600 font-semibold hover:text-emerald-700 lg:hidden">
                                                    <span x-text="openPanels.includes({{ $sectionIdx }}) ? 'Sembunyikan' : 'Tampilkan'"></span>
                                                </button>
                                            </div>

                                            {{-- Desktop: Always visible --}}
                                            <div class="hidden lg:block rounded-xl border border-gray-100 bg-gradient-to-br from-gray-50 to-white p-4">
                                                <div class="space-y-2.5 max-h-80 overflow-y-auto">
                                                    @if (!empty($sectionData['data']))
                                                        @foreach ($sectionData['data'] as $dataKey => $dataValue)
                                                            <div class="flex items-start gap-3 pb-2.5 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                                                <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide whitespace-nowrap min-w-[100px] shrink-0">
                                                                    {{ ucwords(str_replace('_', ' ', $dataKey)) }}
                                                                </span>
                                                                <span class="text-sm text-gray-800 font-medium">
                                                                    @if (is_array($dataValue))
                                                                        {{ json_encode($dataValue) }}
                                                                    @elseif (is_numeric($dataValue) && $dataValue > 1000)
                                                                        {{ number_format($dataValue, 0, ',', '.') }}
                                                                    @else
                                                                        {{ $dataValue ?: '-' }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-xs text-gray-400 italic">Tidak ada data tersedia.</p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Mobile: Collapsible --}}
                                            <div class="lg:hidden rounded-xl border border-gray-100 bg-gradient-to-br from-gray-50 to-white p-4"
                                                 x-show="openPanels.includes({{ $sectionIdx }})" x-collapse x-cloak>
                                                <div class="space-y-2.5">
                                                    @if (!empty($sectionData['data']))
                                                        @foreach ($sectionData['data'] as $dataKey => $dataValue)
                                                            <div class="flex items-start gap-3 pb-2.5 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                                                <span class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide whitespace-nowrap min-w-[100px] shrink-0">
                                                                    {{ ucwords(str_replace('_', ' ', $dataKey)) }}
                                                                </span>
                                                                <span class="text-sm text-gray-800 font-medium">
                                                                    @if (is_array($dataValue))
                                                                        {{ json_encode($dataValue) }}
                                                                    @elseif (is_numeric($dataValue) && $dataValue > 1000)
                                                                        {{ number_format($dataValue, 0, ',', '.') }}
                                                                    @else
                                                                        {{ $dataValue ?: '-' }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-xs text-gray-400 italic">Tidak ada data tersedia.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Hidden input to preserve data --}}
                                    @if (!empty($sectionData['data']))
                                        <input type="hidden"
                                               name="konten_naratif[{{ $moduleKey }}][data]"
                                               value='@json($sectionData['data'], JSON_HEX_APOS | JSON_HEX_AMP)'>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                {{-- RIGHT COLUMN: Sticky Summary --}}
                <div class="lg:col-span-3 space-y-6">

                    {{-- Ringkasan --}}
                    <div class="widget-card lg:sticky lg:top-6 a-fade-up d2">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-violet-500 to-purple-600 mr-2"></span>
                                Ringkasan
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-3">
                            <div class="rounded-xl border border-gray-100 bg-gradient-to-br from-gray-50 to-white p-4 space-y-3">
                                <h4 class="text-sm font-bold text-gray-800 leading-snug" x-text="judul || 'Judul Laporan'"></h4>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span :class="statusColor" class="chip text-[11px]" x-text="statusLabel"></span>
                                    <span class="chip text-[11px] bg-blue-50 text-blue-700">
                                        {{ $laporan->nomor_laporan }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-gray-500 font-medium">{{ $laporan->periode_label }}</p>
                                <div class="pt-2 border-t border-gray-100">
                                    <p class="text-[11px] text-gray-400 mb-1.5">Format PDF</p>
                                    <p class="text-xs font-semibold text-gray-700" x-text="formatPdf === 'laporan_institusional' ? 'Laporan Institusional' : 'Surat Resmi'"></p>
                                </div>
                                <div class="pt-2 border-t border-gray-100">
                                    <p class="text-[11px] text-gray-400 mb-1.5">Modul Aktif</p>
                                    <p class="text-xs font-semibold text-gray-700">{{ count($modules) }} modul</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="widget-card a-fade-up d3">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-gray-400 to-gray-500 mr-2"></span>
                                Informasi
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-3">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Dibuat: {{ $laporan->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                                <span>Diupdate: {{ $laporan->updated_at->locale('id')->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                <span>Penulis: {{ $laporan->creator->name }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                <span>Tipe: {{ ucfirst(str_replace('_', ' ', $laporan->tipe_periode)) }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Sticky Footer Bar --}}
            <div class="fixed bottom-0 left-0 right-0 lg:static bg-white/90 backdrop-blur-md border-t border-gray-200 lg:border-t-0 lg:bg-transparent lg:backdrop-blur-none px-4 lg:px-0 py-3 lg:py-0">
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.laporan.show', $laporan) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                        Kembali
                    </a>
                    <a href="{{ route('admin.laporan.pdf', $laporan) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        Preview PDF
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('v');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

            document.querySelectorAll('.a-fade-up').forEach(el => observer.observe(el));
        });
    </script>
    @endpush

</x-admin-layout>
