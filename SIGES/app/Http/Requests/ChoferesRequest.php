<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChoferesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()?->canManageOperations();
    }

    protected function prepareForValidation(): void
    {
        $data = $this->all();

        if (array_key_exists('unidad_asignada', $data) && trim((string) $data['unidad_asignada']) === '') {
            $data['unidad_asignada'] = null;
        }

        $this->replace($data);
    }

    public function rules(): array
    {
        return [
            'id_usuario' => ['required', 'integer', 'exists:users,id'],
            'unidad_asignada' => ['nullable', 'integer', 'exists:vehiculos,matricula'],
            'identificacion' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario.required' => 'Selecciona un usuario para asignar el chofer.',
            'id_usuario.exists' => 'El usuario seleccionado no existe.',
            'identificacion.required' => 'La identificación del chofer es obligatoria.',
            'identificacion.max' => 'La identificación no puede exceder 255 caracteres.',
            'unidad_asignada.integer' => 'La unidad asignada debe ser un número válido.',
            'unidad_asignada.exists' => 'La unidad asignada debe existir en el catálogo de taxis.',
        ];
    }
}
