<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bento-card p-6">
            <div class="section-header"><h3>Konten Berita</h3><div class="shimmer-line"></div></div>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $berita?->judul) }}" required
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Isi Berita <span class="text-red-500">*</span></label>
                    <textarea name="konten" rows="14" required
                              class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm leading-relaxed focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">{{ old('konten', $berita?->konten) }}</textarea>
                    <p class="text-xs text-slate-400 mt-1.5">Format sederhana didukung: gunakan baris kosong untuk paragraf baru.</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Foto Berita</label>
                    <input type="file" name="foto" accept="image/*"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition">
                    @if($berita?->foto)
                        <div class="mt-3 flex items-center gap-3">
                            <img src="{{ asset('storage/'.$berita->foto) }}" class="w-20 h-14 rounded-xl object-cover ring-1 ring-slate-100" alt="">
                            <span class="text-xs text-slate-400">Foto saat ini — unggah file baru untuk mengganti.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bento-card p-6">
            <div class="section-header"><h3>Status Publikasi</h3><div class="shimmer-line"></div></div>
            <div class="space-y-3">
                <label class="flex items-center gap-3 rounded-xl border border-slate-200 p-4 cursor-pointer hover:border-brand-300 transition {{ old('status', $berita?->status ?? 'publish') === 'publish' ? 'ring-2 ring-brand-500/30 border-brand-400' : '' }}">
                    <input type="radio" name="status" value="publish" class="accent-brand-600" @checked(old('status', $berita?->status ?? 'publish') === 'publish')>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">Publikasikan langsung</p>
                        <p class="text-xs text-slate-400 mt-0.5">Berita langsung tampil di website desa dan tercatat untuk laporan kinerja.</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 rounded-xl border border-slate-200 p-4 cursor-pointer hover:border-slate-300 transition {{ old('status', $berita?->status ?? 'publish') === 'draft' ? 'ring-2 ring-brand-500/30 border-brand-400' : '' }}">
                    <input type="radio" name="status" value="draft" class="accent-brand-600" @checked(old('status', $berita?->status ?? 'publish') === 'draft')>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">Simpan sebagai draf</p>
                        <p class="text-xs text-slate-400 mt-0.5">Belum terlihat publik. Anda bisa publikasikan dari menu Berita Saya nanti.</p>
                    </div>
                </label>
            </div>
        </div>

        <div class="bento-card p-6">
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('lembaga.berita.index') }}" class="btn-ghost">Batal</a>
                <button type="submit" class="btn-primary">{{ isset($berita) ? 'Perbarui Berita' : 'Simpan Berita' }}</button>
            </div>
        </div>
    </div>
</div>
