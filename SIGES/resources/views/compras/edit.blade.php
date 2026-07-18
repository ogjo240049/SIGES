@extends('layouts.app')

@section('title', 'Editar compra - SIGES')

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
            <p class="eyebrow">Editar compra</p>
            <h1>Actualizar registro</h1>
            <p class="hero-copy">Modifica los detalles de la compra.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
             <div class="panel-icon">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 2L3 6V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6L18 2H6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3 6H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16 10C16 11.0609 15.5786 12.0783 14.8284 12.8284C14.0783 13.5786 13.0609 14 12 14C10.9391 14 9.92172 13.5786 9.17157 12.8284C8.42143 12.0783 8 11.0609 8 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
            <div>
                <h2>Editar compra</h2>
                <p>Actualiza la información de la compra y ajusta el inventario automáticamente.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <form method="POST" action="{{ route('compras.update', $compra) }}">
            @csrf
            @method('PUT')

            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Pieza</label>
                    <select name="id_inventario" required>
                        <option value="">Selecciona una pieza</option>
                        @foreach($inventarios as $inv)
                            <option value="{{ $inv->id_inventario }}" {{ old('id_inventario', $compra->id_inventario) == $inv->id_inventario ? 'selected' : '' }}>
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
                        <input type="number" name="precio_unitario" step="0.01" min="0" value="{{ old('precio_unitario', $compra->precio_unitario) }}" required>
                    </div>
                    @error('precio_unitario')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Cantidad comprada</label>
                    <input type="number" name="cantidad_compra" min="1" value="{{ old('cantidad_compra', $compra->cantidad_compra) }}" required>
                    @error('cantidad_compra')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Fecha</label>
                    <input type="date" name="fecha" value="{{ old('fecha', $compra->fecha->format('Y-m-d')) }}" required>
                    @error('fecha')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Lugar de compra</label>
                    <input type="text" name="lugar_compra" value="{{ old('lugar_compra', $compra->lugar_compra) }}" required>
                    @error('lugar_compra')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">Guardar cambios</button>
            </div>
        </form>
    </section>
@endsection
