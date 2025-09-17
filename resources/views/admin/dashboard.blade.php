<x-layouts.app :title="__('Panel de Administración')">
    <div class="flex h-full w-ful                        <div>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400 truncate">Usuarios Suspendidos</dt>
                            <dd class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $suspendedUsers }}</dd>
                            <dd class="text-xs text-red-600 dark:text-red-400">Temporalmente suspendidos</dd>
                        </div>x-1 flex-col gap-6 rounded-xl">
        <!-- Header Administrativo Avanzado -->
        <div class="flex items-center justify-between p-6 bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl shadow-lg border border-purple-500">
            <div>
                <h1 class="text-3xl font-bold text-white">Panel de Administración</h1>
                <p class="text-purple-100">Gestión completa del sistema - {{ auth()->user()->name }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3 py-2 bg-white/20 hover:bg-white/30 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Vista Usuario
                </a>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-white text-purple-800">
                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Administrador
                </span>
            </div>
        </div>

        <!-- Estadísticas Completas del Sistema -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-2 lg:grid-cols-4">
            @php
                $totalUsers = \App\Models\User::count();
                $adminUsers = \App\Models\User::where('role', 'admin')->count();
                $clientUsers = \App\Models\User::where('role', 'client')->count();
                $activeUsers = \App\Models\User::where('is_suspended', false)->count();
                $suspendedUsers = \App\Models\User::where('is_suspended', true)->count();
                $unverifiedUsers = \App\Models\User::whereNull('email_verified_at')->count();
                $todayRegistrations = \App\Models\User::whereDate('created_at', today())->count();
                $weekRegistrations = \App\Models\User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
                $recentLogins = \App\Models\User::where('last_login_at', '>=', now()->subDays(7))->count();
            @endphp

            <!-- Total de Usuarios -->
            <div class="relative p-6 bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400 truncate">Total Usuarios</dt>
                            <dd class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $totalUsers }}</dd>
                            <dd class="text-xs text-blue-600 dark:text-blue-400">+{{ $weekRegistrations }} esta semana</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Usuarios Activos -->
            <div class="relative p-6 bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400 truncate">Activos</dt>
                            <dd class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $activeUsers }}</dd>
                            <dd class="text-xs text-green-600 dark:text-green-400">{{ round(($activeUsers/$totalUsers)*100, 1) }}% del total</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Usuarios Problemáticos -->
            <div class="relative p-6 bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400 truncate">Bloqueados/Suspendidos</dt>
                            <dd class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $bannedUsers + $suspendedUsers }}</dd>
                            <dd class="text-xs text-red-600 dark:text-red-400">{{ $bannedUsers }} bloq. | {{ $suspendedUsers }} susp.</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Registros Recientes -->
            <div class="relative p-6 bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400 truncate">Hoy</dt>
                            <dd class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $todayRegistrations }}</dd>
                            <dd class="text-xs text-orange-600 dark:text-orange-400">{{ $recentLogins }} activos 7d</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Control Administrativo -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Gestión de Usuarios Avanzada -->
            <div class="lg:col-span-2">
                <div class="relative p-6 bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm">
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-6">Control de Usuarios</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <a href="{{ route('admin.users') }}" class="group flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-xl border border-blue-200 dark:border-blue-700 hover:shadow-md transition-all">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-lg font-medium text-blue-900 dark:text-blue-100">Gestionar Usuarios</h4>
                                <p class="text-sm text-blue-700 dark:text-blue-200">Ver, filtrar y administrar cuentas</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-300 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>

                        <div class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl border border-purple-200 dark:border-purple-700">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-lg font-medium text-purple-900 dark:text-purple-100">Crear Administrador</h4>
                                <p class="text-sm text-purple-700 dark:text-purple-200">Próximamente - Nuevo admin</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-xl border border-green-200 dark:border-green-700">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-lg font-medium text-green-900 dark:text-green-100">Reportes Avanzados</h4>
                                <p class="text-sm text-green-700 dark:text-green-200">Estadísticas y métricas</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-xl border border-orange-200 dark:border-orange-700">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-lg font-medium text-orange-900 dark:text-orange-100">Configuración Sistema</h4>
                                <p class="text-sm text-orange-700 dark:text-orange-200">Ajustes generales</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Análisis en Tiempo Real -->
            <div>
                <div class="relative p-6 bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Análisis Rápido</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-700 rounded-lg">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Administradores:</span>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $adminUsers }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-700 rounded-lg">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Clientes:</span>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $clientUsers }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-700 rounded-lg">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Sin verificar:</span>
                            <span class="text-sm font-semibold text-yellow-600 dark:text-yellow-400">{{ $unverifiedUsers }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-700 rounded-lg">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Problemáticos:</span>
                            <span class="text-sm font-semibold text-red-600 dark:text-red-400">{{ $suspendedUsers }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de usuarios recientes -->
        <div class="relative bg-white dark:bg-zinc-800 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Usuarios Recientes</h3>
            </div>
            <div class="p-6">
                @php
                    $recentUsers = \App\Models\User::latest()->take(5)->get();
                @endphp
                
                @if($recentUsers->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentUsers as $user)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-zinc-700 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gray-200 dark:bg-zinc-600 rounded-full flex items-center justify-center">
                                            <span class="text-xs font-medium text-zinc-600 dark:text-zinc-300">
                                                {{ $user->initials() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $user->name }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                        {{ $user->role === 'admin' ? 'Admin' : 'Cliente' }}
                                    </span>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $user->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-zinc-500 dark:text-zinc-400 text-center py-4">No hay usuarios registrados</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>