<x-layouts.app :title="__('Panel de Administración')">
    <div class="container mx-auto p-3">
        @php
            $totalUsers = \App\Models\User::count();
            $recentUsers = \App\Models\User::where('id', '!=', auth()->id())
                ->orderByRaw('last_login_at IS NULL, last_login_at DESC')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'users_page');
        @endphp

        <!-- Header -->
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-700 rounded-2xl mb-4 shadow-xl border border-white/10">
            <!-- Patrón de fondo decorativo -->
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-br from-black/10 to-white/5"></div>
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20 blur-sm"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-16 -mb-16 blur-sm"></div>
                <div class="absolute top-1/3 left-1/4 w-20 h-20 bg-white/5 rounded-full blur-sm"></div>
                <!-- Elementos geométricos -->
                <div class="absolute top-6 right-24 w-3 h-3 bg-white/30 rounded-full"></div>
                <div class="absolute bottom-8 right-40 w-2 h-2 bg-white/40 rounded-full"></div>
                <div class="absolute top-12 left-40 w-2.5 h-2.5 bg-white/25 rounded-full"></div>
                <div class="absolute top-20 right-12 w-1.5 h-1.5 bg-white/35 rounded-full"></div>
            </div>
            
            <div class="relative px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-1.5 h-6 bg-gradient-to-b from-blue-300 to-purple-400 rounded-full mr-4 shadow-lg"></div>
                            <div>
                                <h1 class="text-2xl lg:text-3xl font-bold text-white mb-1 tracking-tight drop-shadow-sm">
                                    Panel de Administración
                                </h1>
                                <div class="flex items-center text-blue-100/90 text-sm font-medium">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Gestión completa del sistema
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <a href="{{ route('admin.users') }}" class="group block">
                            <div class="relative">
                                <div class="w-20 h-20 bg-gradient-to-br from-white/25 to-white/5 backdrop-blur-sm rounded-xl border-2 border-white/30 shadow-xl flex flex-col items-center justify-center ring-2 ring-white/20 hover:scale-105 hover:shadow-2xl transition-all duration-300 cursor-pointer">
                                    <svg class="w-6 h-6 text-white drop-shadow-lg mb-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                    </svg>
                                    <span class="text-xs font-bold text-white drop-shadow-sm">{{ $totalUsers }}</span>
                                </div>
                                <!-- Indicador decorativo -->
                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center">
                                    <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                                </div>
                                <!-- Arrow hover effect -->
                                <div class="absolute -bottom-1 -right-1 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
                                    <div class="bg-white rounded-full p-1 shadow-lg border border-gray-200">
                                        <svg class="w-2.5 h-2.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700 p-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-blue-100 via-purple-50 to-indigo-100 dark:from-blue-900/50 dark:via-purple-800/30 dark:to-indigo-900/50 rounded-xl p-2 mr-3 shadow-md border border-blue-200/50 dark:border-blue-700/50">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-0.5">
                                Usuarios y Última Conexión
                            </h3>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Actividad reciente de usuarios en el sistema</p>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-700 rounded-lg px-3 py-1.5 shadow-md border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center">
                            <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse shadow-sm"></div>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $recentUsers->total() }} usuarios</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4">
                @if($recentUsers->count() > 0)
                    <div class="space-y-1.5">
                        @foreach($recentUsers as $user)
                            <div class="group flex items-center justify-between p-3 rounded-lg hover:bg-gradient-to-r hover:from-blue-50/50 hover:via-purple-50/30 hover:to-indigo-50/50 dark:hover:from-blue-900/10 dark:hover:via-purple-900/5 dark:hover:to-indigo-900/10 transition-all duration-300 border border-transparent hover:border-blue-200/50 dark:hover:border-blue-700/30 hover:shadow-sm">
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <div class="w-9 h-9 bg-gradient-to-br from-blue-400 via-purple-500 to-indigo-500 rounded-lg flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-300 border border-white/20">
                                            <span class="text-xs font-bold text-white drop-shadow-sm">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        @if($user->last_login_at && $user->last_login_at->gt(now()->subHours(24)))
                                            <div class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full border border-white dark:border-gray-800 shadow-sm">
                                                <div class="w-full h-full bg-green-400 rounded-full animate-ping opacity-60"></div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center space-x-2 mb-0.5">
                                            <p class="font-semibold text-gray-900 dark:text-white truncate text-sm">{{ $user->name }}</p>
                                            <span class="inline-flex items-center px-1.5 py-0.5 text-xs font-medium rounded-md border {{ $user->role === 'admin' ? 'bg-gradient-to-r from-yellow-50 to-yellow-100 text-yellow-700 border-yellow-200 dark:from-yellow-900/30 dark:to-yellow-800/30 dark:text-yellow-300 dark:border-yellow-700' : 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 border-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 dark:text-blue-300 dark:border-blue-700' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate flex items-center">
                                            <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                            </svg>
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right flex flex-col items-end space-y-1">
                                    <div class="text-right">
                                        @if($user->last_login_at)
                                            <p class="text-xs font-semibold text-gray-900 dark:text-white">
                                                {{ $user->last_login_at->format('d/m/Y H:i') }}
                                            </p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                                {{ $user->last_login_at->diffForHumans() }}
                                            </p>
                                        @else
                                            <p class="text-xs text-gray-400 dark:text-gray-500 font-medium">Nunca conectado</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-1">
                                        @if($user->is_suspended)
                                            <span class="inline-flex items-center px-1.5 py-0.5 text-xs font-medium bg-gradient-to-r from-red-100 to-red-50 text-red-700 dark:from-red-900/30 dark:to-red-800/30 dark:text-red-300 rounded border border-red-200 dark:border-red-700">
                                                <svg class="w-2.5 h-2.5 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Suspendido
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-1.5 py-0.5 text-xs font-medium bg-gradient-to-r from-green-100 to-green-50 text-green-700 dark:from-green-900/30 dark:to-green-800/30 dark:text-green-300 rounded border border-green-200 dark:border-green-700">
                                                <svg class="w-2.5 h-2.5 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Activo
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="relative mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 rounded-xl mx-auto flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-semibold">No hay usuarios registrados</p>
                        <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">Los usuarios aparecerán aquí cuando se registren</p>
                    </div>
                @endif
            </div>

            <!-- Paginación -->
            @if($recentUsers->hasPages())
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-900 dark:to-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-gray-600 dark:text-gray-400">
                            <span class="font-medium">{{ $recentUsers->firstItem() }} - {{ $recentUsers->lastItem() }}</span>
                            <span class="text-gray-500 dark:text-gray-500 ml-1">de {{ $recentUsers->total() }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            {{-- Botón Anterior --}}
                            @if($recentUsers->onFirstPage())
                                <span class="px-2 py-1.5 text-xs text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-700 rounded cursor-not-allowed border border-gray-200 dark:border-gray-600 flex items-center">
                                    <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Ant
                                </span>
                            @else
                                <a href="{{ $recentUsers->previousPageUrl() }}" class="px-2 py-1.5 text-xs text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded hover:bg-blue-50 dark:hover:bg-gray-600 transition-all duration-200 flex items-center font-medium">
                                    <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Ant
                                </a>
                            @endif

                            {{-- Números de página --}}
                            @foreach($recentUsers->getUrlRange(max(1, $recentUsers->currentPage() - 1), min($recentUsers->lastPage(), $recentUsers->currentPage() + 1)) as $page => $url)
                                @if($page == $recentUsers->currentPage())
                                    <span class="px-2.5 py-1.5 text-xs text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded shadow-md font-semibold min-w-[1.5rem] text-center">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="px-2.5 py-1.5 text-xs text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded hover:bg-blue-50 dark:hover:bg-gray-600 transition-all duration-200 font-medium min-w-[1.5rem] text-center">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Botón Siguiente --}}
                            @if($recentUsers->hasMorePages())
                                <a href="{{ $recentUsers->nextPageUrl() }}" class="px-2 py-1.5 text-xs text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded hover:bg-blue-50 dark:hover:bg-gray-600 transition-all duration-200 flex items-center font-medium">
                                    Sig
                                    <svg class="w-2.5 h-2.5 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="px-2 py-1.5 text-xs text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-700 rounded cursor-not-allowed border border-gray-200 dark:border-gray-600 flex items-center">
                                    Sig
                                    <svg class="w-2.5 h-2.5 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>