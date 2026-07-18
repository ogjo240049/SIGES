@extends('layouts.app')

@section('title', 'Editar servicio - SIGES')

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
            <p class="eyebrow">Editar servicio</p>
            <h1>Actualizar servicio</h1>
            <p class="hero-copy">Modifica los detalles del servicio registrado.</p>
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
                <h2>Editar servicio</h2>
                <p>Actualiza el origen, destino, chofer o fecha del servicio.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <form method="POST" action="{{ route('servicios.update', $servicio) }}">
            @csrf
            @method('PUT')

            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Chofer</label>
                    <select name="id_chofer" required>
                        <option value="">Selecciona un chofer</option>
                        @foreach($choferes as $chofer)
                            <option value="{{ $chofer->id_chofer }}" {{ old('id_chofer', $servicio->id_chofer) == $chofer->id_chofer ? 'selected' : '' }}>
                                <!-- CAMBIO: En la opción del select se concatena el nombre del vehículo -->
                                {{ $chofer->usuario?->name ?? 'Chofer' }} · {{ $chofer->vehiculo?->nombre ?? 'Sin vehículo' }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_chofer')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Origen</label>
                    <input type="text" name="origen_viaje" value="{{ old('origen_viaje', $servicio->origen_viaje) }}" required>
                    @error('origen_viaje')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Destino</label>
                    <input type="text" name="destino_viaje" value="{{ old('destino_viaje', $servicio->destino_viaje) }}" required>
                    @error('destino_viaje')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field-card">
                    <label class="field-label">Fecha de agenda</label>
                    <input type="date" name="fecha_pedido" value="{{ old('fecha_pedido', $servicio->fecha_pedido->format('Y-m-d')) }}" required>
                    @error('fecha_pedido')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">Guardar cambios</button>
            </div>
        </form>
    </section>
@endsection