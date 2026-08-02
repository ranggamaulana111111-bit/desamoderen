<?php

namespace App\Services;

use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;

class ThemeSettingsService
{
    public function getForUser(?int $userId = null): array
    {
        $userId = $userId ?? Auth::id();

        if (! $userId) {
            return UserSetting::defaults();
        }

        $setting = UserSetting::where('user_id', $userId)->first();

        if (! $setting) {
            return UserSetting::defaults();
        }

        return [
            'theme' => $setting->theme,
            'density' => $setting->density,
            'accent_color' => $setting->accent_color,
            'accent_hex' => UserSetting::validAccentColors()[$setting->accent_color] ?? '#10b981',
            'sidebar_collapsed' => $setting->sidebar_collapsed,
        ];
    }

    public function saveForUser(array $data, ?int $userId = null): array
    {
        $userId = $userId ?? Auth::id();

        $validated = collect($data)->only(['theme', 'density', 'accent_color', 'sidebar_collapsed'])
            ->filter(fn ($v, $k) => in_array($k, ['theme', 'density', 'accent_color']) ? in_array($v, match ($k) {
                'theme' => UserSetting::validThemes(),
                'density' => UserSetting::validDensities(),
                'accent_color' => array_keys(UserSetting::validAccentColors()),
            }) : true)
            ->toArray();

        $setting = UserSetting::updateOrCreate(
            ['user_id' => $userId],
            $validated,
        );

        return $this->getForUser($userId);
    }
}
