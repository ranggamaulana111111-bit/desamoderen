<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(
        private AnalyticsService $analyticsService,
    ) {}

    public function index(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : null;
        $end = $request->filled('end') ? Carbon::parse($request->end) : null;

        $stats = $this->analyticsService->getFilteredStats($start, $end);

        return view('admin.analytics.index', compact('stats', 'start', 'end'));
    }

    public function chartData(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : null;
        $end = $request->filled('end') ? Carbon::parse($request->end) : null;

        $stats = $this->analyticsService->getFilteredStats($start, $end);

        return response()->json($stats);
    }

    public function exportCsv(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : null;
        $end = $request->filled('end') ? Carbon::parse($request->end) : null;

        $data = $this->analyticsService->getExportData($start, $end);

        $filename = 'laporan-pengajuan-'.now()->format('Y-m-d-His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            if (! empty($data)) {
                fputcsv($handle, array_keys($data[0]));
                foreach ($data as $row) {
                    fputcsv($handle, $row);
                }
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
