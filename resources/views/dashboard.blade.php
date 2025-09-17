<x-layouts.app :title="'Dashboard'">
    <div class="container mx-auto p-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold mb-4">
                Bienvenido, {{ auth()->user()->name }}!
            </h1>
            
            @if(auth()->user()->isAdmin())
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <a href="{{ route('admin.dashboard') }}" class="bg-purple-100 hover:bg-purple-200 p-4 rounded-lg">
                        <h3 class="font-semibold text-purple-900">Panel de Administración</h3>
                        <p class="text-purple-700">Gestión completa del sistema</p>
                    </a>
                    
                    <a href="{{ route('admin.users') }}" class="bg-blue-100 hover:bg-blue-200 p-4 rounded-lg">
                        <h3 class="font-semibold text-blue-900">Gestión de Usuarios</h3>
                        <p class="text-blue-700">Administrar cuentas</p>
                    </a>
                </div>
            @endif
            
            <div class="grid gap-4 md:grid-cols-2 mt-6">
                <a href="{{ route('settings.profile') }}" class="bg-green-100 hover:bg-green-200 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-900">Mi Perfil</h3>
                    <p class="text-green-700">Configurar información</p>
                </a>
                
                <a href="{{ route('settings.password') }}" class="bg-orange-100 hover:bg-orange-200 p-4 rounded-lg">
                    <h3 class="font-semibold text-orange-900">Seguridad</h3>
                    <p class="text-orange-700">Cambiar contraseña</p>
                </a>
            </div>
            
            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h3 class="font-semibold mb-2">Mi Información</h3>
                <p>Estado: Activo</p>
                <p>Miembro desde: {{ auth()->user()->created_at->format('d/m/Y') }}</p>
                <p>Email: 
                    @if(auth()->user()->email_verified_at)
                        Verificado ✅
                    @else
                        Pendiente ⚠️
                    @endif
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>