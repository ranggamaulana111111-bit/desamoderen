<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class QueueMonitoringService
{
    public function getStats(): array
    {
        return [
            'waiting' => DB::table('jobs')->count(),
            'failed' => DB::table('failed_jobs')->count(),
            'batches_total' => DB::table('job_batches')->count(),
            'batches_pending' => DB::table('job_batches')->sum('pending_jobs'),
            'batches_failed' => DB::table('job_batches')->sum('failed_jobs'),
        ];
    }

    public function getJobsQueue(): array
    {
        return DB::table('jobs')
            ->select('queue', DB::raw('count(*) as total'))
            ->groupBy('queue')
            ->orderByDesc('total')
            ->get()
            ->toArray();
    }

    public function getFailedJobs(int $perPage = 50): array
    {
        $failed = DB::table('failed_jobs')
            ->orderByDesc('failed_at')
            ->paginate($perPage);

        $items = collect($failed->items())->map(function ($job) {
            $payload = json_decode($job->payload, true);

            return (object) [
                'id' => $job->id,
                'uuid' => $job->uuid,
                'connection' => $job->connection,
                'queue' => $job->queue,
                'display_name' => $payload['displayName'] ?? class_basename($payload['data']['commandName'] ?? 'Unknown'),
                'exception_preview' => $this->previewException($job->exception),
                'failed_at' => $job->failed_at,
            ];
        });

        return [
            'items' => $items,
            'total' => $failed->total(),
            'per_page' => $failed->perPage(),
            'current_page' => $failed->currentPage(),
            'last_page' => $failed->lastPage(),
            'has_more' => $failed->hasMorePages(),
            'next_page' => $failed->nextPageUrl(),
            'previous_page' => $failed->previousPageUrl(),
        ];
    }

    public function getProcessingTime(): array
    {
        $avg = DB::table('job_batches')
            ->whereNotNull('finished_at')
            ->select(DB::raw('AVG(finished_at - created_at) as avg_seconds'))
            ->value('avg_seconds');

        $today = DB::table('job_batches')
            ->whereNotNull('finished_at')
            ->where('created_at', '>=', now()->startOfDay()->timestamp)
            ->select(DB::raw('AVG(finished_at - created_at) as avg_seconds'))
            ->value('avg_seconds');

        return [
            'overall_avg_seconds' => round((float) ($avg ?? 0), 2),
            'today_avg_seconds' => round((float) ($today ?? 0), 2),
        ];
    }

    public function getBatchStatusCounts(): array
    {
        $batches = DB::table('job_batches')->get();

        $statuses = [
            'completed' => 0,
            'processing' => 0,
            'failed' => 0,
            'cancelled' => 0,
        ];

        foreach ($batches as $batch) {
            if (! is_null($batch->cancelled_at)) {
                $statuses['cancelled']++;
            } elseif (! is_null($batch->finished_at) && $batch->failed_jobs === 0) {
                $statuses['completed']++;
            } elseif (! is_null($batch->finished_at) && $batch->failed_jobs > 0) {
                $statuses['failed']++;
            } else {
                $statuses['processing']++;
            }
        }

        return $statuses;
    }

    public function getWeeklyStats(): array
    {
        $days = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $startOfDay = now()->subDays($i)->startOfDay()->timestamp;
            $endOfDay = now()->subDays($i)->endOfDay()->timestamp;

            $processed = DB::table('job_batches')
                ->whereNotNull('finished_at')
                ->whereBetween('created_at', [$startOfDay, $endOfDay])
                ->count();

            $failed = DB::table('failed_jobs')
                ->whereDate('failed_at', $date)
                ->count();

            $days->push([
                'date' => $date,
                'label' => now()->subDays($i)->locale('id')->isoFormat('dddd'),
                'processed' => $processed,
                'failed' => $failed,
            ]);
        }

        return $days->toArray();
    }

    public function deleteFailedJob(int $id): void
    {
        DB::table('failed_jobs')->where('id', $id)->delete();
    }

    public function deleteAllFailedJobs(): int
    {
        return DB::table('failed_jobs')->delete();
    }

    private function previewException(string $exception): string
    {
        $lines = explode("\n", $exception);

        return implode("\n", array_slice($lines, 0, 5));
    }
}
