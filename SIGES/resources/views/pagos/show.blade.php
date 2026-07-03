@extends('layouts.app')

@section('title', 'Detalle de pago - SIGES')

@section('topbar-actions')
    <a href="{{ route('pagos.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a pagos
    </a>
    <a href="{{ route('pagos.edit', $pago) }}" class="button-secondary">Editar pago</a>
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
                    <path d="M12 6V12L15 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8 4H16C18.2091 4 20 5.79086 20 8V16C20 18.2091 18.2091 20 16 20H8C5.79086 20 4 18.2091 4 16V8C4 5.79086 5.79086 4 8 4Z" stroke="currentColor" stroke-width="2"/>
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
                <p>{{ $pago->chofer->vehiculo?->matricula ?? 'Sin vehículo asignado' }}</p>
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
