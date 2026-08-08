<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'jenis',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'rt_target',
        'rw_target',
        'user_id',
        'lembaga_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'waktu_mulai' => 'datetime',
            'waktu_selesai' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lembaga(): BelongsTo
    {
        return $this->belongsTo(Lembaga::class);
    }

    public function peserta(): HasMany
    {
        return $this->hasMany(EventPeserta::class);
    }
}
