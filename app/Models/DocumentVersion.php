<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentVersion extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'version_number',
        'status_at_version',
        'data_snapshot',
        'catatan',
        'pdf_path',
        'changes_summary',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'data_snapshot' => 'array',
            'version_number' => 'integer',
        ];
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanSurat::class, 'pengajuan_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getVersionLabelAttribute(): string
    {
        return 'v'.$this->version_number;
    }

    public function getChangesSummaryAttribute(?string $value): string
    {
        return $value ?? 'Tidak ada catatan perubahan';
    }
}
