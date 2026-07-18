<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventarioRequest;
use App\Models\inventario;
use Illuminate\Http\Request; // <-- 1. IMPORTACIÓN AÑADIDA
use Illuminate\Support\Facades\DB;

class InventariosController extends Controller
{
    // <-- 2. SE INYECTA LA CLASE Request AQUÍ
    public function index(Request $request)
    {
        $query = inventario::latest();

        // 3. LÓGICA DE FILTRADO POR NOMBRE DE PIEZA
        if ($request->filled('buscar_pieza')) {
            $buscar = $request->input('buscar_pieza');
            $query->where('nombre_pieza', 'LIKE', '%' . $buscar . '%');
        }

        $inventarios = $query->get();

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