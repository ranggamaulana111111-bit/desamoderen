<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('setting.manage');
    }

    public function rules(): array
    {
        $category = $this->route('category');

        return match ($category) {
            'profil-desa' => $this->profileRules(),
            'pemerintahan' => $this->officialsRules(),
            'ttd-digital' => $this->signatureRules(),
            'nomor-surat' => $this->letterNumberRules(),
            'antrean' => $this->queueRules(),
            'workflow' => $this->workflowRules(),
            'notifikasi' => $this->notificationRules(),
            'tampilan' => $this->appearanceRules(),
            'backup' => $this->backupRules(),
            'keamanan' => $this->securityRules(),
            'integrasi' => $this->integrationRules(),
            'analytics' => $this->analyticsRules(),
            'queue-driver' => $this->queueDriverRules(),
            default => [],
        };
    }

    private function profileRules(): array
    {
        return [
            'nama_desa' => ['required', 'string', 'max:100'],
            'nama_provinsi' => ['required', 'string', 'max:100'],
            'nama_kabupaten' => ['required', 'string', 'max:100'],
            'nama_kecamatan' => ['required', 'string', 'max:100'],
            'kode_desa' => ['nullable', 'string', 'max:20'],
            'kode_pos' => ['required', 'string', 'max:10'],
            'alamat_kantor' => ['required', 'string', 'max:500'],
            'website_desa' => ['nullable', 'url', 'max:200'],
            'email_desa' => ['required', 'email', 'max:100'],
            'telepon_desa' => ['required', 'string', 'max:20'],
            'logo_desa' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'banner_desa' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:3072'],
            'foto_kantor' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:3072'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'deskripsi_desa' => ['nullable', 'string', 'max:2000'],
            'motto_desa' => ['nullable', 'string', 'max:200'],
        ];
    }

    private function officialsRules(): array
    {
        return [
            // Kepala Desa
            'nama_kades' => ['required', 'string', 'max:150'],
            'nip_kades' => ['nullable', 'string', 'max:30'],
            'nik_kades' => ['nullable', 'string', 'max:20'],
            'jabatan_kades' => ['required', 'string', 'max:150'],
            'foto_kades' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'periode_kades_mulai' => ['nullable', 'string', 'max:10'],
            'periode_kades_selesai' => ['nullable', 'string', 'max:10'],
            // Sekretaris Desa
            'nama_sekdes' => ['required', 'string', 'max:150'],
            'nip_sekdes' => ['nullable', 'string', 'max:30'],
            'nik_sekdes' => ['nullable', 'string', 'max:20'],
            // Kaur
            'kaur_keuangan_nama' => ['nullable', 'string', 'max:150'],
            'kaur_keuangan_nik' => ['nullable', 'string', 'max:20'],
            'kaur_perencanaan_nama' => ['nullable', 'string', 'max:150'],
            'kaur_perencanaan_nik' => ['nullable', 'string', 'max:20'],
            'kaur_tu_nama' => ['nullable', 'string', 'max:150'],
            'kaur_tu_nik' => ['nullable', 'string', 'max:20'],
            // Kasi
            'kasi_pemerintahan_nama' => ['nullable', 'string', 'max:150'],
            'kasi_pemerintahan_nik' => ['nullable', 'string', 'max:20'],
            'kasi_kesra_nama' => ['nullable', 'string', 'max:150'],
            'kasi_kesra_nik' => ['nullable', 'string', 'max:20'],
            'kasi_pelayanan_nama' => ['nullable', 'string', 'max:150'],
            'kasi_pelayanan_nik' => ['nullable', 'string', 'max:20'],
            // RT / RW
            'rt_list' => ['nullable', 'string', 'max:2000'],
            'rw_list' => ['nullable', 'string', 'max:2000'],
            // BPD
            'bpd_ketua_nama' => ['nullable', 'string', 'max:150'],
            'bpd_ketua_nik' => ['nullable', 'string', 'max:20'],
            'bpd_wakil_nama' => ['nullable', 'string', 'max:150'],
            'bpd_wakil_nik' => ['nullable', 'string', 'max:20'],
            'bpd_sekretaris_nama' => ['nullable', 'string', 'max:150'],
            'bpd_sekretaris_nik' => ['nullable', 'string', 'max:20'],
            // External
            'nama_camat' => ['nullable', 'string', 'max:150'],
            'nip_camat' => ['nullable', 'string', 'max:30'],
            'nama_operator' => ['nullable', 'string', 'max:150'],
        ];
    }

    private function signatureRules(): array
    {
        return [
            'stempel_desa' => ['nullable', 'image', 'mimes:png', 'max:1024'],
            'ttd_kades' => ['nullable', 'image', 'mimes:png', 'max:1024'],
            'ttd_sekdes' => ['nullable', 'image', 'mimes:png', 'max:1024'],
            'qr_sertifikat' => ['nullable', 'string', 'max:100'],
            'ttd_digital_aktif' => ['nullable', 'boolean'],
            'qr_verifikasi_aktif' => ['nullable', 'boolean'],
        ];
    }

    private function letterNumberRules(): array
    {
        return [
            'format_nomor_surat' => ['required', 'string', 'max:200'],
            'nomor_prefix' => ['nullable', 'string', 'max:20'],
            'nomor_padding' => ['nullable', 'integer', 'min:1', 'max:10'],
            'nomor_reset' => ['nullable', 'string', 'in:tahunan,bulanan,harian'],
            'nomor_suffix' => ['nullable', 'string', 'max:50'],
        ];
    }

    private function queueRules(): array
    {
        return [
            'antrean_jam_mulai' => ['required', 'date_format:H:i'],
            'antrean_jam_selesai' => ['required', 'date_format:H:i'],
            'antrean_jam_istirahat' => ['nullable', 'string', 'max:20'],
            'antrean_kuota_per_slot' => ['required', 'integer', 'min:1', 'max:50'],
            'antrean_durasi_slot' => ['nullable', 'integer', 'min:5', 'max:120'],
            'antrean_hari_aktif' => ['nullable', 'string', 'max:200'],
            'antrean_hari_libur' => ['nullable', 'string', 'max:500'],
            'antrean_auto_close' => ['nullable', 'boolean'],
        ];
    }

    private function workflowRules(): array
    {
        return [
            'workflow_operator' => ['nullable', 'boolean'],
            'workflow_sekdes' => ['nullable', 'boolean'],
            'workflow_kades' => ['nullable', 'boolean'],
            'workflow_revision_limit' => ['nullable', 'integer', 'min:0', 'max:10'],
            'workflow_sla_jam' => ['nullable', 'integer', 'min:1', 'max:720'],
            'workflow_auto_complete' => ['nullable', 'boolean'],
            'workflow_reminder' => ['nullable', 'boolean'],
        ];
    }

    private function notificationRules(): array
    {
        return [
            'notif_smtp_host' => ['nullable', 'string', 'max:200'],
            'notif_smtp_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'notif_smtp_email' => ['nullable', 'email', 'max:100'],
            'notif_smtp_password' => ['nullable', 'string', 'max:200'],
            'notif_wa_api_key' => ['nullable', 'string', 'max:200'],
            'notif_wa_nomor' => ['nullable', 'string', 'max:20'],
            'notif_telegram_token' => ['nullable', 'string', 'max:200'],
            'notif_telegram_chat_id' => ['nullable', 'string', 'max:100'],
            'notif_reminder_aktif' => ['nullable', 'boolean'],
        ];
    }

    private function appearanceRules(): array
    {
        return [
            'tampilan_dark_mode' => ['nullable', 'boolean'],
            'tampilan_accent_color' => ['nullable', 'string', 'max:50'],
            'logo_login' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'logo_sidebar' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:png,ico,svg', 'max:1024'],
            'background_login' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:3072'],
            'tampilan_sidebar_style' => ['nullable', 'string', 'in:default,compact,icon-only'],
        ];
    }

    private function backupRules(): array
    {
        return [
            'backup_auto' => ['nullable', 'boolean'],
            'backup_frekuensi' => ['nullable', 'string', 'in:harian,mingguan,bulanan'],
            'backup_retensi_hari' => ['nullable', 'integer', 'min:1', 'max:365'],
            'backup_google_drive' => ['nullable', 'boolean'],
            'backup_dropbox' => ['nullable', 'boolean'],
            'backup_onedrive' => ['nullable', 'boolean'],
        ];
    }

    private function securityRules(): array
    {
        return [
            'security_session_timeout' => ['nullable', 'integer', 'min:5', 'max:1440'],
            'security_rate_limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'security_captcha_aktif' => ['nullable', 'boolean'],
            'security_audit_log_retensi' => ['nullable', 'integer', 'min:30', 'max:3650'],
            'security_2fa_wajib' => ['nullable', 'boolean'],
            'security_password_policy' => ['nullable', 'boolean'],
            'security_password_min_length' => ['nullable', 'integer', 'min:6', 'max:64'],
            'security_ip_whitelist' => ['nullable', 'string', 'max:1000'],
        ];
    }

    private function integrationRules(): array
    {
        return [
            'integrasi_maps_api_key' => ['nullable', 'string', 'max:200'],
            'integrasi_recaptcha_key' => ['nullable', 'string', 'max:200'],
            'integrasi_recaptcha_secret' => ['nullable', 'string', 'max:200'],
            'integrasi_midtrans_server_key' => ['nullable', 'string', 'max:200'],
            'integrasi_midtrans_client_key' => ['nullable', 'string', 'max:200'],
            'integrasi_midtrans_environment' => ['nullable', 'string', 'in:sandbox,production'],
            'integrasi_webhook_url' => ['nullable', 'url', 'max:500'],
        ];
    }

    private function analyticsRules(): array
    {
        return [
            'analytics_refresh_interval' => ['nullable', 'integer', 'min:30', 'max:86400'],
            'analytics_cache_ttl' => ['nullable', 'integer', 'min:60', 'max:86400'],
            'analytics_default_filter' => ['nullable', 'string', 'in:7,30,90,365'],
            'analytics_widget_aktif' => ['nullable', 'string', 'max:500'],
            'analytics_retention_hari' => ['nullable', 'integer', 'min:30', 'max:3650'],
        ];
    }

    private function queueDriverRules(): array
    {
        return [
            'queue_driver' => ['nullable', 'string', 'in:database,redis,sync'],
            'queue_retry' => ['nullable', 'integer', 'min:0', 'max:10'],
            'queue_timeout' => ['nullable', 'integer', 'min:30', 'max:600'],
            'queue_worker_count' => ['nullable', 'integer', 'min:1', 'max:10'],
        ];
    }
}
