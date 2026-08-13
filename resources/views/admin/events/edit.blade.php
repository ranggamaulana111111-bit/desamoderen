<x-admin-layout title="Edit Event" maxWidth="max-w-[1200px]">

    <div x-data="{
        judul: '{{ old('judul', $event->judul) }}',
        deskripsi: '{{ old('deskripsi', $event->deskripsi) }}',
        jenis: '{{ old('jenis', $event->jenis) }}',
        status: '{{ old('status', $event->status) }}',
        tanggal: '{{ old('tanggal', $event->tanggal->format('Y-m-d')) }}',
        waktuMulai: '{{ old('waktu_mulai', \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i')) }}',
        waktuSelesai: '{{ old('waktu_selesai', $event->waktu_selesai ? \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') : '') }}',
        tempat: '{{ old('tempat', $event->tempat) }}',
        rtTarget: '{{ old('rt_target', $event->rt_target) }}',
        rwTarget: '{{ old('rw_target', $event->rw_target) }}',
        get statusLabel() {
            return { 'akan_datang': 'Akan Datang', 'berlangsung': 'Berlangsung', 'selesai': 'Selesai' }[this.status] || 'Akan Datang';
        },
        get statusColor() {
            return { 'akan_datang': 'bg-teal-100 text-teal-700', 'berlangsung': 'bg-emerald-100 text-emerald-700', 'selesai': 'bg-gray-100 text-gray-600' }[this.status] || 'bg-teal-100 text-teal-700';
        },
        get jenisLabel() {
            return { 'musrenbangdes': 'Musrenbangdes', 'rapat': 'Rapat', 'kegiatan': 'Kegiatan', 'sosialisasi': 'Sosialisasi' }[this.jenis] || 'Musrenbangdes';
        },
        get jenisColor() {
            return { 'musrenbangdes': 'bg-purple-100 text-purple-700', 'rapat': 'bg-green-100 text-green-700', 'kegiatan': 'bg-teal-100 text-teal-700', 'sosialisasi': 'bg-amber-100 text-amber-700' }[this.jenis] || 'bg-purple-100 text-purple-700';
        },
        get formattedTanggal() {
            if (!this.tanggal) return 'Pilih tanggal';
            const d = new Date(this.tanggal + 'T00:00:00');
            return d.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        },
        get formattedWaktu() {
            if (!this.waktuMulai) return 'Pilih waktu';
            let s = this.waktuMulai;
            if (this.waktuSelesai) s += ' - ' + this.waktuSelesai;
            return s;
        },
        get targetInfo() {
            if (!this.rtTarget && !this.rwTarget) return 'Semua Warga';
            let parts = [];
            if (this.rtTarget) parts.push('RT ' + this.rtTarget);
            if (this.rwTarget) parts.push('RW ' + this.rwTarget);
            return parts.join(' & ');
        },
        get estimatedParticipants() {
            if (!this.rtTarget && !this.rwTarget) return 'Seluruh warga desa';
            let parts = [];
            if (this.rtTarget) parts.push('RT ' + this.rtTarget);
            if (this.rwTarget) parts.push('RW ' + this.rwTarget);
            return 'Warga di ' + parts.join(', ');
        }
    }">

        <form method="POST" action="{{ route('admin.events.update', $event) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pb-24 lg:pb-6">

                {{-- LEFT COLUMN --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Informasi Event --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-600 mr-2"></span>
                                Informasi Event
                            </h3>
                        </div>
                        <div class="widget-card-body space-y-5">

                            {{-- Judul --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Event</label>
                                <input type="text" name="judul" x-model="judul" required maxlength="200"
                                    placeholder="Masukkan judul event"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                @error('judul')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                                <textarea name="deskripsi" x-model="deskripsi" rows="3"
                                    placeholder="Deskripsi singkat mengenai event ini"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Jenis Event (Segmented Card Selector) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Event</label>
                                <input type="hidden" name="jenis" :value="jenis">
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <button type="button" @click="jenis = 'musrenbangdes'"
                                        :class="jenis === 'musrenbangdes'
                                            ? 'ring-2 ring-emerald-500 bg-emerald-50 border-emerald-200'
                                            : 'border-gray-200 hover:border-gray-300 bg-white'"
                                        class="relative rounded-xl border p-3 text-center transition-all duration-200 cursor-pointer group">
                                        <div class="w-10 h-10 mx-auto rounded-xl flex items-center justify-center transition-all"
                                            :class="jenis === 'musrenbangdes' ? 'bg-purple-100' : 'bg-purple-50 group-hover:bg-purple-100'">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        </div>
                                        <span class="block text-xs font-semibold mt-2"
                                            :class="jenis === 'musrenbangdes' ? 'text-purple-700' : 'text-gray-600'">Musrenbangdes</span>
                                    </button>
                                    <button type="button" @click="jenis = 'rapat'"
                                        :class="jenis === 'rapat'
                                            ? 'ring-2 ring-emerald-500 bg-emerald-50 border-emerald-200'
                                            : 'border-gray-200 hover:border-gray-300 bg-white'"
                                        class="relative rounded-xl border p-3 text-center transition-all duration-200 cursor-pointer group">
                                        <div class="w-10 h-10 mx-auto rounded-xl flex items-center justify-center transition-all"
                                            :class="jenis === 'rapat' ? 'bg-green-100' : 'bg-green-50 group-hover:bg-green-100'">
                                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </div>
                                        <span class="block text-xs font-semibold mt-2"
                                            :class="jenis === 'rapat' ? 'text-green-700' : 'text-gray-600'">Rapat</span>
                                    </button>
                                    <button type="button" @click="jenis = 'kegiatan'"
                                        :class="jenis === 'kegiatan'
                                            ? 'ring-2 ring-emerald-500 bg-emerald-50 border-emerald-200'
                                            : 'border-gray-200 hover:border-gray-300 bg-white'"
                                        class="relative rounded-xl border p-3 text-center transition-all duration-200 cursor-pointer group">
                                        <div class="w-10 h-10 mx-auto rounded-xl flex items-center justify-center transition-all"
                                            :class="jenis === 'kegiatan' ? 'bg-teal-100' : 'bg-teal-50 group-hover:bg-teal-100'">
                                            <svg class="w-5 h-5 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                        </div>
                                        <span class="block text-xs font-semibold mt-2"
                                            :class="jenis === 'kegiatan' ? 'text-teal-700' : 'text-gray-600'">Kegiatan</span>
                                    </button>
                                    <button type="button" @click="jenis = 'sosialisasi'"
                                        :class="jenis === 'sosialisasi'
                                            ? 'ring-2 ring-emerald-500 bg-emerald-50 border-emerald-200'
                                            : 'border-gray-200 hover:border-gray-300 bg-white'"
                                        class="relative rounded-xl border p-3 text-center transition-all duration-200 cursor-pointer group">
                                        <div class="w-10 h-10 mx-auto rounded-xl flex items-center justify-center transition-all"
                                            :class="jenis === 'sosialisasi' ? 'bg-amber-100' : 'bg-amber-50 group-hover:bg-amber-100'">
                                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                        </div>
                                        <span class="block text-xs font-semibold mt-2"
                                            :class="jenis === 'sosialisasi' ? 'text-amber-700' : 'text-gray-600'">Sosialisasi</span>
                                    </button>
                                </div>
                                @error('jenis')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Status (Segmented Button) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <input type="hidden" name="status" :value="status">
                                <div class="inline-flex rounded-xl border border-gray-200 bg-gray-50 p-1 gap-1">
                                    <button type="button" @click="status = 'akan_datang'"
                                        :class="status === 'akan_datang'
                                            ? 'bg-white shadow-sm text-teal-700 ring-1 ring-teal-100'
                                            : 'text-gray-500 hover:text-gray-700'"
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200">
                                        <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                                        Akan Datang
                                    </button>
                                    <button type="button" @click="status = 'berlangsung'"
                                        :class="status === 'berlangsung'
                                            ? 'bg-white shadow-sm text-emerald-700 ring-1 ring-emerald-100'
                                            : 'text-gray-500 hover:text-gray-700'"
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        Berlangsung
                                    </button>
                                    <button type="button" @click="status = 'selesai'"
                                        :class="status === 'selesai'
                                            ? 'bg-white shadow-sm text-gray-700 ring-1 ring-gray-200'
                                            : 'text-gray-500 hover:text-gray-700'"
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-200">
                                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
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

                    {{-- Jadwal --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-teal-500 to-cyan-600 mr-2"></span>
                                Jadwal
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal</label>
                                    <input type="date" name="tanggal" x-model="tanggal" required
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('tanggal')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tempat</label>
                                    <input type="text" name="tempat" x-model="tempat" maxlength="200"
                                        placeholder="Contoh: Balai Desa"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('tempat')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Waktu Mulai</label>
                                    <input type="time" name="waktu_mulai" x-model="waktuMulai" required
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('waktu_mulai')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Waktu Selesai</label>
                                    <input type="time" name="waktu_selesai" x-model="waktuSelesai"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('waktu_selesai')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Target Peserta --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-amber-500 to-orange-600 mr-2"></span>
                                Filter Target Peserta
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">RT</label>
                                    <input type="text" name="rt_target" x-model="rtTarget" maxlength="3" placeholder="Kosongkan untuk Semua Warga"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('rt_target')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">RW</label>
                                    <input type="text" name="rw_target" x-model="rwTarget" maxlength="3" placeholder="Kosongkan untuk Semua Warga"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                                    @error('rw_target')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/><text x="10" y="13.5" text-anchor="middle" fill="white" font-size="11" font-weight="bold">!</text></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- Preview Event --}}
                    <div class="widget-card lg:sticky lg:top-6">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-teal-500 to-cyan-600 mr-2"></span>
                                Preview Event
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <div class="rounded-xl border border-gray-100 bg-gradient-to-br from-gray-50 to-white p-4 space-y-3">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span :class="jenisColor" class="chip text-[11px]" x-text="jenisLabel"></span>
                                    <span :class="statusColor" class="chip text-[11px]" x-text="statusLabel"></span>
                                </div>
                                <h4 class="text-sm font-bold text-gray-800 leading-snug"
                                    x-text="judul || 'Judul Event'"></h4>
                                <div class="space-y-2 text-xs text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span x-text="formattedTanggal"></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span x-text="formattedWaktu"></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span x-text="tempat || 'Lokasi belum ditentukan'"></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span x-text="targetInfo"></span>
                                    </div>
                                </div>
                                <p x-show="deskripsi" x-text="deskripsi" class="text-xs text-gray-500 border-t border-gray-100 pt-3 mt-3 leading-relaxed"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Ringkasan --}}
                    <div class="widget-card">
                        <div class="widget-card-header">
                            <h3 class="section-header">
                                <span class="inline-block w-1 h-5 rounded-full bg-gradient-to-b from-violet-500 to-purple-600 mr-2"></span>
                                Ringkasan
                            </h3>
                        </div>
                        <div class="widget-card-body">
                            <div class="flex items-center gap-3 rounded-xl bg-violet-50 p-3">
                                <div class="w-9 h-9 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[11px] font-medium text-violet-600 uppercase tracking-wide">Target Peserta</p>
                                    <p class="text-sm font-bold text-gray-800" x-text="estimatedParticipants"></p>
                                </div>
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
                                    <span>Pastikan jadwal tidak bentrok dengan event lain</span>
                                </li>
                                <li class="flex items-start gap-2.5 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-teal-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Pastikan lokasi dan waktu sudah benar</span>
                                </li>
                                <li class="flex items-start gap-2.5 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-teal-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Undangan akan dikirim otomatis ke peserta</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sticky Footer Bar --}}
            <div class="fixed bottom-0 left-0 right-0 lg:static bg-white/90 backdrop-blur-md border-t border-gray-200 lg:border-t-0 lg:bg-transparent lg:backdrop-blur-none px-4 lg:px-0 py-3 lg:py-0">
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.events.index') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-600 to-teal-500 text-white text-sm font-semibold shadow-lg shadow-brand-500/25 hover:shadow-brand-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-admin-layout>
