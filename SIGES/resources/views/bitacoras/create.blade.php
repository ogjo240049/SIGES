@extends('layouts.app')

@section('title', 'Registrar bitácora - SIGES')

@section('topbar-actions')
    <a href="{{ route('bitacoras.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a bitácora
    </a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Registrar bitácora</p>
            <h1>Crear registro</h1>
            <p class="hero-copy">Captura el chofer, la fecha y hora del evento, y la locación correspondiente.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 3V5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M17 3V5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M4 8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <rect x="4" y="6" width="16" height="14" rx="2" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <div>
                <h2>Nuevo registro de bitácora</h2>
                <p>Asocia la actividad con un chofer y registra el momento exacto del evento.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <form method="POST" action="{{ route('bitacoras.store') }}">
            @csrf

            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Chofer</label>
                    <select name="id_chofer" required>
                        <option value="">Selecciona un chofer</option>
                        @foreach($choferes as $chofer)
                            <option value="{{ $chofer->id_chofer }}" {{ old('id_chofer') == $chofer->id_chofer ? 'selected' : '' }}>
                                {{ $chofer->usuario?->name ?? 'Chofer' }}
                                @if($chofer->vehiculo)
                                    - {{ $chofer->vehiculo->matricula }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('id_chofer')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Fecha y hora</label>
                    <input type="datetime-local" name="fecha_hora" value="{{ old('fecha_hora') }}" required>
                    @error('fecha_hora')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card" style="grid-column: 1 / -1;">
                    <label class="field-label">Locación</label>
                    <input type="text" name="locacion" value="{{ old('locacion') }}" required>
                    @error('locacion')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">Guardar registro</button>
            </div>
        </form>
    </section>
@endsection