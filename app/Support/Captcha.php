<?php

namespace App\Support;

class Captcha
{
    public static function question(): array
    {
        $a = random_int(2, 9);
        $b = random_int(2, 9);

        session(['captcha_a' => $a, 'captcha_b' => $b]);

        return [$a, $b];
    }

    public static function data(): array
    {
        return [
            session('captcha_a', 1),
            session('captcha_b', 1),
        ];
    }

    public static function check(mixed $answer): bool
    {
        $a = session('captcha_a');
        $b = session('captcha_b');

        if ($a === null || $b === null) {
            return false;
        }

        return (int) $answer === (int) $a + (int) $b;
    }
}
