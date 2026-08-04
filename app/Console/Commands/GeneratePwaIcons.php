<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GeneratePwaIcons extends Command
{
    protected $signature = 'pwa:generate-icons {--force : Timpa ikon yang sudah ada}';

    protected $description = 'Generate PWA icons (192, 512, maskable 512) dari logo desa';

    private const THEME_COLOR = '#065f46';

    public function handle(): int
    {
        $targetDir = public_path('pwa');

        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $source = $this->findLogo();

        if ($source !== null) {
            $this->info("Logo ditemukan: {$source}");
        } else {
            $this->warn('Logo desa tidak ditemukan. Menggunakan ikon default "P".');
        }

        $outputs = [
            'icon-192.png' => 192,
            'icon-512.png' => 512,
            'icon-maskable-512.png' => 512,
        ];

        foreach ($outputs as $filename => $size) {
            $path = $targetDir . DIRECTORY_SEPARATOR . $filename;

            if (file_exists($path) && ! $this->option('force')) {
                $this->line("  [skip] {$filename} sudah ada.");

                continue;
            }

            $maskable = str_contains($filename, 'maskable');
            $image = $this->render($source, $size, $maskable);

            if ($image === null) {
                $this->error("Gagal membuat {$filename}.");

                return self::FAILURE;
            }

            imagepng($image, $path);
            imagedestroy($image);
            $this->info("  [ok] {$filename} ({$size}x{$size})");
        }

        return self::SUCCESS;
    }

    private function findLogo(): ?string
    {
        $configured = config('village.logo_desa');

        if (is_string($configured) && $configured !== '') {
            $diskPath = Storage::disk('public')->path($configured);

            if (is_file($diskPath)) {
                return $diskPath;
            }
        }

        $dir = Storage::disk('public')->path('uploads/identity');

        foreach (glob($dir . DIRECTORY_SEPARATOR . '*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE) ?: [] as $file) {
            return $file;
        }

        return null;
    }

    private function render(?string $source, int $size, bool $maskable): ?\GdImage
    {
        $canvas = imagecreatetruecolor($size, $size);

        if ($canvas === false) {
            return null;
        }

        [$bgR, $bgG, $bgB] = sscanf(self::THEME_COLOR, '#%02x%02x%02x');
        $bg = imagecolorallocate($canvas, $bgR, $bgG, $bgB);

        if ($bg === false) {
            return null;
        }

        imagefilledrectangle($canvas, 0, 0, $size, $size, $bg);

        if ($source !== null) {
            $logo = $this->loadImage($source);

            if ($logo !== false) {
                $this->drawLogo($canvas, $logo, $size, $maskable);
                imagedestroy($logo);
            } else {
                $this->drawFallback($canvas, $size);
            }
        } else {
            $this->drawFallback($canvas, $size);
        }

        return $canvas;
    }

    private function loadImage(string $path): \GdImage|false
    {
        $mime = mime_content_type($path) ?: '';

        return match ($mime) {
            'image/png' => imagecreatefrompng($path),
            'image/gif' => imagecreatefromgif($path),
            'image/webp' => imagecreatefromwebp($path),
            'image/jpeg' => imagecreatefromjpeg($path),
            default => imagecreatefromjpeg($path),
        };
    }

    private function drawLogo(\GdImage $canvas, \GdImage $logo, int $size, bool $maskable): void
    {
        $scale = $maskable ? 0.62 : 0.9;
        $srcW = imagesx($logo);
        $srcH = imagesy($logo);
        $ratio = $srcW / $srcH;

        if ($ratio > 1) {
            $dstW = (int) ($size * $scale);
            $dstH = (int) ($dstW / $ratio);
        } else {
            $dstH = (int) ($size * $scale);
            $dstW = (int) ($dstH * $ratio);
        }

        $dstX = (int) (($size - $dstW) / 2);
        $dstY = (int) (($size - $dstH) / 2);

        imagecopyresampled($canvas, $logo, $dstX, $dstY, 0, 0, $dstW, $dstH, $srcW, $srcH);
    }

    private function drawFallback(\GdImage $canvas, int $size): void
    {
        $white = imagecolorallocate($canvas, 255, 255, 255);

        if ($white === false) {
            return;
        }

        $fontSize = (int) ($size * 0.5);
        $box = imagettfbbox($fontSize, 0, $this->fontPath(), 'P');

        if ($box === false) {
            return;
        }

        $x = (int) (($size - ($box[2] - $box[0])) / 2 - $box[0]);
        $y = (int) (($size - ($box[5] - $box[1])) / 2 - $box[1]);

        imagettftext($canvas, $fontSize, 0, $x, $y, $white, $this->fontPath(), 'P');
    }

    private function fontPath(): string
    {
        $candidates = [
            public_path('css/fonts/Inter-Bold.ttf'),
            public_path('fonts/Inter-Bold.ttf'),
            'C:\Windows\Fonts\arialbd.ttf',
            'C:\Windows\Fonts\arial.ttf',
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return $candidates[0];
    }
}
