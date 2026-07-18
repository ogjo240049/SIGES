<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()?->canManageOperations();
    }

    public function rules(): array
    {
        return [
            'origen_viaje' => ['required', 'string', 'max:255'],
            'destino_viaje' => ['required', 'string', 'max:255'],
            'id_chofer' => ['required', 'integer', 'exists:choferes,id_chofer'],
            'fecha_pedido' => ['required', 'date'],
        ];
    }
}
