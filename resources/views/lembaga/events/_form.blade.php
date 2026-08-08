<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bento-card p-6">
            <div class="section-header"><h3>Informasi Event</h3><div class="shimmer-line"></div></div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Event <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $event?->judul) }}" required maxlength="200"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Event <span class="text-red-500">*</span></label>
                    <select name="jenis" required
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                        @foreach(['musrenbangdes' => 'Musrenbangdes', 'rapat' => 'Rapat', 'kegiatan' => 'Kegiatan', 'sosialisasi' => 'Sosialisasi'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('jenis', $event?->jenis) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="status" required
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                        @foreach(['akan_datang' => 'Akan Datang', 'berlangsung' => 'Berlangsung', 'selesai' => 'Selesai'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $event?->status ?? 'akan_datang') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $event?->tanggal?->format('Y-m-d')) }}" required
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Waktu Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $event?->waktu_mulai?->format('H:i')) }}" required
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', $event?->waktu_selesai?->format('H:i')) }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tempat</label>
                    <input type="text" name="tempat" value="{{ old('tempat', $event?->tempat) }}" maxlength="200"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="6" placeholder="Deskripsi singkat kegiatan..."
                              class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm leading-relaxed focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">{{ old('deskripsi', $event?->deskripsi) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bento-card p-6">
            <div class="section-header"><h3>Status Publikasi</h3><div class="shimmer-line"></div></div>
            <div class="flex items-start gap-3 rounded-xl bg-brand-50 border border-brand-100 p-4">
                <svg class="w-5 h-5 text-brand-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                <div>
                    <p class="text-sm font-semibold text-brand-800">Langsung tampil</p>
                    <p class="text-xs text-brand-700/70 mt-1">Event langsung tampil setelah disimpan dan tercatat untuk laporan kinerja.</p>
                </div>
            </div>
        </div>

        <div class="bento-card p-6">
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('lembaga.events.index') }}" class="btn-ghost">Batal</a>
                <button type="submit" class="btn-primary">{{ isset($event) ? 'Perbarui Event' : 'Simpan Event' }}</button>
            </div>
        </div>
    </div>
</div>
