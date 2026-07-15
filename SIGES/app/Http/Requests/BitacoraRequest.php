<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BitacoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && in_array((int) auth()->user()?->rol, [1, 2, 3], true);
    }

    public function rules(): array
    {
        return [
            'id_chofer' => ['required', 'integer', 'exists:choferes,id_chofer'],
            'fecha_hora' => ['required', 'date'],
            'locacion' => ['required', 'string', 'max:255'],
        ];
    }
}
