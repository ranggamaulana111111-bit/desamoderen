<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disposisi extends Model
{
    protected $fillable = [
        'surat_masuk_id', 'tujuan_disposisi', 'isi_disposisi',
        'sifat_disposisi', 'deadline', 'status', 'created_by',
    ];

    public function suratMasuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function tujuanUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tujuan_disposisi');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
