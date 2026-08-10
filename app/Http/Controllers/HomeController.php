<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Lembaga;
use App\Models\LetterConfig;
use App\Models\PengajuanSurat;
use App\Models\User;
use App\Services\SettingService;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    public function index()
    {
        $berita = Berita::with(['user', 'lembaga'])
            ->where('status', 'publish')
            ->orderByDesc('dilihat')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $sliderBerita = $berita->map(function ($b) {
            return [
                'id' => $b->id,
                'url' => route('berita.show', $b->slug),
                'judul' => $b->judul,
                'excerpt' => Str::limit(strip_tags($b->konten), 180),
                'bg' => $b->foto
                    ? "background-image:url('".asset('storage/'.$b->foto)."')"
                    : 'background:linear-gradient(135deg,#022c22,#064e3b 60%,#0f766e)',
                'tanggal' => $b->created_at->locale('id')->translatedFormat('d M Y'),
                'dilihat' => $b->dilihat ?? 0,
                'lembaga' => $b->lembaga?->nama ?? 'Pemerintah Desa',
                'lembagaKey' => $b->lembaga_id ? (string) $b->lembaga_id : 'pemdes',
            ];
        })->values();

        $pemdesCount = Berita::where('status', 'publish')->whereNull('lembaga_id')->count();

        $lembagas = Lembaga::withCount(['berita' => function ($q) {
            $q->where('status', 'publish');
        }])
            ->whereHas('berita', function ($q) {
                $q->where('status', 'publish');
            })
            ->orderBy('nama')
            ->get();

        $totalWarga = Role::where('name', 'Warga')->exists()
            ? User::role('Warga')->count()
            : 0;
        $totalSurat = PengajuanSurat::count();
        $suratSelesai = PengajuanSurat::where('status', 'completed')->count();
        $totalBerita = Berita::where('status', 'publish')->count();
        $jenisSurat = LetterConfig::active()->count();

        $officials = app(SettingService::class)->getByGroup('officials');

        return view('home', compact(
            'berita', 'sliderBerita', 'lembagas', 'pemdesCount',
            'totalWarga', 'totalSurat', 'suratSelesai', 'totalBerita', 'jenisSurat', 'officials'
        ));
    }
}
