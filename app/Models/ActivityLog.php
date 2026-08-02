<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'aksi',
        'deskripsi',
        'tipe',
        'target_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function catat(string $aksi, string $deskripsi, ?string $tipe = null, ?int $targetId = null): self
    {
        return static::create([
            'user_id' => auth()->id(),
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
            'tipe' => $tipe,
            'target_id' => $targetId,
        ]);
    }
}
