<!-- Eliminados bloques duplicados y condicionales Blade mal cerrados -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/css/glide.core.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/css/glide.theme.min.css">
        <style>
            /* Estilos para navbar */
            .nav-link {
                position: relative;
            }
            .nav-link::after {
                content: '';
            }
            /* Fin de estilos personalizados */
            /* Eliminado bloque Blade y HTML duplicado dentro de <style> */
            }
            .nav-link:hover::after {
                width: 100%;
            }
            
            /* Glide bullets personalizado */
            .glide__bullet--active {
                background: white !important;
                transform: scale(1.2);
            }
            
            /* Mejores sombras y efectos */
            nav {
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }
            
            /* Dropdown hover effect */
            .group:hover .group-hover\:opacity-100 {
                opacity: 1;
            }
            .group:hover .group-hover\:visible {
                visibility: visible;
            }
            
            /* Avatar gradient animation */
            .avatar-gradient {
                background: linear-gradient(45deg, #2563eb, #4f46e5, #7c3aed);
                background-size: 200% 200%;
                animation: gradient-shift 3s ease infinite;
            }
            
            @keyframes gradient-shift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
        </style>
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-gray-900">
        <!-- Modal de cambio de contraseña -->
    <div id="modal-password" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm {{ session('password_error') || session('password_success') ? '' : 'hidden' }}">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-full max-w-md p-8 relative">
                <button onclick="document.getElementById('modal-password').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Cambiar Contraseña</h2>
                @if(session('password_success'))
                    <div class="mb-4 text-green-600 dark:text-green-400 font-semibold">{{ session('password_success') }}</div>
                @endif
                @if(session('password_error'))
                    <div class="mb-4">
                        <ul class="text-red-600 dark:text-red-400 text-sm list-disc pl-5">
                            @foreach((array) session('password_error') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('perfil.password') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Contraseña actual</label>
                        <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nueva contraseña</label>
                        <input type="password" name="new_password" id="new_password" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Confirmar nueva contraseña</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">Guardar contraseña</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Navegación -->
        <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-black/10 backdrop-blur-md transition-all duration-300">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl p-2">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white">Quality</span>
                    </div>
                    
                    <!-- Navegación Desktop -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#inicio" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium">Inicio</a>
                        <a href="#nosotros" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium">Nosotros</a>
                        <a href="#servicios" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium">Servicios</a>
                        <a href="#galeria" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium">Galería</a>
                        <a href="{{ route('proforma') }}" target="_blank" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium bg-gradient-to-r from-green-500 to-blue-500 px-4 py-2 rounded-lg font-semibold ml-2">Proforma</a>
                        <a href="#ubicacion" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium">Ubicación</a>
                        
                        @auth
                            <!-- Usuario logueado -->
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    Dashboard
                                </a>
                                <div class="relative group">
                                    <button class="flex items-center space-x-2 text-white/90 hover:text-white transition-colors duration-300">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold">{{ substr(optional(auth()->user())->name ?? '', 0, 1) }}</span>
                                        </div>
                                        <span class="font-medium">{{ optional(auth()->user())->name ?? '' }}</span>
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                        <div class="py-2">
                                                <button type="button" onclick="document.getElementById('modal-perfil').classList.remove('hidden')" class="block w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                                                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Perfil
                                                </button>
                                                @if(empty(optional(auth()->user())->oauth_provider))
                                                <button type="button" onclick="document.getElementById('modal-password').classList.remove('hidden')" class="block w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                                                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 8V6a4 4 0 118 0v2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4a2 2 0 012-2zm2-2a2 2 0 114 0v2H6V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Contraseña
                                                </button>
                                                @endif
                                                <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                                                <form method="POST" action="{{ route('logout') }}" class="block">
                                                    @csrf
                                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-300">
                                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Cerrar Sesión
                                                    </button>
                                                </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Usuario no logueado -->
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="text-white/90 hover:text-white font-medium transition-colors duration-300">
                                    Iniciar Sesión
                                </a>
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    Registrarse
                                </a>
                            </div>
                        @endauth
                    </div>
                    
                    <!-- Botón menú móvil -->
                    <button data-mobile-menu class="md:hidden text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Menú móvil -->
                <div data-mobile-menu-content class="hidden md:hidden mt-4 py-4 border-t border-white/20">
                    <div class="flex flex-col space-y-3">
                        <a href="#inicio" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium">Inicio</a>
                        <a href="#nosotros" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium">Nosotros</a>
                        <a href="#servicios" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium">Servicios</a>
                        <a href="#galeria" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium">Galería</a>
                        <a href="#ubicacion" class="nav-link text-white/90 hover:text-white transition-colors duration-300 font-medium">Ubicación</a>
                        
                        @auth
                            <!-- Usuario logueado - Móvil -->
                            <div class="border-t border-white/20 pt-3 mt-3">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold">{{ substr(optional(auth()->user())->name ?? '', 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">{{ optional(auth()->user())->name ?? '' }}</p>
                                        <p class="text-white/70 text-sm">{{ optional(auth()->user())->email ?? '' }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('dashboard') }}" class="block bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 text-center mb-3">
                                    Dashboard
                                </a>
                                <button type="button" onclick="document.getElementById('modal-perfil').classList.remove('hidden')" class="block w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    Perfil
                                </button>
                                @if(empty(optional(auth()->user())->oauth_provider))
                                <button type="button" onclick="document.getElementById('modal-password').classList.remove('hidden')" class="block w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 8V6a4 4 0 118 0v2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4a2 2 0 012-2zm2-2a2 2 0 114 0v2H6V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Contraseña
                                </button>
                                @endif
                                <a href="{{ route('settings.appearance') }}" class="block text-white/90 hover:text-white transition-colors duration-300 font-medium py-2">
                                    Configuración
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                                    @csrf
                                    <button type="submit" class="w-full text-left text-red-400 hover:text-red-300 transition-colors duration-300 font-medium py-2">
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Usuario no logueado - Móvil -->
                            <div class="border-t border-white/20 pt-3 mt-3 space-y-3">
                                <a href="{{ route('login') }}" class="block text-white/90 hover:text-white font-medium transition-colors duration-300">
                                    Iniciar Sesión
                                </a>
                                <a href="{{ route('register') }}" class="block bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 text-center">
                                    Registrarse
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Contenido Principal -->
        <main>
                {{ $slot }}

                {{-- No hay redirección automática a /verify-email --}}

                <!-- Modal de edición de perfil completo -->
                <div id="modal-perfil" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm {{ (auth()->check() && (empty(optional(auth()->user())->address) || empty(optional(auth()->user())->phone) || empty(optional(auth()->user())->province) || empty(optional(auth()->user())->city))) ? '' : 'hidden' }}">
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-full max-w-lg p-8 relative">
                        <button onclick="document.getElementById('modal-perfil').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Editar Perfil</h2>
                        @if(session('success'))
                            <div class="mb-4 text-green-600 dark:text-green-400 font-semibold">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="mb-4">
                                <ul class="text-red-600 dark:text-red-400 text-sm list-disc pl-5">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('perfil.update') }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nombre</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', optional(auth()->user())->name) }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Teléfono</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', optional(auth()->user())->phone) }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Dirección</label>
                                    <input type="text" name="address" id="address" value="{{ old('address', optional(auth()->user())->address) }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="province" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Provincia</label>
                                    <select name="province" id="province" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500" required onchange="updateCities()">
                                        <option value="">Selecciona una provincia</option>
                                        @foreach(array_keys(config('ecuador.provinces')) as $prov)
                                            <option value="{{ $prov }}" @if(old('province', optional(auth()->user())->province) == $prov) selected @endif>{{ $prov }}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Ciudad</label>
                                <select name="city" id="city" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">Selecciona una ciudad</option>
                                    <!-- Las opciones se llenan por JS -->
                                </select>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                                <div class="relative flex items-center">
                                    <input type="email" name="email" id="email" value="{{ optional(auth()->user())->email }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white pr-10" disabled>
                                    @if(optional(auth()->user())->email_verified_at)
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-green-500" title="Correo verificado">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('verification.send') }}" class="absolute right-3 top-1/2 -translate-y-1/2" id="verify-email-form">
                                            @csrf
                                            <button type="submit" class="text-red-500 hover:text-red-700" title="Correo no verificado" onclick="setTimeout(function(){window.location.href='/verify-email';},500)">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">No se puede modificar el email por seguridad.</p>
                                @if(session('resent'))
                                    <div class="text-green-600 dark:text-green-400 text-xs mt-2">Se ha enviado el correo de verificación.</div>
                                @endif
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow">Guardar cambios</button>
                            </div>
                        </form>
                        <script>
                            // Provincias y ciudades desde config
                            const provinces = @json(array_keys(config('ecuador.provinces')));
                            const citiesByProvince = @json(config('ecuador.provinces'));
                            function updateCities() {
                                const province = document.getElementById('province').value;
                                const citySelect = document.getElementById('city');
                                citySelect.innerHTML = '<option value="">Selecciona una ciudad</option>';
                                if (province && citiesByProvince[province]) {
                                    citiesByProvince[province].forEach(function(city) {
                                        const option = document.createElement('option');
                                        option.value = city;
                                        option.textContent = city;
                                            if (city === "{{ old('city', optional(auth()->user())->city) }}") {
                                            option.selected = true;
                                        }
                                        citySelect.appendChild(option);
                                    });
                                }
                            }
                            document.addEventListener('DOMContentLoaded', function() {
                                updateCities();
                            });
                        </script>
                    </div>
                </div>
        </main>

        @fluxScripts
    </body>
</html>