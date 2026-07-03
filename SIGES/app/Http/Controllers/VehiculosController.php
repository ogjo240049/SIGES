<?php

namespace App\Http\Controllers;

use App\Models\choferes;
use App\Models\vehiculos;
use Illuminate\Http\Request;

class VehiculosController extends Controller
{
    public function index()
    {
        $vehiculos = vehiculos::with('chofer.usuario')
            ->latest()
            ->get();

        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        $choferes = choferes::with('usuario')
            ->orderBy('id_chofer')
            ->get();

        return view('vehiculos.create', compact('choferes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'placa' => ['required', 'string', 'max:255', 'unique:vehiculos,placa'],
            'marca' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'motor' => ['required', 'string', 'max:255'],
            'serie' => ['required', 'string', 'max:255'],
            'concesionario' => ['required', 'string', 'max:255'],
            'id_chofer' => ['nullable', 'integer', 'exists:choferes,id_chofer'],
        ]);

        $vehiculo = vehiculos::create($data);

        if ($request->filled('id_chofer')) {
            choferes::where('unidad_asignada', $vehiculo->matricula)
                ->update(['unidad_asignada' => null]);

            choferes::where('id_chofer', $request->input('id_chofer'))
                ->update(['unidad_asignada' => $vehiculo->matricula]);
        }

        return redirect()->route('vehiculos.index')
            ->with('success', 'Unidad de taxi registrada correctamente.');
    }

    public function show(vehiculos $vehiculo)
    {
        $vehiculo->load('chofer.usuario');

        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit(vehiculos $vehiculo)
    {
        $choferes = choferes::with('usuario')
            ->orderBy('id_chofer')
            ->get();

        return view('vehiculos.edit', compact('vehiculo', 'choferes'));
    }

    public function update(Request $request, vehiculos $vehiculo)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'placa' => ['required', 'string', 'max:255', 'unique:vehiculos,placa,' . $vehiculo->matricula . ',matricula'],
            'marca' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'motor' => ['required', 'string', 'max:255'],
            'serie' => ['required', 'string', 'max:255'],
            'concesionario' => ['required', 'string', 'max:255'],
            'id_chofer' => ['nullable', 'integer', 'exists:choferes,id_chofer'],
        ]);

        $vehiculo->update($data);

        if ($request->filled('id_chofer')) {
            choferes::where('unidad_asignada', $vehiculo->matricula)
                ->where('id_chofer', '!=', $request->input('id_chofer'))
                ->update(['unidad_asignada' => null]);

            choferes::where('id_chofer', $request->input('id_chofer'))
                ->update(['unidad_asignada' => $vehiculo->matricula]);
        } else {
            choferes::where('unidad_asignada', $vehiculo->matricula)
                ->update(['unidad_asignada' => null]);
        }

        return redirect()->route('vehiculos.index')
            ->with('success', 'Unidad de taxi actualizada correctamente.');
    }

    public function destroy(vehiculos $vehiculo)
    {
        choferes::where('unidad_asignada', $vehiculo->matricula)
            ->update(['unidad_asignada' => null]);

        $vehiculo->delete();

        return redirect()->route('vehiculos.index')
            ->with('success', 'Unidad de taxi eliminada correctamente.');
    }
}
