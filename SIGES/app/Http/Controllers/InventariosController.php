<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventarioRequest;
use App\Models\inventario;
use Illuminate\Support\Facades\DB;

class InventariosController extends Controller
{
    public function index()
    {
        $inventarios = inventario::latest()->get();

        return view('inventarios.index', compact('inventarios'));
    }

    public function create()
    {
        return view('inventarios.create');
    }

    public function store(InventarioRequest $request)
    {
        $data = $request->validated();

        inventario::create($data);

        return redirect()->route('inventarios.index')
            ->with('success', 'Pieza registrada en el inventario.');
    }

    public function show(inventario $inventario)
    {
        return view('inventarios.show', compact('inventario'));
    }

    public function edit(inventario $inventario)
    {
        return view('inventarios.edit', compact('inventario'));
    }

    public function update(InventarioRequest $request, inventario $inventario)
    {
        $data = $request->validated();

        $inventario->update($data);

        return redirect()->route('inventarios.index')
            ->with('success', 'Registro de inventario actualizado.');
    }

    public function destroy(inventario $inventario)
    {
        DB::transaction(function () use ($inventario): void {
            $inventario->compras()->delete();
            $inventario->delete();
        });

        return redirect()->route('inventarios.index')
            ->with('success', 'Registro eliminado del inventario.');
    }
}
