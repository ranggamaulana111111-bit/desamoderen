# Panduan UI/UX Prodesa — Dokumentasi Antarmuka

Dokumen ini menjelaskan seluruh antarmuka (UI) aplikasi **Prodesa (Portal Desa Digital)** — mulai dari sistem desain, layout, halaman publik, panel warga, panel admin, panel lembaga, hingga template PDF. Ditulis untuk developer agar mudah memahami struktur, gaya, dan perilaku setiap tampilan.

---

## 1. Teknologi & Pendekatan UI

| Aspek | Keterangan |
|---|---|
| CSS | **Tailwind CSS via CDN** (`cdn.tailwindcss.com`) — tidak memakai build, tiap halaman mendefinisikan `tailwind.config` inline |
| JS | **Alpine.js 3.x** (CDN) — interaktivitas: dropdown, modal, wizard, chat, tab, countdown |
| Chart | **Chart.js 4.4.1** (CDN) — dashboard admin, kades, sekdes, queue, analytics |
| Kalender | **FullCalendar 6.x** — halaman agenda/event admin |
| QR | `simple-qrcode` (server, SVG) + `html5-qrcode` (scan kamera pickup) |
| Font | **Inter** (Fontshare) pada halaman publik & warga; **Montserrat** pada halaman berita/verifikasi/antrean & lembaga |
| PDF | `laravel-dompdf` — template surat & laporan resmi |
| State | `localStorage` + backend (`ThemeSettingsService`) untuk preferensi tema admin |

**Dua sistem desain yang berdampingan:**
1. **Emerald "brand"** — warna hijau `#10b981`-family, hero gradien hijau→teal→navy, glass effect. Dipakai home, login, register, berita, seluruh dashboard.
2. **PS-Blue "accent"** — `#0068BD` (PS Blue) + emas `#DFBD4D`, diperkenalkan lewat `design-tokens.blade.php` yang meng-override tombol, input, shadow, dan heading secara global. PS Blue adalah aksen CTA utama.

**Dark mode:** hanya ada di area admin (`darkMode:'class'`, diaktifkan via `themeManager()` pada `<html>`). Semua halaman publik/warga bersifat light-only.

---

## 2. Design System (`components/design-tokens.blade.php`)

File ini di-include di hampir semua halaman dan menjadi lapisan override desain global. Isi utamanya:

### Warna (CSS Variables)
- **Accent (PS Blue):** `--accent-50…950`, `500 = #0068BD`, `600 = #0070CC`, `700 = #005AA6`, `950 = #00234A`.
- **Gold:** `--gold-300…700` (`#DFBD4D` family) — aksen sekunder & highlight.
- **Amber:** `--amber-400/500/600` — warning.
- **Error Red:** `#D63D00`. **Warning Yellow:** `#FEEB37`. **Hyperlink:** `#0000EE`.
- **Neutral:** Charcoal `#1F1F1F`, Dark Gray `#363636`, Medium Gray `#CCCCCC`, Soft Gray `#D1D3DF`, Off-Black.
- **Elevation shadow:** `--shadow-raised/-elevated/-floating/-modal` (4px → 16px, alpha hitam).

### Tipografi
- `h1–h4 { font-weight: 300 !important }` (gaya premium ringan).
- Ukuran fallback: `39/39/25/20px` (desktop) → `28/28/24/20` (480–1023px) → `24/24/21/18` (<480px). Akan kalah oleh utilitas Tailwind eksplisit (`text-2xl`).

### Tombol
- **`.btn-primary`** — pil PS Blue (`border-radius:999px`), padding `16px 20px`, font `13.3333px`, `min-height:48px`; hover `#0070CC` + lift `-1px`; active `#005AA6` + scale `.98`; disabled abu.
- **`.btn-ghost`** — pil outline putih (hover `#F0F6FF`).
- **`.btn-login` / `.btn-register`** — dipaksa PS Blue, menghilangkan shimmer & ripple bawaan halaman.

### Form
- Input: **Arial `13.3333px`**, radius `4px` (dipaksa), border `1px #CCC`, `min-height:44px` (48px di ≤1024px); focus = border biru 2px + ring `rgba(0,104,189,.1)`.
- Select: chevron biru custom (SVG data-URI, `appearance:none`).
- Checkbox custom 18px biru; radio `accent-color:#0068BD`.
- Error state: border `#D63D00` 2px + ring merah; disabled: bg `#F5F5F5`.

### Shadow & Lainnya
- `.shadow-sm/md/xl/2xl` di-remap ke shadow netral PS; warna shadow emerald dinetralkan.
- JS menyuntikkan palet `accent`, `gold`, `amber` ke `tailwind.config` halaman sehingga kelas seperti `bg-accent-500/20`, `border-[#DFBD4D]` bekerja.

---

## 3. Layout & Navigasi

### 3.1 Halaman Publik — `public-layout.blade.php`
Shell minimal: nav sticky putih (`max-w-5xl`, logo "Prodesa" PS Blue) + link auth-aware (Admin / Dashboard Lembaga / Dashboard Warga / Masuk) + `<x-alert />` + slot. Tidak ada dark mode.

### 3.2 Panel Warga — layout sendiri per halaman
Tidak memakai `warga-layout` pada halaman utama (hanya komponen minimal yang ada tapi tak terpakai). Semua halaman warga memakai pola:
- **Progress bar scroll** (3px gradien di atas).
- **Navbar melayang** (`fixed top-3`), pil yang "berubah bentuk" saat scroll (`bg-white/80 backdrop-blur-2xl` + shadow).
- **Hero gradien gelap** (emerald→teal→navy) + orbs blur + pola titik radial; varian amber untuk halaman revisi.
- **AI chat widget** (FAB pojok kanan bawah, kecuali halaman edit) + **bottom nav mobile** (5 item pil glass).

### 3.3 Panel Admin
- **`admin-layout.blade.php`** (halaman modern): `<html x-data="themeManager()" :class="{'dark':…}">`, body `bg-slate-50` (dark: navy-900), sidebar tetap 260px (desktop) / drawer (mobile), konten `max-w-[1440px]` dengan `<x-alert />` dan judul halaman.
- **Sidebar** (`admin/components/sidebar.blade.php`): latar gradien navy gelap `#0c1524→#0f1a2e→#111827` + mesh radial; item aktif = `bg-accent-500/25` + **rail kiri emas `border-l-2 border-[#DFBD4D]`** + teks putih; item nonaktif `text-white/60`. Menu di-gate `@can(...)`: Dashboard, Pelayanan Surat, Daftar Warga, Manajemen Pengguna, Roles & Permissions, Berita, Events, Monitoring Antrean, Analitik & Laporan, Pengaturan Desa, Log Aktivitas, Logout.
- **Halaman legacy** (kades/sekdes dashboard, pengajuan/show & versions): dokumen HTML mandiri dengan token `:root` sendiri.

### 3.4 Panel Lembaga — `lembaga-layout.blade.php`
Body `bg-[#f5f5f0]` (kertas hangat), sidebar navy 260px (desktop) / top bar + drawer (mobile), konten `max-w-[1400px]`. **Font Montserrat** (override Inter). Elemen khas: `.bento-card`, `.section-header`, `.badge-status`, `.table-enhanced` (otomatis jadi kartu di mobile via `data-label`).

---

## 4. Halaman Publik (Tanpa Login)

### 4.1 Home / Landing Page (`home.blade.php`)
Urutan section (atas → bawah):
1. **Progress bar scroll** 3px.
2. **Navbar** fixed transparan → `bg-white/95` saat scroll. Kiri: logo + "Pro**desa**". Tengah (desktop): Profil, Layanan, Keunggulan, Statistik, Struktur, Kelembagaan, Berita, FAQ (underline animasi, tracking section aktif). Kanan: **Masuk** (ghost) + **Daftar Gratis** (pil PS Blue). Mobile: hamburger → panel glass dropdown.
3. **Hero** `min-h-[92vh]` gradien 5-stop emerald→teal→cyan dengan animasi `gradientShift`, 4 orb blur, pola dot-grid. Kiri: pill glass "Sistem Pelayanan Digital {desa}", headline putih "Pelayanan Desa Digital & Modern", 2 CTA, 2 counter live (Warga Aktif, Surat Selesai). **Kanan (desktop): slider "Informasi Desa"** — jendela ala macOS (traffic dots + chevron prev/next) berisi carousel **berita**: foto sebagai background + overlay gradien hijau (emerald) untuk konsistensi, chip "Berita", indeks `n/total`, tanggal, judul, excerpt, "Baca Selengkapnya". Autoplay 6s, pause saat hover, dot navigasi. 2 badge glass melayang di atasnya.
4. **Marquee trust bar** — 8 item ceklis bergulir tak terbatas (2× render), pause saat hover.
5. **Profil Desa** — pill "Profil {desa}", heading `gradient-text`, 2 kolom `card-premium`: Tentang Desa (stat kode pos/kode desa) + Kontak (alamat/telepon/email/website).
6. **Berita Terbaru** — search live `#searchBerita`, kartu featured (gambar + badge "Terbaru") + grid 3 kolom kartu gambar.
7. **Layanan** — 6 kartu fitur (SKTM emerald, KTP Sementara cyan, Akta amber, Domisili violet, Belum Menikah/Janda rose, 14+ Jenis Surat sky) + tag "Proses 1–3 hari kerja". Mengarah ke register/login jika belum login.
8. **Alur Pelayanan** — 4 langkah bernomor (01–04): Daftar Akun, Pilih Surat, Isi Formulir, Terima Surat.
9. **Keunggulan (zig-zag)** — 3 baris gambar/teks: Cepat & Gratis (jendela stat), Aman & Transparan (timeline workflow palsu), AI Assistant (UI chat palsu).
10. **Statistik** — band gradien gelap + 4 kartu glass (Warga, Pengajuan, Surat Selesai, Berita), angka emas `#F6BD23`, counter animasi.
11. **Struktur Organisasi** — Kepala Desa + BPD, SVG connector, Sekretariat, Pelaksana (baca dari settings).
12. **Kelembagaan** — 8 kartu institusi (Karang Taruna, BUMDes, PKK, LPM, Linmas, KWT, BKM, Toga).
13. **FAQ + AI Chat** — accordion 7 item (satu terbuka) + widget chatbot (bubble user gradien hijau kanan / bot putih kiri, typing dots, 4 chip saran, POST `/faq/ask`).
14. **CTA band** gradien brand-900→cyan + **Footer** `bg-slate-900` 4 kolom + kartu kredit developer (border conic berputar).
15. **Back-to-top** tombol melingkar.

### 4.2 Login & Register Terpadu (`auth/index.blade.php`)
Satu halaman `auth/index.blade.php` dengan **mode** (Masuk/Daftar) ditentukan query string dan **segmented toggle** di kanan atas. Backing state `authPage('{{ $mode }}', captchaConfig)`:
- **Segmented toggle** Masuk | Daftar (pindah mode via Alpine `mode = 'login'` / `'register'`).
- **Kiri (desktop):** panel gradien hero, mesh conic animasi, noise SVG, 3 orb blur, **ilustrasi SVG desa** (gedung, dokumen melayang, QR, perisai, gelombang sinyal), 3 `stat-pill` (Surat Diproses, Layanan, Enkripsi SHA-256).
- **Kanan:** navy gelap `#0f172a→#0a2540`, kartu `max-w-[420px]`:

**Mode Login (`mode === 'login'`):**
- Heading "Selamat Datang **Kembali**", error alert (dismissible).
- Form NIK (input glass, filter 16 digit, counter `n/16`, state sukses/error), Password (eye toggle), checkbox "Ingat saya", tombol `.btn-login` gradien + spinner "Memproses...", link "Daftar di sini" (switch mode), link "Lupa password?".
- Pill "Koneksi aman & terenkripsi".
- Kartu **Akun Demo** (NIK demo & password demo1234) + info captcha.

**Mode Register (`mode === 'register'`):** `max-w-[480px]` dengan **wizard 5 langkah** (`registerPage()`, `step` 1–5):
1. **Identitas** (Nama + NIK dengan counter 16 digit)
2. **Alamat** (RT/RW opsional + alamat lengkap)
3. **Kontak** (No. HP opsional)
4. **Keamanan** (password + strength meter live 4 bar: Lemah/Sedang/Kuat/Sangat Kuat)
5. **Review & Daftar** (ringkasan read-only + checkbox konfirmasi)

Stepper 5 titik bernomor dengan garis penghubung; tombol Kembali/Selanjutnya/Daftar Sekarang (disabled sampai `confirmed`). Sukses → overlay penuh `z-[100]` dengan animasi `successRing` + `checkPop` + auto-redirect.

Captcha (soal matematika, Cloudflare Turnstile, atau reCAPTCHA) tampil di kedua mode sesuai konfigurasi `village` security. Prioritas: Turnstile → reCAPTCHA → math.

### 4.3 Lupa Password (`auth/forgot.blade.php`)
Kartu terpusat `max-w-[420px]`: form NIK + No. HP (keduanya harus cocok dengan akun), tombol "Reset Password", validasi error per field, link kembali ke login. Jika akun tidak punya No HP, verifikasi No HP dilewati.

### 4.4 Detail Berita (`berita/show.blade.php`)
Navbar glass sticky → hero `rounded-3xl` gradien emerald dengan foto (opacity 40% + scrim) → artikel `prose-berita` (h2/h3, ul/ol, blockquote border kiri emerald, link `#059669`) → sidebar "Informasi Berita" + "Desa Info" + "Kembali ke Beranda" → footer PRODESA.

### 4.5 Verifikasi Dokumen (`verifikasi/show.blade.php`)
Hero gradien **berubah sesuai status** (valid = emerald, kedaluwarsa = amber) + separator gelombang SVG. Badge status "DOKUMEN TERVERIFIKASI"/"DOKUMEN KEDALUWARSA". Berisi:
- Kartu Status Dokumen (6 tile info, status pill pulsing).
- Identitas Pemilik (4 tile avatar gradien).
- **Validasi Digital "5/5 Lulus"** — 5 check-item (ditemukan, QR valid, digital signature valid, tidak berubah, data server).
- **Legalitas Dokumen** — kartu QR (SVG 160px), TTD + stempel desa, hash verifikasi mono `break-all`, nomor register, dasar hukum (UU 23/2014, PP 72/2019, Permendagri 20/2018).
- 3 kartu tips keamanan + kartu Informasi Desa + footer.

### 4.6 Antrean (`antrean/show.blade.php`)
Hero gradien per status (waiting = biru/cyan, done = emerald, expired = amber) + **nomor antrean besar** dalam tile gradien biru. Fitur utama:
- Info pemohon (3 tile).
- Jadwal pengambilan 2×2 + **countdown live** (Hari:Jam:Menit:Detik).
- Progress 5 langkah (horizontal desktop / vertical timeline mobile).
- QR code + checklist info pengambilan (5 item) + **Google Maps embed** (jika koordinat di-set).

### 4.7 `welcome.blade.php`
Splash redirect: logo tile teal + "Prodesa" + tagline + loader 3 titik → auto-redirect ke `/`.

---

## 5. Halaman Warga (Terautentikasi)

Semua halaman memakai: body `bg-[#f5f5f0]`, progress bar scroll, navbar melayang, hero gradien gelap + orbs, AI assistant, bottom nav mobile 5 item (Beranda, Surat, Riwayat, FAQ, Keluar).

### 5.1 Dashboard Warga (`warga/dashboard.blade.php`)
Root Alpine `dashboard()`. Section:
1. **Hero** — chip sapaan (Selamat Pagi/Siang/Sore/Malam sesuai jam), nama besar, nama desa, pill "N layanan tersedia" + "Online 24/7", **jam & tanggal live** (2 tile glass).
2. **Row 1: Kartu Identitas** (bento-card putih, efek `id-card-shine`, klik avatar → modal "Identitas Digital" QR) + **Kelengkapan Data %** (progress bar gradien animasi) + aksi "Ajukan Surat".
3. **Panel Statistik** (navy) — 2×2 tile dengan **ring SVG conic** + counter animasi: Total, Diproses (amber), Selesai (hijau), Ditolak (rose).
4. **Alert revisi** (gradien amber) — daftar pengajuan yang perlu diperbaiki + tombol "Perbaiki".
5. **Layanan Cepat** — 4 tile aksi (Ajukan Surat, Riwayat, Undangan dengan badge merah pulsing, FAQ).
6. **Antrean Aktif** — strip emerald dengan nomor `text-5xl font-black` + tombol QR (modal base64 SVG).
7. **Undangan Kegiatan** — kartu event dengan date-tile + 3 tombol konfirmasi (Hadir hijau / Izin amber / Absen rose).
8. **Layanan Surat** — grid tile per jenis surat (14 jenis, ikon gradien unik per jenis).
9. **Riwayat Pengajuan** — row scroll horizontal kartu 280px dengan aksi kontekstual (Unduh/QR/Batal/Perbaiki).
10. **Info Desa** — 3 baris (Jam, Kontak, Kades).
11. **Modal Letter Picker** — event `@open-letter-picker.window`, grid tile surat.
12. **AI Chat** + **bottom nav**.

### 5.2 Riwayat Pengajuan (`warga/surat/index.blade.php`)
Root Alpine `riwayat()` dengan **filter client-side**. Hero + 4 stat glass (Total, Aktif, Selesai, Revisi). **Sticky filter bar** (search + filter chips Semua/Aktif/Perlu Perbaikan/Selesai/Ditolak dengan badge jumlah). Kartu aktivitas `x-data="{expanded:false}"`:
- Header: icon tile berwarna status, judul, tanggal, badge status, chevron.
- **Progress stepper 6 langkah** (Diajukan/Verifikasi/Operator/Sekdes/Kades/Selesai) — dot terisi hijau, aktif dengan ring pulsing `progressPulse`, revisi = oranye, ditolak = silang merah.
- Catatan admin + **riwayat approval** (timeline `.timeline-item t-{status}`) + aksi (Lihat Detail / Perbaiki / Unduh PDF / QR / Batalkan dengan `confirm()`).
- Modal QR (SVG).

### 5.3 Detail Pengajuan (`warga/surat/show.blade.php`)
Hero dengan badge status translusen berwarna (blue/indigo/cyan/purple/brand/emerald/amber/red) + pulsing dot + nomor surat + tanggal. **Stepper workflow** (32px circle, check `checkBounce`, aktif ring pulsing). "Informasi Pengajuan" (definition list) + "Data yang Disubmit". Alert revisi amber / ditolak merah. **"Riwayat Proses"** timeline. Aksi kontekstual + modal QR.

### 5.4 Form Pengajuan (`warga/surat/form.blade.php`) — Wizard 4 Langkah
Root Alpine `formWizard()`. Hero + meta pills (Kode klasifikasi, Masa berlaku, "4 Langkah") + 3 info card (Tentang, Lampiran, Estimasi). **Stepper**: Data Diri / Data Surat / Lampiran / Review.
- **Step 1 Data Diri** — render dinamis `$identityFields` (text/select/textarea/date/number; NIK inputmode numeric maxlength 16).
- **Step 2 Data Surat** — render dinamis `$letterFields` (termasuk `time`).
- **Step 3 Lampiran** — daftar dokumen wajib (box sky-blue) + **drop zone** dashed border (drag & drop, preview gambar/PDF, ukuran, tombol hapus) + tips amber.
- **Step 4 Review** — ringkasan Data Diri/Data Surat/Lampiran + checkbox konfirmasi.

Validasi `nextStep()` memeriksa `[required]` di step aktif, menandai merah, scroll ke error pertama. Submit disabled sampai `confirmed`; spinner "Mengirim…".

### 5.5 Perbaiki Pengajuan (`warga/surat/edit.blade.php`)
Hero varian **amber** (tema revisi). Banner catatan petugas (amber). Form semua field config + lampiran (state "Ganti Lampiran"). Tips perbaikan 3 butir. Tanpa AI chat.

### 5.6 Halaman Error `403`
Layout sentral minimal: "403" `text-8xl text-teal-600`, pesan "Akses Ditolak", tombol Kembali (biru PS) + Beranda (outline).

---

## 6. Halaman Admin

### 6.1 Dashboard Admin (`admin/dashboard.blade.php`)
Grid **bento 12 kolom** disusun `WidgetManager::buildLayout()`. Widget dimuat **lazy** (`lazyWidget()` + `x-intersect.once`): skeleton shimmer → fetch partial → fade-in stagger. Kartu = `bento-card` putih rounded-2xl, shadow-sm, hover shadow-lg. Widget menampilkan statistik total surat, ringkasan, pengajuan terbaru, pipeline workflow, SLA, antrean, health sistem, log audit, agenda, notifikasi, dll.

### 6.2 Panel Kepala Desa (`admin/kades/dashboard.blade.php`)
Standalone (sidebar legacy). Header sapaan + flash banner emerald (auto-hide 5s). KPI cards, **Chart.js** (bar + line gradien brand), **Insight bar** dengan chip prioritas + garis status server (dot emerald glowing). Daftar approval dengan **priority badge** (`text-[9px]`, dot warna), SLA-overdue marker, aksi approve/reject cepat.

### 6.3 Panel Sekretaris (`admin/sekdes/dashboard.blade.php`)
Standalone. Quick-action tiles (Riwayat indigo, Analitik purple), stat-micro dengan gradien, timeline widgets, health/progress indicator, notification dot pulsing.

### 6.4 Pelayanan Surat — List (`admin/pengajuan/index.blade.php`)
Modern layout. **Filter status pill tabs** per status dengan warna masing-masing (Semua slate, submitted blue, verified indigo, approved_operator purple, approved_sekdes cyan, approved_kades emerald, completed green, rejected red). Search form (select jenis + keyword + tombol Cari gradien emerald-teal). Tabel `.table-enhanced`: Pemohon / Jenis Surat / Status (pill gradien) / Tanggal / Aksi.

### 6.5 Detail Berkas (`admin/pengajuan/show.blade.php`) + Versions
Legacy standalone. Tabel info `data_tambahan`, timeline approval, **tombol aksi workflow** sesuai role (approve/reject/revision), versi dokumen.
- **`versions`** — daftar snapshot `DocumentVersionService` (label, author, timestamp, diff/download/restore).
- **`version-diff`** — komparasi dua panel A vs B dengan highlight tambah/hapus.

### 6.6 Monitoring Antrean (`admin/queue/index.blade.php`)
Flash success/error. 4 `stat-micro` (aksen amber/oranye), tabel failed jobs dengan **retry single / retry all / delete**, Chart.js bar mingguan + donut distribusi.

### 6.7 Pengambilan Surat (`admin/queue/pickup.blade.php`)
Grid `lg:grid-cols-5` di bawah `pickupApp()`:
- **Panel Scan** (2 kolom): `#qr-reader` di frame `bg-slate-900` (Html5QrcodeScanner), pesan error amber/merah.
- **Panel Hasil** (3 kolom): data antrean/pengajuan hasil scan + aksi (serahkan/lewat).
- Live clock chip amber.

### 6.8 Analitik (`admin/analytics/index.blade.php`)
Filter tanggal (start/end) + tombol Filter gradien + link Reset + **Export CSV**. 4 Chart.js: line (tren), bar (jenis populer), donut (status), line (pertumbuhan pengguna) + KPI dari `AnalyticsService` (8 metrik).

### 6.9 Modul CRUD (pola umum)
Pola yang konsisten di semua modul (users, warga, roles, berita, events, **lembaga**, surat masuk/keluar, disposisi, inventaris, apbdesa, laporan, **template-surat/letter-config**, **activity-log**):

- **List page:** header (`text-2xl md:text-3xl font-bold` + subtitle + CTA kanan) → baris stat-micro → filter bar → tabel dengan pagination. Kolom tersembunyi responsif (`hidden md:table-cell`). Tombol aksi ikon kecil (view blue, edit emerald, hapus merah, PDF violet) dengan hover tint.
- **Form create/edit:** grid `lg:grid-cols-12`, kiri `col-span-8/9` (widget-card per seksi), kanan `col-span-4/3` **sticky** (preview/ringkasan/aksi), **sticky footer action bar** (`fixed bottom-0` desktop `lg:static`). Input uniform: `rounded-xl border-gray-200 focus:ring-emerald-500`. Required `*` merah. Error `text-red-500 text-xs` dengan ikon `!`.
- **Detail page:** **hero header gelap** (`bg-gradient-to-br from-slate-800 via-slate-900 to-navy-900` + orb emerald/teal blur) → konten 8 kolom + sidebar 4 kolom (Panel Aksi + Informasi Dibuat/Diubah/Operator + Kembali).
- **Segmented buttons** menggantikan select (inventaris kategori/kondisi/status, events jenis, apbdesa kategori) — grid tombol dengan hidden input.
- **Live preview cards** via Alpine `x-text` dengan fallback.
- Semua delete pakai `onsubmit="return confirm(...)"`; uang diformat `number_format(...,',','.')` + `Rp `.

**Badge status per modul:**
| Modul | Status → Warna |
|---|---|
| Berita | publish emerald / draft gray |
| Events | akan_datang blue / berlangsung emerald / selesai gray; jenis: musrenbangdes purple, rapat green, kegiatan blue, sosialisasi amber |
| Surat Masuk | diterima blue / diproses amber / selesai emerald / ditolak red; sifat Biasa gray, Segera amber, Rahasia red, Penting blue |
| Surat Keluar | dikirim emerald / diproses blue / selesai violet / ditolak red |
| Inventaris | kategori (7 warna); kondisi Baik emerald / Rusak Ringan amber / Rusak Berat red / Perawatan blue; status Digunakan blue / Tersedia emerald / Disimpan amber / Dihapus red |
| APBDesa | kategori Pendapatan emerald / Belanja rose; status Draft gray / Disetujui emerald / Direvisi amber / Ditolak red |
| Laporan | draft amber / finalisasi emerald / archived gray |
| Activity Log | create emerald / approve·update blue / delete·reject red / login purple |

**Khusus per modul:**
- **Berita:** slug auto dari judul (`@keyup`), counter kata/karakter live, dropzone cover foto (FileReader preview).
- **Events:** FullCalendar + daftar kartu event, timeline peserta (`.timeline-step`), undangan massal.
- **Laporan (create):** **wizard 3 langkah** — ① Informasi (tipe periode segmented, format radio-card) ② Pilih Modul (kartu modul + "Pilih Semua/Batal") ③ Preview & Simpan (generate narasi via AJAX `fetch` ke `admin.laporan.preview`, textarea editable + data mentah JSON collapsible). Edit: accordion per modul dengan gradient accent bar per index + word counter. Show: naratif accordion + data ringkasan pintar (uang→Rp, persen→%, boolean→Ya/Tidak).
- **Pengaturan (`admin/setting/index.blade.php`):** halaman paling kompleks — **3 kolom**: nav sidebar 16 tab (sticky, tab reserved badge "nanti", audit-log live count) · konten (16 panel: profil desa, pemerintahan, ttd digital, template surat, nomor surat, workflow, queue driver, antrean, notifikasi, analytics, backup, keamanan, integrasi, tampilan, maintenance, audit log) · **preview panel live**. Skeleton saat loading, `history.replaceState(?tab=)`, **toast system** (auto-dismiss 4s). Live nomor surat preview (token `{kode},{no},{tahun},{bulan},{hari}`, dsb.) + FileReader preview logo/stempel/ttd. Mobile: select menggantikan sidebar.

### 6.10 Pengaturan Tema (`theme-settings-modal.blade.php`)
Admin-only (dipicu tombol gear di `_header`). Modal `max-w-md`: Mode Tampilan (light/dark/system), Density (compact/comfortable/loose), Warna Aksen (swatch dots → `--accent` di `<html>`), indikator saving. Persist via POST `/admin/widgets/theme/settings`.

---

## 7. Panel Lembaga

Body `bg-[#f5f5f0]`, sidebar navy (item aktif gold rail + ikon `#85c2ef`), font Montserrat, komponen `bento-card` / `section-header` / `table-enhanced`.

- **Dashboard** — hero gradien emerald full-width (white pill "Tulis Berita" + glass pill "Buat Event"), 2 grid stat (Total & bulan ini), stat lanjutan (Total Dilihat, Draf, Terpopuler, Rata-rata/berita), daftar berita terpopuler (rank badge), event terbaru (date tile).
- **Berita** — filter pill (Semua/Tayang/Draf), tabel (thumbnail 48px, badge `bg-publish`/`bg-draft`, aksi ikon eye/pencil/trash), form 2/3+1/3 dengan **radio-card status publikasi** (Publikasikan langsung / Simpan sebagai draf), detail `whitespace-pre-line`.
- **Events** — tabel (badge jenis blue, status), form grid 2 kolom + info callout "Langsung tampil", detail dengan badge + jadwal.
- **Profil Lembaga** — field identitas (nama/jenis) disabled "Diubah oleh admin desa", sisanya editable; kartu logo preview 112px.

---

## 8. Template PDF

### 8.1 Surat Resmi (SKTM / KTP Sementara / Akta / Dinamis)
Satu "DNA" surat resmi yang sama:
- **Times New Roman 12pt**, line-height 1.5, padding `35px 45px`.
- **Kop surat** centered: H1 "Pemerintah {Kabupaten}" (16pt bold uppercase), baris kecamatan/desa (11pt bold), alamat italic 9pt.
- **Garis ganda**: 3px tebal + 1px tipis.
- **Judul** 14pt bold underline + "Nomor: ..." 11pt centered.
- Body: pembuka indent 40px, **tabel identitas borderless** (label 130px), paragraf isi justify indent, penutup, masa berlaku italic 10pt.
- **Blok tanda tangan** 2 kolom floating (Camat kiri / penandatangan kanan) dengan **stempel & TTD overlay absolute** (base64 PNG, opacity .85).
- **Footer verifikasi**: QR SVG 70×70 (20%) + "Verifikasi Dokumen:" + URL + hash truncate (80%).

### 8.2 Laporan Desa Kuantitatif
- **Surat Resmi** (`laporan_surat_resmi`): `@page margin 30/30/40/30`, kop 3 baris + garis ganda, judul dokumen center + underline, pembuka "Dengan hormat" indent 1.2cm, **section bernomor Romawi** dengan tabel data per section (caption "Tabel I.1 Data ..."), penutup, tanda tangan kanan, footer "Halaman N".
- **Institusional / LPPD** (`laporan_institusional`): dokumen formal lengkap — **Cover** (judul besar + author block) → **Kata Pengantar** (4 paragraf) → **Daftar Isi** (dotted leaders) → **Konten** (dengan running header watermark) → **Lampiran** (tabel per modul) → **Penutup + TTD** → footer halaman.

Keduanya punya pipeline teks: `nl2br(e())` → `**bold**` → `<strong>` → sub-heading; angka >1000 diformat `1.000` kecuali kolom demografi.

---

## 9. Komponen & Widget Admin

### Widget (`components/widgets/_*.blade.php`, 18 widget)
| Widget | Isi |
|---|---|
| `_stats` | Kartu utama gradien emerald (total `text-5xl`, counter) + 4 sub-stat |
| `_header` | Sapaan + jam live + role chip + search + **gear tema** + bell notifikasi (dropdown w-80) + strip ringkasan harian |
| `_quick_actions` | 4 kartu aksi (Surat/Warga/Berita/Event) gated permission |
| `_shortcuts` | Chip link cepat |
| `_submissions` | Tabel pengajuan terbaru |
| `_workflow` | Pipeline progress (bar gradien blue→purple→emerald) |
| `_queue` | Status antrean (pulse-dot warn/ok) |
| `_notifications` | 4 stat tile |
| `_system_info` | DB size + progress bar storage |
| `_health` | Health PHP/Laravel/MySQL (emerald/amber/red) |
| `_audit_log` | Log hari ini + stat menunggu |
| `_village` | Info desa (kades/sekdes/populasi) |
| `_sla` | Pengajuan lewat SLA + rata-rata jam proses |
| `_charts` | Chart.js tren (filter 7H/30H/90H/1TH) + donut jenis |
| `_events` | Agenda aktif (date tile pink) |
| `_approvals` | Antrean persetujuan + modal reject |
| `_empty` | Empty state (ikon switchable) |
| `_skeleton` | Placeholder shimmer (`$lines/$chart/$stats`) |

### Komponen kecil lain
- `alert.blade.php` — flash success/error/warning dismissible (Alpine).
- `favicon.blade.php` / `fonts.blade.php` / `pwa-assets.blade.php` — head partials (favicon dari storage logo, Inter, manifest + SW + theme-color `#065f46`).

---

## 10. Pola Status, Warna & Interaksi (Konvensi)

### Warna status pengajuan (konsisten di semua halaman)
| Status | Warna |
|---|---|
| submitted | blue `#3b82f6` |
| verified | indigo `#6366f1` |
| approved_operator | cyan `#06b6d4` |
| approved_sekdes | purple `#8b5cf6` |
| approved_kades | brand `#059669` |
| completed | emerald/green `#34d399` |
| revision | amber `#f59e0b` |
| rejected | red `#ef4444` |

### Konvensi UI
- **Hapus** selalu pakai `confirm()` native; tidak ada sistem modal custom untuk delete.
- Uang: `number_format($x,0,',','.')` + prefix `Rp`.
- **Touch targets**: CTA min 48px, input min 44px (48px mobile), tombol aksi tabel 44px.
- **Animasi scroll-reveal**: `.a-fade-up`, `.a-slide-l/r`, `.a-scale`, `.anim-fade-*` + delay `.d1–d10` / `.stagger-1–8`, dipicu IntersectionObserver.
- **Counter animasi**: `animateNumber()` (ease, 1.2s, `id-ID`).
- **Hover lift**: `.interact`, `.bento-card`, `.action-pill` (translateY + scale aktif .97).
- Setiap detail page punya panel "Panel Aksi + Informasi + Kembali".
- Info desa selalu dari `config('village.*')` (nama_desa, kecamatan, alamat, email, telepon, logo, ttd, stempel, koordinat).

---

## 11. Responsif

| Area | Perilaku |
|---|---|
| Grid | 12 kolom desktop → 1 kolom mobile |
| Navbar | Desktop link penuh → mobile hamburger drawer (public) / bottom nav (warga) / drawer (admin/lembaga) |
| Tabel | `.table-enhanced` → kartu per-baris dengan `data-label` di mobile |
| Hero slider | Hanya desktop (`hidden lg:block`) |
| Filter chips | Scroll horizontal di mobile |
| Stepper | Horizontal desktop → timeline vertikal mobile (antrean) |
| Konten | Container `max-w-[1400/1440px]`, padding 16→24→40 |
| Safe area | `env(safe-area-inset-bottom)` di bottom nav warga |

---

## 12. Catatan Teknis untuk Developer

1. **Dua desain warna** (emerald brand + PS-Blue accent) sengaja hidup bersama; `design-tokens.blade.php` adalah lapisan terakhir yang menang. Saat menambah kelas baru, periksa apakah tokens menimpanya (contoh: `.btn-primary` selalu PS Blue di runtime).
2. **Kelas Tailwind dinamis** yang dihasilkan Blade (`bg-{{ $x }}-50`, `hover:border-{{ $x }}-200`, `w-{{ $n }}/...`) **tidak** akan digenerate CDN JIT — sebagian hover/lebar diam-diam no-op.
3. Halaman warga adalah dokumen mandiri (layout sendiri), sedangkan halaman admin modern memakai `<x-admin-layout>`, dan halaman legacy (kades/sekdes/pengajuan detail) standalone dengan tokens sendiri.
4. PDF memakai DomPDF — jangan pakai fitur CSS modern (flex/grid) di template surat/laporan; gunakan float/table/absolute positioning.
5. Semua halaman publik light-only; dark mode hanya di area admin.
6. `welcome.blade.php` adalah splash redirect — jangan hapus meta refresh.
