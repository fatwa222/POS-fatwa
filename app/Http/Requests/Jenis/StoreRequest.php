<?php

namespace App\Http\Requests\Jenis;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255|unique:jenis,nama',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama jenis wajib diisi.',
            'nama.unique'   => 'Jenis dengan nama ini sudah ada.',
        ];
    }
}