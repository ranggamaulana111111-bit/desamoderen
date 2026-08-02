# Prodesa - Enterprise Village Management System

## Project Overview
Prodesa is an enterprise-grade Laravel application designed for village administration. It handles document workflows, event management, village settings, and approval processes.

## Technical Stack
- **Framework:** Laravel 11+
- **Frontend:** Blade, TailwindCSS, FilamentPHP
- **Build Tool:** Vite
- **Architecture:** Primarily uses a Service-oriented architecture with Models, Services, and Policies to enforce business logic and RBAC.

## Development Conventions
- **Naming:** Follow PSR standards. Use strict typing where applicable.
- **Pattern:** Use the Service-Repository pattern to encapsulate business logic.
- **Queueing:** Leverage Laravel Jobs for asynchronous processing (e.g., mail, heavy computations).
- **Security:** Utilize Laravel Policies and Gates for RBAC. All new features must be audited for security compliance.

## Building and Running
- **Installation:** `composer install`, `npm install`
- **Development:** `php artisan serve`, `npm run dev`
- **Testing:** `php artisan test` (using PHPUnit)
