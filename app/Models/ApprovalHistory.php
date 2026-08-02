<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalHistory extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'user_id',
        'status',
        'catatan',
        'step_order',
    ];

    protected static function booted(): void
    {
        static::creating(function (ApprovalHistory $history) {
            if (is_null($history->step_order)) {
                $history->step_order = static::where('pengajuan_id', $history->pengajuan_id)->max('step_order') + 1;
            }
        });
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function STATUS_LABELS(): array
    {
        return [
            'submitted' => 'Diajukan',
            'verified' => 'Diverifikasi Operator',
            'revision' => 'Perlu Perbaikan',
            'approved_operator' => 'Disetujui Operator',
            'approved_sekdes' => 'Disetujui Sekretaris Desa',
            'approved_kades' => 'Disetujui Kepala Desa',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
        ];
    }

    public static function STATUS_COLORS(): array
    {
        return [
            'submitted' => 'bg-blue-100 text-blue-800',
            'verified' => 'bg-indigo-100 text-indigo-800',
            'revision' => 'bg-yellow-100 text-yellow-800',
            'approved_operator' => 'bg-purple-100 text-purple-800',
            'approved_sekdes' => 'bg-cyan-100 text-cyan-800',
            'approved_kades' => 'bg-emerald-100 text-emerald-800',
            'completed' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
        ];
    }

    public static function STATUS_ICONS(): array
    {
        return [
            'submitted' => 'M12 4v16m8-8H4',
            'verified' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'revision' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
            'approved_operator' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'approved_sekdes' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'approved_kades' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            'completed' => 'M5 13l4 4L19 7',
            'rejected' => 'M6 18L18 6M6 6l12 12',
        ];
    }

    public function getLabelAttribute(): string
    {
        return self::STATUS_LABELS()[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getColorAttribute(): string
    {
        return self::STATUS_COLORS()[$this->status] ?? 'bg-gray-100 text-gray-700';
    }

    public function getIconAttribute(): string
    {
        return self::STATUS_ICONS()[$this->status] ?? 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
    }
}
