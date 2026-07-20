@extends('layouts.app')

@section('title', 'Detalle del taxi - SIGES')

@section('topbar-actions')
    <a href="{{ route('vehiculos.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a taxis
    </a>
    <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="button-secondary">Editar taxi</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Detalle del taxi</p>
            <h1>Unidad: {{ $vehiculo->nombre }}</h1>
            <p class="hero-copy">Revisa toda la información del vehículo y su chofer asignado para llevar un control preciso.</p>
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
                <h2>Información del taxi</h2>
                <p>Consulta los detalles clave del vehículo junto con el chofer responsable.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <div class="field-grid">
            <div class="field-card">
                <span class="field-label">Nombre</span>
                <p>{{ $vehiculo->nombre }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Placa</span>
                <p>{{ $vehiculo->placa }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Marca</span>
                <p>{{ $vehiculo->marca }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Modelo</span>
                <p>{{ $vehiculo->modelo }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Motor</span>
                <p>{{ $vehiculo->motor }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Serie</span>
                <p>{{ $vehiculo->serie }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Concesionario</span>
                <p>{{ $vehiculo->concesionario }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Chofer asignado</span>
                <p>{{ $vehiculo->chofer->usuario?->name ?? 'Sin chofer asignado' }}</p>
            </div>
        </div>
    </section>
@endsection
