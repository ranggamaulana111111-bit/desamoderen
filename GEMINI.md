# Prodesa - Enterprise Village Management System

## Project Overview
Prodesa is an enterprise-grade Laravel application designed for village administration. It handles document workflows, event management, village settings, and approval processes.

## Technical Stack
- **Framework:** Laravel 11+
- **Frontend:** Blade, TailwindCSS (CDN), Alpine.js 3.x, Chart.js, FullCalendar
- **Build Tool:** Vite 5 + laravel-vite-plugin
- **PDF:** barryvdh/laravel-dompdf (surat & laporan desa)
- **RBAC:** spatie/laravel-permission
- **Auth:** Custom (NIK-based), tanpa Breeze/Jetstream
- **Architecture:** Service-oriented architecture with Models, Services, and Policies to enforce business logic and RBAC.
- **Catatan:** `filament/filament` dan `google-gemini-php/laravel` terdaftar di `composer.json` namun **tidak dipakai** dalam kode aplikasi. Semua UI memakai Blade + Tailwind CDN + Alpine.js. Jangan menambahkan provider Filament ke `bootstrap/providers.php`.

## Development Conventions
- **Naming:** Follow PSR standards. Use strict typing where applicable.
- **Pattern:** Service Layer + Strategy/Factory (`LetterServiceFactory`, `ApprovalService`, dll.) untuk membungkus business logic. Jangan pindahkan logika bisnis ke controller.
- **Queueing:** Leverage Laravel Jobs for asynchronous processing (e.g., `ProcessCompletedLetter` untuk PDF + notifikasi).
- **Security:** Utilize Laravel Policies and Gates for RBAC. All new features must be audited for security compliance. Data sensitif (`nik`, `no_kk`, `no_hp`) pakai `encrypted` cast + blind index.
- **Transaksi:** Setiap operasi multi-step dibungkus `DB::transaction` + `lockForUpdate` bila perlu.
- **Audit trail:** Catat aksi penting via `ActivityLog::catat()`.

## Building and Running
- **Installation:** `composer install`, `npm install`
- **Development:** `php artisan serve`, `npm run dev`
- **Testing:** `php artisan test` (using PHPUnit)
