@extends('layouts.app')

@section('title', 'Registrar taxi - SIGES')

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
            <p class="eyebrow">Registrar taxi</p>
            <h1>Agregar unidad</h1>
            <p class="hero-copy">Registra un nuevo taxi con placa, modelo, motor, serie, concesionario y el chofer asignado.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 17V7C4 5.89543 4.89543 5 6 5H18C19.1046 5 20 5.89543 20 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 13H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M7 17V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M17 17V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h2>Registrar taxi</h2>
                <p>Captura los datos completos de cada unidad y asigna el chofer disponible.</p>
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

        <form method="POST" action="{{ route('vehiculos.store') }}">
            @csrf
            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Placa</label>
                    <input type="text" name="placa" value="{{ old('placa') }}" required maxlength="40">
                    @error('placa')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Marca</label>
                    <input type="text" name="marca" value="{{ old('marca') }}" required>
                    @error('marca')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Modelo</label>
                    <input type="text" name="modelo" value="{{ old('modelo') }}" required>
                    @error('modelo')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Motor</label>
                    <input type="text" name="motor" value="{{ old('motor') }}" required>
                    @error('motor')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Serie</label>
                    <input type="text" name="serie" value="{{ old('serie') }}" required>
                    @error('serie')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Concesionario</label>
                    <input type="text" name="concesionario" value="{{ old('concesionario') }}" required>
                    @error('concesionario')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Chofer asignado</label>
                    <select name="id_chofer">
                        <option value="">Sin chofer</option>
                        @foreach($choferes as $chofer)
                            <option value="{{ $chofer->id_chofer }}" {{ old('id_chofer') == $chofer->id_chofer ? 'selected' : '' }}>
                                {{ $chofer->usuario?->name ?? 'Chofer' }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_chofer')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">Guardar taxi</button>
            </div>
        </form>
    </section>
@endsection
