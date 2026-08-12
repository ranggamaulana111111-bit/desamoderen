<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('user.edit');
    }

    public function rules(): array
    {
        $min = (int) config('village.security_password_min_length', 8);
        $password = Password::min($min);

        if ((string) config('village.security_password_policy', '1') === '1') {
            $password = $password->letters()->numbers();
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user ?? $this->route('user'))],
            'nik' => ['required', 'string', 'digits:16', Rule::unique('users', 'nik')->ignore($this->user ?? $this->route('user'))],
            'password' => ['nullable', 'string', $password],
            'role' => ['required', 'string', 'exists:roles,name'],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ];
    }
}
