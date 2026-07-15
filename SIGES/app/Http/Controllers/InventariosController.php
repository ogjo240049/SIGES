<?php

namespace App\Http\Controllers;

use App\Models\inventario;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_pieza' => ['required', 'string', 'max:255'],
            'tipo_pieza' => ['required', 'string', 'max:255'],
            'cantidad' => ['required', 'integer', 'min:0'],
        ]);

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

    public function update(Request $request, inventario $inventario)
    {
        $data = $request->validate([
            'nombre_pieza' => ['required', 'string', 'max:255'],
            'tipo_pieza' => ['required', 'string', 'max:255'],
            'cantidad' => ['required', 'integer', 'min:0'],
        ]);

        $inventario->update($data);

        return redirect()->route('inventarios.index')
            ->with('success', 'Registro de inventario actualizado.');
    }

    public function destroy(inventario $inventario)
    {
        DB::transaction(function () use ($inventario): void {
            $inventario->compras()->update(['id_inventario' => null]);
            $inventario->delete();
        });

        return redirect()->route('inventarios.index')
            ->with('success', 'Registro eliminado del inventario.');
    }
}
