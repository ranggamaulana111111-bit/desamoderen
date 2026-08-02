<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\LetterConfig;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LetterConfigController extends Controller
{
    public function index()
    {
        $templates = LetterConfig::orderBy('kode_klasifikasi')->get();

        return view('admin.letter-config.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.letter-config.form', [
            'template' => null,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['fields'] = $this->buildFields($request);

        LetterConfig::create($data);

        ActivityLog::catat(
            'create_letter_config',
            auth()->user()->name.' menambah template surat: '.$data['label'],
            'letter_config'
        );

        return redirect()->route('admin.letter-config.index')
            ->with('success', 'Template surat berhasil ditambahkan.');
    }

    public function edit(LetterConfig $template_surat)
    {
        return view('admin.letter-config.form', [
            'template' => $template_surat,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, LetterConfig $template_surat)
    {
        $data = $this->validateData($request, $template_surat->id);
        $data['fields'] = $this->buildFields($request);

        $template_surat->update($data);

        ActivityLog::catat(
            'update_letter_config',
            auth()->user()->name.' mengubah template surat: '.$data['label'],
            'letter_config',
            $template_surat->id
        );

        return redirect()->route('admin.letter-config.index')
            ->with('success', 'Template surat berhasil diperbarui.');
    }

    public function destroy(LetterConfig $template_surat)
    {
        $label = $template_surat->label;
        $template_surat->delete();

        ActivityLog::catat(
            'delete_letter_config',
            auth()->user()->name.' menghapus template surat: '.$label,
            'letter_config'
        );

        return redirect()->route('admin.letter-config.index')
            ->with('success', 'Template surat berhasil dihapus.');
    }

    public function toggle(LetterConfig $letterConfig)
    {
        $letterConfig->update(['is_active' => ! $letterConfig->is_active]);

        $status = $letterConfig->is_active ? 'diaktifkan' : 'dinonaktifkan';

        ActivityLog::catat(
            'toggle_letter_config',
            auth()->user()->name.' '.$status.' template surat: '.$letterConfig->label,
            'letter_config',
            $letterConfig->id
        );

        return back()->with('success', "Template surat berhasil {$status}.");
    }

    private function validateData(Request $request, ?int $exceptId = null): array
    {
        $uniqueRule = $exceptId
            ? ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('letter_configs', 'jenis_surat')->ignore($exceptId)]
            : ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('letter_configs', 'jenis_surat')];

        return $request->validate([
            'jenis_surat' => $uniqueRule,
            'label' => 'required|string|max:100',
            'kode_klasifikasi' => 'required|string|max:10',
            'masa_berlaku_bulan' => 'required|integer|min:0|max:255',
            'body_template' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
    }

    private function buildFields(Request $request): array
    {
        $raw = $request->input('fields_json');
        $decoded = is_string($raw) ? json_decode($raw, true) : $raw;

        if (! is_array($decoded)) {
            return [];
        }

        $fields = [];
        foreach ($decoded as $item) {
            if (empty($item['key']) || empty($item['label'])) {
                continue;
            }

            $field = [
                'key' => $item['key'],
                'label' => $item['label'],
                'type' => $item['type'] ?? 'text',
                'required' => ! empty($item['required']),
                'rules' => $item['rules'] ?? 'string|max:255',
            ];

            if (($item['type'] ?? '') === 'select' && ! empty($item['options'])) {
                $field['options'] = $item['options'];
            }

            $fields[] = $field;
        }

        return $fields;
    }
}
