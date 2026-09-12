@if ($errors->any())
    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
        </svg>
        <div>
            <p class="font-semibold">Form tidak bisa disimpan. Perbaiki beberapa hal berikut:</p>
            <ul class="mt-1 list-disc pl-4 text-xs text-red-600 space-y-0.5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Form fields --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bento-card p-6">
            <div class="section-header"><h3>Identitas Lembaga</h3><div class="shimmer-line"></div></div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lembaga <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $lembaga?->nama) }}" required
                           class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('nama') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('nama')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Singkatan</label>
                    <input type="text" name="singkatan" value="{{ old('singkatan', $lembaga?->singkatan) }}" placeholder="cth. KarTar"
                           class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('singkatan') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('singkatan')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Lembaga <span class="text-red-500">*</span></label>
                    <select name="jenis" required
                            class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('jenis') ? 'border-red-400' : 'border-slate-200' }}">
                        @foreach(\App\Models\Lembaga::jenisOptions() as $value => $label)
                            <option value="{{ $value }}" @selected(old('jenis', $lembaga?->jenis) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('jenis')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" placeholder="Deskripsi singkat tentang lembaga..."
                              class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('deskripsi') ? 'border-red-400' : 'border-slate-200' }}">{{ old('deskripsi', $lembaga?->deskripsi) }}</textarea>
                    @error('deskripsi')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Ketua</label>
                    <input type="text" name="ketua" value="{{ old('ketua', $lembaga?->ketua) }}"
                           class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('ketua') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('ketua')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $lembaga?->no_hp) }}"
                           class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('no_hp') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('no_hp')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $lembaga?->email) }}"
                           class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('email')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $lembaga?->alamat) }}"
                           class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('alamat') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('alamat')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status</label>
                    <select name="status"
                            class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('status') ? 'border-red-400' : 'border-slate-200' }}">
                        <option value="aktif" @selected(old('status', $lembaga?->status ?? 'aktif') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status', $lembaga?->status ?? 'aktif') === 'nonaktif')>Nonaktif</option>
                    </select>
                    @error('status')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Logo / Foto</label>
                    <input type="file" name="foto" accept="image/*"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition">
                    @error('foto')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
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
                    <input type="text" name="nama_pengurus" value="{{ old('nama_pengurus', $pengurus?->name) }}" {{ isset($lembaga) ? '' : 'required' }}
                           class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('nama_pengurus') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('nama_pengurus')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email Pengurus @if(!isset($lembaga))<span class="text-red-500">*</span>@else<small class="text-slate-400 font-normal">(untuk login)</small>@endif</label>
                    <input type="email" name="email_pengurus" value="{{ old('email_pengurus', $pengurus?->email) }}" placeholder="pengurus@lembaga.id" {{ isset($lembaga) ? '' : 'required' }}
                           class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('email_pengurus') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('email_pengurus')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. HP Pengurus</label>
                    <input type="tel" name="no_hp_pengurus" value="{{ old('no_hp_pengurus', $pengurus?->no_hp) }}" placeholder="08xxxxxxxxxx"
                           class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('no_hp_pengurus') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('no_hp_pengurus')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password @if(!isset($lembaga))<span class="text-red-500">*</span>@else<small class="text-slate-400 font-normal">(kosongkan jika tidak diubah)</small>@endif</label>
                    <input type="password" name="password" autocomplete="new-password" {{ isset($lembaga) ? '' : 'required minlength="8"' }}
                           class="w-full rounded-xl border px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition {{ $errors->has('password') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('password')<p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
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
