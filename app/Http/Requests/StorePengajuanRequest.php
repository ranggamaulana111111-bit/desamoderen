<?php

namespace App\Http\Requests;

use App\Models\LetterConfig;
use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jenis = $this->input('jenis_surat');

        $config = LetterConfig::where('jenis_surat', $jenis)->first();

        $requiresAttachment = $config && ! empty($config->requirements);

        $rules = [
            'jenis_surat' => 'required|string|max:50',
            'lampiran' => $requiresAttachment ? 'required|array|min:1' : 'nullable|array',
            'lampiran.*' => 'required|file|mimes:pdf,jpg,jpeg,png|mimetypes:image/jpeg,image/png,application/pdf|max:2048',
        ];

        if ($config) {
            foreach ($config->getValidationRules() as $key => $rule) {
                $rules[$key] = $rule;
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'lampiran.required' => 'File lampiran wajib diunggah.',
            'lampiran.min' => 'Minimal satu file lampiran wajib diunggah.',
            'lampiran.*.mimes' => 'Lampiran harus berupa PDF, JPG, JPEG, atau PNG.',
            'lampiran.*.max' => 'Ukuran lampiran maksimal 2MB per file.',
        ];
    }
}
