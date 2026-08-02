<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\DocumentVersion;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentVersionService
{
    public function createVersion(PengajuanSurat $surat, User $user, ?string $catatan = null, ?string $changesSummary = null): DocumentVersion
    {
        return DB::transaction(function () use ($surat, $user, $catatan, $changesSummary) {
            $latestVersion = DocumentVersion::where('pengajuan_id', $surat->id)
                ->max('version_number') ?? 0;

            $versionNumber = $latestVersion + 1;

            $pdfPath = null;
            if ($surat->pdf_path && Storage::disk('private')->exists($surat->pdf_path)) {
                $pathInfo = pathinfo($surat->pdf_path);
                $pdfPath = $pathInfo['dirname'].'/'.$pathInfo['filename']."_v{$versionNumber}.".$pathInfo['extension'];

                Storage::disk('private')->copy($surat->pdf_path, $pdfPath);
            }

            return DocumentVersion::create([
                'pengajuan_id' => $surat->id,
                'version_number' => $versionNumber,
                'status_at_version' => $surat->status,
                'data_snapshot' => $surat->data_tambahan,
                'catatan' => $catatan,
                'pdf_path' => $pdfPath,
                'changes_summary' => $changesSummary,
                'created_by' => $user->id,
            ]);
        });
    }

    public function getVersions(PengajuanSurat $surat): Collection
    {
        return $surat->documentVersions()
            ->with('createdBy')
            ->orderByDesc('version_number')
            ->get();
    }

    public function getVersion(PengajuanSurat $surat, int $versionNumber): ?DocumentVersion
    {
        return DocumentVersion::where('pengajuan_id', $surat->id)
            ->where('version_number', $versionNumber)
            ->with('createdBy')
            ->first();
    }

    public function restore(PengajuanSurat $surat, int $versionNumber, User $user): DocumentVersion
    {
        return DB::transaction(function () use ($surat, $versionNumber, $user) {
            $version = $this->getVersion($surat, $versionNumber);

            if (! $version) {
                throw new \InvalidArgumentException("Versi #{$versionNumber} tidak ditemukan.");
            }

            $oldData = $surat->data_tambahan;

            $surat->update([
                'data_tambahan' => $version->data_snapshot,
            ]);

            $changesSummary = $this->buildRestoreSummary($oldData, $version->data_snapshot);

            $newVersion = $this->createVersion(
                $surat,
                $user,
                "Dikembalikan ke versi {$version->version_label}: {$version->catatan}",
                $changesSummary
            );

            ActivityLog::catat(
                'restore_version',
                "{$user->name} mengembalikan pengajuan #{$surat->id} ke versi {$version->version_label}.",
                'pengajuan',
                $surat->id
            );

            return $newVersion;
        });
    }

    public function diff(PengajuanSurat $surat, int $versionA, int $versionB): array
    {
        $vA = $this->getVersion($surat, $versionA);
        $vB = $this->getVersion($surat, $versionB);

        if (! $vA || ! $vB) {
            throw new \InvalidArgumentException('Versi tidak ditemukan.');
        }

        $dataA = $vA->data_snapshot ?? [];
        $dataB = $vB->data_snapshot ?? [];

        $allKeys = array_unique(array_merge(array_keys($dataA), array_keys($dataB)));
        $diff = [];

        foreach ($allKeys as $key) {
            $old = $dataA[$key] ?? null;
            $new = $dataB[$key] ?? null;

            if ($old !== $new) {
                $diff[] = [
                    'field' => $key,
                    'old' => $old,
                    'new' => $new,
                    'type' => is_null($old) ? 'added' : (is_null($new) ? 'removed' : 'changed'),
                ];
            }
        }

        return [
            'versionA' => $vA,
            'versionB' => $vB,
            'diff' => $diff,
        ];
    }

    private function buildRestoreSummary(array $oldData, array $newData): string
    {
        $changes = [];
        foreach ($newData as $key => $value) {
            $oldValue = $oldData[$key] ?? null;
            if ($oldValue !== $value) {
                $changes[] = str_replace('_', ' ', $key);
            }
        }

        return 'Data yang dikembalikan: '.implode(', ', $changes);
    }
}
