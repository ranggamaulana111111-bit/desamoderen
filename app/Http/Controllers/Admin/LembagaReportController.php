<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LembagaKinerjaService;
use Illuminate\Http\Request;

class LembagaReportController extends Controller
{
    public function __construct(private LembagaKinerjaService $service) {}

    public function index(Request $request)
    {
        $availableYears = $this->service->getAvailableYears();

        $year = (int) $request->input('tahun', now()->year);
        $type = (string) $request->input('jenis', 'total');

        if (! in_array($year, $availableYears, true)) {
            $year = now()->year;
        }

        $report = $this->service->getReport($year, $type);
        $trend = $this->service->getYearlyTrend(min($availableYears), max($availableYears));

        return view('admin.lembaga.report', compact('report', 'trend', 'availableYears', 'year', 'type'));
    }
}
