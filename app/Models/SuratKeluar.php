<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluars';

    protected $fillable = [
        'uuid', 'nomor_agenda', 'tanggal_kirim', 'tujuan',
        'perihal', 'jenis_surat', 'sifat_surat', 'file_path',
        'status', 'created_by',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->uuid = Str::uuid());
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
