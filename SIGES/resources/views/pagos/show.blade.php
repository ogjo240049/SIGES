@extends('layouts.app')

@section('title', 'Detalle de pago - SIGES')

@section('topbar-actions')
    <a href="{{ route('pagos.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a pagos
    </a>
    @unless(auth()->user()?->isDriver())
        <a href="{{ route('pagos.edit', $pago) }}" class="button-secondary">Editar pago</a>
    @endunless
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Detalle del pago</p>
            <h1>Ver registro</h1>
            <p class="hero-copy">Revisa la información del pago con claridad antes de continuar con otras operaciones.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 12C2 12 5 5 12 5C19 5 22 12 22 12C22 12 19 19 12 19C5 19 2 12 2 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <h2>Detalles del pago</h2>
                <p>Consulta todos los datos del pago y verifica que el registro sea correcto.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <div class="field-grid">
            <div class="field-card">
                <span class="field-label">Chofer</span>
                <p>{{ $pago->chofer->usuario?->name ?? 'Chofer no disponible' }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Vehículo</span>
                <p>{{ $pago->chofer->vehiculo?->nombre ?? 'Sin vehículo asignado' }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Fecha de pago</span>
                <p>{{ $pago->fecha_pago->format('d/m/Y') }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Monto</span>
                <p class="payment-tag">${{ number_format($pago->monto_pago, 2, ',', '.') }}</p>
            </div>
        </div>
    </section>
@endsection