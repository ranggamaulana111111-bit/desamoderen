<?php

namespace Database\Seeders;

use App\Models\VillageSetting;
use Illuminate\Database\Seeder;

class VillageSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            // ─── Profil Desa (identity) ───
            ['key' => 'nama_desa', 'value' => 'Kumpay', 'group' => 'identity'],
            ['key' => 'nama_provinsi', 'value' => 'Jawa Barat', 'group' => 'identity'],
            ['key' => 'nama_kabupaten', 'value' => 'Subang', 'group' => 'identity'],
            ['key' => 'nama_kecamatan', 'value' => 'Ciasem', 'group' => 'identity'],
            ['key' => 'kode_desa', 'value' => '3204120001', 'group' => 'identity'],
            ['key' => 'kode_pos', 'value' => '41256', 'group' => 'identity'],
            ['key' => 'alamat_kantor', 'value' => 'Kp. Kumpay, RT 01 RW 01, Kec. Ciasem, Kab. Subang', 'group' => 'identity'],
            ['key' => 'website_desa', 'value' => 'https://kumpay.desa.id', 'group' => 'identity'],
            ['key' => 'email_desa', 'value' => 'desakumpay@subang.go.id', 'group' => 'identity'],
            ['key' => 'telepon_desa', 'value' => '08123456789', 'group' => 'identity'],
            ['key' => 'logo_desa', 'value' => null, 'group' => 'identity'],
            ['key' => 'banner_desa', 'value' => null, 'group' => 'identity'],
            ['key' => 'foto_kantor', 'value' => null, 'group' => 'identity'],
            ['key' => 'latitude', 'value' => '-6.3421', 'group' => 'identity'],
            ['key' => 'longitude', 'value' => '107.8321', 'group' => 'identity'],
            ['key' => 'deskripsi_desa', 'value' => 'Desa Kumpay adalah desa yang terletak di Kecamatan Ciasem, Kabupaten Subang.', 'group' => 'identity'],
            ['key' => 'motto_desa', 'value' => 'Kumpay Maju, Kumpay Sejahtera', 'group' => 'identity'],

            // ─── Pemerintahan (officials) ───
            ['key' => 'nama_kades', 'value' => 'Ade Komara', 'group' => 'officials'],
            ['key' => 'nip_kades', 'value' => '-', 'group' => 'officials'],
            ['key' => 'nik_kades', 'value' => '-', 'group' => 'officials'],
            ['key' => 'jabatan_kades', 'value' => 'Kepala Desa Kumpay', 'group' => 'officials'],
            ['key' => 'foto_kades', 'value' => null, 'group' => 'officials'],
            ['key' => 'periode_kades_mulai', 'value' => '2021', 'group' => 'officials'],
            ['key' => 'periode_kades_selesai', 'value' => '2027', 'group' => 'officials'],
            ['key' => 'nama_sekdes', 'value' => 'Dede Supendi', 'group' => 'officials'],
            ['key' => 'nip_sekdes', 'value' => '-', 'group' => 'officials'],
            ['key' => 'nik_sekdes', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kaur_keuangan_nama', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kaur_keuangan_nik', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kaur_perencanaan_nama', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kaur_perencanaan_nik', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kaur_tu_nama', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kaur_tu_nik', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kasi_pemerintahan_nama', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kasi_pemerintahan_nik', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kasi_kesra_nama', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kasi_kesra_nik', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kasi_pelayanan_nama', 'value' => '-', 'group' => 'officials'],
            ['key' => 'kasi_pelayanan_nik', 'value' => '-', 'group' => 'officials'],
            ['key' => 'rt_list', 'value' => '[]', 'group' => 'officials'],
            ['key' => 'rw_list', 'value' => '[]', 'group' => 'officials'],
            ['key' => 'bpd_ketua_nama', 'value' => '-', 'group' => 'officials'],
            ['key' => 'bpd_ketua_nik', 'value' => '-', 'group' => 'officials'],
            ['key' => 'bpd_wakil_nama', 'value' => '-', 'group' => 'officials'],
            ['key' => 'bpd_wakil_nik', 'value' => '-', 'group' => 'officials'],
            ['key' => 'bpd_sekretaris_nama', 'value' => '-', 'group' => 'officials'],
            ['key' => 'bpd_sekretaris_nik', 'value' => '-', 'group' => 'officials'],
            ['key' => 'nama_camat', 'value' => 'Drs. H. Ahmad Saepudin, M.Si.', 'group' => 'officials'],
            ['key' => 'nip_camat', 'value' => '19681212 199403 1 005', 'group' => 'officials'],
            ['key' => 'nama_operator', 'value' => '-', 'group' => 'officials'],

            // ─── TTD Digital (signature) ───
            ['key' => 'stempel_desa', 'value' => null, 'group' => 'signature'],
            ['key' => 'ttd_kades', 'value' => null, 'group' => 'signature'],
            ['key' => 'ttd_sekdes', 'value' => null, 'group' => 'signature'],
            ['key' => 'qr_sertifikat', 'value' => '-', 'group' => 'signature'],
            ['key' => 'ttd_digital_aktif', 'value' => '1', 'group' => 'signature'],
            ['key' => 'qr_verifikasi_aktif', 'value' => '1', 'group' => 'signature'],

            // ─── Nomor Surat (letter_number) ───
            ['key' => 'format_nomor_surat', 'value' => '{prefix} / {no} / {suffix} / {tahun}', 'group' => 'letter_number'],
            ['key' => 'nomor_prefix', 'value' => '470', 'group' => 'letter_number'],
            ['key' => 'nomor_padding', 'value' => '4', 'group' => 'letter_number'],
            ['key' => 'nomor_reset', 'value' => 'tahunan', 'group' => 'letter_number'],
            ['key' => 'nomor_suffix', 'value' => 'DS-KP', 'group' => 'letter_number'],

            // ─── Workflow (workflow) ───
            ['key' => 'workflow_operator', 'value' => '1', 'group' => 'workflow'],
            ['key' => 'workflow_sekdes', 'value' => '1', 'group' => 'workflow'],
            ['key' => 'workflow_kades', 'value' => '1', 'group' => 'workflow'],
            ['key' => 'workflow_revision_limit', 'value' => '3', 'group' => 'workflow'],
            ['key' => 'workflow_sla_jam', 'value' => '48', 'group' => 'workflow'],
            ['key' => 'workflow_auto_complete', 'value' => '0', 'group' => 'workflow'],
            ['key' => 'workflow_reminder', 'value' => '1', 'group' => 'workflow'],

            // ─── Antrean (service_queue) ───
            ['key' => 'antrean_jam_mulai', 'value' => '09:00', 'group' => 'service_queue'],
            ['key' => 'antrean_jam_selesai', 'value' => '12:00', 'group' => 'service_queue'],
            ['key' => 'antrean_jam_istirahat', 'value' => '12:00-13:00', 'group' => 'service_queue'],
            ['key' => 'antrean_kuota_per_slot', 'value' => '1', 'group' => 'service_queue'],
            ['key' => 'antrean_durasi_slot', 'value' => '15', 'group' => 'service_queue'],
            ['key' => 'antrean_hari_aktif', 'value' => 'Senin,Selasa,Rabu,Kamis,Jumat', 'group' => 'service_queue'],
            ['key' => 'antrean_hari_libur', 'value' => '', 'group' => 'service_queue'],
            ['key' => 'antrean_auto_close', 'value' => '0', 'group' => 'service_queue'],

            // ─── Notifikasi (notification) ───
            ['key' => 'notif_telegram_token', 'value' => '', 'group' => 'notification'],
            ['key' => 'notif_telegram_chat_id', 'value' => '', 'group' => 'notification'],
            ['key' => 'notif_reminder_aktif', 'value' => '1', 'group' => 'notification'],

            // ─── Backup (backup) ───
            ['key' => 'backup_auto', 'value' => '1', 'group' => 'backup'],
            ['key' => 'backup_frekuensi', 'value' => 'harian', 'group' => 'backup'],
            ['key' => 'backup_retensi_hari', 'value' => '30', 'group' => 'backup'],
            ['key' => 'backup_google_drive', 'value' => '0', 'group' => 'backup'],
            ['key' => 'backup_dropbox', 'value' => '0', 'group' => 'backup'],
            ['key' => 'backup_onedrive', 'value' => '0', 'group' => 'backup'],

            // ─── Keamanan (security) ───
            ['key' => 'security_session_timeout', 'value' => '120', 'group' => 'security'],
            ['key' => 'security_rate_limit', 'value' => '60', 'group' => 'security'],
            ['key' => 'security_captcha_aktif', 'value' => '0', 'group' => 'security'],
            ['key' => 'security_audit_log_retensi', 'value' => '365', 'group' => 'security'],
            ['key' => 'security_2fa_wajib', 'value' => '0', 'group' => 'security'],
            ['key' => 'security_password_policy', 'value' => '1', 'group' => 'security'],
            ['key' => 'security_password_min_length', 'value' => '8', 'group' => 'security'],
            ['key' => 'security_ip_whitelist', 'value' => '', 'group' => 'security'],

            // ─── Integrasi (integration) ───
            ['key' => 'integrasi_maps_api_key', 'value' => '', 'group' => 'integration'],
            ['key' => 'integrasi_recaptcha_key', 'value' => '', 'group' => 'integration'],
            ['key' => 'integrasi_recaptcha_secret', 'value' => '', 'group' => 'integration'],
            ['key' => 'integrasi_turnstile_site_key', 'value' => '', 'group' => 'integration'],
            ['key' => 'integrasi_turnstile_secret_key', 'value' => '', 'group' => 'integration'],
            ['key' => 'integrasi_midtrans_server_key', 'value' => '', 'group' => 'integration'],
            ['key' => 'integrasi_midtrans_client_key', 'value' => '', 'group' => 'integration'],
            ['key' => 'integrasi_midtrans_environment', 'value' => 'sandbox', 'group' => 'integration'],
            ['key' => 'integrasi_webhook_url', 'value' => '', 'group' => 'integration'],

            // ─── Analytics (analytics) ───
            ['key' => 'analytics_refresh_interval', 'value' => '300', 'group' => 'analytics'],
            ['key' => 'analytics_cache_ttl', 'value' => '3600', 'group' => 'analytics'],
            ['key' => 'analytics_default_filter', 'value' => '30', 'group' => 'analytics'],
            ['key' => 'analytics_widget_aktif', 'value' => 'overview,trends,popular,processing,users,status', 'group' => 'analytics'],
            ['key' => 'analytics_retention_hari', 'value' => '365', 'group' => 'analytics'],

            // ─── Queue Driver (queue_driver) ───
            ['key' => 'queue_driver', 'value' => 'database', 'group' => 'queue_driver'],
            ['key' => 'queue_retry', 'value' => '3', 'group' => 'queue_driver'],
            ['key' => 'queue_timeout', 'value' => '300', 'group' => 'queue_driver'],
            ['key' => 'queue_worker_count', 'value' => '1', 'group' => 'queue_driver'],

            // ─── Tampilan (appearance) ───
            ['key' => 'tampilan_dark_mode', 'value' => '0', 'group' => 'appearance'],
            ['key' => 'tampilan_accent_color', 'value' => 'emerald', 'group' => 'appearance'],
            ['key' => 'logo_login', 'value' => null, 'group' => 'appearance'],
            ['key' => 'logo_sidebar', 'value' => null, 'group' => 'appearance'],
            ['key' => 'favicon', 'value' => null, 'group' => 'appearance'],
            ['key' => 'background_login', 'value' => null, 'group' => 'appearance'],
            ['key' => 'tampilan_sidebar_style', 'value' => 'default', 'group' => 'appearance'],
        ];

        foreach ($defaults as $item) {
            VillageSetting::updateOrCreate(
                ['key' => $item['key']],
                ['value' => $item['value'], 'group' => $item['group']]
            );
        }
    }
}
