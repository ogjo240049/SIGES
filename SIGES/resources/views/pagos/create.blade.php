@extends('layouts.app')

@section('title', 'Registrar pago - SIGES')

@section('topbar-actions')
    <a href="{{ route('pagos.index') }}" class="link-button">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Volver a pagos
    </a>
@endsection

@section('content')
    <section class="page-header">
        <div class="page-heading">
            <p class="eyebrow">Registrar pago</p>
            <h1>Registrar pago</h1>
            <p class="hero-copy">Crea un nuevo pago registrando al chofer, la fecha, el vehículo y el monto correspondiente.</p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div class="panel-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 6V12L15 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8 4H16C18.2091 4 20 5.79086 20 8V16C20 18.2091 18.2091 20 16 20H8C5.79086 20 4 18.2091 4 16V8C4 5.79086 5.79086 4 8 4Z" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>
            <div>
                <h2>Registrar pago</h2>
                <p>Captura cada pago con un formulario sencillo diseñado para evitar errores.</p>
            </div>
        </div>

        <div class="panel-separator"></div>

        <form method="POST" action="{{ route('pagos.store') }}">
            @csrf
            <div class="field-grid">
                <div class="field-card">
                    <label class="field-label">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M19 21V19C19 16.7909 17.2091 15 15 15H9C6.79086 15 5 16.7909 5 19V21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Chofer
                    </label>
                    <select name="id_chofer" required>
                        <option value="">Selecciona un chofer</option>
                        @foreach($choferes as $chofer)
                            <option value="{{ $chofer->id_chofer }}" {{ old('id_chofer') == $chofer->id_chofer ? 'selected' : '' }}>
                                {{ $chofer->usuario?->name ?? 'Chofer' }} · {{ $chofer->vehiculo?->nombre ?? 'Sin vehículo' }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_chofer')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-card">
                    <label class="field-label">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 2V5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M16 2V5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M4 9H20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M5 20H19C20.1046 20 21 19.1046 21 18V9C21 7.89543 20.1046 7 19 7H5C3.89543 7 3 7.89543 3 9V18C3 19.1046 3.89543 20 5 20Z" stroke="currentColor" stroke-width="1.8"/>
                        </svg>
                        Fecha de pago
                    </label>
                    <input type="date" name="fecha_pago" value="{{ old('fecha_pago') }}" max="{{ date('Y-m-d') }}" required>
                    @error('fecha_pago')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-card">
                    <label class="field-label">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5V19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M8 7H16C17.1046 7 18 7.89543 18 9C18 10.1046 17.1046 11 16 11H12C10.8954 11 10 11.8954 10 13C10 14.1046 10.8954 15 12 15H16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M12 5C9.79086 5 8 6.79086 8 9C8 11.2091 9.79086 13 12 13C14.2091 13 16 14.7909 16 17C16 19.2091 14.2091 21 12 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        Monto pagado
                    </label>
                    <div class="input-prefix-group">
                        <span class="input-prefix">$</span>
                        <input type="number" name="monto_pago" min="0.01" step="0.01" value="{{ old('monto_pago') }}" placeholder="0.00" required>
                    </div>
                    @error('monto_pago')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="button-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 13V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M9 9L12 12L15 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 12V3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Guardar pago
                </button>

                <div class="info-note">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2Z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M12 16V12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M12 8H12.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    Asegúrate de verificar los datos antes de guardar.
                </div>
            </div>
        </form>
    </section>
@endsection