<p align="center"><img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11"> <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2"> <img src="https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS"> <img src="https://img.shields.io/badge/Alpine.js-034A8E?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js"></p>

<h1 align="center">Prodesa — Portal Desa Digital</h1>

<p align="center">
Sistem informasi pemerintahan desa berbasis web untuk digitalisasi pelayanan administrasi kependudukan, ketatausahaan, pengelolaan aset, anggaran, dan laporan desa kuantitatif.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Developer-Rangga_Maulana-0ea5e9?style=for-the-badge&logo=laravel&logoColor=white" alt="Developer">
</p>

<p align="center">
  <a href="https://wa.me/6285176922584"><img src="https://img.shields.io/badge/WhatsApp-0851_7692_2584-25D366?style=for-the-badge&logo=whatsapp&logoColor=white" alt="WhatsApp"></a>
  <a href="https://instagram.com/rangga.mrw"><img src="https://img.shields.io/badge/Instagram-%40rangga.mrw-E4405F?style=for-the-badge&logo=instagram&logoColor=white" alt="Instagram"></a>
  <a href="https://github.com/ranggamaulana111111-bit"><img src="https://img.shields.io/badge/GitHub-ranggamaulana111111_bit-181717?style=for-the-badge&logo=github&logoColor=white" alt="GitHub"></a>
</p>

<p align="center">
<a href="#fitur">Fitur</a> &bull;
<a href="#tech-stack">Tech Stack</a> &bull;
<a href="#setup">Setup</a> &bull;
<a href="#roles--permissions">Roles</a> &bull;
<a href="#routes">Routes</a> &bull;
<a href="#testing">Testing</a> &bull;
<a href="#license">License</a>
</p>
<p align="center">
  <a href="https://desa.ranggamrw.my.id"><img src="https://img.shields.io/badge/DEMO-Prodesa_(GovTech)-00C7B7?style=for-the-badge&logo=google-chrome&logoColor=white" alt="Prodesa Live" /></a>
</p>
---

## Fitur

### Publik
- **Landing Page** — Hero, kartu layanan, counter statistik, berita, FAQ
- **Verifikasi Surat** — QR Code scan untuk validasi keaslian dokumen
- **Cek Antrean** — Info jadwal pengambilan surat via QR
- **FAQ Chatbot** — Chatbot keyword-matching

### Auth
- **Login/Register terpadu** — Wizard register 5 langkah, captcha matematika, Cloudflare Turnstile, atau reCAPTCHA
- **Lupa Password** — Reset via NIK + No. HP terdaftar

### Warga
- Dashboard dengan kartu identitas digital & 14 layanan surat
- Pengajuan surat via form dinamis (14 jenis surat)
- Timeline workflow real-time, revisi, cetak PDF, batalkan

### Admin
- **Dashboard** — Statistik, widget, system health monitoring
- **Panel Kepala Desa** — Approve/reject cepat, mini chart
- **Panel Sekretaris Desa** — Approval/revisi, monitoring pelayanan
- **Pelayanan Surat** — Full workflow: submit → verified → approved → completed
- **Ketatausahaan** — CRUD Surat Masuk (49 referensi), Surat Keluar, Disposisi
- **Inventaris & Aset** — Auto-generate kode, kondisi, status, nilai perolehan
- **APBDesa** — Anggaran vs realisasi per kategori/bidang
- **Laporan Desa Kuantitatif** — 9 modul, narasi akademis, 2 format PDF (surat resmi + LPPD)
- **Berita & Event** — CRUD + undangan massal per RT/RW
- **Lembaga Desa** — CRUD lembaga + role Lembaga (dashboard, berita, event, profil) + laporan kinerja
- **Manajemen Pengguna** — CRUD + role assignment
- **Template Surat** — CRUD LetterConfig (14 jenis surat dinamis) dari panel admin
- **Log Aktivitas** — Audit trail lengkap (view + hapus)
- **Monitoring Antrean** — Queue stats + Chart.js + retry/hapus failed job
- **Pengambilan Surat** — Scan QR antrean via kamera, cari manual, serahkan/tandai lewat
- **Notifikasi Telegram** — Pengajuan baru & surat selesai dikirim otomatis via Telegram Bot
- **Analitik** — 8 metrik + 4 chart + CSV export
- **Backup Database** — Snapshot SQL + storage (manual/jadwal, download/hapus)
- **Update Aplikasi** — Git pull + composer + migrate + npm build (khusus Super Admin)
- **Pengaturan Desa** — 16 tab key-value store (profil, ttd, nomor surat, workflow, keamanan, integrasi, maintenance, dll.)

---

## Tech Stack

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 11, PHP 8.2 |
| Database | MySQL 8 |
| Frontend | Tailwind CSS (CDN), Alpine.js 3.x |
| Chart | Chart.js |
| PDF | barryvdh/laravel-dompdf ^3.1 |
| QR Code | simplesoftwareio/simple-qrcode ^4.2 + html5-qrcode |
| Notifikasi | Telegram Bot API (HTTP) |
| RBAC | spatie/laravel-permission |
| Auth | Kustom (login berbasis NIK) |
| Testing | PHPUnit 10.5 (74 test) |

---

## Setup

```bash
# Clone & install
git clone https://github.com/ranggamaulana111111-bit/desamoderen.git prodesa
cd prodesa
composer install
npm install && npm run build

# Environment
cp .env.example .env
php artisan key:generate

# Database (MySQL)
php artisan migrate:fresh --seed

# Start
php artisan serve
npm run dev
```

> **Catatan:** `QUEUE_CONNECTION=sync` dipakai agar job (PDF + notifikasi) langsung berjalan tanpa worker. Konfigurasi token & chat ID Telegram diatur lewat **Pengaturan Desa → Notifikasi**.

### Requirements
- PHP 8.2+ (extensions: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `gd`, `zip`)
- MySQL 8
- Node.js 18+ (untuk build assets)

---

## Roles & Permissions

| Role | Akses Utama |
|---|---|
| **Super Admin** | Semua menu + role management |
| **Operator Pelayanan** | Pelayanan surat, ketatausahaan, inventaris, APBDesa, queue, analytics, lembaga |
| **Sekretaris Desa** | Panel Sekdes, approval surat, ketatausahaan, inventaris, APBDesa |
| **Kepala Desa** | Panel Kades, final approve, inventaris, APBDesa, audit log |
| **RT / RW** | Dashboard, pelayanan surat, analytics |
| **Warga** | Dashboard warga, pengajuan surat |
| **Lembaga** | Dashboard lembaga, CRUD berita/event/profil lembaga |

---

## Routes

### Public
| Method | URI | Deskripsi |
|---|---|---|
| GET | `/` | Landing page |
| GET | `/berita/{slug}` | Detail berita |
| POST | `/faq/ask` | FAQ chatbot |
| GET | `/verifikasi/{hash}` | Verifikasi surat via QR |
| GET | `/antrean/{kodeQr}` | Info antrean |

### Guest
| Method | URI | Deskripsi |
|---|---|---|
| GET/POST | `/login` | Login NIK (captcha) |
| GET/POST | `/register` | Register warga (wizard + captcha) |
| GET/POST | `/password/lupa` | Reset password via NIK + No HP |
| POST | `/captcha/refresh` | Ganti soal captcha |

### Admin
| Prefix | Deskripsi |
|---|---|
| `/admin/dashboard` | Dashboard admin |
| `/admin/kades` | Panel Kepala Desa |
| `/admin/sekdes` | Panel Sekretaris Desa |
| `/admin/pengajuan` | Pelayanan surat |
| `/admin/surat-masuk` | CRUD Surat Masuk |
| `/admin/surat-keluar` | CRUD Surat Keluar |
| `/admin/disposisi` | CRUD Disposisi |
| `/admin/inventaris` | CRUD Inventaris & Aset |
| `/admin/apbdesa` | CRUD APBDesa |
| `/admin/laporan` | Laporan Desa Kuantitatif |
| `/admin/users` | Manajemen pengguna |
| `/admin/roles` | Role & permission |
| `/admin/berita` | CRUD Berita |
| `/admin/events` | CRUD Event |
| `/admin/lembaga` | CRUD Lembaga desa |
| `/admin/laporan-lembaga` | Laporan kinerja lembaga |
| `/admin/queue` | Monitoring antrean |
| `/admin/queue/pickup` | Pengambilan surat (scan QR + serahkan dokumen) |
| `/admin/analytics` | Analitik & laporan |
| `/admin/template-surat` | CRUD template surat (LetterConfig) |
| `/admin/activity-log` | Log aktivitas |
| `/admin/pengaturan` | Pengaturan desa (16 tab, backup, update aplikasi) |

### Warga
| Prefix | Deskripsi |
|---|---|
| `/warga/dashboard` | Dashboard warga |
| `/warga/surat` | Riwayat & pengajuan surat |

### Lembaga
| Prefix | Deskripsi |
|---|---|
| `/lembaga/dashboard` | Dashboard lembaga |
| `/lembaga/profil` | Edit profil lembaga |
| `/lembaga/berita` | CRUD berita lembaga |
| `/lembaga/events` | CRUD event lembaga |

---

## Database

34 tabel meliputi: `users`, `pengajuan_surats`, `surat_masuks`, `surat_keluars`, `disposisis`, `approval_histories`, `document_versions`, `letter_configs`, `antrean_pengambilan`, `events`, `event_pesertas`, `berita`, `activity_logs`, `village_settings`, `setting_versions`, `user_settings`, `dashboard_layouts`, `lembagas`, `inventaris`, `apbdesa`, `laporan_desas`, dan tabel Spatie Permission.

---

## Testing

```bash
php artisan test
vendor/bin/phpunit tests/Feature/QrVerificationTest.php
```

---

## Security

- **Rate Limiting** — Login & FAQ endpoint (konfigurasi per pengaturan)
- **Captcha** — Matematika (default), Cloudflare Turnstile, atau Google reCAPTCHA di login/register/lupa password (prioritas Turnstile → reCAPTCHA → math)
- **IP Whitelist** — Middleware `ip.whitelist` di seluruh route admin
- **Encrypted Fields** — NIK, No KK, No HP (AES-256-CBC) + blind index (SHA-256)
- **RBAC** — Spatie Permission dengan 37 permission & 8 role
- **Audit Trail** — Semua aksi penting tercatat
- **Transaction + Lock** — Operasi multi-step dengan `DB::transaction` + `lockForUpdate`

---

## Credits

- **Developer** — Rangga Maulana | IG `@rangga.mrw` | WA `085176922584`
- **Framework** — [Laravel](https://laravel.com)

## License

MIT License.
