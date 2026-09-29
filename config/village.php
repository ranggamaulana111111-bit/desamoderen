<?php

// Fallback saja. Nilai sesungguhnya dibaca dari tabel `village_settings`
// oleh App\Providers\VillageSettingServiceProvider — file ini hanya dipakai
// kalau tabel belum ada / belum bisa dibaca. Jangan diisi nama atau nomor
// pejabat asli di sini: file ini ikut ter-deploy ke server lain.

return [
    'nama_desa' => '-',
    'nama_provinsi' => '-',
    'nama_kecamatan' => '-',
    'nama_kabupaten' => '-',
    'kode_desa' => '-',
    'kode_pos' => '-',
    'alamat_kantor' => '-',
    'email_desa' => '-',
    'telepon_desa' => '-',
    'website_desa' => '-',
    'logo_desa' => null,
    'nama_kades' => '-',
    'nip_kades' => '-',
    'jabatan_kades' => 'Kepala Desa',
    'nama_sekdes' => '-',
    'nip_sekdes' => '-',

    // ─── Konfigurasi Fitur G2C ───
    'antrean_jam_mulai' => env('VILLAGE_ANTREAN_JAM_MULAI', '09:00'),
    'antrean_jam_selesai' => env('VILLAGE_ANTREAN_JAM_SELESAI', '12:00'),
    'antrean_kuota_per_slot' => env('VILLAGE_ANTREAN_KUOTA_PER_SLOT', 1),
    'antrean_durasi_slot' => env('VILLAGE_ANTREAN_DURASI_SLOT', 15),

    // ─── Penomoran Surat Otomatis ───
    'format_nomor_surat' => env('VILLAGE_FORMAT_NOMOR_SURAT', '{prefix} / {no} / {suffix} / {tahun}'),
    'nomor_prefix' => env('VILLAGE_NOMOR_PREFIX', '470'),
    'nomor_suffix' => env('VILLAGE_NOMOR_SUFFIX', 'DS-KP'),
    'nomor_padding' => env('VILLAGE_NOMOR_PADDING', 4),
    'nomor_reset' => env('VILLAGE_NOMOR_RESET', 'tahunan'),
];
