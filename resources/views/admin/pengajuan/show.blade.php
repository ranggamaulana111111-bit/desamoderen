<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Berkas - {{ $pengajuan->user->name ?? '-' }} - Prodesa</title>
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
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Detail Berkas</h1>
                    <p class="text-gray-500 mt-1 text-sm">Informasi lengkap pengajuan surat.</p>
                </div>
                <a href="{{ route('admin.pengajuan.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg transition self-start">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">

                    {{-- Data Pengajuan --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Data Pengajuan</h2>
                        </div>
                        <div class="p-5 md:px-6">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                                <div>
                                    <dt class="text-gray-500">Jenis Surat</dt>
                                    <dd class="font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $pengajuan->jenis_surat) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Nomor Surat</dt>
                                    <dd class="font-medium text-gray-900">{{ $pengajuan->nomor_surat ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Tanggal Pengajuan</dt>
                                    <dd class="font-medium text-gray-900">{{ $pengajuan->created_at->locale('id')->translatedFormat('d F Y, H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Status</dt>
                                    <dd>
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $pengajuan->status_color }}">
                                            {{ $pengajuan->status_label }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Diajukan Oleh</dt>
                                    <dd class="font-medium text-gray-900">{{ $pengajuan->submittedBy?->name ?? $pengajuan->user->name ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Terakhir Diperbarui</dt>
                                    <dd class="font-medium text-gray-900">{{ $pengajuan->updated_at->locale('id')->translatedFormat('d F Y, H:i') }}</dd>
                                </div>
                            </dl>
                            @if ($pengajuan->tanda_tangan_meta)
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                                    <div>
                                        <dt class="text-gray-500">Penandatangan</dt>
                                        <dd class="font-medium text-gray-900">{{ $pengajuan->tanda_tangan_meta['jabatan'] ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500">Nama</dt>
                                        <dd class="font-medium text-gray-900">{{ $pengajuan->tanda_tangan_meta['nama'] ?? '-' }}</dd>
                                    </div>
                                </dl>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Workflow Progress --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Proses Workflow</h2>
                        </div>
                        <div class="p-5 md:px-6">
                            <div class="flex items-center justify-between overflow-x-auto pb-2">
                                @foreach ($stepProgress as $i => $step)
                                    <div class="flex flex-col items-center min-w-[80px]">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                                            {{ $step['status'] === 'completed' ? 'bg-green-500 text-white' : '' }}
                                            {{ $step['status'] === 'active' ? 'bg-emerald-600 text-white ring-4 ring-emerald-100' : '' }}
                                            {{ $step['status'] === 'pending' ? 'bg-gray-200 text-gray-500' : '' }}
                                            {{ $step['status'] === 'rejected' ? 'bg-red-500 text-white' : '' }}
                                            {{ $step['status'] === 'revision' ? 'bg-yellow-500 text-white' : '' }}">
                                            @if ($step['status'] === 'completed')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            @else
                                                {{ $i + 1 }}
                                            @endif
                                        </div>
                                        <p class="text-[10px] text-center mt-2 {{ $step['status'] === 'active' ? 'font-semibold text-emerald-700' : 'text-gray-500' }}">
                                            {{ $step['label'] }}
                                        </p>
                                    </div>
                                    @if ($i < count($stepProgress) - 1)
                                        <div class="flex-1 h-0.5 mx-1 mt-[-20px]
                                            {{ $step['status'] === 'completed' ? 'bg-green-400' : 'bg-gray-200' }}"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Approval Timeline --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Riwayat Approval</h2>
                        </div>
                        <div class="p-5 md:px-6">
                            @if ($timeline->count())
                                <div class="space-y-4">
                                    @foreach ($timeline as $idx => $log)
                                        <div class="flex gap-4">
                                            <div class="flex flex-col items-center">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0
                                                    {{ $log->status === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $log->icon }}"/></svg>
                                                </div>
                                                @if ($idx < $timeline->count() - 1)
                                                    <div class="w-0.5 flex-1 bg-gray-200 mt-1"></div>
                                                @endif
                                            </div>
                                            <div class="pb-4">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold {{ $log->color }}">
                                                        {{ $log->label }}
                                                    </span>
                                                    <span class="text-xs text-gray-400">oleh {{ $log->user->name ?? '-' }}</span>
                                                </div>
                                                @if ($log->catatan)
                                                    <p class="text-sm text-gray-600 mt-1 bg-gray-50 rounded-lg px-3 py-2">{{ $log->catatan }}</p>
                                                @endif
                                                <p class="text-xs text-gray-400 mt-1">{{ $log->created_at->locale('id')->translatedFormat('d F Y, H:i:s') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-400 text-center py-4">Belum ada riwayat approval.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Data Pemohon --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Data Pemohon</h2>
                        </div>
                        <div class="p-5 md:px-6">
                            @php $dt = $pengajuan->data_tambahan; @endphp
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                                <div class="sm:col-span-2">
                                    <dt class="text-gray-500">Nama Lengkap</dt>
                                    <dd class="font-medium text-gray-900">{{ $dt['nama_lengkap'] ?? $pengajuan->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">NIK</dt>
                                    <dd class="font-medium text-gray-900">{{ $dt['nik'] ?? $pengajuan->user->nik }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Tempat Lahir</dt>
                                    <dd class="font-medium text-gray-900">{{ $dt['tempat_lahir'] ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Tanggal Lahir</dt>
                                    <dd class="font-medium text-gray-900">{{ isset($dt['tgl_lahir']) ? \Carbon\Carbon::parse($dt['tgl_lahir'])->locale('id')->translatedFormat('d F Y') : '-' }}</dd>
                                </div>
                                @if (!empty($dt['jenis_kelamin']))
                                <div>
                                    <dt class="text-gray-500">Jenis Kelamin</dt>
                                    <dd class="font-medium text-gray-900">{{ $dt['jenis_kelamin'] }}</dd>
                                </div>
                                @endif
                                <div>
                                    <dt class="text-gray-500">Pekerjaan</dt>
                                    <dd class="font-medium text-gray-900">{{ $dt['pekerjaan'] ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-gray-500">Alamat</dt>
                                    <dd class="font-medium text-gray-900">{{ $dt['alamat_lengkap'] ?? 'RT '.($pengajuan->user->rt ?? '-').' / RW '.($pengajuan->user->rw ?? '-') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Data Spesifik per jenis surat --}}
                    @php
                        $letterConfig = \App\Models\LetterConfig::where('jenis_surat', $pengajuan->jenis_surat)->first();
                        $commonKeys = ['nama_lengkap', 'nik', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'pekerjaan', 'alamat_lengkap', 'lampiran'];
                    @endphp
                    @if ($letterConfig && $letterConfig->fields)
                        @php
                            $specificFields = array_filter($letterConfig->fields, fn($f) => !in_array($f['key'], $commonKeys));
                        @endphp
                        @if (count($specificFields) > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-5 md:px-6 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Data {{ $letterConfig->label }}</h2></div>
                            <div class="p-5 md:px-6">
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                                    @foreach ($specificFields as $field)
                                        <div>
                                            <dt class="text-gray-500">{{ $field['label'] }}</dt>
                                            <dd class="font-medium text-gray-900">
                                                @if ($field['key'] === 'penghasilan' || $field['key'] === 'jumlah_penghasilan')
                                                    Rp{{ number_format($dt[$field['key']] ?? 0, 0, ',', '.') }},-
                                                @elseif (in_array($field['type'] ?? 'text', ['date']) && isset($dt[$field['key']]))
                                                    {{ \Carbon\Carbon::parse($dt[$field['key']])->locale('id')->translatedFormat('d F Y') }}
                                                @else
                                                    {{ $dt[$field['key']] ?? '-' }}
                                                @endif
                                            </dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        </div>
                        @endif
                    @endif

                    @if ($pengajuan->catatan_admin)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100"><h2 class="font-semibold text-gray-900">Catatan Admin</h2></div>
                        <div class="p-5 md:px-6"><p class="text-sm text-gray-700 whitespace-pre-line">{{ $pengajuan->catatan_admin }}</p></div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar: Actions --}}
                <div class="space-y-6">

                    {{-- Workflow Actions --}}
                    @if ($pengajuan->isActive() && count($validTransitions) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Aksi Workflow</h2>
                        </div>
                        <div class="p-5 md:px-6 space-y-3" x-data="{ action: '' }">
                            @foreach ($validTransitions as $targetStatus => $label)
                                @if ($targetStatus === 'rejected')
                                    <form action="{{ route('admin.pengajuan.reject', $pengajuan) }}" method="POST" class="space-y-2">
                                        @csrf
                                        <div>
                                            <textarea name="catatan" required rows="2" placeholder="Alasan penolakan..."
                                                class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 outline-none resize-none"></textarea>
                                        </div>
                                        <button type="submit"
                                            class="w-full text-sm font-semibold text-white bg-red-600 hover:bg-red-700 px-4 py-2.5 rounded-lg transition">
                                            {{ $label }}
                                        </button>
                                    </form>
                                @elseif ($targetStatus === 'revision')
                                    <form action="{{ route('admin.pengajuan.revision', $pengajuan) }}" method="POST" class="space-y-2">
                                        @csrf
                                        <div>
                                            <textarea name="catatan" required rows="2" placeholder="Catatan perbaikan yang diperlukan..."
                                                class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500 outline-none resize-none"></textarea>
                                        </div>
                                        <button type="submit"
                                            class="w-full text-sm font-semibold text-white bg-yellow-600 hover:bg-yellow-700 px-4 py-2.5 rounded-lg transition">
                                            {{ $label }}
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.pengajuan.approve', $pengajuan) }}" method="POST" class="space-y-2">
                                        @csrf
                                        <div>
                                            <textarea name="catatan" rows="2" placeholder="Catatan (opsional)..."
                                                class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none resize-none"></textarea>
                                        </div>
                                        <button type="submit"
                                            class="w-full text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2.5 rounded-lg transition">
                                            {{ $label }}
                                        </button>
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if ($pengajuan->status === 'completed')
                    <a href="{{ route('admin.pengajuan.cetak', $pengajuan) }}" target="_blank"
                        class="flex items-center justify-center gap-2 text-sm font-semibold text-green-700 bg-green-50 hover:bg-green-100 border border-green-200 px-4 py-3 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak PDF
                    </a>
                    @endif

                    @can('letter.version.view')
                    <a href="{{ route('admin.pengajuan.versions.index', $pengajuan) }}"
                        class="flex items-center justify-center gap-2 text-sm font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 px-4 py-3 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Riwayat Versi ({{ $pengajuan->documentVersions()->count() }})
                    </a>
                    @endcan

                    @if ($pengajuan->antrean && $pengajuan->status === 'completed')
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Antrean Pengambilan</h2>
                        </div>
                        <div class="p-5 md:px-6 text-sm space-y-2">
                            <div class="flex justify-between"><span class="text-gray-500">Nomor</span><span class="font-medium text-gray-900">{{ $pengajuan->antrean->nomor_antrean }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span class="font-medium text-gray-900">{{ $pengajuan->antrean->tanggal_ambil->format('d/m/Y') }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">Jam</span><span class="font-medium text-gray-900">{{ substr($pengajuan->antrean->jam_mulai, 0, 5) }} - {{ substr($pengajuan->antrean->jam_selesai, 0, 5) }}</span></div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </main>
    </div>

</body>
</html>
