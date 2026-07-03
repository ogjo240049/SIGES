@extends('layouts.app')

@section('title', 'Detalle del servicio - SIGES')

@section('topbar-actions')
    <a href="{{ route('servicios.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a servicios
    </a>
    <a href="{{ route('servicios.edit', $servicio) }}" class="button-secondary">Editar servicio</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Detalle del servicio</p>
            <h1>Servicio programado</h1>
            <p class="hero-copy">Revisa los detalles del servicio y la asignación del chofer y vehículo.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 7H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7 21V10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <h2>Información del servicio</h2>
                <p>Detalles completos del viaje.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <div class="field-grid">
            <div class="field-card">
                <span class="field-label">Chofer</span>
                <p>{{ $servicio->chofer->usuario?->name ?? 'N/D' }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Vehículo</span>
                <p>{{ $servicio->chofer->vehiculo?->matricula ?? 'Sin vehículo' }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Origen</span>
                <p>{{ $servicio->origen_viaje }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Destino</span>
                <p>{{ $servicio->destino_viaje }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Fecha</span>
                <p>{{ $servicio->fecha_pedido->format('d/m/Y') }}</p>
            </div>
        </div>
    </section>
@endsection
