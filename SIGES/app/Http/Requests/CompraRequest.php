<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'id_inventario' => ['required', 'integer', 'exists:inventarios,id_inventario'],
            'precio_unitario' => ['required', 'numeric', 'gt:0', 'max:9999999.99'],
            'cantidad_compra' => ['required', 'integer', 'gt:0'],
            'fecha' => ['required', 'date'],
            'lugar_compra' => ['required', 'string', 'max:255'],
        ];
    }
}
