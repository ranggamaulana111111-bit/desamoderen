<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pengguna: {{ $user->name }} - Prodesa</title>
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
    @include('components.design-tokens')
</head>
<body class="bg-slate-50 font-sans antialiased">

    @include('admin.components.sidebar')

    <main class="flex-1 overflow-y-auto pt-16 md:pt-0">
        <div class="p-4 md:p-8">

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Detail Pengguna</h1>
                    <p class="text-gray-500 mt-1 text-sm">Informasi lengkap dan manajemen role pengguna.</p>
                </div>
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg transition self-start">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- User Info --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Data Pengguna</h2>
                        </div>
                        <div class="p-5 md:px-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl font-bold">
                                    {{ $user->avatar_initials }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                                    @php
                                        $roleBadge = match($user->roles()->first()?->name ?? '') {
                                            'Super Admin' => 'bg-red-100 text-red-800',
                                            'Operator Pelayanan' => 'bg-blue-100 text-blue-800',
                                            'Sekretaris Desa' => 'bg-purple-100 text-purple-800',
                                            'Kepala Desa' => 'bg-amber-100 text-amber-800',
                                            'RT' => 'bg-teal-100 text-teal-800',
                                            'RW' => 'bg-cyan-100 text-cyan-800',
                                            'Warga' => 'bg-gray-100 text-gray-700',
                                            default => 'bg-gray-100 text-gray-500',
                                        };
                                    @endphp
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $roleBadge }}">
                                        {{ $user->roles()->first()?->name ?? 'Tidak ada role' }}
                                    </span>
                                </div>
                            </div>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                                <div>
                                    <dt class="text-gray-500">NIK</dt>
                                    <dd class="font-medium text-gray-900">{{ $user->nik }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Email</dt>
                                    <dd class="font-medium text-gray-900">{{ $user->email ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">RT / RW</dt>
                                    <dd class="font-medium text-gray-900">{{ $user->rt ?? '-' }} / {{ $user->rw ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">No. HP</dt>
                                    <dd class="font-medium text-gray-900">{{ $user->no_hp ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">No. KK</dt>
                                    <dd class="font-medium text-gray-900">{{ $user->no_kk ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500">Bergabung</dt>
                                    <dd class="font-medium text-gray-900">{{ $user->created_at->locale('id')->translatedFormat('d F Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Pengajuan Stats --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Statistik Pengajuan</h2>
                        </div>
                        <div class="p-5 md:px-6">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                @php
                                    $statColors = [
                                        'submitted' => ['bg-blue-50', 'text-blue-700', 'Diajukan'],
                                        'verified' => ['bg-indigo-50', 'text-indigo-700', 'Diverifikasi'],
                                        'approved_operator' => ['bg-purple-50', 'text-purple-700', 'Disetujui Operator'],
                                        'approved_sekdes' => ['bg-cyan-50', 'text-cyan-700', 'Disetujui Sekdes'],
                                        'approved_kades' => ['bg-emerald-50', 'text-emerald-700', 'Disetujui Kades'],
                                        'completed' => ['bg-green-50', 'text-green-700', 'Selesai'],
                                        'rejected' => ['bg-red-50', 'text-red-700', 'Ditolak'],
                                    ];
                                @endphp
                                @foreach ($statColors as $st => [$bg, $text, $label])
                                    @if (isset($pengajuanStats[$st]))
                                    <div class="{{ $bg }} rounded-lg p-3 text-center">
                                        <p class="text-2xl font-bold {{ $text }}">{{ $pengajuanStats[$st] }}</p>
                                        <p class="text-xs {{ $text }} opacity-75 mt-1">{{ $label }}</p>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Recent Activity --}}
                    @if ($recentActivity->count())
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Aktivitas Terbaru</h2>
                        </div>
                        <div class="p-5 md:px-6">
                            <div class="space-y-3">
                                @foreach ($recentActivity as $activity)
                                    <div class="flex items-start gap-3">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500 mt-2 shrink-0"></div>
                                        <div>
                                            <p class="text-sm text-gray-700">
                                                <span class="font-medium">{{ $activity->label }}</span>
                                                @if ($activity->catatan)
                                                    <span class="text-gray-500"> — {{ Str::limit($activity->catatan, 80) }}</span>
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-400 mt-0.5">
                                                {{ $activity->created_at->locale('id')->diffForHumans() }}
                                                @if ($activity->pengajuan)
                                                    &middot; Surat #{{ $activity->pengajuan->id }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar: Role Assignment --}}
                <div class="space-y-6">
                    @can('user.assign_role')
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Ubah Role</h2>
                        </div>
                        <div class="p-5 md:px-6">
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Role Saat Ini</label>
                                    <p class="text-sm font-semibold text-emerald-700">{{ $user->roles()->first()?->name ?? 'Tidak ada role' }}</p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Ubah ke Role</label>
                                    <select name="role" required
                                        class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none">
                                        @foreach ($allRoles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit"
                                    class="w-full text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-lg transition">
                                    Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>
                    @endcan

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                            <h2 class="font-semibold text-gray-900">Permission</h2>
                        </div>
                        <div class="p-5 md:px-6">
                            @php $role = $user->roles()->first(); @endphp
                            @if ($role)
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($role->permissions as $perm)
                                        <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600" title="{{ $perm->name }}">
                                            {{ \App\Helpers\PermissionHelper::label($perm->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-400">Tidak ada role yang ditetapkan.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    </div>

</body>
</html>
