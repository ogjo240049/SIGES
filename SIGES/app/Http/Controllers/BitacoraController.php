<?php

namespace App\Http\Controllers;

use App\Http\Requests\BitacoraRequest;
use App\Models\choferes;
use App\Models\bitacora;

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

    public function store(BitacoraRequest $request)
    {
        $data = $request->validated();

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

    public function update(BitacoraRequest $request, bitacora $bitacora)
    {
        $data = $request->validated();

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
