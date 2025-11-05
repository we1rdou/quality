<!DOCTYPE html>
<html lang="es">
<head>
    @include('partials.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Quality')</title>
    @livewireStyles
</head>
<body class="min-h-screen gradient-bg antialiased">
    @include('partials.sidebar')
    <main id="main-content" class="main-content min-h-screen">
        <div class="p-6">
            {{ $slot }}
        </div>
    </main>
    @livewireScripts
    @stack('scripts')
</body>
</html>
