<?php

namespace App\Services;

use App\Models\Berita;
use App\Models\Event;
use App\Models\Lembaga;

class LembagaKinerjaService
{
    public function getAvailableYears(): array
    {
        $years = array_merge(
            Berita::query()->whereNotNull('lembaga_id')->pluck('created_at')->map(fn ($d) => (int) $d->year)->all(),
            Event::query()->whereNotNull('lembaga_id')->pluck('created_at')->map(fn ($d) => (int) $d->year)->all()
        );

        $years = array_values(array_unique($years));

        if (empty($years)) {
            return [now()->year];
        }

        rsort($years);

        return $years;
    }

    public function getReport(int $year, string $type = 'total'): array
    {
        $type = in_array($type, ['berita', 'event', 'total'], true) ? $type : 'total';

        $beritaCounts = $this->countByLembagaMonth(Berita::class, $year);
        $eventCounts = $this->countByLembagaMonth(Event::class, $year);

        $lembagas = Lembaga::query()->orderBy('nama')->get();

        $rows = [];
        $totals = array_fill(1, 12, 0);

        foreach ($lembagas as $lembaga) {
            $berita = $beritaCounts[$lembaga->id] ?? [];
            $events = $eventCounts[$lembaga->id] ?? [];

            $months = [];
            $beritaTotal = 0;
            $eventTotal = 0;

            for ($m = 1; $m <= 12; $m++) {
                $b = $berita[$m] ?? 0;
                $e = $events[$m] ?? 0;
                $beritaTotal += $b;
                $eventTotal += $e;

                $months[$m] = $type === 'berita' ? $b : ($type === 'event' ? $e : $b + $e);
                $totals[$m] += $months[$m];
            }

            $rows[] = [
                'id' => $lembaga->id,
                'nama' => $lembaga->nama,
                'singkatan' => $lembaga->singkatan,
                'status' => $lembaga->status,
                'months' => $months,
                'total' => $type === 'berita' ? $beritaTotal : ($type === 'event' ? $eventTotal : $beritaTotal + $eventTotal),
                'berita_total' => $beritaTotal,
                'event_total' => $eventTotal,
            ];
        }

        return [
            'year' => $year,
            'type' => $type,
            'lembagas' => $rows,
            'totals' => $totals,
            'grand_total' => array_sum($totals),
        ];
    }

    public function getYearlyTrend(int $startYear, int $endYear): array
    {
        $trend = [];

        for ($year = $startYear; $year <= $endYear; $year++) {
            $report = $this->getReport($year, 'total');

            $trend[] = [
                'year' => $year,
                'berita' => array_sum(collect($report['lembagas'])->pluck('berita_total')->all()),
                'event' => array_sum(collect($report['lembagas'])->pluck('event_total')->all()),
                'total' => $report['grand_total'],
            ];
        }

        return $trend;
    }

    private function countByLembagaMonth(string $model, int $year): array
    {
        $rows = $model::query()
            ->whereNotNull('lembaga_id')
            ->whereYear('created_at', $year)
            ->get(['lembaga_id', 'created_at']);

        $counts = [];

        foreach ($rows as $row) {
            $month = (int) $row->created_at->format('n');
            $counts[$row->lembaga_id][$month] = ($counts[$row->lembaga_id][$month] ?? 0) + 1;
        }

        return $counts;
    }
}
