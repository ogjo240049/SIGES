<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIGES')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700|space-grotesk:500,700" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
</head>
<body>
    <div class="shell">
        <header class="topbar">
            <div class="brand">
                <img src="{{ asset('images/mini-logo.png') }}" alt="Logo Radio Taxi" class="brand-mark-img">
                
                <div>
                    <span class="brand-name">SIGES</span>
                    <span class="brand-subtitle">Gestión inteligente</span>
                </div>
            </div>


            <div class="topbar-actions">
                @hasSection('topbar-actions')
                    @yield('topbar-actions')
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout">Cerrar sesión</button>
                </form>
            </div>
        </header>

        @if(session('success'))
            <div class="flash-message">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="flash-message" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
