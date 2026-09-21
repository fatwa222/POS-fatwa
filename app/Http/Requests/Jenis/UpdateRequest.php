<?php

namespace App\Http\Requests\Jenis;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $id = $this->route('jenis')?->id;

        return [
            'nama' => 'required|string|max:255|unique:jenis,nama,' . $id,
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