<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()?->canManageOperations();
    }

    public function rules(): array
    {
        return [
            'nombre_pieza' => ['required', 'string', 'max:255'],
            'tipo_pieza' => ['required', 'string', 'max:255'],
            'cantidad' => ['required', 'integer', 'min:0'],
        ];
    }
}
