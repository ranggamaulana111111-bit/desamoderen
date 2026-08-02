<?php

namespace App\Http\Controllers\Admin;

use App\Dashboard\WidgetManager;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Services\ThemeSettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class WidgetController extends Controller
{
    public function show(Request $request, string $key): JsonResponse
    {
        try {
            $manager = app(WidgetManager::class);
            $manager->init();

            $data = $manager->getWidgetData($key);

            if ($data === null) {
                return response()->json([
                    'error' => true,
                    'message' => 'Widget tidak ditemukan atau tidak tersedia untuk role Anda.',
                ], 404);
            }

            $html = view("components.widgets._{$key}", $data)->render();

            return response()->json([
                'key' => $key,
                'data' => $data,
                'html' => $html,
            ]);
        } catch (Throwable $e) {
            Log::error("Widget [{$key}] load failed: {$e->getMessage()}", [
                'widget' => $key,
                'user_id' => $request->user()?->id,
                'exception' => $e,
            ]);

            ActivityLog::catat(
                'widget_error',
                "Widget \"{$key}\" gagal dimuat: {$e->getMessage()}",
                'dashboard',
            );

            return response()->json([
                'error' => true,
                'message' => $this->getWidgetErrorMessage($key, $e),
            ], 500);
        }
    }

    private function getWidgetErrorMessage(string $key, Throwable $e): string
    {
        if (str_contains($e->getMessage(), 'View [') && str_contains($e->getMessage(), 'not found')) {
            return "Template widget \"{$key}\" belum tersedia.";
        }

        if (str_contains($e->getMessage(), 'Class "') && str_contains($e->getMessage(), 'not found')) {
            return "Widget \"{$key}\" belum terdaftar di sistem.";
        }

        return "Widget \"{$key}\" sementara tidak dapat dimuat. Silakan coba lagi beberapa saat.";
    }

    public function saveLayout(Request $request): JsonResponse
    {
        $request->validate([
            'layout' => 'required|array',
            'layout.*.key' => 'required|string',
            'layout.*.position' => 'required|integer|min:0',
            'layout.*.visible' => 'required|boolean',
            'layout.*.width' => 'nullable|string|in:full,half,third',
            'layout.*.colspan' => 'nullable|integer|min:1|max:12',
        ]);

        $user = $request->user();

        foreach ($request->layout as $item) {
            $user->dashboardLayouts()->updateOrCreate(
                ['widget_key' => $item['key']],
                [
                    'position' => $item['position'],
                    'visible' => $item['visible'],
                    'width' => $item['width'] ?? 'full',
                    'colspan' => $item['colspan'] ?? 12,
                ]
            );
        }

        return response()->json(['success' => true]);
    }

    public function getTheme(Request $request): JsonResponse
    {
        $settings = app(ThemeSettingsService::class)->getForUser($request->user()->id);

        return response()->json($settings);
    }

    public function saveTheme(Request $request): JsonResponse
    {
        $request->validate([
            'theme' => 'nullable|string|in:light,dark,system',
            'density' => 'nullable|string|in:compact,comfortable,loose',
            'accent_color' => 'nullable|string|in:emerald,blue,purple,indigo,amber,cyan,rose',
            'sidebar_collapsed' => 'nullable|boolean',
        ]);

        $settings = app(ThemeSettingsService::class)->saveForUser(
            $request->only(['theme', 'density', 'accent_color', 'sidebar_collapsed']),
            $request->user()->id,
        );

        return response()->json(['success' => true, 'settings' => $settings]);
    }
}
