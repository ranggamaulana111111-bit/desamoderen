<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PrivateFileHelper
{
    /**
     * Path tersimpan bisa relatif terhadap disk 'private' (storage/app/private)
     * atau relatif terhadap disk default 'local' (storage/app, mis. "private/lampiran/...").
     * Helper ini mencari file di seluruh kombinasi tersebut agar file lama & baru
     * tetap bisa diunduh.
     *
     * @return array{disk: string, path: string}|null
     */
    public static function locate(string $path): ?array
    {
        if ($path === '') {
            return null;
        }

        $normalized = str_replace('\\', '/', $path);
        $normalized = ltrim($normalized, '/');
        $defaultDisk = Storage::getDefaultDriver();

        $candidates = [
            ['disk' => 'private', 'path' => $normalized],
        ];

        if (str_starts_with($normalized, 'private/')) {
            $candidates[] = ['disk' => 'private', 'path' => Str::after($normalized, 'private/')];
        }

        if ($defaultDisk !== 'private') {
            $candidates[] = ['disk' => $defaultDisk, 'path' => $normalized];
        }

        foreach ($candidates as $candidate) {
            if (Storage::disk($candidate['disk'])->exists($candidate['path'])) {
                return $candidate;
            }
        }

        return null;
    }

    public static function exists(string $path): bool
    {
        return self::locate($path) !== null;
    }

    public static function delete(string $path): bool
    {
        $located = self::locate($path);

        if (! $located) {
            return false;
        }

        return Storage::disk($located['disk'])->delete($located['path']);
    }
}
