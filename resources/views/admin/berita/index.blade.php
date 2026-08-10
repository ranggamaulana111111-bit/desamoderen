<x-admin-layout title="Berita Desa" maxWidth="max-w-[1440px]">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Berita Desa</h1>
            <p class="text-gray-500 mt-1 text-sm">Kelola berita dan informasi desa.</p>
        </div>
        <a href="{{ route('admin.berita.create') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-200 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Berita
        </a>
    </div>

    <div class="widget-card">
        <div class="overflow-x-auto">
            <table class="table-enhanced min-w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-left">Foto</th>
                        <th class="px-6 py-4 text-left">Judul</th>
                        <th class="px-6 py-4 text-left">Penulis</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($berita as $item)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                @if ($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="w-14 h-10 rounded-lg object-cover shadow-sm">
                                @else
                                    <div class="w-14 h-10 rounded-lg bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center border border-gray-100">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900 group-hover:text-emerald-700 transition max-w-[250px] truncate">{{ $item->judul }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $item->user->name }}</td>
                            <td class="px-6 py-4">
                                @if ($item->status === 'publish')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Publish
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 border border-gray-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.berita.edit', $item) }}"
                                        class="inline-flex items-center gap-1 text-emerald-600 hover:text-white text-xs font-semibold bg-emerald-50 hover:bg-emerald-600 px-3 py-1.5 rounded-lg transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.berita.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-red-500 hover:text-white text-xs font-semibold bg-red-50 hover:bg-red-600 px-3 py-1.5 rounded-lg transition-all duration-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5"/></svg>
                                    </div>
                                    <p class="text-sm text-gray-400 font-medium">Belum ada berita</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($berita->hasPages())
            <div class="px-6 py-4 border-t border-gray-100/60">
                {{ $berita->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
