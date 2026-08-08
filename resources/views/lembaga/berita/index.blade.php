<x-lembaga-layout title="Berita Saya">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Berita Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola berita {{ $lembaga->nama }}.</p>
        </div>
        <a href="{{ route('lembaga.berita.create') }}" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tulis Berita
        </a>
    </div>

    <div class="flex items-center gap-2 mb-4 flex-wrap">
        @foreach(['' => 'Semua', 'publish' => 'Tayang', 'draft' => 'Draf'] as $value => $label)
            <a href="{{ route('lembaga.berita.index', $value ? ['status' => $value] : []) }}"
               class="px-4 py-1.5 rounded-full text-xs font-semibold transition {{ request()->query('status', '') === $value ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'bg-white text-slate-500 ring-1 ring-slate-200 hover:ring-brand-300 hover:text-brand-600' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bento-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-enhanced">
                <thead>
                    <tr>
                        <th>Berita</th>
                        <th>Status</th>
                        <th>Dilihat</th>
                        <th>Dibuat</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($berita as $item)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                @if($item->foto)
                                    <img src="{{ asset('storage/'.$item->foto) }}" alt="" class="w-12 h-12 rounded-xl object-cover ring-1 ring-slate-100">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 truncate max-w-xs">{{ $item->judul }}</p>
                                    <p class="text-xs text-slate-400">{{ $item->created_at->translatedFormat('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-status {{ 'bg-'.$item->status }}">{{ $item->status === 'publish' ? 'Tayang' : 'Draf' }}</span>
                        </td>
                        <td>
                            <span class="inline-flex items-center gap-1.5 text-slate-600">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ number_format($item->dilihat) }}
                            </span>
                        </td>
                        <td class="text-slate-600">{{ $item->user?->name }}</td>
                        <td class="text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('lembaga.berita.show', $item) }}" class="p-2 rounded-lg hover:bg-brand-50 text-slate-500 hover:text-brand-600 transition" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </a>
                                <a href="{{ route('lembaga.berita.edit', $item) }}" class="p-2 rounded-lg hover:bg-amber-50 text-slate-500 hover:text-amber-600 transition" title="Ubah">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
                                </a>
                                <form action="{{ route('lembaga.berita.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-slate-500 hover:text-red-600 transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state py-10">
                                <div class="empty-state-icon bg-brand-50 text-brand-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Belum ada berita</p>
                                <a href="{{ route('lembaga.berita.create') }}" class="mt-3 text-sm font-bold text-brand-600 hover:underline">Tulis berita pertama</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($berita->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">{{ $berita->links() }}</div>
        @endif
    </div>

</x-lembaga-layout>
