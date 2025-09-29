<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Quality') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">Quality</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="/proformas">Proformas</a></li>
                    <li class="nav-item"><a class="nav-link" href="/windows">Ventanas</a></li>
                    <li class="nav-item"><a class="nav-link" href="/profile">Perfil</a></li>
                    <li class="nav-item"><a class="nav-link" href="/gallery">Galería</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="/logout">Salir</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="/login">Ingresar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mb-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
        {{ $slot ?? '' }}
    </main>
    <footer class="bg-light text-center py-3 border-top">
        <small>&copy; {{ date('Y') }} Quality. Todos los derechos reservados.</small>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
