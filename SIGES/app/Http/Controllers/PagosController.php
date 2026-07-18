<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagoRequest;
use App\Models\choferes;
use App\Models\pagos;
use Illuminate\Http\Request; // <-- Importación añadida para leer el formulario
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PagosController extends Controller
{
    private function currentUser(): ?\App\Models\User
    {
        return Auth::user();
    }

    private function currentUserChoferIds(): Collection
    {
        $user = $this->currentUser();

        if (! $user) {
            return collect();
        }

        return $user->choferes()->pluck('id_chofer');
    }

    private function ensureCanManagePayments(): void
    {
        abort_if($this->currentUser()?->isDriver(), Response::HTTP_FORBIDDEN);
    }

    private function ensureCanViewPayment(pagos $pago): void
    {
        $user = $this->currentUser();

        if (! $user || $user->isAdmin() || $user->isOperator()) {
            return;
        }

        abort_unless($this->currentUserChoferIds()->contains($pago->id_chofer), Response::HTTP_FORBIDDEN);
    }

// <-- Se inyecta Request aquí
    public function index(Request $request) 
    {
        $query = pagos::with('chofer.usuario', 'chofer.vehiculo')
            ->latest();

        if ($this->currentUser()?->isDriver()) {
            $choferIds = $this->currentUserChoferIds();

            $query->whereIn('id_chofer', $choferIds->all());
        }

        // <-- LÓGICA DE FILTRADO MODIFICADA PARA BUSCAR POR NOMBRE
        if ($request->filled('unidad')) {
            $unidad = $request->input('unidad');
            
            $query->whereHas('chofer.vehiculo', function($q) use ($unidad) {
                // Cambiado de 'matricula' a 'nombre'
                $q->where('nombre', 'LIKE', '%' . $unidad . '%');
            });
        }

        $pagos = $query->get();

        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        $this->ensureCanManagePayments();

        $choferes = choferes::with('usuario', 'vehiculo')
            ->orderBy('id_chofer')
            ->get();

        return view('pagos.create', compact('choferes'));
    }

    public function store(PagoRequest $request)
    {
        $this->ensureCanManagePayments();

        $data = $request->validated();

        pagos::create($data);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago registrado correctamente.');
    }

    public function show(pagos $pago)
    {
        $pago->load('chofer.usuario', 'chofer.vehiculo');
        $this->ensureCanViewPayment($pago);

        return view('pagos.show', compact('pago'));
    }

    public function edit(pagos $pago)
    {
        $this->ensureCanManagePayments();

        $choferes = choferes::with('usuario', 'vehiculo')
            ->orderBy('id_chofer')
            ->get();

        return view('pagos.edit', compact('pago', 'choferes'));
    }

    public function update(PagoRequest $request, pagos $pago)
    {
        $this->ensureCanManagePayments();

        $data = $request->validated();

        $pago->update($data);

        return redirect()->route('pagos.index')
            ->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(pagos $pago)
    {
        $this->ensureCanManagePayments();

        $pago->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Registro de pago eliminado.');
    }
}