<?php

namespace App\Services;

use RuntimeException;
use Symfony\Component\Process\Process;

class GitUpdateService
{
    private const TIMEOUT = 600;

    private function basePath(): string
    {
        return base_path();
    }

    private function run(array $command, ?int $timeout = null, array $env = []): array
    {
        $process = new Process($command, $this->basePath(), array_merge([
            'GIT_TERMINAL_PROMPT' => '0',
            'COMPOSER_NO_INTERACTION' => '1',
            'CI' => '1',
        ], $env));
        $process->setTimeout($timeout ?? self::TIMEOUT);
        $process->run();

        return [
            'success' => $process->isSuccessful(),
            'output' => trim($process->getOutput().$process->getErrorOutput()),
        ];
    }

    private function mustRun(array $command, ?int $timeout = null): string
    {
        $result = $this->run($command, $timeout);

        if (! $result['success']) {
            throw new RuntimeException($result['output'] ?: 'Perintah gagal dijalankan.');
        }

        return $result['output'];
    }

    private function currentBranch(): string
    {
        return $this->mustRun(['git', 'symbolic-ref', '--short', 'HEAD']);
    }

    public function isGitRepository(): bool
    {
        $process = new Process(['git', 'rev-parse', '--is-inside-work-tree'], $this->basePath());
        $process->run();

        return $process->isSuccessful() && trim($process->getOutput()) === 'true';
    }

    public function gitAvailable(): bool
    {
        $process = new Process(['git', '--version']);
        $process->run();

        return $process->isSuccessful();
    }

    public function currentVersion(): array
    {
        if (! $this->isGitRepository()) {
            return [
                'available' => false,
                'hash' => null,
                'shortHash' => null,
                'message' => null,
                'date' => null,
                'branch' => null,
            ];
        }

        $hash = $this->mustRun(['git', 'rev-parse', 'HEAD']);
        $log = $this->mustRun(['git', 'log', '-1', '--format=%h|%s|%cI']);
        [$shortHash, $message, $date] = array_pad(explode('|', $log, 3), 3, null);

        return [
            'available' => true,
            'hash' => $hash,
            'shortHash' => $shortHash,
            'message' => $message,
            'date' => $date,
            'branch' => $this->currentBranch(),
        ];
    }

    public function checkForUpdates(): array
    {
        $branch = $this->currentBranch();

        $fetch = $this->run(['git', 'fetch', 'origin', $branch]);

        if (! $fetch['success']) {
            return [
                'available' => false,
                'branch' => $branch,
                'behindCount' => 0,
                'hasUpdate' => false,
                'latestHash' => null,
                'latestMessage' => null,
                'latestDate' => null,
                'error' => $fetch['output'] ?: 'Gagal menghubungi origin (git fetch). Periksa koneksi internet.',
            ];
        }

        $behind = $this->mustRun(['git', 'rev-list', '--count', 'HEAD..origin/'.$branch]);
        $latestLog = $this->mustRun(['git', 'log', '-1', '--format=%h|%s|%cI', 'origin/'.$branch]);
        [$latestHash, $latestMessage, $latestDate] = array_pad(explode('|', $latestLog, 3), 3, null);

        return [
            'available' => true,
            'branch' => $branch,
            'behindCount' => (int) $behind,
            'hasUpdate' => ((int) $behind) > 0,
            'latestHash' => $latestHash,
            'latestMessage' => $latestMessage,
            'latestDate' => $latestDate,
        ];
    }

    public function update(): array
    {
        $steps = [];

        $branch = $this->currentBranch();

        $commands = [
            'git_pull' => ['git', 'pull', '--ff-only', 'origin', $branch],
            'composer' => ['composer', 'install', '--no-dev', '--optimize-autoloader', '--no-interaction'],
            'migrate' => [PHP_BINARY, 'artisan', 'migrate', '--force'],
            'npm' => ['npm', 'ci'],
            'build' => ['npm', 'run', 'build'],
            'optimize' => [PHP_BINARY, 'artisan', 'optimize:clear'],
        ];

        foreach ($commands as $key => $command) {
            $result = $this->run($command);
            $steps[] = [
                'step' => $key,
                'success' => $result['success'],
                'output' => $result['output'],
            ];

            if (! $result['success']) {
                break;
            }
        }

        $ok = ! collect($steps)->contains(fn ($step) => ! $step['success']);

        return [
            'success' => $ok,
            'steps' => $steps,
            'version' => $ok ? $this->currentVersion() : null,
        ];
    }
}
