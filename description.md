# Prodesa (Portal Desa) — Digitalisasi Pelayanan Desa

<p align="center">
  <img src="https://img.shields.io/badge/Developer-Rangga_Maulana-0ea5e9?style=for-the-badge&logo=laravel&logoColor=white" alt="Developer">
</p>

<p align="center">
  <a href="https://wa.me/6285176922584"><img src="https://img.shields.io/badge/WhatsApp-0851_7692_2584-25D366?style=for-the-badge&logo=whatsapp&logoColor=white" alt="WhatsApp"></a>
  <a href="https://instagram.com/rangga.mrw"><img src="https://img.shields.io/badge/Instagram-%40rangga.mrw-E4405F?style=for-the-badge&logo=instagram&logoColor=white" alt="Instagram"></a>
  <a href="https://github.com/ranggamaulana111111-bit"><img src="https://img.shields.io/badge/GitHub-ranggamaulana111111_bit-181717?style=for-the-badge&logo=github&logoColor=white" alt="GitHub"></a>
</p>

**Prodesa** adalah aplikasi web desa digital (Web Desa) berbasis **Laravel 11** dan **PHP 8.2**, dirancang untuk memberikan layanan administrasi kependudukan secara online bagi warga **Desa Kumpay, Kecamatan Ciasem, Kabupaten Subang, Jawa Barat**. Aplikasi ini menggantikan proses birokrasi konvensional dengan sistem pengajuan surat secara daring yang cepat, transparan, dan terintegrasi, dilengkapi RBAC multi-level, workflow approval, manajemen dokumen, monitoring antrean, pengambilan surat via scan QR, notifikasi Telegram, analitik, ketatausahaan desa, inventaris & aset, APBDesa, serta laporan desa kuantitatif.

---

## Tech Stack

| Teknologi | Versi | Keterangan |
|---|---|---|
| **Framework** | Laravel 11 | Tanpa `Http/Kernel.php`, tanpa `Exceptions/Handler.php` |
| **PHP** | ^8.2 | Berjalan di PHP 8.2.31 |
| **Database** | MySQL 8 | database `prodesa`, user `root` tanpa password |
| **CSS Framework** | Tailwind CSS | CDN (`cdn.tailwindcss.com`) |
| **Frontend JS** | Alpine.js 3.x | Dropdown interaktif, modal, teleport, form reaktif |
| **Font** | Montserrat | via fontshare CDN (`components/fonts.blade.php`) |
| **Chart** | Chart.js | Chart pada dashboard admin, kades, sekdes, queue, analytics |
| **Calendar** | FullCalendar | Kalender event desa |
| **Build Tool** | Vite 5 + laravel-vite-plugin | HMR & build |
| **PDF Generation** | barryvdh/laravel-dompdf ^3.1 | Generate surat & laporan kuantitatif PDF |
| **QR Code** | simplesoftwareio/simple-qrcode ^4.2 + html5-qrcode | QR Code pada PDF, antrean, & scan kamera pickup |
| **Notifikasi** | Telegram Bot API (HTTP) | Pengajuan baru & surat selesai via bot |
| **RBAC** | spatie/laravel-permission | Role & permission management |
| **Auth** | Kustom (tanpa Breeze/Jetstream) | Login berbasis NIK |
| **Testing** | PHPUnit 10.5 + Collision 8.x | Unit & Feature test (41 test) |
| **Code Style** | Laravel Pint ^1.13 | PSR-12 berbasis Laravel |

---

## Fitur Aplikasi

### Fitur Publik (Tanpa Login)

| Fitur | Endpoint | Deskripsi |
|---|---|---|
| Landing Page | `/` | Hero section, kartu layanan, counter statistik, struktur organisasi desa, berita terbaru, FAQ accordion |
| Detail Berita | `/berita/{slug}` | Artikel berita desa lengkap |
| FAQ Chatbot | POST `/faq/ask` | Chatbot keyword-matching untuk pertanyaan layanan desa |
| Verifikasi Surat | `/verifikasi/{hash}` | Verifikasi keaslian surat via QR Code |
| Cek Antrean | `/antrean/{kodeQr}` | Info jadwal pengambilan surat via QR |

### Fitur Warga (Terautentikasi)

| Fitur | Endpoint | Deskripsi |
|---|---|---|
| Dashboard | `/warga/dashboard` | Kartu identitas digital, undangan aktif, antrean, statistik, alert revisi, 14 layanan surat, riwayat |
| Riwayat Surat | `/warga/surat` | Daftar pengajuan dengan status, aksi detail/perbaiki/batal/download PDF |
| Pengajuan Surat | `/warga/surat/create/{jenis}` | Form dinamis berdasarkan LetterConfig (14 jenis surat) |
| Detail & Timeline | `/warga/surat/{id}` | Info pengajuan lengkap dengan timeline workflow |
| Perbaiki Revisi | `/warga/surat/{id}/edit` | Form revisi dengan catatan admin |
| Cetak PDF | `/warga/surat/{id}/cetak` | Download PDF (jika status completed) |
| Batalkan | DELETE `/warga/surat/{id}` | Batalkan pengajuan (hanya status submitted) |
| Konfirmasi Event | POST `/warga/events/{undangan}/konfirmasi` | Hadir/izin/absen untuk undangan event |

### Fitur Admin

Akses dibagi berdasarkan role & permission. Menu sidebar menyesuaikan otomatis.

#### Dashboard & Panel Khusus

| Fitur | Endpoint | Permission | Deskripsi |
|---|---|---|---|
| **Dashboard** | `/admin/dashboard` | `dashboard.view` | Statistik + pengajuan terbaru + widget (notification, system info, audit log) |
| **Panel Kepala Desa** | `/admin/kades` | `letter.final_approve` | Khusus Kepala Desa — approve/reject cepat, riwayat ttd, mini chart |
| **Panel Sekretaris Desa** | `/admin/sekdes` | `letter.verify` | Khusus Sekretaris Desa — approval/revisi, monitoring pelayanan, statistik |

#### Pelayanan Surat & Ketatausahaan

| Fitur | Endpoint | Permission | Deskripsi |
|---|---|---|---|
| **Pelayanan Surat** | `/admin/pengajuan` | `letter.view` | List/filter/search/paginate pengajuan |
| **Detail Berkas** | `/admin/pengajuan/{id}` | `letter.view` | Info lengkap + workflow actions + versi dokumen |
| **Cetak PDF** | `/admin/pengajuan/{id}/cetak` | `letter.print` | Download PDF surat completed |
| **Versi Dokumen** | `/admin/pengajuan/{id}/versions/*` | `letter.version.view` | Riwayat versi, diff comparator, restore |
| **Surat Masuk** | `/admin/surat-masuk` | `office.view` | CRUD surat masuk (49 surat dari instansi) |
| **Surat Keluar** | `/admin/surat-keluar` | `office.view` | CRUD surat keluar ke instansi |
| **Disposisi** | `/admin/disposisi` | `office.view` | CRUD disposisi surat masuk |

#### Manajemen Aset & Anggaran

| Fitur | Endpoint | Permission | Deskripsi |
|---|---|---|---|
| **Inventaris & Aset** | `/admin/inventaris` | `inventaris.view` | CRUD inventaris desa dengan auto-generate kode barang, kondisi, status |
| **APBDesa** | `/admin/apbdesa` | `anggaran.view` | CRUD Anggaran Pendapatan dan Belanja Desa per tahun/bidang/kategori |

#### Pengelolaan Data & Informasi

| Fitur | Endpoint | Permission | Deskripsi |
|---|---|---|---|
| **Manajemen Pengguna** | `/admin/users` | `user.view` | CRUD pengguna & assign role |
| **Daftar Warga** | `/admin/warga` | `user.view` | List warga terdaftar |
| **Role & Permission** | `/admin/roles` | `role.manage` | CRUD role + sync permission |
| **Berita Desa** | `/admin/berita` | `news.manage` | CRUD berita (draft/publish) |
| **Kalender Event** | `/admin/events` | `event.manage` | CRUD event + undangan massal per RT/RW |

#### Monitoring & Analitik

| Fitur | Endpoint | Permission | Deskripsi |
|---|---|---|---|
| **Monitoring Antrean** | `/admin/queue` | `queue.view` | Statistik queue + Chart.js chart + failed jobs (retry/delete) |
| **Pengambilan Surat** | `/admin/queue/pickup` | `queue.view` / `queue.manage` | Scan QR antrean via kamera, cari manual (live filter), serahkan dokumen / tandai lewat |
| **Analitik & Laporan** | `/admin/analytics` | `analytics.view` | 8 metrik + 4 Chart.js chart + CSV export |
| **Pengaturan Desa** | `/admin/pengaturan` | `setting.manage` | Identitas desa, kades, stempel, ttd, jam antrean, konfigurasi notifikasi Telegram |

#### Laporan Desa Kuantitatif

| Fitur | Endpoint | Permission | Deskripsi |
|---|---|---|---|
| **Daftar Laporan** | `/admin/laporan` | `laporan.view` | List laporan dengan filter status/tipe |
| **Buat Laporan** | `/admin/laporan/create` | `laporan.manage` | 3-step wizard: pilih modul → preview data → generate |
| **Detail Laporan** | `/admin/laporan/{id}` | `laporan.view` | Lihat konten naratif + data per modul |
| **Edit Laporan** | `/admin/laporan/{id}/edit` | `laporan.manage` | Edit narasi per modul (section-based editor) |
| **Preview Data** | POST `/admin/laporan/preview` | `laporan.manage` | AJAX preview data modul tanpa simpan |
| **Generate PDF** | GET `/admin/laporan/{id}/pdf` | `laporan.download` | Download PDF (format surat resmi atau institusional) |
| **Finalisasi** | POST `/admin/laporan/{id}/finalize` | `laporan.finalize` | Kades/Super Admin finalisasi laporan |
| **Restore Draft** | POST `/admin/laporan/{id}/restore` | `laporan.finalize` | Kembalikan ke status draf |

**Modul Laporan (9 modul):**

| Modul | Label | Deskripsi |
|---|---|---|
| `profil_desa` | Profil Desa | Identitas, struktur, kontak desa |
| `kependudukan` | Kependudukan | Jumlah warga, pertumbuhan, distribusi RT/RW |
| `pelayanan_surat` | Pelayanan Surat | Statistik pengajuan, penyelesaian, jenis terbanyak |
| `ketatausahaan` | Ketatausahaan | Surat masuk/keluar, disposisi |
| `inventaris_aset` | Inventaris & Aset | Jumlah item, nilai, kondisi, kategori |
| `anggaran` | APBDesa | Anggaran vs realisasi per kategori/bidang |
| `kegiatan` | Kegiatan & Event | Jumlah kegiatan, partisipasi warga |
| `berita_informasi` | Berita & Informasi | Publikasi berita, status |
| `kesimpulan` | Kesimpulan & Rekomendasi | Auto-generated dari data modul lain |

**Format PDF:**
- **Surat Resmi** — Kop surat pemerintah desa, nomor surat, format formal
- **Laporan Institusional (LPPD)** — Cover page, kata pengantar, daftar isi, lampiran data

---

## Roles & Permissions (RBAC)

| Role | Login redirect | Menu sidebar yang terlihat |
|---|---|---|
| **Super Admin** | `/admin/dashboard` | Semua menu |
| **Operator Pelayanan** | `/admin/dashboard` | Dashboard, Pelayanan Surat, Ketatausahaan, Inventaris, APBDesa, Manajemen Pengguna, Monitoring Antrean, **Pengambilan Surat**, Analitik, Laporan, Pengaturan |
| **Sekretaris Desa** | `/admin/dashboard` | Dashboard, **Panel Sekdes**, Pelayanan Surat, Ketatausahaan, Inventaris, APBDesa, Manajemen Pengguna, Analitik, Monitoring Antrean, **Pengambilan Surat**, Laporan, Pengaturan |
| **Kepala Desa** | `/admin/dashboard` | Dashboard, **Panel Kades**, Pelayanan Surat, Ketatausahaan, Inventaris, APBDesa, Manajemen Pengguna, Analitik, Monitoring Antrean, **Pengambilan Surat**, Laporan, Pengaturan |
| **RT / RW** | `/admin/dashboard` | Dashboard, Pelayanan Surat, Analitik |
| **Warga** | `/warga/dashboard` | Panel warga (bukan admin) |

Permission key yang digunakan:

| Permission | Pemilik |
|---|---|
| `dashboard.view` | Semua non-Warga |
| `user.view` | Operator, Sekdes, Kades |
| `user.assign_role` | Super Admin |
| `letter.view` | Semua non-Warga |
| `letter.create` | Warga |
| `letter.review` | Operator |
| `letter.verify` | Sekdes |
| `letter.final_approve` | Kepala Desa, Super Admin |
| `letter.reject` | Sekdes, Kades |
| `letter.sign` | Kades |
| `letter.print` | Operator, Sekdes, Kades |
| `letter.download` | Operator, Sekdes, Kades |
| `letter.version.view` | Operator, Sekdes, Kades |
| `letter.version.restore` | Sekdes, Kades |
| `office.view` | Operator, Sekdes, Kades |
| `office.manage` | Operator |
| `inventaris.view` | Operator, Sekdes, Kades |
| `inventaris.manage` | Operator |
| `anggaran.view` | Operator, Sekdes, Kades |
| `anggaran.manage` | Operator |
| `queue.view` | Operator, Sekdes, Kades |
| `queue.manage` | Operator |
| `analytics.view` | Semua non-Warga |
| `setting.manage` | Operator, Sekdes, Kades |
| `role.manage` | Super Admin |
| `news.manage` | Super Admin |
| `event.manage` | Super Admin |
| `laporan.view` | Operator, Sekdes, Kades |
| `laporan.manage` | Operator, Sekdes, Kades |
| `laporan.download` | Operator, Sekdes, Kades |
| `laporan.finalize` | Kepala Desa, Super Admin |

---

## Alur Pengajuan Surat (Multi-Step Workflow)

```
Warga → submitted
  ↓
Operator → verified (letter.review)
  ↓
Operator → approved_operator (letter.review)
  ↓
Sekdes → approved_sekdes (letter.verify)
  ↓
Kades → completed (letter.final_approve)
    ↳ Generate hash verifikasi
    ↳ Alokasi slot antrean (nomor + kode QR)
    ↳ Dispatch queue job (generate PDF + notifikasi Telegram)
```

Setiap step bisa **reject** (ke status terminal) atau **revision** (kembali ke warga untuk diperbaiki, status `revision`). Warga memperbaiki lalu resubmit → kembali ke `submitted`.

Service: `ApprovalService` — menangani step map, permission check, transisi, timeline.

---

## Letter Config System (Dynamic Template Engine)

14 jenis surat dikonfigurasi via tabel `letter_configs`, bukan hardcode:

| Jenis Surat | Kode Klasifikasi | Masa Berlaku |
|---|---|---|
| SKTM | 460 | 3 bulan |
| KTP Sementara | 471 | 1 bulan |
| Akta | 472 | 3 bulan |
| SKU | 473 | 6 bulan |
| Domisili | 474 | 12 bulan |
| SKKB | 475 | 6 bulan |
| Belum Menikah | 476 | 3 bulan |
| Izin Keramaian | 477 | - |
| Ahli Waris | 478 | - |
| Kepemilikan Tanah | 479 | - |
| Pengantar SKCK | 480 | 3 bulan |
| Penghasilan | 481 | 3 bulan |
| Janda/Duda | 482 | 6 bulan |
| Pindah | 483 | 1 bulan |

**Cara kerja:**
- `LetterConfig` model: `fields` (JSON), `body_template`, `kode_klasifikasi`, `masa_berlaku_bulan`, `requirements` (daftar dokumen wajib)
- `DynamicLetterService` implements `LetterGeneratorInterface` — render body dari template
- `LetterServiceFactory::make()` → cek existing strategy (sktm/ktp_sementara/akta) → fallback ke `DynamicLetterService`
- Form warga: render field dinamis (text, select, textarea, number, date, time) dari `LetterConfig.fields` + kotak "Dokumen yang Wajib Dilampirkan" dari `requirements`
- Validasi: `LetterConfig::getValidationRules()` generate rules otomatis
- PDF: `pdf/template_dynamic.blade.php` dengan `{{ $rendered_body }}` hasil `LetterConfig::renderBody()`

---

## Document Versioning

Setiap transisi workflow otomatis membuat versi dokumen baru (via `DocumentVersionService`).

- **Trigger:** `ApprovalService@transition` → `DocumentVersionService@createVersion`
- **Fitur:** Lihat riwayat versi, diff comparator (perubahan data), restore versi lama, download versi tertentu
- **View:** `admin/pengajuan/versions/*` — index, show, diff, restore, download
- **Policy:** `DocumentVersionPolicy` — gates akses per permission

---

## Queue Monitoring

Dashboard monitoring antrean job Laravel:

- **Stats:** Total jobs, sukses, gagal, antrean saat ini
- **Chart.js:** Bar chart mingguan + donut chart distribusi status
- **Failed jobs:** Tabel dengan aksi retry single / retry all / delete
- **Service:** `QueueMonitoringService` — query tabel `jobs` + `failed_jobs`
- **Catatan:** aplikasi memakai `QUEUE_CONNECTION=sync` sehingga job berjalan langsung tanpa worker

---

## Pengambilan Surat (QR Pickup)

Alur pengambilan dokumen selesai diproses oleh petugas:

- **Antrean dibuat otomatis** saat surat `completed` — `nomor_antrean`, slot jadwal, `kode_qr` (unik)
- **Halaman publik** `/antrean/{kodeQr}` — warga melihat nomor antrean & jadwal pengambilan
- **Halaman admin** `/admin/queue/pickup` (`AntreanController`):
  - **Scan kamera** via html5-qrcode (getCameras + start/stop)
  - **Cari manual** dengan live filter (nomor antrean / kode QR / nama / NIK / jenis surat)
  - **Detail antrean** — pemohon, NIK, jenis surat, jadwal, nomor surat
  - **Serahkan Dokumen** (`proses`) → status `diambil`
  - **Tandai Lewat** (`lewat`) → status `lewat`
- Setiap aksi dicatat di `activity_logs` (`antrean_diambil` / `antrean_lewat`)
- Akses: `queue.view` untuk melihat, `queue.manage` untuk memproses

---

## Analytics Dashboard

8 metode metrik di `AnalyticsService`:

| Metode | Deskripsi |
|---|---|
| `overview()` | Total warga, surat, bulan ini, rata-rata/hari |
| `trends()` | Pengajuan per bulan (6 bulan) |
| `popularTypes()` | Jenis surat paling banyak diajukan |
| `avgProcessingTime()` | Rata-rata waktu selesai per jenis surat (jam) |
| `userGrowth()` | Pendaftaran warga per bulan |
| `operatorPerformance()` | Jumlah surat diproses per operator |
| `statusDistribution()` | Distribusi status semua pengajuan |
| `exportData()` | Data mentah untuk CSV export |

4 Chart.js charts: line (trend), bar (popular types), donut (status), line (user growth).

---

## Laporan Desa Kuantitatif

Fitur pembuatan laporan desa berbasis data kuantitatif dengan narasi analitis bergaya akademis.

### Arsitektur

| Komponen | Deskripsi |
|---|---|
| `LaporanService` | Gather data 9 modul + generate narasi akademis per modul + auto-generate kesimpulan |
| `LaporanController` | 11 metode: CRUD, preview data, generate PDF, finalisasi, restore |
| `LaporanDesa` | Model (SoftDeletes, uuid, auto nomor_laporan, status draft/finalisasi) |
| PDF Templates | 2 format: surat resmi (kop surat) + institusional (LPPD: cover, kata pengantar, daftar isi, lampiran) |

### Gaya Penulisan Naratif

Setiap modul menghasilkan narasi akademis dengan struktur:
- **Sub-heading** dengan border-bottom sebagai pembuka topik
- Paragraf mengalir dengan analisis data, persentase, dan rasio
- **Implikasi/Penilaian** sebagai penutup setiap modul
- Format: `text-indent: 1.2cm` (standar akademis Indonesia)

### Workflow

```
Operator/Sekdes/Kades → Buat Laporan
  ↓ (pilih modul, atur periode)
  ↓ (preview data AJAX)
  ↓ (simpan draf dengan narasi auto-generated)
  ↓ (edit narasi per modul)
  ↓
Kepala Desa → Finalisasi
  ↓ (status: draft → finalisasi)
  ↓ (generate PDF)
Kades/Super Admin → Restore (jika perlu koreksi)
```

---

## Database

### Tabel

| Tabel | Fungsi |
|---|---|
| `users` | Data warga & admin (dengan encrypted cast + blind index) |
| `pengajuan_surats` | Pengajuan surat, `data_tambahan` JSON, status workflow |
| `surat_masuks` | Surat masuk dari instansi (49 surat referensi) |
| `surat_keluars` | Surat keluar ke instansi |
| `disposisis` | Disposisi surat masuk |
| `approval_histories` | Riwayat setiap transisi workflow (step, status, catatan, user) |
| `document_versions` | Versi dokumen per transisi (snapshot `data_tambahan`, diff) |
| `letter_configs` | Konfigurasi per jenis surat (fields JSON, body_template) |
| `antrean_pengambilan` | Slot antrean pengambilan dokumen |
| `events` | Event/kegiatan desa |
| `event_pesertas` | Undangan + konfirmasi kehadiran |
| `berita` | Artikel berita desa |
| `activity_logs` | Audit trail aksi admin |
| `village_settings` | Key-value store pengaturan desa |
| `inventaris` | Inventaris & aset desa (kode, nama, kategori, kondisi, nilai perolehan) |
| `apbdesa` | Anggaran Pendapatan dan Belanja Desa (tahun, kategori, bidang, anggaran, realisasi) |
| `laporan_desas` | Laporan Desa Kuantitatif (judul, periode, modul, konten_naratif JSON, status) |
| `permissions` | Spatie Permission |
| `roles` | Spatie Role |
| `model_has_roles` | Spatie Pivot |
| `model_has_permissions` | Spatie Pivot |
| `jobs` / `failed_jobs` | Queue |

### Entity Relationship

```
users (1) ———< (N) pengajuan_surats
users (1) ———< (N) approval_histories
users (1) ———< (N) berita
users (1) ———< (N) events
users (1) ———< (N) surat_masuks
users (1) ———< (N) surat_keluars
users (1) ———< (N) disposisis
users (1) ———< (N) inventaris
users (1) ———< (N) apbdesa
users (1) ———< (N) laporan_desas
events (1) ———< (N) event_peserta ———> (1) users
pengajuan_surats (1) ———< (1) antrean_pengambilan
pengajuan_surats (1) ———< (N) document_versions
pengajuan_surats (1) ———< (N) approval_histories
disposisis (N) ———> (1) surat_masuks
letter_configs (independen — lookup oleh jenis_surat)
village_settings (key-value store)
```

---

## Arsitektur

### Service Layer Pattern

| Service | Tanggung Jawab |
|---|---|
| `ApprovalService` | Workflow logic, step map, permissions, transitions, timeline |
| `AnalyticsService` | 8 metrik + data export |
| `QueueMonitoringService` | Queue stats + failed jobs |
| `DocumentVersionService` | Auto-create version, diff, restore |
| `DynamicLetterService` | Render body surat dari LetterConfig (14 jenis surat) |
| `LaporanService` | Gather data 9 modul + narasi akademis + kesimpulan otomatis |

### Strategy / Factory Pattern

- `LetterGeneratorInterface` — kontrak untuk generate data PDF
- `LetterServiceFactory::make()` — resolve strategy berdasarkan jenis surat
  - `SktmLetterService` (existing)
  - `KtpSementaraLetterService` (existing)
  - `AktaLetterService` (existing)
  - `DynamicLetterService` (fallback — driven by LetterConfig)

### Blinding Index (UU PDP)

Kolom sensitif dienkripsi AES-256-CBC via `encrypted` cast, dengan blind index untuk pencarian:

| Kolom | Tipe | Enkripsi | Fungsi |
|---|---|---|---|
| `nik` | encrypted | AES-256-CBC | Data asli |
| `nik_hash` | string(64), unique | SHA-256 + APP_KEY | Blind index login |
| `no_kk` | encrypted | AES-256-CBC | Data asli |
| `no_hp` | encrypted | AES-256-CBC | Data asli |

### Audit Trail

Semua aksi penting dicatat via `ActivityLog::catat()`: create/approve/reject/revision pengajuan, CRUD berita, update pengaturan, CRUD inventaris, CRUD APBDesa, CRUD surat masuk/keluar, CRUD disposisi, laporan desa.

### Queue (Async PDF Generation)

`ProcessCompletedLetter` job di-dispatch saat surat selesai (via `QUEUE_CONNECTION=sync`):
- Generate PDF via DomPDF + Strategy Pattern
- Simpan ke `storage/app/private/surat/`
- Update `pdf_path` di `pengajuan_surats`
- Kirim notifikasi Telegram (surat selesai + jadwal ambil) via `TelegramNotifier`

### Pessimistic Lock

Slot antrean menggunakan `lockForUpdate()` untuk mencegah over-capacity pada konkurensi tinggi.

---

## Struktur View (Blade)

```
resources/views/
├── home.blade.php
├── components/{favicon,fonts}.blade.php
├── auth/{login,register}.blade.php
├── berita/show.blade.php
├── verifikasi/show.blade.php
├── antrean/show.blade.php
├── warga/
│   ├── dashboard.blade.php
│   └── surat/{index,show,form,edit}.blade.php
├── admin/
│   ├── components/sidebar.blade.php
│   ├── {dashboard, kades/dashboard, sekdes/dashboard}.blade.php
│   ├── pengajuan/{index,show,versions,version-show,version-diff}.blade.php
│   ├── warga/index.blade.php
│   ├── users/{index,show,create}.blade.php
│   ├── roles/{index,create,edit}.blade.php
│   ├── berita/{index,show,create,edit}.blade.php
│   ├── events/{index,create,edit,show}.blade.php
│   ├── surat-masuk/{index,create,show,edit}.blade.php
│   ├── surat-keluar/{index,create,show,edit}.blade.php
│   ├── disposisi/{index,create,show,edit}.blade.php
│   ├── inventaris/{index,create,show,edit}.blade.php
│   ├── apbdesa/{index,create,show,edit}.blade.php
│   ├── laporan/{index,create,show,edit}.blade.php
│   ├── queue/{index,pickup}.blade.php
│   ├── analytics/index.blade.php
│   └── setting/index.blade.php
├── pdf/
│   ├── template_{sktm,ktp_sementara,akta,dynamic}.blade.php
│   ├── laporan_surat_resmi.blade.php
│   └── laporan_institusional.blade.php
```

---

## Struktur Route Ringkas

### Public
`/` → Home, `/berita/{slug}`, POST `/faq/ask`, `/verifikasi/{hash}`, `/antrean/{kodeQr}`

### Guest
`/login` GET/POST, `/register` GET/POST

### Auth
POST `/logout`

### Admin — middleware: auth + admin (role != Warga)
`/admin/dashboard` • `/admin/kades` • `/admin/sekdes` • `/admin/pengajuan/*` • `/admin/warga` • `/admin/users/*` • `/admin/roles/*` • `/admin/berita/*` • `/admin/events/*` • `/admin/surat-masuk/*` • `/admin/surat-keluar/*` • `/admin/disposisi/*` • `/admin/inventaris/*` • `/admin/apbdesa/*` • `/admin/laporan/*` • `/admin/queue/*` (termasuk `/admin/queue/pickup`) • `/admin/analytics/*` • `/admin/pengaturan`

### Warga — middleware: auth
`/warga/dashboard` • `/warga/surat/*` • `/warga/events/{undangan}/konfirmasi`

---

## Migrasi

| File | Tujuan |
|---|---|
| 26 migrasi dari `0001_01_01_000000` sampai `2026_07_11_000006` | Users, cache, jobs, berita, pengajuan_surats (+6 alter), village_settings, antrean, events, peserta, activity_logs, nik_hash, pdf_path, permissions (spatie), approval_histories, letter_configs, document_versions, jenis_surat string |
| `2026_07_13_160000_create_inventaris_table` | Inventaris & aset desa (16 kolom, SoftDeletes, uuid) |
| `2026_07_13_160100_create_apbdesa_table` | APBDesa (13 kolom, SoftDeletes, uuid) |
| `2026_07_14_170000_create_laporan_desas_table` | Laporan Desa Kuantitatif (20 kolom, index, SoftDeletes, uuid) |

## Seeder

| Seeder | Fungsi |
|---|---|
| `VillageSettingSeeder` | Pengaturan default desa (profil, officials, signature, nomor surat, workflow, antrean, notifikasi Telegram, backup, keamanan, integrasi, analytics, queue, tampilan) |
| `RolePermissionSeeder` | 30 permission + 7 role + sync |
| `AdminUserSeeder` | User admin (NIK 0000000000000000) |
| `LetterConfigSeeder` | 14 konfigurasi jenis surat (termasuk `requirements` dokumen wajib) |

---

## Testing

```bash
php artisan test
vendor/bin/phpunit tests/Feature/QrVerificationTest.php
vendor/bin/phpunit tests/Feature/AntreanPickupTest.php
```

Konfigurasi test menggunakan SQLite `:memory:` (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`) dengan `CACHE_STORE=array`, `SESSION_DRIVER=array`, dan `QUEUE_CONNECTION=sync`. Total **41 test / 109 assertions**.

---

## Keamanan

- **Rate limit:** Login (5/menit/IP), FAQ (10/menit/IP)
- **File upload:** MIME double-check (mimes + mimetypes), max 2MB, nama tersanitasi
- **Transaction + lock:** Setiap operasi multi-step dibungkus `DB::transaction` + `lockForUpdate`
- **Policy:** `PengajuanSuratPolicy`, `DocumentVersionPolicy`
- **Auth:** NIK sebagai identitas + bcrypt password
- **Error pages:** 403, 404, 500 dengan branding desa
