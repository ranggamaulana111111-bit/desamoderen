<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\SettingVersion;
use App\Models\VillageSetting;
use Illuminate\Support\Facades\DB;

class SettingVersionService
{
    public function __construct(
        private SettingService $settingService,
    ) {}

    public function createSnapshot(?string $label = null, ?array $changes = null): SettingVersion
    {
        $allSettings = VillageSetting::pluck('value', 'key')->toArray();
        $latestVersion = SettingVersion::max('version_number') ?? 0;

        return SettingVersion::create([
            'version_number' => $latestVersion + 1,
            'label' => $label ?? 'v'.($latestVersion + 1),
            'data_snapshot' => $allSettings,
            'changes_summary' => $changes,
            'created_by' => auth()->id(),
        ]);
    }

    public function getVersions(int $limit = 20): array
    {
        return SettingVersion::with('createdBy')
            ->latest()
            ->take($limit)
            ->get()
            ->toArray();
    }

    public function getVersion(int $id): ?SettingVersion
    {
        return SettingVersion::with('createdBy')->find($id);
    }

    public function rollback(int $versionId): bool
    {
        $version = SettingVersion::findOrFail($versionId);
        $snapshot = $version->data_snapshot;

        $oldSettings = VillageSetting::pluck('value', 'key')->toArray();

        DB::transaction(function () use ($snapshot) {
            foreach ($snapshot as $key => $value) {
                VillageSetting::where('key', $key)->update(['value' => $value]);
            }
        });

        $this->settingService->clearCache();

        $userName = auth()->user()->name ?? 'System';
        ActivityLog::catat(
            'rollback_pengaturan',
            "{$userName} melakukan rollback pengaturan ke versi v{$version->version_number} ({$version->label})",
            'pengaturan',
            null
        );

        $this->createSnapshot(
            "Rollback ke v{$version->version_number}",
            ['rollback_from' => $versionId]
        );

        return true;
    }

    public function diffBetweenVersions(int $fromId, int $toId): array
    {
        $from = SettingVersion::findOrFail($fromId);
        $to = SettingVersion::findOrFail($toId);

        $fromData = $from->data_snapshot;
        $toData = $to->data_snapshot;

        $changes = [];
        $allKeys = array_unique(array_merge(array_keys($fromData), array_keys($toData)));

        foreach ($allKeys as $key) {
            $oldVal = $fromData[$key] ?? null;
            $newVal = $toData[$key] ?? null;
            if ($oldVal !== $newVal) {
                $changes[$key] = ['old' => $oldVal, 'new' => $newVal];
            }
        }

        return $changes;
    }

    public function getLatestVersionNumber(): int
    {
        return SettingVersion::max('version_number') ?? 0;
    }
}
