# Product Requirement Document (PRD) - Aplikasi Web Desa

## 1. Ringkasan Proyek
Aplikasi Web Desa adalah platform digital yang berfungsi sebagai media informasi resmi desa sekaligus sistem pelayanan administrasi mandiri untuk warga (Digitalisasi Pelayanan Desa). Target utamanya adalah mempercepat proses birokrasi surat-menyurat dan transparansi informasi kegiatan desa.

## 2. Pengguna Sistem (User Personas)
*   **Warga Publik:** Membaca profil, berita, dan kegiatan desa tanpa login.
*   **Warga Terdaftar:** Mengajukan surat administrasi (SKTM, KTP Sementara, Akta), melacak status pengajuan, dan mengelola profil kependudukan mandiri.
*   **Admin Desa (Perangkat Desa):** Mengelola konten profil/kegiatan, memvalidasi pengajuan surat warga, dan mencetak dokumen pengantar.

## 3. Cakupan Fitur (Feature Scope)

### Pandangan Publik (Tanpa Login)
*   **Beranda:** Banner dinamis, pengumuman penting, dan sekilas kegiatan terbaru.
*   **Profil Desa:** Sejarah, visi-misi, wilayah geografis, dan struktur organisasi.
*   **Kelembagaan:** Informasi BPD, LPM, PKK, Karang Taruna, dll.
*   **Kegiatan:** Galeri foto dan artikel berita kegiatan desa.

### Layanan Informasi & Surat (Butuh Login Warga)
*   **Formulir Pengajuan Surat Mandiri:**
    *   Surat Keterangan Tidak Mampu (SKTM)
    *   Surat Keterangan KTP Sementara
    *   Surat Pengantar Pembuatan Akta Kelahiran/Kematian
*   **Pelacak Dokumen (Tracking):** Halaman untuk melihat riwayat dan status surat (Pending, Diproses, Selesai, Ditolak).

### Panel Admin (Dashboard Perangkat Desa)
*   **Manajemen Konten (CMS):** Kelola berita, profil, kegiatan, dan kelembagaan.
*   **Manajemen Data Warga:** Import/Export data kependudukan dasar (NIK, Nama, Alamat, RT/RW).
*   **Verifikasi Surat:** Mengubah status pengajuan surat warga dan mencetak draf surat siap tanda tangan.

## 4. Persyaratan Nonfungsional (Non-Functional Requirements)
*   **Keamanan:** Enkripsi password warga menggunakan bcrypt, proteksi CSRF pada setiap formulir pengajuan.
*   **Performa:** Respons halaman kurang dari 2 detik pada jaringan seluler standar.
*   **Responsif:** Tampilan harus *mobile-first* karena mayoritas warga mengakses via smartphone.
