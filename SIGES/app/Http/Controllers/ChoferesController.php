<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\vehiculos;
use App\Models\choferes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChoferesController extends Controller
{
    private function availableVehicles(?choferes $currentChofer = null)
    {
        return vehiculos::with('chofer.usuario')
            ->orderBy('matricula')
            ->get()
            ->filter(function ($vehiculo) use ($currentChofer) {
                return ! $vehiculo->chofer || $currentChofer?->id_chofer === $vehiculo->chofer->id_chofer;
            })
            ->values();
    }

    public function index()
    {
        $choferes = choferes::with('usuario', 'vehiculo')
            ->latest()
            ->get();

        return view('choferes.index', compact('choferes'));
    }

    public function create()
    {
        $usuarios = User::with('choferes')
            ->orderBy('name')
            ->get();

        return view('choferes.create', [
            'usuarios' => $usuarios,
            'vehiculos' => $this->availableVehicles(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => ['required', 'integer', 'exists:users,id'],
            'unidad_asignada' => ['nullable', 'integer', 'exists:vehiculos,matricula'],
            'identificacion' => ['required', 'string', 'max:255'],
        ]);

        $chofer = choferes::create($data);

        if ($request->filled('unidad_asignada')) {
            choferes::where('unidad_asignada', $request->integer('unidad_asignada'))
                ->where('id_chofer', '!=', $chofer->id_chofer)
                ->update(['unidad_asignada' => null]);
        }

        return redirect()->route('choferes.index')
            ->with('success', 'Chofer registrado correctamente.');
    }

    public function show(choferes $chofer)
    {
        $chofer->load('usuario', 'vehiculo', 'pagos', 'servicios', 'bitacoras');

        return view('choferes.show', compact('chofer'));
    }

    public function edit(choferes $chofer)
    {
        $usuarios = User::with('choferes')
            ->orderBy('name')
            ->get();

        return view('choferes.edit', [
            'chofer' => $chofer,
            'usuarios' => $usuarios,
            'vehiculos' => $this->availableVehicles($chofer),
        ]);
    }

    public function update(Request $request, choferes $chofer)
    {
        $data = $request->validate([
            'id_usuario' => ['required', 'integer', 'exists:users,id'],
            'unidad_asignada' => ['nullable', 'integer', 'exists:vehiculos,matricula'],
            'identificacion' => ['required', 'string', 'max:255'],
        ]);

        $previousVehicle = $chofer->unidad_asignada;
        $chofer->update($data);

        if ($request->filled('unidad_asignada')) {
            choferes::where('unidad_asignada', $request->integer('unidad_asignada'))
                ->where('id_chofer', '!=', $chofer->id_chofer)
                ->update(['unidad_asignada' => null]);
        } elseif ($previousVehicle !== null) {
            $chofer->update(['unidad_asignada' => null]);
        }

        return redirect()->route('choferes.index')
            ->with('success', 'Chofer actualizado correctamente.');
    }

    public function destroy(choferes $chofer)
    {
        if ($chofer->pagos()->exists() || $chofer->servicios()->exists() || $chofer->bitacoras()->exists()) {
            return redirect()->route('choferes.index')
                ->with('error', 'No se puede eliminar un chofer con registros asociados.');
        }

        $chofer->delete();

        return redirect()->route('choferes.index')
            ->with('success', 'Chofer eliminado correctamente.');
    }
}
