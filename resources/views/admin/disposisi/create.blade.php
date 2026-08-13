<x-admin-layout title="Buat Disposisi Baru" maxWidth="max-w-[1200px]">
    <form method="POST" action="{{ route('admin.disposisi.store') }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-24 lg:pb-6">

            {{-- LEFT COLUMN --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- Informasi Disposisi --}}
                <div class="widget-card">
                    <div class="widget-card-header">
                        <h3 class="section-header">
                            <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                            Informasi Disposisi
                        </h3>
                    </div>
                    <div class="widget-card-body space-y-5">

                        {{-- Surat Masuk --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Surat Masuk</label>
                            <select name="surat_masuk_id" required
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                <option value="">Pilih Surat Masuk</option>
                                @foreach ($suratMasuks as $sm)
                                    <option value="{{ $sm->id }}" {{ old('surat_masuk_id') == $sm->id ? 'selected' : '' }}>
                                        {{ $sm->pengirim }} &mdash; {{ $sm->perihal }}
                                    </option>
                                @endforeach
                            </select>
                            @error('surat_masuk_id')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Tujuan Disposisi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tujuan Disposisi</label>
                            <select name="tujuan_disposisi" required
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                <option value="">Pilih Tujuan</option>
                                @foreach ($tujuanUsers as $user)
                                    <option value="{{ $user->id }}" {{ old('tujuan_disposisi') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tujuan_disposisi')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Isi Disposisi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Isi Disposisi</label>
                            <textarea name="isi_disposisi" rows="4" required
                                placeholder="Tuliskan isi disposisi..."
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">{{ old('isi_disposisi') }}</textarea>
                            @error('isi_disposisi')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Sifat & Deadline --}}
                <div class="widget-card">
                    <div class="widget-card-header">
                        <h3 class="section-header">
                            <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-amber-500 to-orange-600 mr-2"></span>
                            Sifat & Deadline
                        </h3>
                    </div>
                    <div class="widget-card-body space-y-5">

                        {{-- Sifat Disposisi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Sifat Disposisi</label>
                            <input type="hidden" name="sifat_disposisi" value="{{ old('sifat_disposisi', 'Biasa') }}">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" x-data="{ sifat: '{{ old('sifat_disposisi', 'Biasa') }}' }">
                                <template x-for="item in ['Biasa', 'Segera', 'Rahasia', 'Penting']" :key="item">
                                    <button type="button" @click="sifat = item; $el.closest('[x-data]').querySelector('input[name=sifat_disposisi]').value = item"
                                        :class="sifat === item
                                            ? 'ring-2 ring-emerald-500 bg-emerald-50 border-emerald-200'
                                            : 'border-gray-200 hover:border-gray-300 bg-white'"
                                        class="relative rounded-xl border p-3 text-center transition-all duration-200 cursor-pointer group">
                                        <div class="w-10 h-10 mx-auto rounded-xl flex items-center justify-center transition-all"
                                            :class="{
                                                'bg-gray-100': item === 'Biasa' && sifat !== item,
                                                'bg-gray-200': item === 'Biasa' && sifat === item,
                                                'bg-red-100': item === 'Segera' && sifat !== item,
                                                'bg-red-200': item === 'Segera' && sifat === item,
                                                'bg-purple-100': item === 'Rahasia' && sifat !== item,
                                                'bg-purple-200': item === 'Rahasia' && sifat === item,
                                                'bg-amber-100': item === 'Penting' && sifat !== item,
                                                'bg-amber-200': item === 'Penting' && sifat === item,
                                            }">
                                            <svg class="w-5 h-5" :class="{
                                                'text-gray-500': item === 'Biasa',
                                                'text-red-600': item === 'Segera',
                                                'text-purple-600': item === 'Rahasia',
                                                'text-amber-600': item === 'Penting',
                                            }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" x-show="item === 'Segera'"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" x-show="item === 'Rahasia'"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" x-show="item === 'Penting'"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" x-show="item === 'Biasa'"/>
                                            </svg>
                                        </div>
                                        <span class="block text-xs font-semibold mt-2"
                                            :class="sifat === item ? 'text-emerald-700' : 'text-gray-600'" x-text="item"></span>
                                    </button>
                                </template>
                            </div>
                            @error('sifat_disposisi')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Deadline --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deadline</label>
                            <input type="datetime-local" name="deadline" value="{{ old('deadline') }}" required
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                            @error('deadline')
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

                {{-- Status --}}
                <div class="widget-card lg:sticky lg:top-6">
                    <div class="widget-card-header">
                        <h3 class="section-header">
                            <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-teal-500 to-cyan-600 mr-2"></span>
                            Status
                        </h3>
                    </div>
                    <div class="widget-card-body">
                        <div x-data="{ status: '{{ old('status', 'Diteruskan') }}' }">
                            <input type="hidden" name="status" :value="status">
                            <div class="space-y-2">
                                <button type="button" @click="status = 'Diteruskan'"
                                    :class="status === 'Diteruskan'
                                        ? 'bg-emerald-50 border-emerald-300 text-emerald-700 ring-2 ring-emerald-500/20'
                                        : 'bg-white border-gray-200 text-gray-500 hover:border-gray-300'"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border text-sm font-semibold transition-all duration-200 text-left">
                                    <span class="w-2.5 h-2.5 rounded-full bg-gray-400 shrink-0"></span>
                                    Diteruskan
                                </button>
                                <button type="button" @click="status = 'Diproses'"
                                    :class="status === 'Diproses'
                                        ? 'bg-teal-50 border-teal-300 text-teal-700 ring-2 ring-teal-500/20'
                                        : 'bg-white border-gray-200 text-gray-500 hover:border-gray-300'"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border text-sm font-semibold transition-all duration-200 text-left">
                                    <span class="w-2.5 h-2.5 rounded-full bg-teal-500 shrink-0"></span>
                                    Diproses
                                </button>
                                <button type="button" @click="status = 'Selesai'"
                                    :class="status === 'Selesai'
                                        ? 'bg-emerald-50 border-emerald-300 text-emerald-700 ring-2 ring-emerald-500/20'
                                        : 'bg-white border-gray-200 text-gray-500 hover:border-gray-300'"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border text-sm font-semibold transition-all duration-200 text-left">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    Selesai
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
                                <span>Pilih surat masuk yang sesuai untuk didisposisikan</span>
                            </li>
                            <li class="flex items-start gap-2.5 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-teal-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Tentukan deadline yang realistis untuk tindak lanjut</span>
                            </li>
                            <li class="flex items-start gap-2.5 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-teal-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Isi disposisi harus jelas dan terukur</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sticky Footer Bar --}}
        <div class="fixed bottom-0 left-0 right-0 lg:static bg-white/90 backdrop-blur-md border-t border-gray-200 lg:border-t-0 lg:bg-transparent lg:backdrop-blur-none px-4 lg:px-0 py-3 lg:py-0">
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.disposisi.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Simpan Disposisi
                </button>
            </div>
        </div>
    </form>
</x-admin-layout>
