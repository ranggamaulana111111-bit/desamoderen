<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surats';

    protected $fillable = [
        'user_id',
        'submitted_by',
        'current_step',
        'jenis_surat',
        'kode_klasifikasi',
        'nomor_surat',
        'data_tambahan',
        'status',
        'catatan_admin',
        'tanda_tangan_meta',
        'hash_verifikasi',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'data_tambahan' => 'array',
            'tanda_tangan_meta' => 'array',
            'current_step' => 'integer',
        ];
    }

    public const STATUSES = [
        'submitted',
        'verified',
        'revision',
        'approved_operator',
        'approved_sekdes',
        'approved_kades',
        'completed',
        'rejected',
    ];

    public const ACTIVE_STATUSES = [
        'submitted',
        'verified',
        'revision',
        'approved_operator',
        'approved_sekdes',
        'approved_kades',
    ];

    public const TERMINAL_STATUSES = [
        'completed',
        'rejected',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function antrean(): HasOne
    {
        return $this->hasOne(AntreanPengambilan::class, 'pengajuan_id');
    }

    public function approvalHistories(): HasMany
    {
        return $this->hasMany(ApprovalHistory::class, 'pengajuan_id')->orderBy('step_order');
    }

    public function latestApproval(): HasOne
    {
        return $this->hasOne(ApprovalHistory::class, 'pengajuan_id')->latestOfMany();
    }

    public function documentVersions(): HasMany
    {
        return $this->hasMany(DocumentVersion::class, 'pengajuan_id')->orderByDesc('version_number');
    }

    public function scopeForStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', self::ACTIVE_STATUSES);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function getStatusLabelAttribute(): string
    {
        return ApprovalHistory::STATUS_LABELS()[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getStatusColorAttribute(): string
    {
        return ApprovalHistory::STATUS_COLORS()[$this->status] ?? 'bg-gray-100 text-gray-700';
    }

    public function isActive(): bool
    {
        return in_array($this->status, self::ACTIVE_STATUSES);
    }

    public function isTerminal(): bool
    {
        return in_array($this->status, self::TERMINAL_STATUSES);
    }
}
