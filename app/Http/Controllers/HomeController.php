<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\PengajuanSurat;
use App\Models\User;
use App\Services\SettingService;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    public function index()
    {
        $berita = Berita::with('user')
            ->where('status', 'publish')
            ->latest()
            ->take(6)
            ->get();

        $totalWarga = Role::where('name', 'Warga')->exists()
            ? User::role('Warga')->count()
            : 0;
        $totalSurat = PengajuanSurat::count();
        $suratSelesai = PengajuanSurat::where('status', 'completed')->count();
        $totalBerita = Berita::where('status', 'publish')->count();

        $officials = app(SettingService::class)->getByGroup('officials');

        return view('home', compact(
            'berita', 'totalWarga', 'totalSurat', 'suratSelesai', 'totalBerita', 'officials'
        ));
    }
}
