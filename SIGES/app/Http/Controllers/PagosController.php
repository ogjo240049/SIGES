<?php

namespace App\Http\Controllers;

use App\Models\choferes;
use App\Models\pagos;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    public function index()
    {
        $pagos = pagos::with('chofer.usuario', 'chofer.vehiculo')
            ->latest()
            ->get();

        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        $choferes = choferes::with('usuario', 'vehiculo')
            ->orderBy('id_chofer')
            ->get();

        return view('pagos.create', compact('choferes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_chofer' => ['required', 'integer', 'exists:choferes,id_chofer'],
            'fecha_pago' => ['required', 'date'],
            'monto_pago' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
        ]);

        pagos::create($data);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    public function show(pagos $pago)
    {
        $pago->load('chofer.usuario', 'chofer.vehiculo');

        return view('pagos.show', compact('pago'));
    }

    public function edit(pagos $pago)
    {
        $choferes = choferes::with('usuario', 'vehiculo')
            ->orderBy('id_chofer')
            ->get();

        return view('pagos.edit', compact('pago', 'choferes'));
    }

    public function update(Request $request, pagos $pago)
    {
        $data = $request->validate([
            'id_chofer' => ['required', 'integer', 'exists:choferes,id_chofer'],
            'fecha_pago' => ['required', 'date'],
            'monto_pago' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
        ]);

        $pago->update($data);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(pagos $pago)
    {
        $pago->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Registro de pago eliminado.');
    }
}
