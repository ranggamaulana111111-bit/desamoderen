@php
    $quickActions = [];
    $quickActions[] = ['perm' => 'letter.create', 'route' => route('admin.pengajuan.index'), 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'gradient' => 'from-emerald-400 to-teal-500', 'bg' => 'emerald', 'label' => 'Surat Baru', 'desc' => 'Buat pengajuan'];
    $quickActions[] = ['perm' => 'user.create', 'route' => route('admin.users.index'), 'icon' => 'M18 9.75v-.7V9a6 6 0 00-12 0v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.75 12h.008v.008H3.75V12z', 'gradient' => 'from-teal-400 to-cyan-500', 'bg' => 'teal', 'label' => 'Warga Baru', 'desc' => 'Tambah data'];
    $quickActions[] = ['perm' => 'news.manage', 'route' => route('admin.berita.create'), 'icon' => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z', 'gradient' => 'from-violet-400 to-purple-500', 'bg' => 'violet', 'label' => 'Berita', 'desc' => 'Publikasi'];
    $quickActions[] = ['perm' => 'event.manage', 'route' => route('admin.events.create'), 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', 'gradient' => 'from-pink-400 to-rose-500', 'bg' => 'pink', 'label' => 'Event', 'desc' => 'Jadwalkan'];
@endphp
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
    @foreach ($quickActions as $action)
        @if ($can[$action['perm']])
        <a href="{{ $action['route'] }}" class="stat-micro group bg-white rounded-2xl border border-gray-200/60 p-4 shadow-sm hover:shadow-lg hover:border-{{ $action['bg'] }}-200 hover:-translate-y-0.5 transition-all duration-300">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $action['gradient'] }} flex items-center justify-center text-white shadow-lg shadow-{{ $action['bg'] }}-500/25 mb-3 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $action['icon'] }}"/>
                </svg>
            </div>
            <p class="text-[13px] font-bold text-gray-800 group-hover:text-{{ $action['bg'] }}-700 transition">{{ $action['label'] }}</p>
            <p class="text-[10px] text-gray-400 mt-0.5">{{ $action['desc'] }}</p>
        </a>
        @endif
    @endforeach
</div>
