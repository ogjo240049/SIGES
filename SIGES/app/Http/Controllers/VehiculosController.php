<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehiculoRequest;
use App\Models\choferes;
use App\Models\vehiculos;

class VehiculosController extends Controller
{
// Se añade la inyección de Request en los parámetros del método
    public function index(\Illuminate\Http\Request $request)
    {
        $query = vehiculos::with('chofer.usuario')->latest();

        // Lógica de filtrado por nombre o placa del vehículo
        if ($request->filled('buscar_vehiculo')) {
            $buscar = $request->input('buscar_vehiculo');
            
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', '%' . $buscar . '%')
                  ->orWhere('placa', 'LIKE', '%' . $buscar . '%');
            });
        }

        $vehiculos = $query->get();

        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        $choferes = choferes::with('usuario')
            ->orderBy('id_chofer')
            ->get();

        return view('vehiculos.create', compact('choferes'));
    }

    public function store(VehiculoRequest $request)
    {
        $data = $request->validated();
        $data['nombre'] = trim((string) ($data['nombre'] ?? ''));
        $data['placa'] = trim((string) ($data['placa'] ?? ''));
        $data['marca'] = trim((string) ($data['marca'] ?? ''));
        $data['modelo'] = trim((string) ($data['modelo'] ?? ''));
        $data['motor'] = trim((string) ($data['motor'] ?? ''));
        $data['serie'] = trim((string) ($data['serie'] ?? ''));
        $data['concesionario'] = trim((string) ($data['concesionario'] ?? ''));

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

    public function update(VehiculoRequest $request, vehiculos $vehiculo)
    {
        $data = $request->validated();
        $data['nombre'] = trim((string) ($data['nombre'] ?? ''));
        $data['placa'] = trim((string) ($data['placa'] ?? ''));
        $data['marca'] = trim((string) ($data['marca'] ?? ''));
        $data['modelo'] = trim((string) ($data['modelo'] ?? ''));
        $data['motor'] = trim((string) ($data['motor'] ?? ''));
        $data['serie'] = trim((string) ($data['serie'] ?? ''));
        $data['concesionario'] = trim((string) ($data['concesionario'] ?? ''));

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
