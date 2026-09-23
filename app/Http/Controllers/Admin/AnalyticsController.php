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
        [$start, $end] = $this->resolveRange($request);

        $stats = $this->analyticsService->getFilteredStats($start, $end);

        $activeWidgets = $this->activeWidgets();
        $refreshInterval = $this->refreshInterval();

        return view('admin.analytics.index', compact('stats', 'start', 'end', 'activeWidgets', 'refreshInterval'));
    }

    public function chartData(Request $request)
    {
        [$start, $end] = $this->resolveRange($request);

        $stats = $this->analyticsService->getFilteredStats($start, $end);

        return response()->json($stats);
    }

    public function exportCsv(Request $request)
    {
        [$start, $end] = $this->resolveRange($request);

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

    private function resolveRange(Request $request): array
    {
        $start = null;
        $end = null;

        if ($request->filled('start')) {
            $parsed = Carbon::createFromFormat('Y-m-d', $request->start);
            if (! $parsed) {
                abort(422, 'Format tanggal mulai tidak valid (Y-m-d).');
            }
            $start = $parsed->startOfDay();
        }

        if ($request->filled('end')) {
            $parsed = Carbon::createFromFormat('Y-m-d', $request->end);
            if (! $parsed) {
                abort(422, 'Format tanggal akhir tidak valid (Y-m-d).');
            }
            $end = $parsed->startOfDay();
        }

        if ($start && $end && $start->gt($end)) {
            abort(422, 'Tanggal mulai tidak boleh lebih baru dari tanggal akhir.');
        }

        if (! $start) {
            $defaultDays = (int) config('village.analytics_default_filter', 30);
            $start = now()->subDays($defaultDays)->startOfDay();
        }

        return [$start, $end];
    }

    private function activeWidgets(): array
    {
        $raw = array_filter(array_map('trim', explode(',', (string) config('village.analytics_widget_aktif', ''))));

        return $raw ?: ['overview', 'trends', 'popular', 'processing', 'users', 'status'];
    }

    private function refreshInterval(): int
    {
        return max(0, (int) config('village.analytics_refresh_interval', 300));
    }
}
