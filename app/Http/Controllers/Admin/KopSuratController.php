<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KopSuratController extends Controller
{
    public function __construct(
        private SettingService $settingService,
    ) {}

    public function show()
    {
        $settings = \App\Models\VillageSetting::pluck('value', 'key')->toArray();

        return view('admin.kop-surat.show', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'kop_nama_kabupaten' => 'nullable|string|max:255',
            'kop_nama_desa' => 'nullable|string|max:255',
            'kop_nama_kecamatan' => 'nullable|string|max:255',
            'kop_alamat_kantor' => 'nullable|string|max:255',
            'kop_email_desa' => 'nullable|email|max:255',
            'kop_telepon_desa' => 'nullable|string|max:50',
            'kop_logo_pemda' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kop_logo_desa' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $files = [];

        if ($request->hasFile('kop_logo_pemda')) {
            $files['logo_pemda'] = $request->file('kop_logo_pemda');
        }

        if ($request->hasFile('kop_logo_desa')) {
            $files['logo_desa'] = $request->file('kop_logo_desa');
        }

        // Map kop fields to village settings keys
        $mapped = [
            'nama_kabupaten' => $validated['kop_nama_kabupaten'] ?? null,
            'nama_desa' => $validated['kop_nama_desa'] ?? null,
            'nama_kecamatan' => $validated['kop_nama_kecamatan'] ?? null,
            'alamat_kantor' => $validated['kop_alamat_kantor'] ?? null,
            'email_desa' => $validated['kop_email_desa'] ?? null,
            'telepon_desa' => $validated['kop_telepon_desa'] ?? null,
        ];

        // Only save non-null values
        $mapped = array_filter($mapped, fn ($v) => $v !== null && $v !== '');

        $this->settingService->updateGroup('identity', $mapped, $files);

        ActivityLog::catat(
            'update_kop_surat',
            auth()->user()->name.' mengubah kop surat',
            'pengaturan',
            null
        );

        return redirect()->route('admin.kop-surat.show')
            ->with('success', 'Kop surat berhasil diperbarui. Perubahan berlaku untuk semua surat.');
    }
}
