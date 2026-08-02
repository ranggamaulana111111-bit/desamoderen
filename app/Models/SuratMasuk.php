<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuks';

    protected $fillable = [
        'uuid', 'nomor_agenda', 'tanggal_terima', 'tanggal_surat',
        'nomor_surat', 'pengirim', 'perihal', 'jenis_surat',
        'sifat_surat', 'file_path', 'keterangan', 'status', 'created_by',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn ($model) => $model->uuid = Str::uuid());
    }

    public function disposisis(): HasMany
    {
        return $this->hasMany(Disposisi::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
