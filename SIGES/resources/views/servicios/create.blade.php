@extends('layouts.app')

@section('title', 'Registrar servicio - SIGES')

@section('topbar-actions')
    <a href="{{ route('servicios.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a servicios
    </a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Registrar servicio</p>
            <h1>Agregar servicio</h1>
            <p class="hero-copy">Registra un servicio indicando chofer, vehículo, origen, destino y fecha.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 16L11 18L15 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        <div>
                <h2>Registrar servicio</h2>
                <p>Captura los datos del servicio de la radio taxi.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <form method="POST" action="{{ route('servicios.store') }}">
            @csrf
            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Chofer</label>
                    <select name="id_chofer" required>
                        <option value="">Selecciona un chofer</option>
                        @foreach($choferes as $chofer)
                            <option value="{{ $chofer->id_chofer }}" {{ old('id_chofer') == $chofer->id_chofer ? 'selected' : '' }}>
                                <!-- CAMBIO: En la opción del select se concatena el nombre del vehículo -->
                                {{ $chofer->usuario?->name ?? 'Chofer' }} · {{ $chofer->vehiculo?->nombre ?? 'Sin vehículo' }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_chofer')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Origen</label>
                    <input type="text" name="origen_viaje" value="{{ old('origen_viaje') }}" required>
                    @error('origen_viaje')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Destino</label>
                    <input type="text" name="destino_viaje" value="{{ old('destino_viaje') }}" required>
                    @error('destino_viaje')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Fecha de agenda</label>
                    <input type="date" name="fecha_pedido" value="{{ old('fecha_pedido') }}" required>
                    @error('fecha_pedido')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 13V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M9 9L12 12L15 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 12V3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Guardar servicio</button>
            </div>
        </form>
    </section>
@endsection