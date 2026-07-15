<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'id_chofer' => ['required', 'integer', 'exists:choferes,id_chofer'],
            'fecha_pago' => ['required', 'date'],
            'monto_pago' => ['required', 'numeric', 'gt:0', 'max:9999999.99'],
        ];
    }
}
