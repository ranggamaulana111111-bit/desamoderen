<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengajuanRequest;
use App\Models\ActivityLog;
use App\Models\LetterConfig;
use App\Models\PengajuanSurat;
use App\Services\ApprovalService;
use App\Services\TelegramNotifier;
use App\Services\WebhookNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    public function __construct(
        private ApprovalService $approvalService,
    ) {}

    public function index(Request $request)
    {
        $query = PengajuanSurat::where('user_id', auth()->id())
            ->with('approvalHistories.user');

        if ($jenis = $request->input('jenis')) {
            $query->where('jenis_surat', $jenis);
        }

        $pengajuan = $query->latest()->get();
        $letterConfigs = LetterConfig::active()->get();

        return view('warga.surat.index', compact('pengajuan', 'letterConfigs'));
    }

    public function create(string $jenis)
    {
        $config = LetterConfig::active()->where('jenis_surat', $jenis)->first();

        if (! $config) {
            abort(404);
        }

        return view('warga.surat.form', compact('config'));
    }

    public function show(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->user_id !== auth()->id()) {
            abort(403);
        }

        $pengajuan->load('approvalHistories.user');
        $config = LetterConfig::where('jenis_surat', $pengajuan->jenis_surat)->first();
        $timeline = $this->approvalService->getTimeline($pengajuan);
        $stepProgress = $this->approvalService->getStepProgress($pengajuan);

        return view('warga.surat.show', compact('pengajuan', 'config', 'timeline', 'stepProgress'));
    }

    public function edit(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->user_id !== auth()->id() || $pengajuan->status !== 'revision') {
            abort(403, 'Anda hanya dapat memperbaiki pengajuan yang diminta revisi.');
        }

        $pengajuan->load('approvalHistories.user');
        $config = LetterConfig::where('jenis_surat', $pengajuan->jenis_surat)->first();
        $revisionNotes = $pengajuan->approvalHistories()
            ->where('status', 'revision')
            ->latest()
            ->first();

        return view('warga.surat.edit', compact('pengajuan', 'config', 'revisionNotes'));
    }

    public function updateAfterRevision(Request $request, PengajuanSurat $pengajuan)
    {
        if ($pengajuan->user_id !== auth()->id() || $pengajuan->status !== 'revision') {
            abort(403);
        }

        $config = LetterConfig::where('jenis_surat', $pengajuan->jenis_surat)->first();

        $rules = [
            'lampiran' => 'nullable|array',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        if ($config) {
            foreach ($config->getValidationRules() as $key => $rule) {
                $rules[$key] = $rule;
            }
        }

        $validated = $request->validate($rules);

        $dataTambahan = $pengajuan->data_tambahan ?? [];

        if (isset($dataTambahan['lampiran']) && ! is_array($dataTambahan['lampiran'])) {
            $dataTambahan['lampiran'] = [$dataTambahan['lampiran']];
        }

        foreach ($validated as $key => $value) {
            if ($key !== 'lampiran') {
                $dataTambahan[$key] = $value;
            }
        }

        if ($request->hasFile('lampiran')) {
            foreach (($dataTambahan['lampiran'] ?? []) as $old) {
                if ($old && Storage::exists($old)) {
                    Storage::delete($old);
                }
            }

            $hash = substr(hash('sha256', auth()->id().now()->timestamp), 0, 12);
            $timestamp = now()->timestamp;
            $paths = [];

            foreach ($request->file('lampiran') as $i => $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = "{$pengajuan->jenis_surat}_{$hash}_{$timestamp}_{$i}.{$extension}";
                $paths[] = $file->storeAs('private/lampiran', $filename);
            }

            $dataTambahan['lampiran'] = $paths;
        }

        $pengajuan->update([
            'data_tambahan' => $dataTambahan,
            'catatan_admin' => null,
        ]);

        $this->approvalService->transition($pengajuan, 'submitted', $request->user());

        ActivityLog::catat(
            'resubmit_pengajuan',
            "Warga {$request->user()->name} mengirim ulang pengajuan {$pengajuan->jenis_surat} ID #{$pengajuan->id} setelah revisi.",
            'pengajuan',
            $pengajuan->id
        );

        $this->sendTelegramNotification($pengajuan);

        return redirect()->route('warga.surat.show', $pengajuan)
            ->with('success', 'Pengajuan berhasil dikirim ulang untuk diproses kembali.');
    }

    public function destroy(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->user_id !== auth()->id() || $pengajuan->status !== 'submitted') {
            abort(403);
        }

        $pengajuan->delete();

        return redirect()->route('warga.dashboard')
            ->with('success', 'Pengajuan surat berhasil dibatalkan.');
    }

    public function store(StorePengajuanRequest $request)
    {
        $validated = $request->validated();

        $files = $request->file('lampiran', []);
        $hash = substr(hash('sha256', auth()->id().now()->timestamp), 0, 12);
        $timestamp = now()->timestamp;
        $paths = [];

        foreach (is_array($files) ? $files : [$files] as $i => $file) {
            $extension = $file->getClientOriginalExtension();
            $filename = "{$validated['jenis_surat']}_{$hash}_{$timestamp}_{$i}.{$extension}";
            $paths[] = $file->storeAs('private/lampiran', $filename);
        }

        $dataTambahan = collect($validated)
            ->except('jenis_surat', 'lampiran')
            ->put('lampiran', $paths)
            ->toArray();

        $pengajuan = PengajuanSurat::create([
            'user_id' => auth()->id(),
            'submitted_by' => auth()->id(),
            'jenis_surat' => $validated['jenis_surat'],
            'data_tambahan' => $dataTambahan,
            'status' => 'submitted',
            'current_step' => 0,
        ]);

        ActivityLog::catat(
            'create_pengajuan',
            "Warga {$request->user()->name} mengajukan {$validated['jenis_surat']} ID #{$pengajuan->id}.",
            'pengajuan',
            $pengajuan->id
        );

        $this->sendTelegramNotification($pengajuan);

        app(WebhookNotifier::class)->send([
            'event' => 'pengajuan.created',
            'pengajuan_id' => $pengajuan->id,
            'pemohon' => $request->user()->name,
            'jenis_surat' => $pengajuan->jenis_surat,
            'status' => $pengajuan->status,
            'url' => route('admin.pengajuan.show', $pengajuan),
            'occurred_at' => now()->toIso8601String(),
        ]);

        return redirect()
            ->route('warga.surat.show', $pengajuan)
            ->with('success', 'Pengajuan surat berhasil dikirim.');
    }

    private function sendTelegramNotification(PengajuanSurat $pengajuan): void
    {
        $namaPemohon = $pengajuan->user->name ?? 'Warga';
        $jenis = str_replace('_', ' ', $pengajuan->jenis_surat);

        $message = "Pengajuan Surat Baru\n"
            ."Pemohon: {$namaPemohon}\n"
            ."Jenis: {$jenis}\n"
            .'Link: '.route('admin.pengajuan.show', $pengajuan);

        app(TelegramNotifier::class)->send($message);
    }
}
