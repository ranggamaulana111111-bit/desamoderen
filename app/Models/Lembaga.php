<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lembaga extends Model
{
    protected $fillable = [
        'nama',
        'singkatan',
        'jenis',
        'deskripsi',
        'ketua',
        'alamat',
        'no_hp',
        'email',
        'foto',
        'status',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function getJenisLabelAttribute(): string
    {
        return self::jenisOptions()[$this->jenis] ?? $this->jenis;
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'aktif' ? 'Aktif' : 'Nonaktif';
    }

    public static function jenisOptions(): array
    {
        return [
            'karang_taruna' => 'Karang Taruna',
            'bumdes' => 'BUMDes',
            'pkk' => 'PKK',
            'lpm' => 'LPM',
            'linmas' => 'Linmas',
            'kwt' => 'KWT',
            'bkm' => 'BKM',
            'toga' => 'Toga',
            'lainnya' => 'Lainnya',
        ];
    }
}
