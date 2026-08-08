<div class="grid lg:grid-cols-3 gap-6">
    {{-- Form fields --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bento-card p-6">
            <div class="section-header"><h3>Identitas Lembaga</h3><div class="shimmer-line"></div></div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lembaga <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $lembaga?->nama) }}" required
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Singkatan</label>
                    <input type="text" name="singkatan" value="{{ old('singkatan', $lembaga?->singkatan) }}" placeholder="cth. KarTar"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Lembaga <span class="text-red-500">*</span></label>
                    <select name="jenis" required
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                        @foreach(\App\Models\Lembaga::jenisOptions() as $value => $label)
                            <option value="{{ $value }}" @selected(old('jenis', $lembaga?->jenis) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" placeholder="Deskripsi singkat tentang lembaga..."
                              class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">{{ old('deskripsi', $lembaga?->deskripsi) }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Ketua</label>
                    <input type="text" name="ketua" value="{{ old('ketua', $lembaga?->ketua) }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $lembaga?->no_hp) }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $lembaga?->email) }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $lembaga?->alamat) }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status</label>
                    <select name="status"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                        <option value="aktif" @selected(old('status', $lembaga?->status ?? 'aktif') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status', $lembaga?->status ?? 'aktif') === 'nonaktif')>Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Logo / Foto</label>
                    <input type="file" name="foto" accept="image/*"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition">
                    @if(isset($lembaga) && $lembaga?->foto)
                        <p class="text-xs text-slate-400 mt-2">Foto saat ini: <a href="{{ asset('storage/'.$lembaga->foto) }}" target="_blank" class="text-brand-600 underline">lihat</a></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="bento-card p-6">
            <div class="section-header"><h3>Akun Login Pengurus</h3><div class="shimmer-line"></div></div>
            <p class="text-xs text-slate-500 mb-4">Akun ini digunakan pengurus lembaga untuk login dan mengunggah berita/event.</p>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Pengurus @if(!isset($lembaga))<span class="text-red-500">*</span>@endif</label>
                    <input type="text" name="nama_pengurus" value="{{ old('nama_pengurus', $pengurus?->name) }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">NIK (16 digit) @if(!isset($lembaga))<span class="text-red-500">*</span>@endif</label>
                    <input type="text" name="nik" maxlength="16" inputmode="numeric" value="{{ old('nik', $pengurus?->nik) }}"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password @if(!isset($lembaga))<span class="text-red-500">*</span>@else<small class="text-slate-400 font-normal">(kosongkan jika tidak diubah)</small>@endif</label>
                    <input type="password" name="password" autocomplete="new-password"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                </div>
            </div>
        </div>
    </div>

    {{-- Preview / actions --}}
    <div class="space-y-6">
        <div class="bento-card p-6">
            <div class="section-header"><h3>Pratinjau</h3><div class="shimmer-line"></div></div>
            <div class="rounded-2xl bg-gradient-to-br from-brand-500 to-teal-600 p-6 text-white shadow-lg">
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-xl font-bold mb-3">
                    {{ strtoupper(substr(old('nama', $lembaga?->nama ?? 'L'), 0, 1)) }}
                </div>
                <p class="font-bold text-lg leading-tight">{{ old('nama', $lembaga?->nama ?? 'Nama Lembaga') }}</p>
                <p class="text-sm text-white/70 mt-0.5">{{ old('jenis', $lembaga?->jenis ?? '') ? \App\Models\Lembaga::jenisOptions()[old('jenis', $lembaga?->jenis)] ?? '' : '' }}</p>
                <div class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold bg-white/20 rounded-full px-3 py-1">
                    <span class="w-1.5 h-1.5 rounded-full {{ old('status', $lembaga?->status ?? 'aktif') === 'nonaktif' ? 'bg-red-300' : 'bg-green-300' }}"></span>
                    {{ old('status', $lembaga?->status ?? 'aktif') === 'nonaktif' ? 'Nonaktif' : 'Aktif' }}
                </div>
            </div>
        </div>

        <div class="bento-card p-6">
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.lembaga.index') }}" class="btn-ghost">Batal</a>
                <button type="submit" class="btn-primary">
                    {{ isset($lembaga) ? 'Simpan Perubahan' : 'Simpan Lembaga' }}
                </button>
            </div>
        </div>
    </div>
</div>
