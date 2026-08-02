<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingVersionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingVersionController extends Controller
{
    public function __construct(
        private SettingVersionService $versionService,
    ) {}

    public function index()
    {
        $versions = $this->versionService->getVersions(50);

        return response()->json($versions);
    }

    public function show(int $id)
    {
        $version = $this->versionService->getVersion($id);

        if (! $version) {
            return response()->json(['error' => 'Version not found'], 404);
        }

        return response()->json($version);
    }

    public function rollback(Request $request, int $id): RedirectResponse
    {
        try {
            $this->versionService->rollback($id);

            return redirect()->route('admin.setting.index', ['tab' => 'audit-log'])
                ->with('success', 'Pengaturan berhasil dirollback ke versi sebelumnya.');
        } catch (\Exception $e) {
            return redirect()->route('admin.setting.index', ['tab' => 'audit-log'])
                ->with('error', 'Gagal melakukan rollback: '.$e->getMessage());
        }
    }

    public function diff(int $from, int $to)
    {
        $changes = $this->versionService->diffBetweenVersions($from, $to);

        return response()->json($changes);
    }
}
