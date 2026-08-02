<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Services\QueueMonitoringService;
use Illuminate\Support\Facades\Artisan;

class QueueController extends Controller
{
    public function __construct(
        private QueueMonitoringService $queueService,
    ) {}

    public function index()
    {
        $stats = $this->queueService->getStats();
        $processingTime = $this->queueService->getProcessingTime();
        $batchStatuses = $this->queueService->getBatchStatusCounts();
        $weeklyStats = $this->queueService->getWeeklyStats();
        $jobsByQueue = $this->queueService->getJobsQueue();
        $failed = $this->queueService->getFailedJobs();

        return view('admin.queue.index', compact(
            'stats',
            'processingTime',
            'batchStatuses',
            'weeklyStats',
            'jobsByQueue',
            'failed',
        ));
    }

    public function retry(int $id)
    {
        $job = \DB::table('failed_jobs')->find($id);

        if (! $job) {
            return redirect()->route('admin.queue.index')
                ->with('error', 'Job tidak ditemukan.');
        }

        Artisan::call('queue:retry', ['id' => [$job->uuid]]);

        ActivityLog::catat(
            'retry_job',
            'Admin '.auth()->user()->name." mencoba ulang failed job #{$id} ({$job->uuid}).",
            'queue',
            $id
        );

        return redirect()->route('admin.queue.index')
            ->with('success', "Job #{$id} sedang dijalankan ulang.");
    }

    public function retryAll()
    {
        $count = \DB::table('failed_jobs')->count();

        if ($count === 0) {
            return redirect()->route('admin.queue.index')
                ->with('error', 'Tidak ada failed job untuk di-retry.');
        }

        Artisan::call('queue:retry', ['id' => ['all']]);

        ActivityLog::catat(
            'retry_all_jobs',
            'Admin '.auth()->user()->name." mencoba ulang semua {$count} failed jobs.",
            'queue',
            null
        );

        return redirect()->route('admin.queue.index')
            ->with('success', "Semua {$count} failed job sedang dijalankan ulang.");
    }

    public function destroy(int $id)
    {
        $this->queueService->deleteFailedJob($id);

        ActivityLog::catat(
            'delete_failed_job',
            'Admin '.auth()->user()->name." menghapus failed job #{$id}.",
            'queue',
            $id
        );

        return redirect()->route('admin.queue.index')
            ->with('success', "Failed job #{$id} berhasil dihapus.");
    }

    public function destroyAll()
    {
        $count = $this->queueService->deleteAllFailedJobs();

        ActivityLog::catat(
            'delete_all_failed_jobs',
            'Admin '.auth()->user()->name." menghapus semua {$count} failed jobs.",
            'queue',
            null
        );

        return redirect()->route('admin.queue.index')
            ->with('success', "Semua {$count} failed job berhasil dihapus.");
    }

    public function chartData()
    {
        $weeklyStats = $this->queueService->getWeeklyStats();
        $batchStatuses = $this->queueService->getBatchStatusCounts();
        $stats = $this->queueService->getStats();
        $processingTime = $this->queueService->getProcessingTime();

        return response()->json([
            'weekly' => $weeklyStats,
            'batchStatuses' => $batchStatuses,
            'stats' => $stats,
            'processingTime' => $processingTime,
        ]);
    }
}
