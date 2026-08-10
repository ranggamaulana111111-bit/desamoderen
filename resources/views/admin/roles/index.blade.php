<x-admin-layout title="Manajemen Role" maxWidth="max-w-[1440px]">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Manajemen Role</h1>
            <p class="text-gray-500 mt-1 text-sm">Kelola role dan permission sistem.</p>
        </div>
        @can('role.manage')
        <a href="{{ route('admin.roles.create') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 px-5 py-2.5 rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-200 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Role
        </a>
        @endcan
    </div>

    <div class="widget-card">
        <div class="overflow-x-auto">
            <table class="table-enhanced min-w-full text-sm">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-left">Role</th>
                        <th class="px-6 py-4 text-center">Permissions</th>
                        <th class="px-6 py-4 text-center">Users</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($roles as $role)
                        @php
                            $roleBadge = match($role->name) {
                                'Super Admin' => 'bg-red-50 text-red-700 border-red-100',
                                'Operator Pelayanan' => 'bg-blue-50 text-blue-700 border-blue-100',
                                'Sekretaris Desa' => 'bg-purple-50 text-purple-700 border-purple-100',
                                'Kepala Desa' => 'bg-amber-50 text-amber-700 border-amber-100',
                                'RT' => 'bg-teal-50 text-teal-700 border-teal-100',
                                'RW' => 'bg-cyan-50 text-cyan-700 border-cyan-100',
                                default => 'bg-gray-50 text-gray-700 border-gray-100',
                            };
                        @endphp
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 group-hover:text-indigo-700 transition">{{ $role->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="chip bg-indigo-50 text-indigo-700 border border-indigo-100">{{ $role->permissions_count }} permission</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="chip bg-gray-50 text-gray-600 border border-gray-100">{{ $role->users_count }} user</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    @can('role.manage')
                                    <a href="{{ route('admin.roles.edit', $role) }}"
                                        class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-white text-xs font-semibold bg-emerald-50 hover:bg-emerald-600 px-3 py-1.5 rounded-lg transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                        Edit
                                    </a>
                                    @if ($role->name !== 'Super Admin')
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline"
                                        x-data="{ show: false }" @submit.prevent="show = true">
                                        @csrf @method('DELETE')
                                        <div x-show="show" x-transition class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4" @click.outside="show = false">
                                            <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-400 to-rose-500 flex items-center justify-center text-white mx-auto mb-4 shadow-lg shadow-red-500/20">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Hapus Role?</h3>
                                                <p class="text-sm text-gray-500 text-center mb-6">Role <strong class="text-gray-700">{{ $role->name }}</strong> akan dihapus permanen.</p>
                                                <div class="flex gap-3">
                                                    <button type="button" @click="show = false" class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">Batal</button>
                                                    <button type="submit" class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 rounded-xl shadow-lg shadow-red-500/20 transition-all duration-200">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-red-500 hover:text-white text-xs font-semibold bg-red-50 hover:bg-red-600 px-3 py-1.5 rounded-lg transition-all duration-200">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                    </div>
                                    <p class="text-sm text-gray-400 font-medium">Belum ada role</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($roles->hasPages())
            <div class="px-6 py-4 border-t border-gray-100/60">
                {{ $roles->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
