<x-admin-layout title="Buat Laporan Desa Baru" maxWidth="max-w-[1440px]">

    <div x-data="laporanCreate({{ json_encode($modules) }}, {{ json_encode($moduleLabels) }}, {{ json_encode($moduleIcons) }})">

        <form method="POST" action="{{ route('admin.laporan.store') }}" x-ref="mainForm" @submit.prevent="submitForm()">
            @csrf

            {{-- Page Header --}}
            <div class="mb-6 a-fade-up">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <a href="{{ route('admin.laporan.index') }}"
                                class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:border-gray-300 transition-all duration-200 shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                            </a>
                            <h1 class="text-xl font-bold text-gray-900">Buat Laporan Desa Baru</h1>
                        </div>
                        <p class="text-sm text-gray-500 ml-12">Susun laporan periodik desa dengan data otomatis dari seluruh modul</p>
                    </div>
                </div>
            </div>

            {{-- Step Indicator --}}
            <div class="mb-8 a-fade-up d1">
                <div class="widget-card">
                    <div class="widget-card-body !py-5">
                        <div class="flex items-center justify-between max-w-2xl mx-auto">
                            @foreach(['Informasi Laporan', 'Pilih Modul', 'Preview & Simpan'] as $i => $label)
                                @php $step = $i + 1; @endphp
                                <div class="flex items-center {{ $step < 3 ? 'flex-1' : '' }}">
                                    <button type="button" @click="goToStep({{ $step }})"
                                        :class="step === currentStep
                                            ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/25 border-emerald-500'
                                            : step < currentStep
                                                ? 'bg-emerald-500 text-white border-emerald-500'
                                                : 'bg-white text-gray-400 border-gray-200'"
                                        class="w-10 h-10 rounded-full border-2 flex items-center justify-center text-sm font-bold transition-all duration-300 flex-shrink-0">
                                        <template x-if="step < currentStep">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </template>
                                        <template x-if="step >= currentStep">
                                            <span x-text="{{ $step }}"></span>
                                        </template>
                                    </button>
                                    <div class="ml-3 {{ $step < 3 ? 'flex-1' : '' }}">
                                        <p class="text-xs font-semibold transition-colors duration-200"
                                            :class="step === currentStep ? 'text-emerald-600' : step < currentStep ? 'text-emerald-500' : 'text-gray-400'">
                                            {{ $label }}
                                        </p>
                                        @if($step < 3)
                                            <div class="mt-2 h-1 rounded-full overflow-hidden bg-gray-100">
                                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 transition-all duration-700 ease-out"
                                                    :style="{ width: step < currentStep ? '100%' : '0%' }"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 1: Informasi Laporan --}}
            <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <div class="lg:col-span-8 space-y-6">

                        {{-- Identitas Laporan --}}
                        <div class="widget-card a-fade-up">
                            <div class="widget-card-header">
                                <h3 class="section-header">
                                    <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                                    Identitas Laporan
                                </h3>
                            </div>
                            <div class="widget-card-body space-y-5">

                                {{-- Judul --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Laporan <span class="text-red-500">*</span></label>
                                    <input type="text" name="judul" x-model="form.judul" required maxlength="255"
                                        placeholder="Contoh: Laporan Kegiatan Desa Bulan Januari 2026"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('judul')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Tipe Periode --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Periode <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="tipe_periode" :value="form.tipe_periode">
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                        @foreach(['bulanan' => 'Bulanan', 'kuartal' => 'Kuartal', 'tahunan' => 'Tahunan', 'khusus' => 'Khusus'] as $val => $lbl)
                                            <button type="button" @click="form.tipe_periode = '{{ $val }}'"
                                                :class="form.tipe_periode === '{{ $val }}'
                                                    ? 'bg-emerald-50 text-emerald-700 border-emerald-300 ring-1 ring-emerald-200 shadow-sm'
                                                    : 'bg-white text-gray-500 border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                                class="flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl border text-xs font-semibold transition-all duration-200">
                                                @if($val === 'bulanan')
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                                @elseif($val === 'kuartal')
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                                                @elseif($val === 'tahunan')
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                                                @endif
                                                {{ $lbl }}
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('tipe_periode')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Periode Dates --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Periode Mulai <span class="text-red-500">*</span></label>
                                        <input type="date" name="periode_mulai" x-model="form.periode_mulai" required
                                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                        @error('periode_mulai')
                                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Periode Akhir <span class="text-red-500">*</span></label>
                                        <input type="date" name="periode_akhir" x-model="form.periode_akhir" required
                                            :min="form.periode_mulai"
                                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                        @error('periode_akhir')
                                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Format PDF --}}
                        <div class="widget-card a-fade-up d2">
                            <div class="widget-card-header">
                                <h3 class="section-header">
                                    <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-blue-500 to-indigo-600 mr-2"></span>
                                    Format Dokumen
                                </h3>
                            </div>
                            <div class="widget-card-body">
                                <input type="hidden" name="format_pdf" :value="form.format_pdf">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    {{-- Surat Resmi --}}
                                    <button type="button" @click="form.format_pdf = 'surat_resmi'"
                                        :class="form.format_pdf === 'surat_resmi'
                                            ? 'bg-emerald-50 border-emerald-300 ring-1 ring-emerald-200 shadow-sm'
                                            : 'bg-white border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                        class="relative flex items-start gap-3 p-4 rounded-xl border text-left transition-all duration-200">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 transition-colors duration-200"
                                            :class="form.format_pdf === 'surat_resmi' ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-400'">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">Surat Resmi</p>
                                            <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Format surat dinas dengan kop, nomor surat, dan tanda tangan resmi</p>
                                        </div>
                                        <div class="absolute top-3 right-3">
                                            <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-all duration-200"
                                                :class="form.format_pdf === 'surat_resmi' ? 'border-emerald-500 bg-emerald-500' : 'border-gray-300'">
                                                <div class="w-1.5 h-1.5 rounded-full bg-white" x-show="form.format_pdf === 'surat_resmi'"></div>
                                            </div>
                                        </div>
                                    </button>

                                    {{-- Laporan Institusional --}}
                                    <button type="button" @click="form.format_pdf = 'laporan_institusional'"
                                        :class="form.format_pdf === 'laporan_institusional'
                                            ? 'bg-emerald-50 border-emerald-300 ring-1 ring-emerald-200 shadow-sm'
                                            : 'bg-white border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                                        class="relative flex items-start gap-3 p-4 rounded-xl border text-left transition-all duration-200">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 transition-colors duration-200"
                                            :class="form.format_pdf === 'laporan_institusional' ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-400'">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">Laporan Institusional</p>
                                            <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Format laporan resmi institusi dengan cover, daftar isi, dan lampiran</p>
                                        </div>
                                        <div class="absolute top-3 right-3">
                                            <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-all duration-200"
                                                :class="form.format_pdf === 'laporan_institusional' ? 'border-emerald-500 bg-emerald-500' : 'border-gray-300'">
                                                <div class="w-1.5 h-1.5 rounded-full bg-white" x-show="form.format_pdf === 'laporan_institusional'"></div>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                                @error('format_pdf')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Right sidebar --}}
                    <div class="lg:col-span-4 space-y-6">
                        <div class="widget-card lg:sticky lg:top-6 a-fade-up d3">
                            <div class="widget-card-header">
                                <h3 class="section-header">
                                    <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-teal-500 to-cyan-600 mr-2"></span>
                                    Ringkasan
                                </h3>
                            </div>
                            <div class="widget-card-body">
                                <div class="rounded-xl border border-gray-100 bg-gradient-to-br from-gray-50 to-white p-4 space-y-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>
                                        </span>
                                        <span class="text-xs font-semibold text-gray-600">Judul</span>
                                    </div>
                                    <p class="text-sm font-bold text-gray-800 leading-snug min-h-[2rem]" x-text="form.judul || 'Belum diisi'"></p>

                                    <div class="h-px bg-gray-100"></div>

                                    <div class="space-y-2.5">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-gray-500">Tipe</span>
                                            <span class="text-xs font-semibold text-gray-700 capitalize" x-text="form.tipe_periode"></span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-gray-500">Mulai</span>
                                            <span class="text-xs font-semibold text-gray-700" x-text="form.periode_mulai || '-'"></span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-gray-500">Akhir</span>
                                            <span class="text-xs font-semibold text-gray-700" x-text="form.periode_akhir || '-'"></span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-gray-500">Format</span>
                                            <span class="text-xs font-semibold text-gray-700" x-text="form.format_pdf === 'surat_resmi' ? 'Surat Resmi' : 'Laporan Institusional'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 2: Pilih Modul --}}
            <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                <div class="space-y-6">
                    <div class="widget-card a-fade-up">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                                Modul Laporan
                            </h3>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-gray-500" x-text="selectedModules.length + ' dari ' + allModules.length + ' modul dipilih'"></span>
                                <button type="button" @click="toggleAllModules()" class="btn-ghost !text-[11px] !px-2.5 !py-1">
                                    <span x-text="selectedModules.length === allModules.length ? 'Batal Semua' : 'Pilih Semua'"></span>
                                </button>
                            </div>
                        </div>
                        <div class="widget-card-body">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                <template x-for="(mod, idx) in allModules" :key="mod">
                                    <button type="button" @click="toggleModule(mod)"
                                        :class="isSelected(mod)
                                            ? 'bg-emerald-50 border-emerald-300 ring-1 ring-emerald-100'
                                            : 'bg-white border-gray-200 hover:border-gray-300 hover:bg-gray-50/50'"
                                        class="relative flex items-center gap-3.5 p-4 rounded-xl border text-left transition-all duration-200 group"
                                        :style="{ transitionDelay: (idx * 30) + 'ms' }">

                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors duration-200"
                                            :class="isSelected(mod) ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-100 text-gray-400 group-hover:bg-gray-200'">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" :d="moduleIcons[mod]"/>
                                            </svg>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold transition-colors duration-200"
                                                :class="isSelected(mod) ? 'text-emerald-700' : 'text-gray-700'" x-text="moduleLabels[mod]"></p>
                                            <p class="text-[11px] mt-0.5" :class="isSelected(mod) ? 'text-emerald-500' : 'text-gray-400'"
                                                x-text="isSelected(mod) ? 'Terpilih' : 'Klik untuk memilih'"></p>
                                        </div>

                                        <div class="absolute top-3 right-3">
                                            <div class="w-5 h-5 rounded-md border-2 flex items-center justify-center transition-all duration-200"
                                                :class="isSelected(mod) ? 'border-emerald-500 bg-emerald-500' : 'border-gray-300'">
                                                <svg x-show="isSelected(mod)" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </button>
                                </template>
                            </div>
                            @error('modul_yang_dipilih')
                                <p class="text-red-500 text-xs mt-3 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 3: Preview & Simpan --}}
            <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    {{-- Left: Module Narrative Sections --}}
                    <div class="lg:col-span-8 space-y-6">

                        {{-- Fetch Button --}}
                        <div x-show="!previewData && !loading" class="widget-card a-fade-up">
                            <div class="widget-card-body">
                                <div class="flex flex-col items-center justify-center py-10 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-800 mb-1.5">Generate Narasi Otomatis</h3>
                                    <p class="text-xs text-gray-500 max-w-md mb-5 leading-relaxed">Sistem akan mengambil data dari modul yang dipilih dan menghasilkan teks narasi untuk setiap bagian laporan</p>
                                    <button type="button" @click="fetchPreview()"
                                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                                        Generate Narasi
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Loading State --}}
                        <div x-show="loading" class="widget-card a-fade-up">
                            <div class="widget-card-body">
                                <div class="flex flex-col items-center justify-center py-12 text-center">
                                    <div class="relative mb-5">
                                        <div class="w-14 h-14 rounded-full border-4 border-emerald-100 border-t-emerald-500 animate-spin"></div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                        </div>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-700 mb-1">Memproses Data...</h3>
                                    <p class="text-xs text-gray-500">Mengambil data dari server dan menyusun narasi</p>
                                </div>
                            </div>
                        </div>

                        {{-- Generated Narratives --}}
                        <template x-if="previewData && !loading">
                            <div class="space-y-4">
                                <template x-for="(mod, idx) in selectedModules" :key="mod">
                                    <div class="widget-card" :style="{ transitionDelay: (idx * 60) + 'ms' }">
                                        <div class="widget-card-header">
                                            <h3 class="section-header">
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-lg text-[10px] font-bold bg-emerald-50 text-emerald-600 mr-2"
                                                    x-text="idx + 1"></span>
                                                <span x-text="moduleLabels[mod]"></span>
                                            </h3>
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-100 text-gray-400">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" :d="moduleIcons[mod]"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="widget-card-body space-y-3">
                                            {{-- Judul Section --}}
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Judul Bagian</label>
                                                <input type="text"
                                                    :name="'konten_naratif[' + mod + '][judul]'"
                                                    :value="previewData[mod]?.judul || moduleLabels[mod]"
                                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                            </div>
                                            {{-- Teks Section --}}
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Narasi</label>
                                                <textarea
                                                    :name="'konten_naratif[' + mod + '][teks]'"
                                                    rows="5"
                                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm text-gray-700 leading-relaxed focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition resize-y"
                                                    x-text="previewData[mod]?.teks || ''"></textarea>
                                            </div>
                                            {{-- Stats Preview --}}
                                            <template x-if="previewData[mod]?.data">
                                                <div class="rounded-lg bg-gray-50 border border-gray-100 p-3">
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Data Mentah</p>
                                                    <pre class="text-[11px] text-gray-500 font-mono leading-relaxed whitespace-pre-wrap max-h-32 overflow-y-auto"
                                                        x-text="JSON.stringify(previewData[mod].data, null, 2)"></pre>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    {{-- Right: Submit Panel --}}
                    <div class="lg:col-span-4 space-y-6">
                        <div class="widget-card lg:sticky lg:top-6 a-fade-up d2">
                            <div class="widget-card-header">
                                <h3 class="section-header">
                                    <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-violet-500 to-purple-600 mr-2"></span>
                                    Aksi
                                </h3>
                            </div>
                            <div class="widget-card-body space-y-4">
                                {{-- Summary --}}
                                <div class="rounded-xl border border-gray-100 bg-gradient-to-br from-gray-50 to-white p-4 space-y-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500">Judul</span>
                                        <span class="text-xs font-semibold text-gray-700 text-right max-w-[180px] truncate" x-text="form.judul || '-'"></span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500">Periode</span>
                                        <span class="text-xs font-semibold text-gray-700" x-text="(form.periode_mulai || '-') + ' s/d ' + (form.periode_akhir || '-')"></span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500">Modul</span>
                                        <span class="text-xs font-semibold text-gray-700" x-text="selectedModules.length + ' modul'"></span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500">Format</span>
                                        <span class="text-xs font-semibold text-gray-700" x-text="form.format_pdf === 'surat_resmi' ? 'Surat Resmi' : 'Laporan Institusional'"></span>
                                    </div>
                                    <template x-if="previewData">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-emerald-600 font-semibold">Status</span>
                                            <span class="badge-status bg-completed !text-[10px]">Siap Disimpan</span>
                                        </div>
                                    </template>
                                </div>

                                {{-- Actions --}}
                                <div class="space-y-2.5">
                                    <button type="submit"
                                        :disabled="loading && !previewData"
                                        :class="(loading && !previewData) ? 'opacity-50 cursor-not-allowed' : ''"
                                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        Simpan Laporan
                                    </button>
                                    <a href="{{ route('admin.laporan.index') }}"
                                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Batal
                                    </a>
                                </div>

                                {{-- Tips --}}
                                <div class="rounded-xl bg-blue-50 border border-blue-100 p-3.5 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                                        <p class="text-xs font-semibold text-blue-700">Tips</p>
                                    </div>
                                    <ul class="space-y-1.5 text-[11px] text-blue-600 leading-relaxed">
                                        <li class="flex items-start gap-1.5">
                                            <span class="text-blue-400 mt-0.5">-</span>
                                            <span>Narasi yang dihasilkan bisa diedit sebelum disimpan</span>
                                        </li>
                                        <li class="flex items-start gap-1.5">
                                            <span class="text-blue-400 mt-0.5">-</span>
                                            <span>Laporan tersimpan sebagai draf dan bisa difinalisasi kemudian</span>
                                        </li>
                                        <li class="flex items-start gap-1.5">
                                            <span class="text-blue-400 mt-0.5">-</span>
                                            <span>PDF akan dihasilkan berdasarkan format yang dipilih</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hidden inputs for submission --}}
            <template x-for="mod in selectedModules" :key="'hidden-' + mod">
                <input type="hidden" name="modul_yang_dipilih[]" :value="mod">
            </template>

            {{-- Sticky Navigation Footer --}}
            <div class="fixed bottom-0 left-0 right-0 lg:static bg-white/90 backdrop-blur-md border-t border-gray-200 lg:border-t-0 lg:bg-transparent lg:backdrop-blur-none px-4 lg:px-0 py-3 lg:py-0 mt-6">
                <div class="flex items-center justify-between">
                    <button type="button" x-show="currentStep > 1" @click="prevStep()"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        Kembali
                    </button>
                    <div x-show="currentStep === 1"></div>
                    <button type="button" x-show="currentStep < 3" @click="nextStep()"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                        Selanjutnya
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function laporanCreate(modules, moduleLabels, moduleIcons) {
            return {
                currentStep: 1,
                allModules: modules,
                moduleLabels: moduleLabels,
                moduleIcons: moduleIcons,
                selectedModules: modules.filter(m => m !== 'kesimpulan'),
                previewData: null,
                loading: false,
                form: {
                    judul: '{{ old('judul') }}',
                    tipe_periode: '{{ old('tipe_periode', 'bulanan') }}',
                    periode_mulai: '{{ old('periode_mulai') }}',
                    periode_akhir: '{{ old('periode_akhir') }}',
                    format_pdf: '{{ old('format_pdf', 'surat_resmi') }}',
                },

                isSelected(mod) {
                    return this.selectedModules.includes(mod);
                },

                toggleModule(mod) {
                    if (this.selectedModules.includes(mod)) {
                        this.selectedModules = this.selectedModules.filter(m => m !== mod);
                    } else {
                        this.selectedModules.push(mod);
                    }
                    this.previewData = null;
                },

                toggleAllModules() {
                    if (this.selectedModules.length === this.allModules.length) {
                        this.selectedModules = [];
                    } else {
                        this.selectedModules = [...this.allModules];
                    }
                    this.previewData = null;
                },

                goToStep(step) {
                    if (step < this.currentStep) {
                        this.currentStep = step;
                    }
                },

                nextStep() {
                    if (this.currentStep === 1) {
                        if (!this.form.judul || !this.form.periode_mulai || !this.form.periode_akhir) return;
                    }
                    if (this.currentStep < 3) {
                        this.currentStep++;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },

                prevStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },

                async fetchPreview() {
                    if (this.selectedModules.length === 0) return;

                    this.loading = true;
                    this.previewData = null;

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                        const resp = await fetch('{{ route('admin.laporan.preview') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({
                                modul_yang_dipilih: this.selectedModules,
                                periode_mulai: this.form.periode_mulai,
                                periode_akhir: this.form.periode_akhir,
                            }),
                        });

                        if (!resp.ok) {
                            throw new Error('Gagal mengambil data preview');
                        }

                        const data = await resp.json();
                        this.previewData = data;
                    } catch (err) {
                        console.error('Preview error:', err);
                        alert('Terjadi kesalahan saat mengambil data preview. Silakan coba lagi.');
                    } finally {
                        this.loading = false;
                    }
                },

                submitForm() {
                    this.$refs.mainForm.submit();
                },
            };
        }

        document.addEventListener('DOMContentLoaded', function () {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('v');
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

            document.querySelectorAll('.a-fade-up,.a-fade-in,.a-scale').forEach(function (el) {
                observer.observe(el);
            });
        });
    </script>
    @endpush

</x-admin-layout>
