<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'theme',
        'density',
        'accent_color',
        'sidebar_collapsed',
    ];

    protected $casts = [
        'sidebar_collapsed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function defaults(): array
    {
        return [
            'theme' => 'light',
            'density' => 'comfortable',
            'accent_color' => 'emerald',
            'sidebar_collapsed' => false,
        ];
    }

    public static function validThemes(): array
    {
        return ['light', 'dark', 'system'];
    }

    public static function validDensities(): array
    {
        return ['compact', 'comfortable', 'loose'];
    }

    public static function validAccentColors(): array
    {
        return [
            'emerald' => '#10b981',
            'blue' => '#3b82f6',
            'purple' => '#8b5cf6',
            'indigo' => '#6366f1',
            'amber' => '#f59e0b',
            'cyan' => '#06b6d4',
            'rose' => '#f43f5e',
        ];
    }
}
