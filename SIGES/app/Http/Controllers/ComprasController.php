<?php

namespace App\Http\Controllers;

use App\Models\compras;
use App\Models\inventario;
use Illuminate\Http\Request;

class ComprasController extends Controller
{
    public function index()
    {
        $compras = compras::with('inventario')->latest()->get();

        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $inventarios = inventario::orderBy('nombre_pieza')->get();

        return view('compras.create', compact('inventarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_inventario' => ['required', 'integer', 'exists:inventarios,id_inventario'],
            'precio_unitario' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'cantidad_compra' => ['required', 'integer', 'min:1'],
            'fecha' => ['required', 'date'],
            'lugar_compra' => ['required', 'string', 'max:255'],
        ]);

        $compra = compras::create($data);

        // Incrementar stock en inventario
        inventario::where('id_inventario', $data['id_inventario'])
            ->increment('cantidad', $data['cantidad_compra']);

        return redirect()->route('compras.index')
            ->with('success', 'Compra registrada correctamente.');
    }

    public function show(compras $compra)
    {
        $compra->load('inventario');

        return view('compras.show', compact('compra'));
    }

    public function edit(compras $compra)
    {
        $inventarios = inventario::orderBy('nombre_pieza')->get();

        return view('compras.edit', compact('compra', 'inventarios'));
    }

    public function update(Request $request, compras $compra)
    {
        $data = $request->validate([
            'id_inventario' => ['required', 'integer', 'exists:inventarios,id_inventario'],
            'precio_unitario' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'cantidad_compra' => ['required', 'integer', 'min:1'],
            'fecha' => ['required', 'date'],
            'lugar_compra' => ['required', 'string', 'max:255'],
        ]);

        // Ajustar stock: si cambió inventario o cantidad
        if ($compra->id_inventario != $data['id_inventario']) {
            // Restar de inventario antiguo
            inventario::where('id_inventario', $compra->id_inventario)
                ->decrement('cantidad', $compra->cantidad_compra);

            // Sumar al nuevo inventario
            inventario::where('id_inventario', $data['id_inventario'])
                ->increment('cantidad', $data['cantidad_compra']);
        } else {
            // Mismo inventario: ajustar por la diferencia
            $diff = $data['cantidad_compra'] - $compra->cantidad_compra;
            if ($diff > 0) {
                inventario::where('id_inventario', $compra->id_inventario)
                    ->increment('cantidad', $diff);
            } elseif ($diff < 0) {
                inventario::where('id_inventario', $compra->id_inventario)
                    ->decrement('cantidad', abs($diff));
            }
        }

        $compra->update($data);

        return redirect()->route('compras.index')
            ->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(compras $compra)
    {
        // Restar cantidad del inventario
        if ($compra->id_inventario !== null) {
            inventario::where('id_inventario', $compra->id_inventario)
                ->decrement('cantidad', $compra->cantidad_compra);
        }

        $compra->delete();

        return redirect()->route('compras.index')
            ->with('success', 'Compra eliminada. Inventario ajustado.');
    }
}
