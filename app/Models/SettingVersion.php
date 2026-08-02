<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SettingVersion extends Model
{
    protected $fillable = [
        'version_number',
        'label',
        'data_snapshot',
        'changes_summary',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'version_number' => 'integer',
            'changes_summary' => 'array',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDataSnapshotAttribute(string $value): array
    {
        return json_decode($value, true) ?? [];
    }

    public function setDataSnapshotAttribute(array $data): void
    {
        $this->attributes['data_snapshot'] = json_encode($data);
    }

    public function getVersionLabelAttribute(): string
    {
        return 'v'.$this->version_number;
    }
}
