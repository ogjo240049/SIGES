@extends('layouts.app')

@section('title', 'Detalle del chofer - SIGES')

@section('topbar-actions')
    <a href="{{ route('choferes.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a choferes
    </a>
    <a href="{{ route('choferes.edit', $chofer) }}" class="button-secondary">Editar chofer</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Detalle del chofer</p>
            <h1>Chofer #{{ $chofer->id_chofer }}</h1>
            <p class="hero-copy">Consulta la relación entre el usuario, la identificación y la unidad asociada.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
                    <path d="M4 21V19C4 16.7909 5.79086 15 8 15H16C18.2091 15 20 16.7909 20 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h2>Información del chofer</h2>
                <p>Revisa el perfil y los vínculos actuales del chofer dentro del sistema.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <div class="field-grid">
            <div class="field-card">
                <span class="field-label">Usuario</span>
                <p>{{ $chofer->usuario?->name ?? 'N/D' }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Correo</span>
                <p>{{ $chofer->usuario?->email ?? 'N/D' }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Identificación</span>
                <p>{{ $chofer->identificacion }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Unidad asignada</span>
                <p>{{ $chofer->vehiculo?->matricula ?? 'Sin unidad' }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Pagos</span>
                <p>{{ $chofer->pagos->count() }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Servicios</span>
                <p>{{ $chofer->servicios->count() }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Bitácoras</span>
                <p>{{ $chofer->bitacoras->count() }}</p>
            </div>
        </div>
    </section>
@endsection