# AGENTS.md - Prodesa

## Stack

Laravel 11, PHP ^8.2, MySQL (via Laragon), Tailwind CSS (CDN), Alpine.js, Chart.js.

## First-time setup

```bash
copy .env.example .env
php artisan key:generate
npm install && npm run build
```

`APP_KEY` must be generated before the app runs. SQLite extension `pdo_sqlite` and `zip` extension must be enabled in `php.ini`.

PHP and Composer via Laragon:
```powershell
$env:Path = "C:\laragon\bin\php\php-8.2.31-Win32-vs16-x64\;C:\laragon\bin\composer\;$env:Path"
php -d memory_limit=-1 C:\laragon\bin\composer\composer.phar require <package>
```

## Users & Auth

| Role | Login | Register |
|------|-------|----------|
| Warga | NIK + password via `/login` | Self-register via `/register` |
| Admin (any role != Warga) | NIK + password via `/login` | Only created manually via tinker |

**Roles available:** Super Admin, Operator Pelayanan, Sekretaris Desa, Kepala Desa, RT, RW, Warga.

Admin user created via:
```powershell
php artisan tinker --execute="\App\Models\User::create(['name'=>'Admin','nik'=>'0000000000000000','password'=>bcrypt('admin123'),'email'=>'admin@prodesa.id']);"
```

## Common commands

| What | How |
|------|-----|
| Dev server | `php artisan serve` |
| Vite dev | `npm run dev` (or `npm run build`) |
| Run all tests | `php artisan test` or `vendor/bin/phpunit` |
| Run single test | `vendor/bin/phpunit tests/Unit/ExampleTest.php` |
| Lint (Pint) | `vendor/bin/pint` |
| Migrate | `php artisan migrate` |
| Fresh migrate | `php artisan migrate:fresh` |
| Tinker | `php artisan tinker` |
| Seed all | `php artisan db:seed` |
| Seed specific | `php artisan db:seed --class=LetterConfigSeeder` |

## Routes

### Public (no auth)
| Route | Function |
|-------|----------|
| `/` | Landing page |
| `/berita/{slug}` | Public news detail |
| `/faq/ask` (POST) | AI FAQ assistant (throttled) |
| `/verifikasi/{hash}` | Public document verification via QR |
| `/antrean/{kodeQr}` | Public queue info by QR |

### Guest
| Route | Function |
|-------|----------|
| `/login` GET/POST | Login with NIK |
| `/register` GET/POST | Self-register warga |

### Auth (shared)
| Route | Function |
|-------|----------|
| `/logout` POST | Logout |

### Admin (`/admin/*`, middleware: auth + admin)
| Route | Permission | Function |
|-------|------------|----------|
| `/admin/dashboard` | `dashboard.view` | Admin dashboard with stats & recent submissions |
| `/admin/kades` | `letter.final_approve` | Panel Kepala Desa — pending approvals, quick approve/reject |
| `/admin/pengajuan` | `letter.view` | Pelayanan Surat — list with filter/search/pagination |
| `/admin/pengajuan/{id}` | `letter.view` | Detail berkas + workflow actions |
| `/admin/pengajuan/{id}/approve` POST | — | Approve (auto-transition based on role) |
| `/admin/pengajuan/{id}/reject` POST | — | Reject with catatan |
| `/admin/pengajuan/{id}/revision` POST | — | Request revision with catatan |
| `/admin/pengajuan/{id}/cetak` | `letter.print` | Download/completed PDF |
| `/admin/pengajuan/{id}/versions/*` | `letter.version.view` | Document version history |
| `/admin/warga` | `user.view` | Daftar warga |
| `/admin/users` | `user.view` | Manajemen pengguna |
| `/admin/users/{id}` | `user.view` | Detail pengguna |
| `/admin/users/{id}/role` PATCH | `user.assign_role` | Assign role |
| `/admin/roles` | `role.manage` | CRUD roles & permissions |
| `/admin/berita` | `news.manage` | CRUD berita |
| `/admin/events` | `event.manage` | CRUD events |
| `/admin/queue` | `queue.view` | Queue monitoring with charts |
| `/admin/queue/*` POST/DELETE | `queue.manage` | Retry/delete failed jobs |
| `/admin/analytics` | `analytics.view` | Analytics dashboard with CSV export |
| `/admin/pengaturan` | `setting.manage` | Village settings (nama desa, kecamatan, kades, etc.) |

### Warga (`/warga/*`, middleware: auth)
| Route | Function |
|-------|----------|
| `/warga/dashboard` | Warga dashboard with identity card, stats, queues, invitations |
| `/warga/surat` | Riwayat pengajuan surat |
| `/warga/surat/create/{jenis}` | Dynamic form driven by LetterConfig |
| `/warga/surat` POST | Simpan pengajuan |
| `/warga/surat/{id}` | Detail + timeline pengajuan |
| `/warga/surat/{id}/edit` | Revision form |
| `/warga/surat/{id}` PATCH | Resubmit after revision |
| `/warga/surat/{id}/cetak` | Download completed PDF |
| `/warga/surat/{id}` DELETE | Batalkan pengajuan (only submitted) |
| `/warga/events/{undangan}/konfirmasi` POST | Confirm event attendance |

## Roles & Permissions

| Role | Key Permissions |
|------|----------------|
| **Super Admin** | All permissions |
| **Operator Pelayanan** | `dashboard.view`, `user.view`, `letter.view`, `letter.create`, `letter.review`, `letter.cancel`, `letter.print`, `letter.download`, `letter.version.view`, `queue.view`, `queue.manage`, `setting.view`, `analytics.view` |
| **Sekretaris Desa** | `dashboard.view`, `user.view`, `letter.view`, `letter.verify`, `letter.reject`, `letter.print`, `letter.download`, `letter.version.view`, `letter.version.restore`, `analytics.view`, `queue.view`, `setting.view` |
| **Kepala Desa** | `dashboard.view`, `user.view`, `letter.view`, `letter.final_approve`, `letter.reject`, `letter.sign`, `letter.print`, `letter.download`, `letter.version.view`, `letter.version.restore`, `analytics.view`, `queue.view`, `setting.view` |
| **RT / RW** | `dashboard.view`, `letter.view`, `analytics.view` |
| **Warga** | `letter.create` |

## Database

- MySQL: database `prodesa`, user `root`, no password
- Key tables: `users`, `pengajuan_surats`, `approval_histories`, `document_versions`, `letter_configs`, `antrean_pengambilan`, `events`, `event_pesertas`, `berita`, `activity_logs`, `village_settings`, `permissions`, `roles`, `model_has_roles`, `model_has_permissions`
- `pengajuan_surats.data_tambahan` stores per-type form fields as JSON

## Architecture

### Approval Workflow
- `ApprovalService` handles all workflow logic (step map, permissions, transitions, timeline)
- Steps: `submitted → verified → approved_operator → approved_sekdes → approved_kades → completed`
- Reject/revision can happen at any step
- `PengajuanSurat` status tracks current workflow step
- Permissions: `letter.create` (warga), `letter.review` (operator), `letter.verify` (sekdes), `letter.final_approve` (kades)

### Letter Config System (Feature 6)
- `LetterConfig` model stores per-type config: fields JSON, body_template, kode_klasifikasi, masa_berlaku_bulan
- `DynamicLetterService` implements `LetterGeneratorInterface` using `LetterConfig::renderBody()`
- `LetterServiceFactory` resolves: existing strategies (sktm/ktp_sementara/akta) → DynamicLetterService fallback
- 14 letter types seeded: sktm, ktp_sementara, akta, sku, domisili, skkb, belum_menikah, izin_keramaian, ahli_waris, kepemilikan_tanah, pengantar_skck, penghasilan, janda_duda, pindah
- Form validation is dynamic via `LetterConfig::getValidationRules()`
- Form view renders fields dynamically (text, select, textarea, number, date, time)

### Document Versioning
- `DocumentVersionService` auto-creates version on each workflow transition
- `DocumentVersionController` provides index, show, diff, restore, download
- `DocumentVersionPolicy` gates access

### Queue Monitoring
- `QueueMonitoringService` fetches stats + failed jobs from `failed_jobs` table
- Chart.js weekly bar chart + status donut
- Retry single / retry all / delete failed jobs

### Analytics
- `AnalyticsService` with 8 metric methods (overview, trends, popular types, avg processing time, user growth, operator performance, status distribution, export CSV)
- 4 Chart.js charts (line, bar, donut, line)

### Conventions

- 4-space indentation, LF line endings (`.editorconfig`)
- Models in `app\Models\`, controllers in `app\Http\Controllers\`
- Routes: web in `routes/web.php`, commands in `routes/console.php`
- `bootstrap/app.php` is the Laravel 11 app config entrypoint
- No Breeze / Jetstream / auth scaffolding — custom auth via NIK
- Spatie Permission for RBAC (already installed)
- Service Layer pattern (ApprovalService, AnalyticsService, etc.)
- Strategy/Factory pattern (LetterServiceFactory + strategies)
- Transaction safety for multi-step operations
- Activity Log via `ActivityLog::catat()` model method
