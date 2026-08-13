<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Versi - {{ $pengajuan->user->name ?? '-' }} - Prodesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sidebar: '#064e3b',
                        'sidebar-hover': '#047857',
                    }
                }
            }
        }
    </script>
    @include('components.favicon')
    @include('components.fonts')
    @include('components.design-tokens')
</head>
<body class="bg-slate-50 font-sans antialiased">
    @include('admin.components.sidebar')

    <main class="flex-1 overflow-y-auto pt-16 md:pt-0">
        <div class="p-4 md:p-8">

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Riwayat Versi</h1>
                    <p class="text-gray-500 mt-1 text-sm">
                        {{ str_replace('_', ' ', ucfirst($pengajuan->jenis_surat)) }} &middot;
                        {{ $pengajuan->user->name ?? '-' }}
                    </p>
                </div>
                <a href="{{ route('admin.pengajuan.show', $pengajuan) }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg transition self-start">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Detail
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
            @endif

            {{-- Diff Comparator --}}
            @if ($versions->count() >= 2)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">Bandingkan Versi</h2>
                </div>
                <div class="p-5 md:px-6">
                    <form action="{{ route('admin.pengajuan.versions.diff', $pengajuan) }}" method="GET" class="flex flex-wrap items-end gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Versi A</label>
                            <select name="v1" required class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                @foreach ($versions as $v)
                                    <option value="{{ $v->version_number }}">{{ $v->version_label }} ({{ $v->created_at->format('d/m/Y') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Versi B</label>
                            <select name="v2" required class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                @foreach ($versions as $v)
                                    <option value="{{ $v->version_number }}">{{ $v->version_label }} ({{ $v->created_at->format('d/m/Y') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-lg transition">
                            Bandingkan
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- Version List --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 md:px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Versi</th>
                                <th class="px-5 md:px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-5 md:px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Oleh</th>
                                <th class="px-5 md:px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-5 md:px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Catatan</th>
                                <th class="px-5 md:px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($versions as $version)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-5 md:px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 font-semibold text-gray-900">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            {{ $version->version_label }}
                                        </span>
                                    </td>
                                    <td class="px-5 md:px-6 py-4 whitespace-nowrap">
                                        @php
                                            $color = \App\Models\ApprovalHistory::STATUS_COLORS()[$version->status_at_version] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold {{ $color }}">
                                            {{ \App\Models\ApprovalHistory::STATUS_LABELS()[$version->status_at_version] ?? ucfirst(str_replace('_', ' ', $version->status_at_version)) }}
                                        </span>
                                    </td>
                                    <td class="px-5 md:px-6 py-4 whitespace-nowrap text-gray-700">
                                        {{ $version->createdBy?->name ?? 'Sistem' }}
                                    </td>
                                    <td class="px-5 md:px-6 py-4 whitespace-nowrap text-gray-500">
                                        {{ $version->created_at->locale('id')->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="px-5 md:px-6 py-4 text-gray-500 max-w-[200px] truncate">
                                        {{ $version->catatan ?? '-' }}
                                    </td>
                                    <td class="px-5 md:px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('admin.pengajuan.versions.show', [$pengajuan, $version->version_number]) }}"
                                                class="inline-flex items-center gap-1 text-cyan-600 hover:text-cyan-700 text-xs font-semibold bg-cyan-50 hover:bg-cyan-100 px-2.5 py-1.5 rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                Detail
                                            </a>
                                            @can('letter.version.restore')
                                            <form action="{{ route('admin.pengajuan.versions.restore', [$pengajuan, $version->version_number]) }}" method="POST"
                                                onsubmit="return confirm('Kembalikan data ke {{ $version->version_label }}? Data saat ini akan tersimpan sebagai versi baru.')">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 text-amber-600 hover:text-amber-700 text-xs font-semibold bg-amber-50 hover:bg-amber-100 px-2.5 py-1.5 rounded-lg transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                    Restore
                                                </button>
                                            </form>
                                            @endcan
                                            @if ($version->pdf_path)
                                            <a href="{{ route('admin.pengajuan.versions.download', [$pengajuan, $version->version_number]) }}"
                                                class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 text-xs font-semibold bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1.5 rounded-lg transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                PDF
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 md:px-6 py-10 text-center text-gray-400">
                                        Belum ada riwayat versi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    </div>
</body>
</html>