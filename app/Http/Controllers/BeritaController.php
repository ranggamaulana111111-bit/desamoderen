<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class BeritaController extends Controller
{
    public function show($slug)
    {
        $berita = Berita::with('user')
            ->where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        return view('berita.show', compact('berita'));
    }
}
