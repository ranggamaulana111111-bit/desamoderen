<p align="center"><img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11"> <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2"> <img src="https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS"> <img src="https://img.shields.io/badge/Alpine.js-034A8E?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js"></p>

<h1 align="center">Prodesa — Portal Desa Digital</h1>

<p align="center">
Sistem informasi pemerintahan desa berbasis web untuk digitalisasi pelayanan administrasi kependudukan, ketatausahaan, pengelolaan aset, anggaran, dan laporan desa kuantitatif.
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

---

## Fitur

### Publik
- **Landing Page** — Hero, kartu layanan, counter statistik, berita, FAQ
- **Verifikasi Surat** — QR Code scan untuk validasi keaslian dokumen
- **Cek Antrean** — Info jadwal pengambilan surat via QR
- **FAQ Chatbot** — Chatbot keyword-matching

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
- **Manajemen Pengguna** — CRUD + role assignment
- **Monitoring Antrean** — Queue stats + Chart.js
- **Analitik** — 8 metrik + 4 chart + CSV export
- **Pengaturan Desa** — Key-value store

---

## Tech Stack

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 11, PHP 8.2 |
| Database | MySQL 8 |
| Frontend | Tailwind CSS (CDN), Alpine.js 3.x |
| Chart | Chart.js |
| PDF | barryvdh/laravel-dompdf ^3.1 |
| QR Code | simplesoftwareio/simple-qrcode ^4.2 |
| RBAC | spatie/laravel-permission |
| Auth | Kustom (login berbasis NIK) |
| Testing | PHPUnit 10.5 |

---

## Setup

```bash
# Clone & install
git clone <repo-url> prodesa
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

### Requirements
- PHP 8.2+ (extensions: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `gd`, `zip`)
- MySQL 8
- Node.js 18+ (untuk build assets)

---

## Roles & Permissions

| Role | Akses Utama |
|---|---|
| **Super Admin** | Semua menu + role management |
| **Operator Pelayanan** | Pelayanan surat, ketatausahaan, inventaris, APBDesa, queue, analytics |
| **Sekretaris Desa** | Panel Sekdes, approval surat, ketatausahaan, inventaris, APBDesa |
| **Kepala Desa** | Panel Kades, final approve, inventaris, APBDesa |
| **RT / RW** | Dashboard, pelayanan surat, analytics |
| **Warga** | Dashboard warga, pengajuan surat |

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
| `/admin/queue` | Monitoring antrean |
| `/admin/analytics` | Analitik & laporan |
| `/admin/pengaturan` | Pengaturan desa |

### Warga
| Prefix | Deskripsi |
|---|---|
| `/warga/dashboard` | Dashboard warga |
| `/warga/surat` | Riwayat & pengajuan surat |

---

## Database

29 tabel utama meliputi: `users`, `pengajuan_surats`, `surat_masuks`, `surat_keluars`, `disposisis`, `approval_histories`, `document_versions`, `letter_configs`, `antrean_pengambilan`, `events`, `event_pesertas`, `berita`, `activity_logs`, `village_settings`, `inventaris`, `apbdesa`, `laporan_desas`, dan tabel Spatie Permission.

---

## Testing

```bash
php artisan test
vendor/bin/phpunit tests/Feature/QrVerificationTest.php
```

---

## Security

- **Rate Limiting** — Login & FAQ endpoint
- **Encrypted Fields** — NIK, No KK, No HP (AES-256-CBC) + blind index (SHA-256)
- **RBAC** — Spatie Permission dengan 30 permission
- **Audit Trail** — Semua aksi penting tercatat
- **Transaction + Lock** — Operasi multi-step dengan `DB::transaction` + `lockForUpdate`

---

## Credits

- **Developer** — IG `@rangga.mrw` | WA `085176922584`
- **Framework** — [Laravel](https://laravel.com)

## License

MIT License.
