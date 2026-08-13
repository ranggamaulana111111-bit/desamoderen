<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Role - Prodesa</title>
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
        <div class="p-4 md:p-8 max-w-4xl">
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Tambah Role Baru</h1>
                    <p class="text-gray-500 mt-1 text-sm">Buat role baru dan tentukan permission-nya.</p>
                </div>
                <a href="{{ route('admin.roles.index') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-lg transition self-start">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-6 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-5 md:px-6 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-gray-900">Informasi Role</h2>
                    </div>
                    <div class="p-5 md:px-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Role <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required maxlength="100"
                                class="w-full text-sm border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-emerald-500 outline-none"
                                placeholder="Contoh: Kepala Dusun">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ selectAll: false }">
                    <div class="px-5 md:px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="font-semibold text-gray-900">Permission</h2>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" x-model="selectAll" @click="
                                document.querySelectorAll('.perm-check').forEach(c => c.checked = selectAll)
                            " class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            Pilih Semua
                        </label>
                    </div>
                    <div class="p-5 md:px-6 space-y-4">
                        @foreach ($permissions as $group => $perms)
                            <div>
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">{{ \App\Helpers\PermissionHelper::groupLabel($group) }}</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                    @foreach ($perms as $perm)
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-lg px-3 py-2 cursor-pointer transition">
                                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                                {{ in_array($perm->name, old('permissions', [])) ? 'checked' : '' }}
                                                class="perm-check rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                            <span class="truncate" title="{{ $perm->name }}">{{ \App\Helpers\PermissionHelper::label($perm->name) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-6 py-2.5 rounded-lg transition">
                        Simpan Role
                    </button>
                </div>
            </form>
        </div>
    </main>
    </div>

</body>
</html>
