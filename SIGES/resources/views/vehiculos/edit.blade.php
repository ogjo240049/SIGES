@extends('layouts.app')

@section('title', 'Editar taxi - SIGES')

@section('topbar-actions')
    <a href="{{ route('vehiculos.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a taxis
    </a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Editar taxi</p>
            <h1>Actualizar unidad</h1>
            <p class="hero-copy">Modifica los datos del taxi y ajusta el chofer asignado cuando sea necesario.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 11L6.8 6.5C7.14 5.65 7.96 5 8.9 5H15.1C16.04 5 16.86 5.65 17.2 6.5L19 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="3" y="11" width="18" height="6" rx="1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="7" cy="17" r="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="17" cy="17" r="2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <h2>Editar taxi</h2>
                <p>Actualiza los atributos de la unidad sin perder el historial de información del vehículo.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        @if($errors->any())
            <div class="flash-message" role="alert" style="margin-bottom: 20px;">
                <strong>Revisa los campos marcados:</strong>
                <ul style="margin: 8px 0 0 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('vehiculos.update', $vehiculo) }}">
            @csrf
            @method('PUT')

            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $vehiculo->nombre) }}" required>
                    @error('nombre')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Placa</label>
                    <input type="text" name="placa" value="{{ old('placa', $vehiculo->placa) }}" required maxlength="40">
                    @error('placa')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Marca</label>
                    <input type="text" name="marca" value="{{ old('marca', $vehiculo->marca) }}" required>
                    @error('marca')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Modelo</label>
                    <input type="text" name="modelo" value="{{ old('modelo', $vehiculo->modelo) }}" required>
                    @error('modelo')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Motor</label>
                    <input type="text" name="motor" value="{{ old('motor', $vehiculo->motor) }}" required>
                    @error('motor')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Serie</label>
                    <input type="text" name="serie" value="{{ old('serie', $vehiculo->serie) }}" required>
                    @error('serie')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Concesionario</label>
                    <input type="text" name="concesionario" value="{{ old('concesionario', $vehiculo->concesionario) }}" required>
                    @error('concesionario')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Chofer asignado</label>
                    <select name="id_chofer">
                        <option value="">Sin chofer</option>
                        @foreach($choferes as $chofer)
                            <option value="{{ $chofer->id_chofer }}" {{ old('id_chofer', optional($vehiculo->chofer)->id_chofer) == $chofer->id_chofer ? 'selected' : '' }}>
                                {{ $chofer->usuario?->name ?? 'Chofer' }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_chofer')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">Guardar cambios</button>
            </div>
        </form>
    </section>
@endsection
