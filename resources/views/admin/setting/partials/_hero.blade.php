{{-- ═══ Premium Hero: Desa Digital Command Center ═══ --}}
<div class="hero relative overflow-hidden rounded-[28px] mb-6 animate-fade-in">
    <div class="hero-grid" aria-hidden="true"></div>
    <div class="hero-orb hero-orb-a" aria-hidden="true"></div>
    <div class="hero-orb hero-orb-b" aria-hidden="true"></div>
    <div class="hero-orb hero-orb-c" aria-hidden="true"></div>

    <div class="relative px-6 pt-7 pb-6 sm:px-8 sm:pt-9 sm:pb-7">
        <div class="flex flex-col gap-7 xl:flex-row xl:items-start xl:justify-between">

            {{-- ── Identity block ── --}}
            <div class="min-w-0 xl:max-w-[52%]">
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="hero-badge hero-badge-live">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        </span>
                        Sistem Aktif
                    </span>
                </div>

                <span class="hero-eyebrow">Pusat Kendali Desa Digital</span>

                <h1 class="hero-title"
                    x-text='preview.nama_desa || @js($settings['nama_desa'] ?? 'Desa')'>{{ $settings['nama_desa'] ?? 'Desa' }}</h1>

                <p class="hero-sub">
                    <span x-text='preview.nama_kecamatan || @js($settings['nama_kecamatan'] ?? 'Kecamatan …')'>{{ $settings['nama_kecamatan'] ?? 'Kecamatan …' }}</span>
                    <span class="opacity-40">·</span>
                    <span x-text='preview.nama_kabupaten || @js($settings['nama_kabupaten'] ?? 'Kabupaten …')'>{{ $settings['nama_kabupaten'] ?? 'Kabupaten …' }}</span>
                    <span class="opacity-40">·</span>
                    <span x-text='preview.nama_provinsi || @js($settings['nama_provinsi'] ?? 'Provinsi …')'>{{ $settings['nama_provinsi'] ?? 'Provinsi …' }}</span>
                </p>

                @if (($settings['motto_desa'] ?? '') !== '')
                    <p class="hero-motto">
                        <svg class="w-3.5 h-3.5 shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.5a.56.56 0 011.04 0l2.13 4.32a.56.56 0 00.5.32h4.55a.56.56 0 01.33.9l-3.22 3.15a.56.56 0 00-.14.52l1.02 4.66a.56.56 0 01-.83.6l-3.85-2.3a.56.56 0 00-.5 0l-3.85 2.3a.56.56 0 01-.83-.6l1.02-4.66a.56.56 0 00-.14-.52L4.44 9.04a.56.56 0 01.33-.9h4.55a.56.56 0 00.5-.32l2.16-4.32z"/>
                        </svg>
                        <span x-text='preview.motto_desa || @js($settings["motto_desa"] ?? "-")'>{{ $settings['motto_desa'] }}</span>
                    </p>
                @endif

                <div class="flex flex-wrap gap-2 mt-5">
                    <span class="hero-chip">
                        <span class="hero-chip-dot bg-emerald-400"></span>
                        {{ $stats['kategori'] }} modul konfigurasi
                    </span>
                    <span class="hero-chip">
                        <span class="hero-chip-dot bg-cyan-400"></span>
                        {{ $stats['template_surat'] }} template surat
                    </span>
                    <span class="hero-chip">
                        <span class="hero-chip-dot bg-violet-400"></span>
                        Konfigurasi v{{ $currentVersion ?? 0 }}
                    </span>
                </div>
            </div>

            {{-- ── Live metrics ── --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 xl:w-[440px] xl:shrink-0">
                @php
                    $heroStats = [
                        ['label' => 'Warga Terdaftar', 'value' => $stats['warga'], 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z', 'accent' => 'emerald'],
                        ['label' => 'RT / RW', 'value' => $stats['rt'] + $stats['rw'], 'icon' => 'M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25', 'accent' => 'cyan'],
                        ['label' => 'Surat Bulan Ini', 'value' => $stats['surat_bulan_ini'], 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z', 'accent' => 'violet'],
                        ['label' => 'Total Surat', 'value' => $stats['surat_total'], 'icon' => 'M3.75 6.75h16.5M3.75 12H12m-8.25 5.25H12', 'accent' => 'amber'],
                    ];
                @endphp

                @foreach ($heroStats as $item)
                    <div class="hero-stat" data-acc="{{ $item['accent'] }}">
                        <div class="hero-stat-icon">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                            </svg>
                        </div>
                        <p class="hero-stat-value count-up">{{ number_format($item['value'], 0, ',', '.') }}</p>
                        <p class="hero-stat-label">{{ $item['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── System status strip ── --}}
        <div class="hero-status mt-7">
            <div class="hero-status-item">
                <span class="health-dot ok"></span>
                <div>
                    <p class="hero-status-label">Database</p>
                    <p class="hero-status-value">{{ config('database.default') }}</p>
                </div>
            </div>
            <span class="hero-status-sep"></span>
            <div class="hero-status-item">
                <span class="health-dot ok"></span>
                <div>
                    <p class="hero-status-label">Queue Driver</p>
                    <p class="hero-status-value">{{ $settings['queue_driver'] ?? config('queue.default') }}</p>
                </div>
            </div>
            <span class="hero-status-sep"></span>
            <div class="hero-status-item">
                <span class="health-dot {{ ($telegramConfigured ?? false) ? 'ok' : 'warn' }}"></span>
                <div>
                    <p class="hero-status-label">Notifikasi</p>
                    <p class="hero-status-value">{{ ($telegramConfigured ?? false) ? 'Telegram Aktif' : 'Belum Diatur' }}</p>
                </div>
            </div>
            <span class="hero-status-sep"></span>
            <div class="hero-status-item">
                <span class="health-dot {{ ($stats['backup_terakhir'] ?? null) ? 'ok' : 'warn' }}"></span>
                <div>
                    <p class="hero-status-label">Backup Terakhir</p>
                    <p class="hero-status-value">
                        @if ($stats['backup_terakhir'] ?? null)
                            {{ \Illuminate\Support\Carbon::createFromTimestamp($stats['backup_terakhir']['created_at'])->diffForHumans() }}
                        @else
                            Belum ada
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
