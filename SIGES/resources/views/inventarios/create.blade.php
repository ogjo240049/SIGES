@extends('layouts.app')

@section('title', 'Registrar pieza - SIGES')

@section('topbar-actions')
    <a href="{{ route('inventarios.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver al inventario
    </a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Registrar pieza</p>
            <h1>Agregar pieza al inventario</h1>
            <p class="hero-copy">Registra una pieza con su nombre, tipo y cantidad disponible.</p>
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
                <h2>Nueva pieza</h2>
                <p>Captura los datos de la pieza para mantener el control de stock.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <form method="POST" action="{{ route('inventarios.store') }}">
            @csrf
            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Nombre de la pieza</label>
                    <input type="text" name="nombre_pieza" value="{{ old('nombre_pieza') }}" required>
                    @error('nombre_pieza')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Tipo de pieza</label>
                    <input type="text" name="tipo_pieza" value="{{ old('tipo_pieza') }}" required>
                    @error('tipo_pieza')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Cantidad (stock)</label>
                    <input type="number" name="cantidad" min="0" step="1" value="{{ old('cantidad', 0) }}" required>
                    @error('cantidad')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">Guardar pieza</button>
            </div>
        </form>
    </section>
@endsection
