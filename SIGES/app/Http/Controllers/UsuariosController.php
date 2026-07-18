<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    private function roleOptions(): array
    {
        return [
            1 => 'Administrador',
            2 => 'Operador',
            3 => 'Chofer',
        ];
    }

    public function index()
    {
        $usuarios = User::latest()->get();

        return view('usuarios.index', [
            'usuarios' => $usuarios,
            'roleOptions' => $this->roleOptions(),
        ]);
    }

    public function create()
    {
        return view('usuarios.create', [
            'roleOptions' => $this->roleOptions(),
        ]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        User::create($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario registrado correctamente.');
    }

    public function show(User $user)
    {
        return view('usuarios.show', [
            'user' => $user,
            'roleOptions' => $this->roleOptions(),
        ]);
    }

    public function edit(User $user)
    {
        return view('usuarios.edit', [
            'user' => $user,
            'roleOptions' => $this->roleOptions(),
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        DB::transaction(function () use ($user): void {
            $user->load('choferes');

            foreach ($user->choferes as $chofer) {
                $chofer->pagos()->delete();
                $chofer->servicios()->delete();
                $chofer->bitacoras()->delete();
                $chofer->delete();
            }

            $user->delete();
        });

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
