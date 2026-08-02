<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Apbdesa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'apbdesa';

    protected $fillable = [
        'tahun',
        'kategori',
        'bidang',
        'uraian',
        'anggaran',
        'realisasi',
        'sumber_dana',
        'keterangan',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'anggaran' => 'decimal:2',
        'realisasi' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Apbdesa $model) {
            $model->uuid = Str::uuid();
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
