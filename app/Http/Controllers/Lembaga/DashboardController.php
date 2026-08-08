<?php

namespace App\Http\Controllers\Lembaga;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $lembaga = auth()->user()->lembaga;

        if (! $lembaga) {
            abort(403, 'Akun ini tidak terhubung dengan lembaga mana pun.');
        }

        $stats = [
            'berita_total' => $lembaga->berita()->count(),
            'event_total' => $lembaga->events()->count(),
            'berita_bulan' => $lembaga->berita()
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count(),
            'event_bulan' => $lembaga->events()
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count(),
            'dilihat_total' => $lembaga->berita()->where('status', 'publish')->sum('dilihat'),
            'draft_total' => $lembaga->berita()->where('status', 'draft')->count(),
        ];

        $recentBerita = $lembaga->berita()->latest()->take(5)->get();
        $recentEvents = $lembaga->events()->latest()->take(5)->get();
        $topBerita = $lembaga->berita()
            ->where('status', 'publish')
            ->orderByDesc('dilihat')
            ->take(5)
            ->get();

        return view('lembaga.dashboard', compact('lembaga', 'stats', 'recentBerita', 'recentEvents', 'topBerita'));
    }
}
