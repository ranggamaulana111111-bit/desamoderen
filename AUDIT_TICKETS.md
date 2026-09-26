# Audit Prodesa — Laporan Tiket

Tanggal audit: 22 Sep 2026
Status: **SELESAI DIPERBAIKI** (25 tiket DONE + M-04/M-05 dituntaskan 23 Sep 2026). Verifikasi: `php artisan test` → 98 passed (289 assertions), Pint bersih.
Label: `[C]` Critical · `[H]` High · `[M]` Medium · `[L]` Low · `[B]` Build/Env

---

Bug manual (dilaporkan pengguna):
1. ~~notifikasi oprator di dashboard~~ — **DIPERBAIKI**: notifikasi kini role-aware & dinamis (dari `getWorkflowSteps()`/`getPendingStatusesForPermission()`) di `DashboardService`, `HeaderWidget`, `NotificationWidget` (operator/sekdes/kades masing-masing melihat antrean sesuai rantai workflow aktif). Bukan lagi hardcode `status=submitted`. **Perbaikan lanjutan 23 Sep 2026** — notifikasi approval di-agregat per aksi (satu baris per permission, total dijumlah) sehingga Super Admin tidak lagi melihat 4 baris identik "X menunggu verifikasi" & operator 2 baris identik; pesan dibedakan (`verifikasi` / `verifikasi Sekretaris Desa` / `tanda tangan Kepala Desa`) + label badge sinkron dengan jumlah baris. Regresi: `tests/Feature/NotifWidgetTest.php`.
2. ~~ga bisa di edit berita di admin~~ — **TIDAK TEREPRODUKSI**: backend & view edit berfungsi normal; ditambah test regresi `tests/Feature/BeritaEditTest.php` (edit page renders + PUT update) + verifikasi browser pada `/admin/berita/{id}/edit` (form terisi, tanpa error).
## KATEGORI BACKEND — LOGIKA & KEAMANAN

### C-01 — Lupa password = takeover akun penuh
- File: `app/Http/Controllers/Auth/AuthController.php:222-266, 279-314`
- Masalah: `forgot()` hanya mengecek email + captcha lalu mengembalikan **token reset langsung di URL redirect** ke pemohon (baris 262-265). Tidak ada email/SMS dikirim ke pemilik akun. Cek `no_hp` **dilewati** bila `no_hp` adalah NULL (baris 249) — dan `no_hp` nullable di registrasi & pembuatan admin.
- Dampak: Siapa pun yang tahu email (mis. `admin@prodesa.id`) bisa reset password akun. Untuk akun tanpa no_hp, butuh 0 faktor kedua.
- Perbaikan: Kirim token out-of-band (email/Telegram/SMS); jangan pernah melewati cek no_hp; pesan error seragam (hindari enumerasi email).

### C-02 — RT/RW bisa membuka & mengunduh seluruh data pribadi warga
- File: `app/Http/Middleware/AdminMiddleware.php:19-20` + `app/Policies/PengajuanSuratPolicy.php:11-18,37-44` + `PengajuanSuratController` (index/show/downloadLampiran) + `AnalyticsService::getExportData` (~baris 237, NIK diekspor CSV)
- Masalah: AdminMiddleware meloloskan role apa pun selain `Warga`/`Lembaga` (termasuk RT/RW). RT/RW memegang `letter.view` dan `analytics.view`. Daftar/detail pengajuan tidak di-scope wilayah, dan lampiran (KTP/KK) + CSV berisi NIK penuh bisa diunduh.
- Dampak: RT bisa melihat & mengunduh lampiran KTP/KK semua warga desa; CSV analytics berisi NIK penuh.
- Perbaikan: Scope kuery per RT/RW atau lepaskan `letter.view` dari RT/RW; hapus NIK dari CSV atau gating export lebih ketat.

### C-03 — Hapus user = hapus riwayat surat & audit trail (cascade)
- File: `app/Http/Controllers/Admin/UserManagementController.php:119` + migrasi `pengajuan_surats.user_id` (cascade), `approval_histories.user_id` (cascade), `antrean_pengambilan` (cascade)
- Masalah: `$user->delete()` hard-delete. Menghapus warga menghapus semua `pengajuan_surats`, `approval_histories`, `document_versions`, `antrean`. Menghapus admin menghapus semua approval yang pernah ia lakukan.
- Dampak: Arsip surat desa & jejak audit hilang permanen.
- Perbaikan: Soft-delete user; ubah FK jadi `nullOnDelete`/`restrict` untuk approval_histories; blokir hapus bila user memiliki pengajuan.

### C-04 — Approve/reject/revision: tanpa middleware permission & rawan HTTP 500
- File: `routes/web.php:120-122` (tanpa `permission:`) + `app/Policies/PengajuanSuratPolicy.php:20-35` + `app/Services/ApprovalService.php:83-85` (throw uncaught `InvalidArgumentException`)
- Masalah: Policy `approve()` lolos untuk siapa pun yang punya salah satu dari `letter.review/verify/final_approve` di status apa pun; `canReject` lolos (rank 0) untuk revisi/completed; controller tidak menangkap exception.
- Dampak: POST crafted (approve di `approved_sekdes`, reject di `revision`, dst.) → 500 alih-alih 403, atau aksi yang tidak sah.
- Perbaikan: Delegasikan policy ke `ApprovalService::getValidTransitions()`/`canReject`; bungkus exception di controller → redirect + pesan error.

### H-01 — Role sistem bisa diubah namanya / dihapus / Super Admin terakhir bisa di-demote → lockout
- File: `app/Http/Controllers/Admin/RoleController.php:67-104` + `UserManagementController.php:149-166` (`updateRole` tanpa guard Super Admin terakhir)
- Masalah: `update()` bisa rename "Super Admin"/"Warga"/dll.; `destroy()` hanya blokir "Super Admin"; `updateRole()` bisa menurunkan Super Admin terakhir.
- Dampak: Rename memutus middleware `role:Super Admin`; hapus role "Warga" merusak registrasi; demote Super Admin terakhir = kunci administrasi permanen.
- Perbaikan: Lindungi role sistem dari rename/hapus; larang demote Super Admin terakhir.

### H-02 — Surat belum selesai bisa dicetak: nomor sementara + hash verifikasi bisa ditebak
- File: `app/Controllers/General/CetakSuratController.php:24-36` + `app/Policies/PengajuanSuratPolicy.php:37-44`
- Masalah: Policy `download` mengizinkan pemilik di status apa pun; `cetak()` mencetak PDF untuk non-completed dan mengisi `hash_verifikasi` (jika kosong) dengan `hash('sha256', id.user_id.jenis.now()->timestamp)` yang **dapat diprediksi** (baris 28-33). Nomor surat di PDF = sementara, tidak dipersist.
- Dampak: Warga mencetak "surat resmi" padahal belum selesai, nomor bisa beda dari final, dan QR verifikasi pakai hash tebakan → dokumen kedaluwarsa tetap "valid" publik.
- Perbaikan: Hanya render saat `completed` (atau watermark DRAFT); hash & nomor final hanya di `handleCompletion`.

### M-01 — Lampiran surat masuk/keluar bisa diakses publik (disk `public`)
- File: `SuratMasukController`, `SuratKeluarController` (store di disk `public` → `/storage`)
- Masalah: File di domain web tanpa auth (hanya nama UUID unguessable). Jika path bocor (log, list), siapa saja bisa unduh.
- Perbaikan: Disk `private` + route ber-auth / signed URL.

### M-02 — Audit log bisa dihapus tanpa jejak
- File: `app/Http/Controllers/Admin/ActivityLogController.php:50-62`
- Masalah: `destroyAll()` menghapus semua `activity_logs` (opsional per tipe) tanpa log dirinya sendiri; middleware hanya `audit.view`.
- Perbaikan: Wajibkan Super Admin; tulis self-log dulu; atau soft-delete.

### M-03 — Nomor surat: race condition duplikat + periode memakai `updated_at`
- File: `app/Services/LetterNumberService.php:51-70`
- Masalah: `count()+1` tanpa lock & tanpa unique constraint; window `whereYear/Month/Date('updated_at')` bergeser saat row di-update (mis. job PDF jalan bulan berikutnya).
- Dampak: Dua completion bersamaan → nomor duplikat; hitungan historis berubah retroaktif.
- Perbaikan: Tabel sekuens per jenis/tahun + `lockForUpdate`; simpan kolom `tgl_dokumen` stabil sebagai batas periode.

### M-04 — Dashboard & notifikasi hardcode status yang bisa hilang saat toggle workflow mati
- File: `DashboardService.php:222-230,518-534`, `SekdesDashboardController.php:33-39,127-133,219-223`, `KadesDashboardController.php:25-28,149-153`
- Masalah: `ApprovalService::activeChain()` bisa membuang `verified/approved_operator/approved_sekdes/approved_kades` sesuai `config('village.workflow_*')`, tapi dashboard tetap menampilkan status itu.
- Dampak: Admin melihat antrean yang tidak bisa diproses (approve → 500, lihat C-04); SLA menghitung status yang tak ada.
- Perbaikan: Bangun daftar status dari `getWorkflowSteps()`/`activeChain()`.

### M-05 — Rollback setting parsial & tidak bisa diulang
- File: `app/Services/SettingVersionService.php:44-73`
- Masalah: Hanya meng-update key yang ada di snapshot (key baru tidak dihapus, key lama yang sudah dihapus tidak dibuat ulang); snapshot "rollback" dibuat setelah apply → state sebelum rollback tidak terversi.
- Perbaikan: Restore selisih penuh (hapus/j=tambah key); snapshot sebelum apply.

### M-06 — Hapus template surat → detail/cetak/verifikasi surat lama jadi 500
- File: `app/Http/Controllers/Admin/LetterConfigController.php:74-87` + `LetterServiceFactory.php:26-30` + `PublicVerificationController.php:30`
- Masalah: `destroy()` hard-delete `letter_configs`. Surat lama (termasuk completed) dari jenis itu → throw saat detail/PDF/verifikasi QR publik.
- Perbaikan: Soft-delete / deaktivasi (`is_active`) saja.

### M-07 — Rendering surat dinamis membocorkan seluruh `config('village')` ke PDF
- File: `app/Services/Surat/DynamicLetterService.php:18-21` + `LetterConfig.php:78-128`
- Masalah: `array_merge(config('village', []), $dt)` → setiap kunci internal (telegram, token, whitelist, backup) bisa ikut tersubstitusi placeholder di body surat.
- Perbaikan: Whitelist hanya key kop surat (nama_desa, kecamatan, kades/sekdes dll).

### M-08 — Filter tanggal analytics diabaikan di 5 dari 7 widget; durasi pakai `updated_at`
- File: `app/Services/AnalyticsService.php:35,91,116,146,182,232,250-287` + `AnalyticsController.php:67-78`
- Masalah: `getFilteredStats()` mengirim `$start/$end` hanya ke overview/popularTypes; sisanya all-time. Durasi `created_at`→`updated_at` termasuk waktu revisi & bump PDF async. Input tanggal tidak divalidasi → 500.
- Perbaikan: Terapkan range ke semua widget; durasi dihitung dari timeline approval; tambah validasi `date_format`.

### M-09 — Queue monitoring mengembalikan `null` pada tabel kosong
- File: `app/Services/QueueMonitoringService.php:9-18`
- Perbaikan: Cast `(int) ... ?? 0`.

### M-10 — Overbooking slot antrean & nomor antrean wrap melebihi 999/hari
- File: `app/Http/Controllers/Admin/PengajuanSuratController.php:204-254` + `app/Models/AntreanPengambilan.php:60-72`
- Masalah: Fallback hari ke-15 selalu mengembalikan slot walau kapasitas penuh; `substr($last->nomor_antrean,-3)` bentrok di atas 999; `handleCompletion` berjalan di transaksi terpisah setelah status completed (jika gagal, surat "completed" tanpa nomor/antrean).
- Perbaikan: Cek kapasitas sebelum fallback; nomor monotonic + `lockForUpdate` dengan index `tanggal_ambil`; finalisasi dalam satu transaksi.

### M-11 — Restore versi dokumen membuang state saat ini
- File: `app/Services/DocumentVersionService.php:60-93`
- Masalah: Snapshot yang dibuat setelah restore = state post-restore → tidak bisa "undo restore".
- Perbaikan: Snapshot state sebelum restore.

### L-01 — IP whitelist hanya exact-match, tanpa CIDR & tidak sadar proxy
- File: `app/Http/Middleware/AdminIpWhitelist.php:21-23`
- Perbaikan: Dukung CIDR + `X-Forwarded-For` via trusted proxies.

### L-02 — GET untuk state change (toggle template) — CSRF-able
- File: `routes/web.php:181`
- Perbaikan: POST + button.

### L-03 — Route coercion TypeError 500 (non-numeric id)
- File: `routes/web.php:129-132, 210-212` (`pengajuan/{id}/versions/{version}` sebelum `/diff`, `pengaturan/versions/{id}`, queue retry/delete)
- Perbaikan: `->whereNumber(...)`.

### L-04 — Event: prune peserta menghapus konfirmasi yang sudah ada
- File: `EventController::prunePesertaTidakTarget` — saat `rt_rw_target` dikosongkan, semua `event_pesertas` dihapus lalu dibuat ulang dengan `konfirmasi = null`.
- Perbaikan: Hanya prune yang di luar target, pertahankan konfirmasi.

### L-05 — Enumerasi email di forgot-password
- File: `AuthController.php:246` ("Email tidak terdaftar." vs pesan salah HP).
- Perbaikan: Pesan seragam.

### L-06 — Resubmit sesudah revisi tidak memvalidasi ulang config aktif
- File: `Warga/SuratController.php::updateAfterRevision` — config yang dinonaktifkan masih bisa disubmit ulang.

---

## KATEGORI UI/UX

### U-01 `[H]` — Halaman laporan desa 500: `str_contains()` dengan array
- File: `resources/views/admin/laporan/show.blade.php:130-132`
- Masalah: `str_contains($key, ['anggaran','pendapatan',...])` — argumen ke-2 harus string, diberi array → `TypeError`.
- Perbaikan: `collect([...])->contains(fn($n) => str_contains($haystack, $n))`.

### U-02 `[M]` — Captcha reset password tampil kosong (math mode)
- File: `resources/views/auth/reset.blade.php:66, 248`
- Masalah: `x-data` hanya `{ submitting:false, showPw:false }` — `captchaA`/`captchaB` undefined sampai user klik "Ganti soal". (Login & forgot sudah benar.)
- Perbaikan: Inisialisasi `captchaA/captchaB` dari `$captcha` (mirip forgot.blade).

### U-03 `[M]` — Form bersarang di Pengaturan → Notifikasi: tombol "Kirim Pesan Uji" salah submit
- File: `resources/views/admin/setting/partials/_notifikasi.blade.php:9` (form luar) & `:40` (form dalam)
- Masalah: `<form>` dalam `<form>` diabaikan HTML → tombol uji mengirim form SAVE notifikasi, bukan `notifyTest`.
- Perbaikan: Pindahkan tombol ke luar form / pakai fetch async.

### U-04 `[M]` — Badge status/kategori APBDesa selalu abu-abu
- File: `resources/views/admin/apbdesa/show.blade.php:4-24` vs `ApbdesaController.php:71,106`
- Masalah: View memetakan `draft/aktif/selesai/dibatalkan` & `pembangunan/pelayanan/pemerintahan/kemasyrakatan` (typo), tapi data `Direvisi/Draft/Disetujui/Ditolak` dan `Pendapatan/Belanja`.
- Perbaikan: Samakan peta warna dengan nilai yang disimpan; perbaiki typo.

### U-05 `[M]` — `design-tokens.blade.php` pakai `!important` global → merusak styling Tailwind & tidak konsisten (auth beda dari admin)
- File: `resources/views/components/design-tokens.blade.php:118-131, 245-249`
- Masalah: Semua input dipaksa `border-radius:4px; border:#cccccc; padding:12px 16px; min-height:44px !important`, menimpa `rounded-xl border-gray-300`; `shadow-sm`–`shadow-2xl` dipetakan ulang. Halaman auth tidak menyertakan file ini → input look berbeda.
- Perbaikan: Scope override ke wrapper khusus, satu gaya input kanonik.

### U-06 `[M]` — Form warga: lampiran diwajibkan di step 3 padahal server tidak mewajibkan
- File: `resources/views/warga/surat/form.blade.php:~748` vs `StorePengajuanRequest`
- Masalah: Server wajibkan lampiran hanya bila `!empty($config->requirements)`; form tetap memblokir submit tanpa file.
- Perbaikan: Samakan kondisi di form dengan `requirements`.

### U-07 `[L]` — Link `/admin/search` mati (404)
- File: `resources/views/admin/dashboard.blade.php:~197`, `components/widgets/_header.blade.php:~32` — route tidak ada.
- Perbaikan: Implementasikan atau hapus link.

### U-08 `[L]` — Tombol QR di halaman surat warga tidak berfungsi
- File: `resources/views/warga/surat/index.blade.php:399-400,442`, `show.blade.php:358,369` memakai `qr_verifikasi_svg` yang hanya diisi `Warga/DashboardController.php:27`.
- Perbaikan: Isi `qr_verifikasi_svg` dari `Warga/SuratController`.

### U-09 `[L]` — Verifikasi publik selalu "5/5 Lulus" hijau
- File: `resources/views/verifikasi/show.blade.php:~312`
- Masalah: Hasil selalu semua-hijau meski hash/status tidak lulus → menyesatkan.
- Perbaikan: Hitung per-check.

### U-10 `[L]` — Google Static Maps tanpa API key → peta kosong
- File: `resources/views/antrean/show.blade.php`
- Perbaikan: Pakai embed tanpa API key.

### U-11 `[L]` — Konten hardcoded: IG `@rangga.mrw`, cuaca "32°C Cerah" saat non-produksi
- File: `admin/dashboard.blade.php:~105`, `widgets/_header.blade.php:~28,32`, `kades:~878`, `sekdes:~952`
- Perbaikan: Jadikan config-driven.
- **DONE 23 Sep 2026**: IG `@rangga.mrw` sudah lama tidak ada di sumber. Cuaca kini **realtime** via `app/Services/WeatherService.php` (Open-Meteo, tanpa API key): baca `village.latitude/longitude` dari DB, cache sukses 10 mnt / gagal 5 mnt, Peta kode WMO → deskripsi Indonesia, chip di `components/widgets/_header.blade.php` (dan file header lama `admin/dashboard/_header.blade.php`) menampilkan `{suhu}°C {deskripsi}` dengan fallback `--°C`. Regresi: `tests/Feature/WeatherServiceTest.php` (6 tes).

### U-12 `[L]` — Format tanggal campur-campur (`d M Y`, `h`, bulan telanjang)
- File: `admin/berita/index:~158`, `admin/events/index`, `admin/warga/index`, widgets
- Perbaikan: Seragamkan format Indonesia (Intl).

### U-13 `[L]` — `addslashes(old(...))` dalam `x-data` → meledak di input multiline
- File: `admin/surat-masuk/create&edit`, `admin/berita/edit`, `admin/apbdesa/create&edit`, `admin/inventaris/create&edit` (dan `{{ old() }}` polos di `admin/events/*`, `admin/berita/create`)
- Dampak: Textarea multiline + validasi fail → JS mati.
- Perbaikan: `@js()`.

### U-14 `[L]` — Logo PNG tidak tampil di PDF (mime map hanya jpg/jpeg)
- File: `resources/views/pdf/_kop.blade.php`
- Perbaikan: Dukung PNG (settings mengizinkan upload png).

### U-15 `[L]` — Badge event lembaga hardcode `bg-akan_datang`
- File: `resources/views/lembaga/events/index.blade.php:37`
- Perbaikan: Mapping berdasar status/jenis.

### U-16 `[L]` — `welcome.blade.php` memuat Tailwind CDN + design-tokens + fonts padahal langsung redirect
- Perbaikan: Redirect inline.

### U-17 `[L]` — `home.blade.php:251` dead `getElementById('navbar')`
- Perbaikan: Hapus.

### U-18 `[L]` — Tag `<script>` (collapse Alpine) di dalam `@push('styles')`
- File: `resources/views/admin/setting/index.blade.php:3`
- Perbaikan: Pindah ke `@push('scripts')`.

---

## KATEGORI BUILD / ENVIRONMENT

### B-01 — `package.json` hilang dari repo root
- File: root proyek (hanya `package-lock.json` ada)
- Dampak: `npm install`/`npm run dev`/`npm run build` gagal; fitur **Update Aplikasi** selalu gagal pada langkah `npm ci`/`npm run build` (`GitUpdateService.php:132-139`).
- Perbaikan: Commit `package.json` (vite/alpine) + regenerate lockfile.

### B-02 — `.env.example` tidak sinkron dengan `.env` kerja
- File: `.env.example:12` (`DB_CONNECTION=sqlite` vs mysql) + tidak ada `APP_DOMAIN`
- Dampak: Install baru ikut SQLite padahal AnalyticsService pakai perintah MySQL; fitur bergantung `APP_DOMAIN` rusak.
- Perbaikan: Sinkronkan ke kunci nyata.

---

## Prioritas perbaikan (saran)

1. `C-01` (takeover akun) — segera.
2. `C-02`, `U-01` (PII RT/RW + halaman 500) — tinggi.
3. `C-03`, `C-04`, `H-01`, `H-02` — integritas data & akses.
4. `M-01` s/d `M-11` — hardening batch.
5. `U-02` s/d `U-18`, `B-01`, `B-02` — polish.