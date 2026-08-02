<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perbandingan Versi - Prodesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sidebar: '#1e3a5f',
                        'sidebar-hover': '#2a4a7f',
                    }
                }
            }
        }
    </script>
    @include('components.favicon')
    @include('components.fonts')
</head>
<body class="bg-slate-50 font-sans antialiased">
    @include('admin.components.sidebar')

    <main class="flex-1 overflow-y-auto pt-16 md:pt-0">
        <div class="p-4 md:p-8">

            <div class="mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Perbandingan Versi</h1>
                <p class="text-gray-500 mt-1 text-sm">
                    {{ $diff['versionA']->version_label }} vs {{ $diff['versionB']->version_label }}
                    &middot; {{ str_replace('_', ' ', ucfirst($pengajuan->jenis_surat)) }}
                </p>
            </div>

            <div class="mb-4 flex gap-3">
                <a href="{{ route('admin.pengajuan.versions.index', $pengajuan) }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Semua Versi
                </a>
            </div>

            {{-- Version Info --}}
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Versi A</span>
                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $diff['versionA']->version_label }}</p>
                    <p class="text-xs text-gray-400">{{ $diff['versionA']->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <span class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Versi B</span>
                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $diff['versionB']->version_label }}</p>
                    <p class="text-xs text-gray-400">{{ $diff['versionB']->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
                </div>
            </div>

            {{-- Diff Table --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">Perubahan Data</h2>
                </div>
                @if (count($diff['diff']) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-5 md:px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Field</th>
                                    <th class="px-5 md:px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</th>
                                    <th class="px-5 md:px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $diff['versionA']->version_label }} (Lama)</th>
                                    <th class="px-5 md:px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $diff['versionB']->version_label }} (Baru)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($diff['diff'] as $change)
                                    <tr>
                                        <td class="px-5 md:px-6 py-3 font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $change['field']) }}</td>
                                        <td class="px-5 md:px-6 py-3">
                                            @if ($change['type'] === 'added')
                                                <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-700">Ditambahkan</span>
                                            @elseif ($change['type'] === 'removed')
                                                <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-700">Dihapus</span>
                                            @else
                                                <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-yellow-100 text-yellow-700">Berubah</span>
                                            @endif
                                        </td>
                                        <td class="px-5 md:px-6 py-3 text-gray-500 {{ $change['type'] === 'removed' ? 'line-through' : '' }}">
                                            {{ is_array($change['old']) ? json_encode($change['old']) : ($change['old'] ?? '-') }}
                                        </td>
                                        <td class="px-5 md:px-6 py-3 text-gray-900 font-medium {{ $change['type'] === 'added' ? 'text-green-700' : '' }}">
                                            {{ is_array($change['new']) ? json_encode($change['new']) : ($change['new'] ?? '-') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm">Tidak ada perubahan data antara kedua versi.</p>
                    </div>
                @endif
            </div>

        </div>
    </main>
    </div>
</body>
</html>