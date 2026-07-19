@extends('layouts.app')

@section('title', 'Registrar usuario - SIGES')

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
            <p class="eyebrow">Registrar usuario</p>
            <h1>Crear nueva cuenta</h1>
            <p class="hero-copy">Captura la información de acceso y define el rol que tendrá el usuario dentro del sistema.</p>
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
                <h2>Crear usuario</h2>
                <p>Llena los datos del perfil y asigna una contraseña inicial segura.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf
            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">Nombre</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Apellido paterno</label>
                    <input type="text" name="apellido_pat" value="{{ old('apellido_pat') }}" required>
                    @error('apellido_pat')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Apellido materno</label>
                    <input type="text" name="apellido_mat" value="{{ old('apellido_mat') }}" required>
                    @error('apellido_mat')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" required pattern="[0-9+\-\s]{7,15}" title="Ingresa un teléfono válido">
                    @error('telefono')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Rol</label>
                    <select name="rol" required>
                        <option value="">Selecciona un rol</option>
                        @foreach($roleOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('rol') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('rol')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Correo</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Contraseña</label>
                    <input type="password" name="password" required>
                    @error('password')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field-card">
                    <label class="field-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" required>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 13V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M9 9L12 12L15 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 12V3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Guardar usuario</button>
            </div>
        </form>
    </section>
@endsection