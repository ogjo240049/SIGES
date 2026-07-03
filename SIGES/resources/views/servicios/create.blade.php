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
                    <path d="M3 7H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7 21V10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                                {{ $chofer->usuario?->name ?? 'Chofer' }} · {{ $chofer->vehiculo?->matricula ?? 'Sin vehículo' }}
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
                <button type="submit" class="button-primary">Guardar servicio</button>
            </div>
        </form>
    </section>
@endsection
