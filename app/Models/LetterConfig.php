<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LetterConfig extends Model
{
    protected $table = 'letter_configs';

    protected $fillable = [
        'jenis_surat',
        'label',
        'kode_klasifikasi',
        'masa_berlaku_bulan',
        'fields',
        'body_template',
        'requirements',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'fields' => 'array',
            'requirements' => 'array',
            'masa_berlaku_bulan' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFieldKeys(): array
    {
        return array_column($this->fields ?? [], 'key');
    }

    public function getFieldLabels(): array
    {
        $labels = [];
        foreach ($this->fields ?? [] as $field) {
            $labels[$field['key']] = $field['label'];
        }

        return $labels;
    }

    public function getValidationRules(): array
    {
        $rules = [];
        foreach ($this->fields ?? [] as $field) {
            $fieldRules = [];
            if ($field['required'] ?? false) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }
            $fieldRules[] = $field['rules'] ?? 'string|max:255';
            $rules[$field['key']] = implode('|', $fieldRules);
        }

        return $rules;
    }

    public function renderBody(array $data): string
    {
        $data = $this->normalizeData($data);
        $body = $this->body_template ?? '';

        foreach ($data as $key => $value) {
            if (is_array($value) || is_object($value)) {
                continue;
            }
            $body = str_replace('{'.$key.'}', (string) ($value ?? '-'), $body);
        }

        return preg_replace('/\{[a-zA-Z_][a-zA-Z0-9_]*\}/', '', $body);
    }

    private function normalizeData(array $data): array
    {
        $aliases = [
            'kecamatan' => $data['nama_kecamatan'] ?? null,
            'kabupaten' => $data['nama_kabupaten'] ?? null,
        ];

        foreach ($aliases as $alias => $value) {
            if ($value !== null && ! array_key_exists($alias, $data)) {
                $data[$alias] = $value;
            }
        }

        if (isset($data['jenis_kelamin'])) {
            $data['jenis_kelamin_label'] ??= $data['jenis_kelamin'];
            $data['status_janda_label'] ??= strtolower($data['jenis_kelamin']) === 'perempuan' ? 'janda' : 'duda';
        }

        if (isset($data['jenis_akta'])) {
            $data['jenis_akta_label'] ??= strtolower($data['jenis_akta']) === 'kelahiran' ? 'Akta Kelahiran' : 'Akta Kematian';
        }

        foreach ($data as $key => $value) {
            if (is_string($value) && str_starts_with($key, 'tgl_') && $this->isDate($value)) {
                $data[$key] = Carbon::parse($value)->locale('id')->translatedFormat('d F Y');
            }
        }

        foreach (['penghasilan', 'jumlah_penghasilan', 'luas_tanah'] as $key) {
            if (isset($data[$key]) && is_numeric($data[$key])) {
                $data[$key] = number_format((float) $data[$key], 0, ',', '.');
            }
        }

        return $data;
    }

    private function isDate(string $value): bool
    {
        if (! str_contains($value, '-')) {
            return false;
        }

        try {
            Carbon::parse($value);

            return true;
        } catch (\Throwable) {
            return false;
        }
    }
}
