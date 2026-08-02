<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        $body = $this->body_template ?? '';
        foreach ($data as $key => $value) {
            $body = str_replace('{'.$key.'}', $value ?? '-', $body);
        }

        return $body;
    }
}
