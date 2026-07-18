@extends('layouts.app')

@section('title', 'Editar usuario - SIGES')

@section('topbar-actions')
    <a href="{{ route('usuarios.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a usuarios
    </a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Editar usuario</p>
            <h1>Actualizar cuenta</h1>
            <p class="hero-copy">Modifica la información del perfil, su rol y, si es necesario, la contraseña de acceso.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <div>
                <h2>Editar usuario</h2>
                <p>Actualiza los datos de acceso y conserva la contraseña actual si dejas el campo vacío.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <form method="POST" action="{{ route('usuarios.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Apellido paterno</label>
                    <input type="text" name="apellido_pat" value="{{ old('apellido_pat', $user->apellido_pat) }}" required>
                    @error('apellido_pat')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Apellido materno</label>
                    <input type="text" name="apellido_mat" value="{{ old('apellido_mat', $user->apellido_mat) }}" required>
                    @error('apellido_mat')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $user->telefono) }}" required pattern="[0-9+\-\s]{7,15}" title="Ingresa un teléfono válido">
                    @error('telefono')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Rol</label>
                    <select name="rol" required>
                        @foreach($roleOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('rol', $user->rol) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('rol')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Correo</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Nueva contraseña</label>
                    <input type="password" name="password" placeholder="Deja en blanco para conservarla">
                    @error('password')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" placeholder="Repite la nueva contraseña">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">Guardar cambios</button>
            </div>
        </form>
    </section>
@endsection