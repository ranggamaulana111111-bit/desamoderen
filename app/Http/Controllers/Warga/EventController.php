<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\EventPeserta;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function konfirmasi(Request $request, EventPeserta $undangan)
    {
        if ($undangan->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'konfirmasi' => 'required|in:hadir,izin,absen',
        ]);

        $undangan->update($validated);

        return redirect()->back()
            ->with('success', 'Konfirmasi kehadiran berhasil disimpan');
    }
}
