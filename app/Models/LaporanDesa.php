<?php

namespace App\Models;

use App\Services\LaporanService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LaporanDesa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laporan_desas';

    protected $fillable = [
        'uuid',
        'judul',
        'periode_mulai',
        'periode_akhir',
        'tipe_periode',
        'modul_yang_dipilih',
        'konten_naratif',
        'status',
        'format_pdf',
        'nomor_laporan',
        'approved_by',
        'approved_at',
        'pdf_path',
        'created_by',
    ];

    protected $casts = [
        'periode_mulai' => 'date',
        'periode_akhir' => 'date',
        'modul_yang_dipilih' => 'array',
        'konten_naratif' => 'array',
        'approved_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
            if (empty($model->nomor_laporan)) {
                $model->nomor_laporan = self::generateNomorLaporan();
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isFinalized(): bool
    {
        return $this->status === 'finalisasi';
    }

    public function canEdit(): bool
    {
        return $this->status === 'draft';
    }

    public function getPeriodeLabelAttribute(): string
    {
        return $this->periode_mulai->format('d M Y') . ' — ' . $this->periode_akhir->format('d M Y');
    }

    public function getModuleLabelsAttribute(): array
    {
        $labels = LaporanService::MODULE_LABELS;
        return array_map(fn($key) => $labels[$key] ?? $key, $this->modul_yang_dipilih ?? []);
    }

    public function slugifyJudul(): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->judul), '-'));
    }

    private static function generateNomorLaporan(): string
    {
        $year = now()->format('Y');
        $month = now()->format('n');
        $romanMonths = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];
        $romanMonth = $romanMonths[(int) $month];
        $lastSequence = static::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
        $seq = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);

        return "{$seq}/Laporan-Desa/{$romanMonth}/{$year}";
    }
}
