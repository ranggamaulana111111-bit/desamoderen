<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AntreanPengambilan extends Model
{
    public const STATUS_MENUNGGU = 'menunggu';

    public const STATUS_DIAMBIL = 'diambil';

    public const STATUS_LEWAT = 'lewat';

    protected $table = 'antrean_pengambilan';

    protected $fillable = [
        'pengajuan_id',
        'nomor_antrean',
        'tanggal_ambil',
        'jam_mulai',
        'jam_selesai',
        'kode_qr',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_ambil' => 'date',
        ];
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('tanggal_ambil', now()->toDateString());
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    public function markAsTaken(int $userId): void
    {
        $this->update(['status' => self::STATUS_DIAMBIL]);
    }

    public function markAsMissed(int $userId): void
    {
        $this->update(['status' => self::STATUS_LEWAT]);
    }

    public static function generateNomor(\DateTime $tanggal): string
    {
        $prefix = 'AQ/'.$tanggal->format('Ymd');

        $last = static::whereDate('tanggal_ambil', $tanggal)
            ->lockForUpdate()
            ->orderBy('id', 'desc')
            ->first();

        $next = $last ? (int) substr($last->nomor_antrean, -3) + 1 : 1;

        return $prefix.'/'.str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
