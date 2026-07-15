<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()?->canManageSystem();
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'apellido_pat' => ['required', 'string', 'max:255'],
            'apellido_mat' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]{7,15}$/'],
            'rol' => ['required', 'integer', Rule::in([1, 2, 3])],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => $this->isMethod('post')
                ? ['required', 'string', 'min:8', 'confirmed']
                : ['nullable', 'string', 'min:8', 'confirmed'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'telefono.regex' => 'El teléfono debe contener solo números, espacios o signos de separación válidos.',
            'foto.image' => 'La fotografía debe ser un archivo de imagen válido.',
            'foto.mimes' => 'La fotografía debe tener formato JPG, JPEG, PNG o WEBP.',
            'foto.max' => 'La fotografía no debe superar los 2 MB.',
        ];
    }
}
