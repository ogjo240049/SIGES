@extends('layouts.app')

@section('title', 'Detalle de pieza - SIGES')

@section('topbar-actions')
    <a href="{{ route('inventarios.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al inventario
    </a>
    
    {{-- BOTÓN ACCIÓN RÁPIDA DE CONSUMO --}}
    @if($inventario->cantidad > 0)
        <form action="{{ route('inventarios.update', $inventario) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('PUT')
            <input type="hidden" name="nombre_pieza" value="{{ $inventario->nombre_pieza }}">
            <input type="hidden" name="tipo_pieza" value="{{ $inventario->tipo_pieza }}">
            <input type="hidden" name="cantidad" value="{{ $inventario->cantidad - 1 }}">
            <button type="submit" class="button-primary" style="background-color: #10b981;">
                Usar 1 pieza
            </button>
        </form>
    @else
        <button class="button-ghost" style="opacity: 0.5; cursor: not-allowed;" disabled>Agotado</button>
    @endif

    <a href="{{ route('inventarios.edit', $inventario) }}" class="button-secondary">Editar pieza</a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Detalle de la pieza</p>
            <h1>{{ $inventario->nombre_pieza }}</h1>
            <p class="hero-copy">Revisa los detalles de la pieza y su stock disponible.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L20 7V17L12 22L4 17V7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <h2>Información de la pieza</h2>
                <p>Detalles y cantidad disponible en inventario.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <div class="field-grid">
            <div class="field-card">
                <span class="field-label">Nombre</span>
                <p>{{ $inventario->nombre_pieza }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Tipo</span>
                <p>{{ $inventario->tipo_pieza }}</p>
            </div>
            <div class="field-card">
                <span class="field-label">Cantidad disponible</span>
                <p>
                    <span class="payment-tag" style="background-color: {{ $inventario->cantidad > 0 ? 'rgba(59, 130, 246, 0.1)' : 'rgba(239, 68, 68, 0.1)' }}; color: {{ $inventario->cantidad > 0 ? '#1d4ed8' : '#dc2626' }}; font-size: 1.1rem; padding: 4px 12px;">
                        {{ $inventario->cantidad }} unidades
                    </span>
                </p>
            </div>
        </div>
    </section>
@endsection