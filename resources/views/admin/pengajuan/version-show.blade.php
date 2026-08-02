<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Versi {{ $version->version_label }} - Prodesa</title>
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

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Versi {{ $version->version_label }}</h1>
                    <p class="text-gray-500 mt-1 text-sm">
                        {{ str_replace('_', ' ', ucfirst($pengajuan->jenis_surat)) }} &middot;
                        {{ $pengajuan->user->name ?? '-' }}
                    </p>
                </div>
                <a href="{{ route('admin.pengajuan.versions.index', $pengajuan) }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg transition self-start">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Semua Versi
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Data pada Versi Ini</h2>
                        </div>
                        <div class="p-5 md:px-6">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                                @foreach (($version->data_snapshot ?? []) as $key => $value)
                                    @if ($key !== 'lampiran')
                                        <div class="{{ is_array($value) ? 'sm:col-span-2' : '' }}">
                                            <dt class="text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }}</dt>
                                            <dd class="font-medium text-gray-900">
                                                @if (is_array($value))
                                                    <pre class="text-xs bg-gray-50 rounded-lg p-3 overflow-x-auto mt-1">{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                @else
                                                    {{ $value ?? '-' }}
                                                @endif
                                            </dd>
                                        </div>
                                    @endif
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Informasi Versi</h2>
                        </div>
                        <div class="p-5 md:px-6 text-sm space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Versi</span>
                                <span class="font-semibold text-gray-900">{{ $version->version_label }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Status</span>
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold
                                    {{ \App\Models\ApprovalHistory::STATUS_COLORS()[$version->status_at_version] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ \App\Models\ApprovalHistory::STATUS_LABELS()[$version->status_at_version] ?? ucfirst(str_replace('_', ' ', $version->status_at_version)) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Oleh</span>
                                <span class="font-medium text-gray-900">{{ $version->createdBy?->name ?? 'Sistem' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Tanggal</span>
                                <span class="font-medium text-gray-900">{{ $version->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                            @if ($version->catatan)
                            <div class="pt-2 border-t border-gray-100">
                                <span class="text-gray-500 block text-xs">Catatan</span>
                                <p class="text-gray-800 mt-1">{{ $version->catatan }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        @can('letter.version.restore')
                        <form action="{{ route('admin.pengajuan.versions.restore', [$pengajuan, $version->version_number]) }}" method="POST"
                            onsubmit="return confirm('Kembalikan data ke {{ $version->version_label }}?')">
                            @csrf
                            <button type="submit"
                                class="w-full text-sm font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 px-4 py-2.5 rounded-lg transition text-center">
                                Kembalikan ke Versi Ini
                            </button>
                        </form>
                        @endcan
                        @if ($version->pdf_path)
                        <a href="{{ route('admin.pengajuan.versions.download', [$pengajuan, $version->version_number]) }}"
                            class="w-full text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-4 py-2.5 rounded-lg transition text-center">
                            Download PDF Versi ini
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
</body>
</html>