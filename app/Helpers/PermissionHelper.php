<?php

namespace App\Helpers;

class PermissionHelper
{
    protected static array $labels = [
        'dashboard.view'       => 'Melihat Dashboard',
        'user.view'            => 'Melihat Data Pengguna',
        'user.create'          => 'Menambah Pengguna',
        'user.edit'            => 'Mengubah Data Pengguna',
        'user.delete'          => 'Menghapus Pengguna',
        'user.assign_role'     => 'Menetapkan Role',
        'letter.view'          => 'Melihat Daftar Surat',
        'letter.create'        => 'Membuat Pengajuan Surat',
        'letter.review'        => 'Review Pengajuan Surat',
        'letter.verify'        => 'Verifikasi Surat',
        'letter.final_approve' => 'Persetujuan Akhir Surat',
        'letter.reject'        => 'Menolak Pengajuan Surat',
        'letter.print'         => 'Mencetak Surat',
        'letter.download'      => 'Mengunduh Surat',
        'letter.sign'          => 'Menandatangani Surat',
        'letter.cancel'        => 'Membatalkan Pengajuan Surat',
        'letter.version.view'  => 'Melihat Riwayat Versi',
        'letter.version.restore' => 'Memulihkan Versi Surat',
        'setting.view'         => 'Melihat Pengaturan',
        'setting.manage'       => 'Mengelola Pengaturan',
        'event.manage'         => 'Mengelola Acara',
        'news.manage'          => 'Mengelola Berita',
        'analytics.view'       => 'Melihat Analitik',
        'queue.view'           => 'Melihat Status Antrian',
        'queue.manage'         => 'Mengelola Antrian Proses',
        'audit.view'           => 'Melihat Log Aktivitas',
        'backup.manage'        => 'Mengelola Backup Data',
        'office.view'          => 'Melihat Surat Masuk & Keluar',
        'inventaris.view'      => 'Melihat Inventaris & Aset',
        'inventaris.manage'    => 'Mengelola Inventaris & Aset',
        'anggaran.view'        => 'Melihat APBDesa',
        'anggaran.manage'      => 'Mengelola APBDesa',
        'role.manage'          => 'Mengelola Role',
        'permission.manage'    => 'Mengelola Permission',
    ];

    protected static array $groupLabels = [
        'Dashboard'   => 'Dashboard',
        'User'        => 'Manajemen Pengguna',
        'Letter'      => 'Pengelolaan Surat',
        'Setting'     => 'Pengaturan',
        'Event'       => 'Acara & Kegiatan',
        'News'        => 'Berita & Informasi',
        'Analytics'   => 'Analitik & Statistik',
        'Queue'       => 'Antrian Proses',
        'Audit'       => 'Log Aktivitas',
        'Backup'      => 'Cadangan Data',
        'Office'      => 'Surat Masuk & Keluar',
        'Inventaris'  => 'Inventaris & Aset',
        'Anggaran'    => 'Anggaran Desa (APBDesa)',
        'Role'        => 'Role & Izin',
        'Permission'  => 'Role & Izin',
    ];

    public static function label(string $name): string
    {
        return self::$labels[$name] ?? str_replace(['.', '_'], ' ', ucfirst($name));
    }

    public static function groupLabel(string $group): string
    {
        return self::$groupLabels[$group] ?? ucfirst(str_replace('_', ' ', $group));
    }

    public static function all(): array
    {
        return self::$labels;
    }
}
