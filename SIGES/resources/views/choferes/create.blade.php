@extends('layouts.app')

@section('title', 'Registrar chofer - SIGES')

@section('topbar-actions')
    <a href="{{ route('choferes.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a choferes
    </a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Registrar chofer</p>
            <h1>Crear chofer</h1>
            <p class="hero-copy">Asocia un usuario al chofer, captura su identificación y asigna una unidad si está disponible.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
                    <path d="M4 21V19C4 16.7909 5.79086 15 8 15H16C18.2091 15 20 16.7909 20 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h2>Nuevo chofer</h2>
                <p>Completa el vínculo con su usuario y su unidad de trabajo.</p>
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

        <form method="POST" action="{{ route('choferes.store') }}">
            @csrf

            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Usuario</label>
                    <select name="id_usuario" required>
                        <option value="">Selecciona un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('id_usuario') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }} {{ $usuario->apellido_pat }} {{ $usuario->apellido_mat }} - {{ $usuario->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_usuario')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Identificación</label>
                    <input type="text" name="identificacion" value="{{ old('identificacion') }}" required>
                    @error('identificacion')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Unidad asignada</label>
                    <select name="unidad_asignada">
                        <option value="">Sin unidad</option>
                        @foreach($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->matricula }}" {{ old('unidad_asignada') == $vehiculo->matricula ? 'selected' : '' }}>
                                {{ $vehiculo->nombre }} (Placa: {{ $vehiculo->placa }})
                                @if($vehiculo->chofer)
                                    - [Asignada a {{ $vehiculo->chofer->usuario?->name ?? 'otro chofer' }}]
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('unidad_asignada')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">Guardar chofer</button>
            </div>
        </form>
    </section>
@endsection