<?php

namespace App\Http\Controllers;

use App\Models\choferes;
use App\Models\pagos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function index()
    {
        $query = pagos::with('chofer.usuario', 'chofer.vehiculo')
            ->latest();

        if ($this->currentUser()?->isDriver()) {
            $choferIds = $this->currentUserChoferIds();

            $query->whereIn('id_chofer', $choferIds->all());
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

    public function store(Request $request)
    {
        $this->ensureCanManagePayments();

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

    public function update(Request $request, pagos $pago)
    {
        $this->ensureCanManagePayments();

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
        $this->ensureCanManagePayments();

        $pago->delete();

        return redirect()->route('pagos.index')
            ->with('success', 'Registro de pago eliminado.');
    }
}
