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
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Búsqueda -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Buscar usuarios
                    </label>
                    <div class="mt-1">
                        <input 
                            type="text" 
                            wire:model.live="search"
                            id="search"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md"
                            placeholder="Nombre o email..."
                        >
                    </div>
                </div>

                <!-- Filtro por rol -->
                <div>
                    <label for="roleFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Filtrar por rol
                    </label>
                    <div class="mt-1">
                        <select 
                            wire:model.live="roleFilter"
                            id="roleFilter"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md"
                        >
                            <option value="all">Todos los roles</option>
                            <option value="admin">Administradores</option>
                            <option value="client">Clientes</option>
                        </select>
                    </div>
                </div>

                <!-- Filtro por estado -->
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Filtrar por estado
                    </label>
                    <div class="mt-1">
                        <select 
                            wire:model.live="statusFilter"
                            id="statusFilter"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md"
                        >
                            <option value="all">Todos los estados</option>
                            <option value="active">Activos</option>
                            <option value="suspended">Suspendidos</option>
                            <option value="unverified">Sin verificar</option>
                        </select>
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
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
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
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
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
</div>