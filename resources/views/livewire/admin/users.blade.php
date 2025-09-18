<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Gestión de Usuarios</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">Administra las cuentas de usuario del sistema</p>
        </div>
    </div>

    <!-- Mensaje de éxito -->
    @if (session()->has('message'))
        <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                        {{ session('message') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-900 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4 rounded-t-xl">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filtros de Búsqueda</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Encuentra usuarios específicos usando los filtros</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Búsqueda -->
                <div>
                    <label for="search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                        Buscar usuarios
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live="search"
                            id="search"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            placeholder="Buscar por nombre o email..."
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filtro por rol -->
                <div>
                    <label for="roleFilter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                        </svg>
                        Filtrar por rol
                    </label>
                    <div class="relative">
                        <select 
                            wire:model.live="roleFilter"
                            id="roleFilter"
                            class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none"
                        >
                            <option value="all">🔹 Todos los roles</option>
                            <option value="admin">👑 Administradores</option>
                            <option value="client">👤 Clientes</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Filtro por estado -->
                <div>
                    <label for="statusFilter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Filtrar por estado
                    </label>
                    <div class="relative">
                        <select 
                            wire:model.live="statusFilter"
                            id="statusFilter"
                            class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 appearance-none"
                        >
                            <option value="all">📊 Todos los estados</option>
                            <option value="active">✅ Activos</option>
                            <option value="suspended">🚫 Suspendidos</option>
                            <option value="unverified">⚠️ Sin verificar</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Usuario
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Rol
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Verificación
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Fecha de registro
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors duration-200" 
                            wire:click="openUserDetailsModal({{ $user->id }})"
                            title="Click para ver detalles del usuario">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium text-sm">
                                            {{ $user->initials() }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                    {{ $user->isAdmin() ? 'Administrador' : 'Cliente' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @php
                                        $color = $user->getAccountStatusColor();
                                        $colorClasses = [
                                            'red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                            'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                            'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
                                        ];
                                        echo $colorClasses[$color] ?? 'bg-gray-100 text-gray-800';
                                    @endphp">
                                    {{ $user->getAccountStatus() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($user->email_verified_at)
                                    <span class="text-green-600 dark:text-green-400">✓ Verificado</span>
                                @else
                                    <span class="text-yellow-600 dark:text-yellow-400">⚠ Pendiente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" onclick="event.stopPropagation()">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- Solo un botón: Suspender o Reactivar -->
                                    @if($user->isSuspended())
                                        <button 
                                            wire:click="openUserModal({{ $user->id }}, 'unsuspend')"
                                            class="bg-green-100 text-green-800 hover:bg-green-200 px-3 py-1 rounded text-sm font-medium"
                                            title="Reactivar usuario"
                                        >
                                            Reactivar
                                        </button>
                                    @else
                                        <button 
                                            wire:click="openUserModal({{ $user->id }}, 'suspend')"
                                            class="bg-red-100 text-red-800 hover:bg-red-200 px-3 py-1 rounded text-sm font-medium"
                                            title="Suspender usuario"
                                        >
                                            Suspender
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                No se encontraron usuarios que coincidan con los filtros seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="bg-white dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal para acciones de usuario - VERSION SIMPLE -->
    @if ($showUserModal && $selectedUser)
        <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">
                    @if($actionType === 'suspend')
                        Suspender Usuario
                    @else
                        Reactivar Usuario
                    @endif
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    ¿Confirmas que quieres 
                    @if($actionType === 'suspend')
                        suspender temporalmente
                    @else
                        reactivar
                    @endif
                    al usuario <strong>{{ $selectedUser->name }}</strong>?
                </p>

                @if($actionType === 'suspend')
                    <div class="mb-4">
                        <label for="suspensionDays" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Duración de la suspensión
                        </label>
                        <select wire:model="suspensionDays" id="suspensionDays" 
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md">
                            <option value="1">1 día</option>
                            <option value="3">3 días</option>
                            <option value="7">1 semana</option>
                            <option value="14">2 semanas</option>
                            <option value="30">1 mes</option>
                            <option value="90">3 meses</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="actionReason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Razón de la suspensión (opcional)
                        </label>
                        <textarea wire:model="actionReason" 
                                id="actionReason" 
                                rows="3" 
                                class="w-full p-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md"
                                placeholder="Describe la razón de la suspensión..."></textarea>
                    </div>
                @endif

                <div class="flex space-x-4">
                    <button 
                        wire:click="executeAction"
                        class="flex-1 {{ $actionType === 'suspend' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded font-medium"
                    >
                        Confirmar
                    </button>
                    <button 
                        wire:click="closeUserModal"
                        class="flex-1 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 font-medium"
                    >
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Detalles Completos del Usuario -->
    @if ($showUserDetailsModal && $userDetails)
        <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-6" wire:click="closeUserDetailsModal">
            <div class="bg-white dark:bg-gray-800 rounded-3xl max-w-4xl w-full max-h-[85vh] overflow-hidden shadow-2xl border border-gray-200 dark:border-gray-700 mx-auto" wire:click.stop>
                <!-- Header del Modal -->
                <div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-700 p-6 overflow-hidden">
                    <!-- Patrón de fondo decorativo -->
                    <div class="absolute inset-0">
                        <div class="absolute inset-0 bg-gradient-to-br from-black/10 to-white/5"></div>
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-sm"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12 blur-sm"></div>
                        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white/5 rounded-full blur-sm"></div>
                        <!-- Elementos geométricos -->
                        <div class="absolute top-4 right-20 w-2 h-2 bg-white/30 rounded-full"></div>
                        <div class="absolute bottom-6 right-32 w-1 h-1 bg-white/40 rounded-full"></div>
                        <div class="absolute top-8 left-32 w-1.5 h-1.5 bg-white/25 rounded-full"></div>
                    </div>
                    
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center space-x-5">
                            <div class="relative">
                                <!-- Avatar con mejor diseño -->
                                <div class="w-18 h-18 bg-gradient-to-br from-white/25 to-white/5 backdrop-blur-sm rounded-2xl border-2 border-white/30 shadow-xl flex items-center justify-center ring-4 ring-white/20">
                                    <span class="text-2xl font-bold text-white drop-shadow-lg">
                                        {{ $userDetails->initials() }}
                                    </span>
                                </div>
                                <!-- Indicador de estado mejorado -->
                                @if(!$userDetails->isSuspended())
                                    <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-400 rounded-full border-3 border-white shadow-lg flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                @else
                                    <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-red-500 rounded-full border-3 border-white shadow-lg flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-1 drop-shadow-sm">{{ $userDetails->name }}</h2>
                                <p class="text-blue-100 text-base font-medium">{{ $userDetails->email }}</p>
                                <div class="flex items-center mt-3 space-x-2">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold 
                                        {{ $userDetails->isAdmin() ? 'bg-yellow-400/20 text-yellow-100 border border-yellow-300/30 backdrop-blur-sm' : 'bg-blue-400/20 text-blue-100 border border-blue-300/30 backdrop-blur-sm' }}">
                                        <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            @if($userDetails->isAdmin())
                                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                            @else
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            @endif
                                        </svg>
                                        {{ $userDetails->isAdmin() ? 'Administrador' : 'Cliente' }}
                                    </span>
                                    <!-- Estado adicional -->
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold 
                                        @php
                                            $color = $userDetails->getAccountStatusColor();
                                            $statusClasses = [
                                                'red' => 'bg-red-400/20 text-red-100 border border-red-300/30',
                                                'orange' => 'bg-orange-400/20 text-orange-100 border border-orange-300/30',
                                                'yellow' => 'bg-yellow-400/20 text-yellow-100 border border-yellow-300/30',
                                                'green' => 'bg-green-400/20 text-green-100 border border-green-300/30',
                                                'gray' => 'bg-gray-400/20 text-gray-100 border border-gray-300/30',
                                            ];
                                            echo $statusClasses[$color] ?? 'bg-gray-400/20 text-gray-100 border border-gray-300/30';
                                        @endphp backdrop-blur-sm">
                                        {{ $userDetails->getAccountStatus() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button wire:click="closeUserDetailsModal" 
                                class="flex-shrink-0 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-xl flex items-center justify-center transition-all duration-200 group backdrop-blur-sm border border-white/20 hover:border-white/40">
                            <svg class="w-5 h-5 text-white group-hover:scale-110 transition-transform drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Contenido del Modal -->
                <div class="overflow-y-auto max-h-[calc(85vh-140px)]">
                    <div class="p-6 space-y-6">
                        <!-- Grid de información principal -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Información Personal -->
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center mb-5">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white ml-3">Información Personal</h3>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-600">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">ID de usuario:</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">#{{ $userDetails->id }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-600">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre completo:</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $userDetails->name }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Email:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $userDetails->email }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado de la Cuenta -->
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center mb-5">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white ml-3">Estado de Cuenta</h3>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-600">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado:</span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                            @php
                                                $color = $userDetails->getAccountStatusColor();
                                                $colorClasses = [
                                                    'red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                    'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                                                    'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                    'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                    'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
                                                ];
                                                echo $colorClasses[$color] ?? 'bg-gray-100 text-gray-800';
                                            @endphp">
                                            {{ $userDetails->getAccountStatus() }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Email verificado:</span>
                                        @if($userDetails->email_verified_at)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Verificado
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                Pendiente
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Suspensión activa (si aplica) -->
                        @if($userDetails->isSuspended())
                            <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-xl p-5 border border-red-200 dark:border-red-800">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-red-800 dark:text-red-200 ml-3">Suspensión Activa</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-sm font-medium text-red-600 dark:text-red-400">Suspendido hasta:</span>
                                        <p class="text-red-800 dark:text-red-200 font-semibold">
                                            {{ $userDetails->suspended_until?->format('d/m/Y H:i') ?: 'Indefinidamente' }}
                                        </p>
                                    </div>
                                    @if($userDetails->suspension_reason)
                                        <div>
                                            <span class="text-sm font-medium text-red-600 dark:text-red-400">Razón:</span>
                                            <p class="text-red-800 dark:text-red-200 font-medium">{{ $userDetails->suspension_reason }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Fechas y Actividad -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-5 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center mb-5">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white ml-3">Actividad y Fechas</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center">
                                    <div class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $userDetails->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">Fecha de registro</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $userDetails->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $userDetails->updated_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">Última actualización</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $userDetails->updated_at->diffForHumans() }}</div>
                                </div>
                                <div class="text-center">
                                    @if($userDetails->last_login_at)
                                        <div class="text-xl font-bold text-green-600 dark:text-green-400">{{ $userDetails->last_login_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400">Último login</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $userDetails->last_login_at->diffForHumans() }}</div>
                                    @else
                                        <div class="text-xl font-bold text-gray-400 dark:text-gray-500">---</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400">Último login</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">Nunca</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto (si existe) -->
                        @if($userDetails->phone || $userDetails->address || $userDetails->province || $userDetails->city || $userDetails->oauth_provider)
                            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 rounded-xl p-5 border border-indigo-200 dark:border-indigo-800">
                                <div class="flex items-center mb-5">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white ml-3">Información de Contacto</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if($userDetails->phone)
                                        <div class="flex justify-between items-center py-2 border-b border-indigo-200 dark:border-indigo-700">
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Teléfono:</span>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $userDetails->phone }}</span>
                                        </div>
                                    @endif
                                    @if($userDetails->address)
                                        <div class="flex justify-between items-center py-2 border-b border-indigo-200 dark:border-indigo-700">
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Dirección:</span>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $userDetails->address }}</span>
                                        </div>
                                    @endif
                                    @if($userDetails->city)
                                        <div class="flex justify-between items-center py-2 border-b border-indigo-200 dark:border-indigo-700">
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Ciudad:</span>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $userDetails->city }}</span>
                                        </div>
                                    @endif
                                    @if($userDetails->province)
                                        <div class="flex justify-between items-center py-2 border-b border-indigo-200 dark:border-indigo-700">
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Provincia:</span>
                                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $userDetails->province }}</span>
                                        </div>
                                    @endif
                                    @if($userDetails->oauth_provider)
                                        <div class="flex justify-between items-center py-2">
                                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Proveedor OAuth:</span>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ ucfirst($userDetails->oauth_provider) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer del Modal -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-medium">Registrado:</span> {{ $userDetails->created_at->diffForHumans() }}
                            </div>
                            @if($userDetails->email_verified_at)
                                <div class="text-sm text-green-600 dark:text-green-400">
                                    <span class="font-medium">Verificado:</span> {{ $userDetails->email_verified_at->format('d/m/Y') }}
                                </div>
                            @endif
                        </div>
                        <button wire:click="closeUserDetailsModal" 
                                class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-xl hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>