<x-lembaga-layout title="Profil Lembaga">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Profil Lembaga</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui identitas {{ $lembaga->nama }} yang tampil di website desa.</p>
    </div>

    <form action="{{ route('lembaga.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bento-card p-6">
                    <div class="section-header"><h3>Informasi Umum</h3><div class="shimmer-line"></div></div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lembaga</label>
                            <input type="text" value="{{ $lembaga->nama }}" disabled
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-400">
                            <p class="text-[11px] text-slate-400 mt-1">Diubah oleh admin desa.</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Lembaga</label>
                            <input type="text" value="{{ $lembaga->jenis_label }}" disabled
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-400">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Ketua</label>
                            <input type="text" name="ketua" value="{{ old('ketua', $lembaga->ketua) }}" maxlength="100"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $lembaga->no_hp) }}" maxlength="20"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $lembaga->email) }}" maxlength="100"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat / Sekretariat</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $lembaga->alamat) }}" maxlength="255"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" rows="6" maxlength="2000"
                                      class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm leading-relaxed focus:ring-2 focus:ring-brand-500/40 focus:border-brand-500 outline-none transition">{{ old('deskripsi', $lembaga->deskripsi) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bento-card p-6">
                    <div class="section-header"><h3>Logo Lembaga</h3><div class="shimmer-line"></div></div>
                    <div class="space-y-3">
                        @if($lembaga->foto)
                            <img src="{{ asset('storage/'.$lembaga->foto) }}" alt="Logo {{ $lembaga->nama }}"
                                 class="w-28 h-28 rounded-2xl object-cover ring-1 ring-slate-100 mx-auto">
                        @else
                            <div class="w-28 h-28 rounded-2xl bg-brand-50 flex items-center justify-center text-brand-600 mx-auto">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        @endif
                        <input type="file" name="foto" accept="image/*"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition">
                    </div>
                </div>

                <div class="bento-card p-6">
                    <div class="flex items-center justify-end gap-3">
                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-lembaga-layout>
