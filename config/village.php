<?php

return [
    // ─── Identitas & Legalitas Desa ───
    'nama_desa' => env('VILLAGE_NAMA_DESA', 'Kumpay'),
    'nama_kecamatan' => env('VILLAGE_KECAMATAN', 'Ciasem'),
    'nama_kabupaten' => env('VILLAGE_KABUPATEN', 'Subang'),
    'kode_pos' => env('VILLAGE_KODE_POS', '41256'),
    'alamat_kantor' => env('VILLAGE_ALAMAT', 'Kp. Kumpay, RT 01 RW 01, Kec. Ciasem, Kab. Subang'),
    'email_desa' => env('VILLAGE_EMAIL', 'desakumpay@subang.go.id'),
    'logo_desa' => null,

    // ─── Manajemen Pejabat & Penandatangan ───
    'nama_kades' => env('VILLAGE_NAMA_KADES', 'Ade Komara'),
    'nip_kades' => env('VILLAGE_NIP_KADES', '-'),
    'jabatan_kades' => env('VILLAGE_JABATAN_KADES', 'Kepala Desa Kumpay'),
    'nama_sekdes' => env('VILLAGE_NAMA_SEKDES', 'Dede Supendi'),
    'nip_sekdes' => env('VILLAGE_NIP_SEKDES', '-'),

    // ─── Konfigurasi Fitur G2C ───
    'antrean_jam_mulai' => env('VILLAGE_ANTREAN_JAM_MULAI', '09:00'),
    'antrean_jam_selesai' => env('VILLAGE_ANTREAN_JAM_SELESAI', '12:00'),
    'antrean_kuota_per_slot' => env('VILLAGE_ANTREAN_KUOTA_PER_SLOT', 1),
    'format_nomor_surat' => env('VILLAGE_FORMAT_NOMOR_SURAT', '470 / {id} / DS-KP / {tahun}'),
];
