<?php

namespace App\Http\Controllers;

use App\Models\choferes;
use App\Models\bitacora;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index()
    {
        $bitacoras = bitacora::with('chofer.usuario', 'chofer.vehiculo')
            ->latest('fecha_hora')
            ->get();

        return view('bitacoras.index', compact('bitacoras'));
    }

    public function create()
    {
        $choferes = choferes::with('usuario', 'vehiculo')
            ->orderBy('id_chofer')
            ->get();

        return view('bitacoras.create', compact('choferes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_chofer' => ['required', 'integer', 'exists:choferes,id_chofer'],
            'fecha_hora' => ['required', 'date'],
            'locacion' => ['required', 'string', 'max:255'],
        ]);

        bitacora::create($data);

        return redirect()->route('bitacoras.index')
            ->with('success', 'Registro de bitácora creado correctamente.');
    }

    public function show(bitacora $bitacora)
    {
        $bitacora->load('chofer.usuario', 'chofer.vehiculo');

        return view('bitacoras.show', compact('bitacora'));
    }

    public function edit(bitacora $bitacora)
    {
        $choferes = choferes::with('usuario', 'vehiculo')
            ->orderBy('id_chofer')
            ->get();

        return view('bitacoras.edit', compact('bitacora', 'choferes'));
    }

    public function update(Request $request, bitacora $bitacora)
    {
        $data = $request->validate([
            'id_chofer' => ['required', 'integer', 'exists:choferes,id_chofer'],
            'fecha_hora' => ['required', 'date'],
            'locacion' => ['required', 'string', 'max:255'],
        ]);

        $bitacora->update($data);

        return redirect()->route('bitacoras.index')
            ->with('success', 'Registro de bitácora actualizado correctamente.');
    }

    public function destroy(bitacora $bitacora)
    {
        $bitacora->delete();

        return redirect()->route('bitacoras.index')
            ->with('success', 'Registro de bitácora eliminado correctamente.');
    }
}
