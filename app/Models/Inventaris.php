<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Inventaris extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'kode_inventaris',
        'nama_barang',
        'kategori',
        'nomor_inventaris',
        'kondisi',
        'jumlah',
        'lokasi',
        'tahun_perolehan',
        'nilai_perolehan',
        'foto',
        'keterangan',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tahun_perolehan' => 'integer',
        'nilai_perolehan' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
