@extends('layouts.app')

@section('title', 'Pagos - SIGES')

@section('topbar-actions')
    <a href="{{ route('dashboard') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al dashboard
    </a>
    @unless(auth()->user()?->isDriver())
        <a href="{{ route('pagos.create') }}" class="button-secondary">Nuevo pago</a>
    @endunless
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Pagos</p>
            <h1>{{ auth()->user()?->isDriver() ? 'Historial de pagos' : 'Cuentas de taxi' }}</h1>
            <p class="hero-copy">
                {{ auth()->user()?->isDriver() ? 'Consulta tus pagos registrados con fecha, hora y monto entregado.' : 'Registra, revisa y administra los pagos realizados por los choferes de forma clara y segura.' }}
            </p>
        </div>
    </section>

    <section class="table-card">
        @if(auth()->user()?->isAdmin() || auth()->user()?->isOperator())
        <div class="filter-container" style="margin-bottom: 20px; padding: 15px; border-bottom: 1px solid #eaeaea;">
            <form action="{{ route('pagos.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
                <input 
                    type="text" 
                    name="unidad" 
                    placeholder="Filtrar por nombre de unidad..." 
                    value="{{ request('unidad') }}" 
                    class="form-input"
                    style="flex: 1; max-width: 300px;"
                >
                <button type="submit" class="button-secondary">Buscar</button>
                
                @if(request('unidad'))
                    <a href="{{ route('pagos.index') }}" class="button-ghost">Limpiar filtro</a>
                @endif
            </form>
        </div>
        @endif

        @if($pagos->isEmpty())
            <div class="empty-state">
                <h2>No hay registros de pagos aún</h2>
                <p>Comienza creando un nuevo registro para mantener el control financiero actualizado.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Chofer</th>
                        <th>Vehículo</th>
                        <th>Monto</th>
                        @unless(auth()->user()?->isDriver())
                            <th>Acciones</th>
                        @endunless
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                        <tr>
                            <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td>{{ $pago->created_at?->format('H:i') ?? '--:--' }}</td>
                            <td>{{ $pago->chofer->usuario?->name ?? 'Chofer no disponible' }}</td>
                            <td>{{ $pago->chofer->vehiculo?->nombre ?? 'Sin vehículo' }}</td>
                            <td><span class="payment-tag">${{ number_format($pago->monto_pago, 2, ',', '.') }}</span></td>
                            @unless(auth()->user()?->isDriver())
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('pagos.show', $pago) }}" class="button-ghost">Ver</a>
                                        <a href="{{ route('pagos.edit', $pago) }}" class="button-secondary">Editar</a>
                                        <form action="{{ route('pagos.destroy', $pago) }}" method="POST" onsubmit="return confirm('¿Eliminar este pago?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button-ghost" style="border: 1px solid rgba(239, 68, 68, 0.2); color: #dc2626;">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            @endunless
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection