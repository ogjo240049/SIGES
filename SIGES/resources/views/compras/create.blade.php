@extends('layouts.app')

@section('title', 'Registrar compra - SIGES')

@section('topbar-actions')
    <a href="{{ route('compras.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a compras
    </a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Registrar compra</p>
            <h1>Agregar compra</h1>
            <p class="hero-copy">Registra la compra de una pieza con su precio, cantidad, fecha y lugar.</p>
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
                <h2>Registrar compra</h2>
                <p>Captura los detalles de la adquisición.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <form method="POST" action="{{ route('compras.store') }}">
            @csrf
            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Pieza</label>
                    <select name="id_inventario" required>
                        <option value="">Selecciona una pieza</option>
                        @foreach($inventarios as $inv)
                            <option value="{{ $inv->id_inventario }}" {{ old('id_inventario') == $inv->id_inventario ? 'selected' : '' }}>
                                {{ $inv->nombre_pieza }} · {{ $inv->tipo_pieza }} (Stock: {{ $inv->cantidad }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_inventario')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Precio unitario</label>
                    <div class="input-prefix-group">
                        <span class="input-prefix">$</span>
                        <input type="number" name="precio_unitario" step="0.01" min="0.01" value="{{ old('precio_unitario') }}" required>
                    </div>
                    @error('precio_unitario')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Cantidad comprada</label>
                    <input type="number" name="cantidad_compra" min="1" value="{{ old('cantidad_compra', 1) }}" required>
                    @error('cantidad_compra')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Fecha</label>
                    <input type="date" name="fecha" value="{{ old('fecha') }}" required>
                    @error('fecha')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Lugar de compra</label>
                    <input type="text" name="lugar_compra" value="{{ old('lugar_compra') }}" required>
                    @error('lugar_compra')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">Guardar compra</button>
            </div>
        </form>
    </section>
@endsection
