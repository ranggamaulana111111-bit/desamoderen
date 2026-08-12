# Server & Deployment — Prodesa

Panduan konfigurasi server, deployment, dan maintenance aplikasi Prodesa
(Laravel 11 + PHP 8.2 + MySQL + Vite/Tailwind + Alpine.js + Chart.js).

---

## 1. Prasyarat (Requirements)

- **PHP >= 8.2** (di Laragon: `php-8.2.x-Win32-vs16-x64`)
- Ekstensi PHP wajib:
  `mbstring, xml, ctype, json, bcmath, openssl, tokenizer, fileinfo,`
  `pdo_mysql, curl, gd,`
  **`pdo_sqlite`** (dibutuhkan), **`zip`** (dibutuhkan)
- **Composer**
- **Node.js + npm** (build asset via Vite)
- **Git** (wajib untuk fitur "Update Aplikasi", lihat bagian 9)
- **MySQL** — database `prodesa`, user `root`, tanpa password (sesuai `.env.example`)

---

## 2. Setup Lokal (Laragon — Windows)

1. Clone repo ke folder Laragon, mis. `C:\laragon\www\prodesa`
   (harus **git clone**, bukan copy biasa — lihat bagian 9).
2. Di terminal Laragon, set PATH PHP & Composer:
   ```powershell
   $env:Path = "C:\laragon\bin\php\php-8.2.31-Win32-vs16-x64\;C:\laragon\bin\composer\;$env:Path"
   ```
3. Install dependency:
   ```powershell
   copy .env.example .env
   php artisan key:generate
   composer install
   npm install
   npm run build
   ```
4. Migrasi + seed:
   ```powershell
   php artisan migrate --seed
   ```
5. Jalankan:
   ```powershell
   php artisan serve      # http://127.0.0.1:8000
   ```
   Atau gunakan Apache Laragon (lihat bagian 4).

> Ekstensi `pdo_sqlite` dan `zip` harus aktif di `php.ini`.

---

## 3. Konfigurasi `.env`

| Key | Keterangan |
|-----|-----------|
| `APP_KEY` | Harus digenerate (`php artisan key:generate`). Aplikasi tidak jalan tanpa ini. |
| `APP_URL` | URL publik aplikasi (penting untuk link verifikasi QR, antrean, email). |
| `DB_CONNECTION` / `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | MySQL `prodesa`, `root`, kosong. |
| `QUEUE_CONNECTION` | `sync` (default di `.env.example`, job jalan inline) atau `database` (perlu worker, lihat 7). |
| `MAIL_*` | SMTP untuk notifikasi email (opsional tapi disarankan). |
| `CACHE_DRIVER` / `SESSION_DRIVER` | `file` aman untuk awal; `redis` disarankan di produksi. |

Setelah mengubah `.env`, jalankan:
```powershell
php artisan config:clear
php artisan optimize:clear
```

---

## 4. Web Server

### A. Laragon Apache (disarankan, Windows)
Buat virtual host dengan **document root mengarah ke folder `public/`**:
```
DocumentRoot "C:/laragon/www/prodesa/public"
<Directory "C:/laragon/www/prodesa/public">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```
Pastikan `mod_rewrite` aktif dan file `public/.htaccess` ada (bawaan Laravel).

### B. `php artisan serve` (hanya development)
```powershell
php artisan serve --host=0.0.0.0 --port=8000
```
Jangan gunakan untuk produksi.

### C. Produksi (Linux + Nginx/Apache)
- Document root = `public/`.
- Arahkan semua request ke `public/index.php` (front controller).
- Contoh Nginx:
  ```nginx
  root /var/www/prodesa/public;
  location / { try_files $uri $uri/ /index.php?$query_string; }
  location ~ \.php$ { include fastcgi_params; fastcgi_pass unix:/var/run/php/php8.2-fpm.sock; }
  ```

---

## 5. Izin Folder (Linux / Produksi)

```bash
sudo chown -R www-data:www-data /var/www/prodesa
sudo chmod -R 755 /var/www/prodesa
sudo chmod -R 775 /var/www/prodesa/storage /var/www/prodesa/bootstrap/cache
```
Folder `storage` dan `bootstrap/cache` harus writable oleh user web server.

---

## 6. Scheduler / Cron

Aplikasi menggunakan `Schedule` (`routes/console.php`) untuk:
- `BackupDatabase` — otomatis jika `backup_auto = 1` (frekuensi harian/mingguan/bulanan).
- `PruneAuditLogs` — membersihkan log audit tiap hari.

Tambahkan cron pada server (Linux):
```bash
* * * * * cd /var/www/prodesa && php artisan schedule:run >> /dev/null 2>&1
```
Di Windows (Laragon) jadwalkan task lewat Task Scheduler menjalankan
`php artisan schedule:run` setiap menit.

---

## 7. Queue Worker

Job `ProcessCompletedLetter` (`app/Jobs/ProcessCompletedLetter.php`) di-dispatch
saat surat selesai (`PengajuanSuratController::class` line ~181).

- Jika `QUEUE_CONNECTION=sync` → job berjalan langsung (inline), **tidak perlu worker**.
- Jika `QUEUE_CONNECTION=database` (atau `redis`) → butuh worker aktif agar job diproses:
  ```bash
  php artisan queue:work --queue=default --tries=3
  ```
  Di produksi jalankan via **supervisor** agar otomatis restart:
  ```ini
  [program:prodesa-queue]
  command=php /var/www/prodesa/artisan queue:work --queue=default --tries=3
  autostart=true
  autorestart=true
  user=www-data
  ```

Fitur monitoring antrean (`/admin/queue`) membaca tabel `failed_jobs` —
retry/delete dilakukan dari UI admin.

---

## 8. IP Whitelist Admin

Middleware `ip.whitelist` (`app/Http/Middleware/AdminIpWhitelist.php`)
melindungi seluruh route `/admin/*`.

- Diisi di **Admin → Pengaturan → Keamanan** (`security_ip_whitelist`),
  satu IP per baris atau dipisah koma.
- **Kosong = semua IP diizinkan** (default).
- Jika diisi dan IP request tidak cocok → `403 Access denied`.

> Pastikan IP server/proxy (mis. IP load balancer) tidak terblokir sendiri.
> Di balik reverse proxy, pastikan `TrustProxies` dikonfigurasi agar
> `Request::ip()` membaca IP asli (bukan IP proxy).

---

## 9. Fitur "Update Aplikasi" — Prasyarat PENTING (Windows)

Card **Admin → Pengaturan → Maintenance** menjalankan
`git pull --ff-only`, `composer install`, `php artisan migrate`,
`npm ci`, `npm run build`, `php artisan optimize:clear` lewat Symfony `Process`.

Agar fitur ini berfungsi di Windows:

1. **Git, Node, dan Composer harus ada di PATH proses yang men-service app**
   (`php artisan serve` / Apache Laragon). Di Windows, tambahkan
   `C:\Program Files\Git\cmd` ke PATH **sebelum** memulai server.
2. **Folder aplikasi harus hasil `git clone` dari repo**, bukan folder/copy biasa
   (agar terdeteksi sebagai repository git).
3. Server harus punya akses internet ke `origin` untuk `git fetch`.
4. **Gunakan array-form `Process(['git', ...])`, BUKAN `Process::fromShellCommandline()`**.
   Shell-form (`cmd.exe /c`) gagal resolve executable di dalam web request Laravel
   di Windows meskipun `git` ada di PATH — array-form reliable.

---

## 10. Reverse Proxy & HTTPS (Produksi)

- Terminasi SSL di reverse proxy (Nginx/Caddy/Cloudflare), lalu set:
  - `APP_URL=https://domain.desa`
  - `TrustProxies` agar skema `https` dan IP asli terbaca.
- Header yang diteruskan: `X-Forwarded-For`, `X-Forwarded-Proto=https`.
- Captcha login mendukung math / Cloudflare Turnstile / reCAPTCHA —
  setel via pengaturan sesuai provider yang dipakai.

---

## 11. Checklist Deployment Produksi

- [ ] `git clone` repo ke server (bukan copy).
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] `npm ci && npm run build`
- [ ] `cp .env.example .env` lalu isi `APP_KEY`, `APP_URL`, DB, mail, cache.
- [ ] `php artisan key:generate`
- [ ] `php artisan migrate --force`
- [ ] `php artisan storage:link`
- [ ] `php artisan config:cache && php artisan route:cache`
- [ ] Izin `storage/` & `bootstrap/cache/` writable (bagian 5).
- [ ] Cron `schedule:run` tiap menit (bagian 6).
- [ ] Queue worker via supervisor jika `QUEUE_CONNECTION != sync` (bagian 7).
- [ ] Document root = `public/` (bagian 4).
- [ ] IP whitelist admin disetel (bagian 8) — atau biarkan kosong untuk semua IP.
- [ ] HTTPS + TrustProxies (bagian 10).
- [ ] Backup otomatis aktif (`backup_auto = 1`) di Pengaturan.
