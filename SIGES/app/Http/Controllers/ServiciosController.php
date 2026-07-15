<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicioRequest;
use App\Models\servicios;
use App\Models\choferes;

class ServiciosController extends Controller
{
    public function index()
    {
        $servicios = servicios::with('chofer.usuario', 'chofer.vehiculo')->latest()->get();

        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        $choferes = choferes::with('usuario', 'vehiculo')->orderBy('id_chofer')->get();

        return view('servicios.create', compact('choferes'));
    }

    public function store(ServicioRequest $request)
    {
        $data = $request->validated();

        servicios::create($data);

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio registrado correctamente.');
    }

    public function show(servicios $servicio)
    {
        $servicio->load('chofer.usuario', 'chofer.vehiculo');

        return view('servicios.show', compact('servicio'));
    }

    public function edit(servicios $servicio)
    {
        $choferes = choferes::with('usuario', 'vehiculo')->orderBy('id_chofer')->get();

        return view('servicios.edit', compact('servicio', 'choferes'));
    }

    public function update(ServicioRequest $request, servicios $servicio)
    {
        $data = $request->validated();

        $servicio->update($data);

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(servicios $servicio)
    {
        $servicio->delete();

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio eliminado.');
    }
}
