@extends('layouts.app')

@section('title', 'Editar chofer - SIGES')

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
            <p class="eyebrow">Editar chofer</p>
            <h1>Actualizar chofer</h1>
            <p class="hero-copy">Modifica el usuario, la identificación y la unidad asignada del chofer.</p>
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
                <h2>Editar chofer</h2>
                <p>Conserva la asignación actual o cambia la unidad sin dejar registros huérfanos.</p>
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

        <form method="POST" action="{{ route('choferes.update', $chofer) }}">
            @csrf
            @method('PUT')

            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Usuario</label>
                    <select name="id_usuario" required>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('id_usuario', $chofer->id_usuario) == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }} {{ $usuario->apellido_pat }} {{ $usuario->apellido_mat }} - {{ $usuario->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_usuario')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Identificación</label>
                    <input type="text" name="identificacion" value="{{ old('identificacion', $chofer->identificacion) }}" required>
                    @error('identificacion')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Unidad asignada</label>
                    <select name="unidad_asignada">
                        <option value="">Sin unidad</option>
                        @foreach($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->matricula }}" {{ old('unidad_asignada', $chofer->unidad_asignada) == $vehiculo->matricula ? 'selected' : '' }}>
                                {{ $vehiculo->matricula }} - {{ $vehiculo->placa }}
                                @if($vehiculo->chofer && $vehiculo->chofer->id_chofer !== $chofer->id_chofer)
                                    (Asignada)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('unidad_asignada')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">Guardar cambios</button>
            </div>
        </form>
    </section>
@endsection