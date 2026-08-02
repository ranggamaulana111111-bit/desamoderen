<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($type = $request->input('tipe')) {
            $query->where('tipe', $type);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                    ->orWhere('aksi', 'like', "%{$search}%");
            });
        }

        if ($userId = $request->input('user_id')) {
            $query->where('user_id', $userId);
        }

        $types = ActivityLog::distinct()->whereNotNull('tipe')->pluck('tipe');
        $logs = $query->latest()->paginate(30)->withQueryString();

        return view('admin.activity-log.index', compact('logs', 'types'));
    }
}
