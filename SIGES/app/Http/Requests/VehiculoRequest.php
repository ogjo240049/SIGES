<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()?->canManageSystem();
    }

    protected function prepareForValidation(): void
    {
        $data = $this->all();

        foreach (['nombre', 'placa', 'marca', 'modelo', 'motor', 'serie', 'concesionario'] as $field) {
            if (array_key_exists($field, $data)) {
                $data[$field] = trim((string) $data[$field]);
            }
        }

        $this->replace($data);
    }

    public function rules(): array
    {
        $vehiculoId = $this->route('vehiculo')?->matricula;

        return [
            'nombre' => ['required', 'string', 'max:255'],
            'placa' => ['required', 'string', 'max:40', 'unique:vehiculos,placa,' . $vehiculoId . ',matricula'],
            'marca' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'motor' => ['required', 'string', 'max:255'],
            'serie' => ['required', 'string', 'max:255'],
            'concesionario' => ['required', 'string', 'max:255'],
            'id_chofer' => ['nullable', 'integer', 'exists:choferes,id_chofer'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del taxi es obligatorio.',
            'placa.required' => 'La placa del taxi es obligatoria.',
            'placa.unique' => 'La placa ya está registrada en el sistema.',
            'marca.required' => 'La marca es obligatoria.',
            'modelo.required' => 'El modelo es obligatorio.',
            'motor.required' => 'El motor es obligatorio.',
            'serie.required' => 'La serie es obligatoria.',
            'concesionario.required' => 'El concesionario es obligatorio.',
            'id_chofer.exists' => 'El chofer seleccionado no existe.',
        ];
    }
}
