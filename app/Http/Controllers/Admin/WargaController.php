<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('Warga');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nik_hash', User::hashNik($search));
            });
        }

        $warga = $query->latest()->paginate(20);

        return view('admin.warga.index', compact('warga'));
    }
}
