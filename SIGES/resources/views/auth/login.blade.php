<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acceso a SIGES</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700|space-grotesk:500,700" rel="stylesheet" />
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    <main class="frame">
        <section class="hero">
            <div class="brand">
                <span class="brand-mark"></span>
                <span>SIGES</span>
            </div>

        </section>

        <section class="form-panel">
            <h2>Iniciar sesión</h2>
            <p>Accede con tu correo y contraseña para continuar al tablero principal.</p>

            @if ($errors->any())
                <div class="alert" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf

                <div class="field">
                    <label for="email">Correo electrónico</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        placeholder="usuario@gmail.com"
                        autocomplete="email"
                        required
                    >
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Contraseña</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                    >
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <label class="remember">
                        <input type="checkbox" name="remember" value="1">
                        Recordarme
                    </label>

                    <a class="link" href="mailto:soporte@siges.local">¿Necesitas acceso?</a>
                </div>

                <button type="submit" class="button">Entrar al sistema</button>
            </form>

            <div class="footer-note">
                Servicio de Radio Taxi Estrella Sureña
            </div>
        </section>
    </main>
</body>
</html>