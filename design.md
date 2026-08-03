# Prodesa - System Design & Architecture Document

## 1. System Overview
**Prodesa** adalah Sistem Informasi Manajemen Desa terpadu kelas enterprise yang dirancang untuk menjembatani pelayanan administrasi warga secara mandiri (Layanan Mandiri) dan mendigitalisasi operasional kantor desa (E-Office). Sistem ini memiliki fitur tingkat lanjut seperti *Document Versioning*, *Approval Workflow* berjenjang, *Queue System*, dan kapabilitas analitik dengan standar keamanan dan performa tinggi.

---

## 2. Actor & Role Mapping (RBAC)
Sistem menggunakan arsitektur RBAC (Role-Based Access Control) granular untuk memastikan keamanan data tingkat tinggi.

| Aktor | Area Akses | Deskripsi Kewenangan & Fokus Visual |
| :--- | :--- | :--- |
| **Public / Guest** | `Front-End` | **Fokus:** Informasi, Transparansi, & Kepercayaan. Mengakses berita, FAQ, cek antrean via QR, verifikasi surat. |
| **Warga** | `/warga/*` | **Fokus:** Kemudahan, Kecepatan, & Personalisasi. Mengajukan surat, cek status (timeline), cetak, RSVP event. |
| **Admin / Staf** | `/admin/*` | **Fokus:** Efisiensi, Produktivitas, & Data Management. Mengelola tata usaha, inventaris, APBDesa, user, queue. |
| **Sekdes** | `/admin/sekdes`| **Fokus:** Review, Validasi, & Kontrol Kualitas. Otoritas verifikasi dokumen (`letter.verify`) sebelum ke Kades. |
| **Kades** | `/admin/kades` | **Fokus:** Pengambilan Keputusan & Strategic Oversight. *Final approval* surat/laporan, memantau analitik desa. |

---

## 3. Visual Design Language (The "Enterprise & Stunning" Look)

Untuk mencapai tampilan yang menakjubkan dan *enterprise*, Prodesa mengadopsi prinsip **Modern Professionalism** dengan pendekatan *Clean Design*, *Ample White Space*, dan *Subtle Depth*.

### 3.1 Philosophies
*   **Trustworthy:** Desain harus memancarkan stabilitas, keamanan, dan otoritas formal lembaga pemerintahan.
*   **Intuitive:** Kompleksitas birokrasi disembunyikan di balik antarmuka yang sangat mudah dipahami bahkan oleh pengguna awam.
*   **Performant:** Animasi yang halus (*subtle*) dan transisi yang *seamless* untuk memberikan kesan sistem yang sangat *responsive* dan mahal.

### 3.2 Color Palette (Premium Executive)
Kami menggunakan kombinasi warna yang melambangkan kepercayaan, profesionalisme, dan pertumbuhan alamiah desa.

| Kategori | Warna | Hex | Deskripsi Penggunaan |
| :--- | :--- | :--- | :--- |
| **Primary** | **Sapphire Authority** | `#1E3A8A` | Warna utama untuk elemen branding, *active states*, tombol utama, dan header formal (Corporate Blue). |
| **Secondary** | **Emerald Growth** | `#10B981` | Digunakan sebagai aksen untuk status 'Success', tombol konfirmasi positif, dan elemen pertumbuhan (Desa Hijau). |
| **Background**| **Executive White** | `#F9FAFB` | Latar belakang utama aplikasi. Sedikit keabu-abuan agar mata tidak cepat lelah (bukan putih mati). |
| **Surface** | **Pure Canvas** | `#FFFFFF` | Latar belakang untuk Kartu (*Cards*), Modals, dan Data Tables. Memberikan efek kedalaman. |
| **Text** | **Obsidian Gray** | `#1F2937` | Warna teks utama. Sangat gelap tapi tidak hitam pekat, meningkatkan keterbacaan (*readability*). |
| **Accent** | **Slate Divider** | `#E5E7EB` | Untuk garis pembatas, *borders*, dan teks *disabled*. Sangat halus. |

### 3.3 Typography (Crisp & Modern)
Menggunakan *font* Sans-Serif yang *clean*, modern, dan memiliki *readability* tinggi di berbagai ukuran layar.

*   **Primary Font:** `Inter` (Google Fonts). Sangat baik untuk UI *enterprise* dengan banyak data.
*   **Headers (H1-H4):** `Inter`, Semi-Bold/Bold.
*   **Body Text:** `Inter`, Regular.

### 3.4 UI Elements & Shadows (Depth)
Menghindari tampilan *flat* yang membosankan. Kami menggunakan *Shadows* tingkat lanjut (*Advanced Shadow Design*) untuk memisahkan lapisan UI.

*   **Borders:** Sangat minimal. Pemisahan elemen menggunakan *Shadow* dan perbedaan warna *Background/Surface*.
*   **Shadow S (Subtle):** Untuk Kartu Konten kecil. `0 1px 2px 0 rgba(0, 0, 0, 0.05)`
*   **Shadow M (Medium):** Untuk Modal, Dropdowns, Sidebar aktif. `0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)`

---

## 4. Key Views Visual Mockup Concepts

Bagaimana *routing* teknis diterjemahkan menjadi visual yang menakjubkan:

### 4.1 Landing Page Publik (`Route::get('/', ...)`)
**Visual Goal:** Impresi pertama yang megah, formal, dan informatif.

*   **Hero Section:** Gambar *High-Resolution* (atau Video latar belakang yang *subtle*) pemandangan terbaik desa atau kantor desa yang ikonik, dilapisi *overlay* Sapphire Blue tipis. Teks *heading* besar dan *tagline* desa yang inspiratif.
*   **Quick Search/Lacak:** Bilah pencarian besar yang elegan di tengah *hero* untuk melacak status surat (via Hash) atau cek antrean (via QR Code) secara instan.
*   **Berita Utama:** Menggunakan *Card Grid* dengan efek *zoom* halus saat *hover*. Gambar berita berkualitas tinggi dengan tipografi judul yang kuat.

### 4.2 Dashboard Warga (`Route::get('warga/dashboard', ...)`)
**Visual Goal:** Personalisasi, kehangatan, dan efisiensi tindakan.

*   **Personal Greeting:** Bagian atas menampilkan: "Selamat Pagi, Bapak Rangga!" dengan foto profil melingkar yang elegan.
*   **Status Timeline:** *Widget* utama berbentuk *timeline* vertikal yang *clean* untuk memantau pengajuan surat yang sedang aktif. Tiap *step* memiliki ikon warna (Biru: Proses, Hijau: Selesai, Merah: Revisi).
*   **Quick Actions:** Tombol-tombol berbentuk kartu besar dengan ikon minimalis untuk tugas utama: "Ajukan Surat Baru", "RSVP Undangan Desa".

### 4.3 E-Office Admin & Analytics (`Route::get('admin/dashboard', ...)`)
**Visual Goal:** Kontrol data total, kejelasan analitik, dan produktivitas tinggi.

*   **Key Metrics Cards:** Kartu-kartu di bagian atas menampilkan angka statistik utama desa dengan tren (naik/turun kecil di pojok). Contoh: Total Warga, Pengajuan Aktif, Inventaris, Anggaran Terpakai.
*   **Interactive Charts (ApexCharts/Chart.js):** Visualisasi data yang dinamis dan berwarna-warni namun formal (menggunakan palet Sapphire/Emerald). Grafik garis untuk tren pengajuan surat bulanan, grafik lingkaran untuk demografi warga.
*   **Activity Feed:** *Stream* real-time yang *clean* di sisi kanan, menunjukkan aktivitas terbaru di sistem (Contoh: "Sekdes memverifikasi Surat Kematian A-001", "Warga B melakukan RSVP Event").

### 4.4 Advanced Letter Versioning Diff (`Route::get('admin/pengajuan/.../diff', ...)`)
**Visual Goal:** Kejelasan komparasi data yang kompleks secara visual.

*   **Side-by-Side View:** Dua panel *clean Canvas* berdampingan (Versi Lama vs Versi Baru).
*   **Highlighting:** Teks yang dihapus di-*highlight* latar belakang merah muda dengan coretan (*strikethrough*). Teks yang ditambahkan di-*highlight* latar belakang hijau muda. Sangat *clean*, mirip tampilan *diff* di GitHub tapi disesuaikan untuk dokumen formal.

---

## 5. Micro-Interactions & Experience (The "Amazing" Factor)

*   **Subtle Hover States:** Semua elemen interaktif (tombol, kartu berita, baris tabel) memiliki transisi warna atau bayangan halus (0.2 detik) saat di-*hover*, memberikan kesan responsif yang elegan.
*   **Skeleton Loading:** Menghindari *spinner* loading jadul. Saat data sedang dimuat, sistem menampilkan *outline* abu-abu tipis yang berdenyut lembut (*skeleton screen*) yang bentuknya menyerupai konten asli.
*   **Seamless Page Transitions:** Menggunakan teknik AJAX/SPA-like *rendering* (jika memungkinkan, contoh dengan Livewire/Inertia di Laravel) agar perpindahan halaman terasa instan tanpa *full page reload* yang patah-patah.

---

## 6. Core Modules & Architecture (Technical Mapping)

*(Bagian ini tetap sama seperti sebelumnya, karena ini adalah mesin Ferrari Anda, kita tidak mengubahnya, kita hanya membungkusnya dengan body yang menakjubkan di atas).*

### A. Public Facing & Portal (Front-End)
*   **Berita & Informasi:** Artikel dan berita desa (`/berita`).
*   **FAQ System:** Tanya jawab publik dengan throttling (`/faq/ask`).
*   **Validasi & Tracking:** Cek keaslian via Hash (`/verifikasi/{hash}`) & antrean via QR (`/antrean/{kodeQr}`).

### B. Layanan Mandiri Warga (Citizen Portal)
*   **Pengajuan Surat:** Alur CRUD, revisi mandiri, cetak mandiri.
*   **Event Desa:** Konfirmasi kehadiran (*RSVP*) undangan/kegiatan.

### C. E-Office & Tata Usaha (Admin Dashboard)
*   **Surat Menyurat:** Surat Masuk, Surat Keluar, Disposisi.
*   **Manajemen Aset:** Pencatatan Inventaris Desa.
*   **Keuangan:** Pemantauan APBDesa.

### D. Advanced Letter Workflow & Versioning
*   **Approval Chain:** Pengajuan -> Revisi -> Verifikasi (Sekdes) -> Finalisasi (Kades).
*   **Document Versioning:** Simpan versi, *Diff Compare*, *Restore*.
*   **Dynamic Templates:** Konfigurasi *template* surat dinamis (`/template-surat`).

### E. Manajemen Pelaporan (Reporting Engine)
*   Laporan Desa bulanan/tahunan, *Generate PDF*, *Finalize* (Kunci), *Restore*.

### F. System Management & Analytics (Super Admin Area)
*   **User & Role Management:** Warga, User accounts, granular Permissions.
*   **Queue Monitoring:** Pantau *job processing*, *Retry*, *Retry All*, *Destroy*.
*   **Analytics Dashboard:** Visualisasi data demografi, performa pelayanan, Ekspor CSV.
*   **Activity Log (Audit Trail):** Merekam aktivitas krusial.
*   **Dynamic Settings & Widgets:** Manajemen *layout widget* AJAX, tema, *maintenance mode*, *clear cache*, hingga **Configuration Versioning** (system *rollback*).