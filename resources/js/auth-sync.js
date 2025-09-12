/**
 * Sistema de sincronización de autenticación entre pestañas
 * Versión simplificada que funciona con Laravel session
 */

class AuthSync {
    constructor() {
        this.storageKey = 'quality_auth_sync';
        this.isInitialized = false;
        this.init();
    }

    init() {
        if (this.isInitialized) {
            return;
        }
        
        this.isInitialized = true;
        console.log('AuthSync inicializado');

        // Escuchar cambios en localStorage (entre pestañas)
        window.addEventListener('storage', (e) => {
            if (e.key === this.storageKey) {
                this.handleStorageChange(e);
            }
        });

        // Marcar esta pestaña como activa
        this.markTabActive();
        
        // Verificar estado cada minuto (menos agresivo)
        setInterval(() => {
            this.checkAuthStatus();
        }, 60000);
    }

    markTabActive() {
        const tabData = {
            timestamp: Date.now(),
            url: window.location.href,
            tabId: this.generateTabId()
        };
        
        localStorage.setItem(this.storageKey, JSON.stringify(tabData));
    }

    generateTabId() {
        return 'tab_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    checkAuthStatus() {
        // Solo verificar en rutas protegidas
        const protectedRoutes = ['/dashboard', '/settings'];
        const currentPath = window.location.pathname;
        
        if (!protectedRoutes.some(route => currentPath.startsWith(route))) {
            return;
        }

        // Verificar si el usuario está autenticado usando Laravel session
        // En lugar de hacer una petición AJAX, verificamos si hay una meta tag o variable global
        const authUser = document.querySelector('meta[name="auth-user"]');
        
        if (!authUser || !authUser.content) {
            // Usuario no autenticado
            this.handleLogout();
        }
    }

    handleStorageChange(e) {
        const newValue = e.newValue ? JSON.parse(e.newValue) : null;
        
        if (newValue && newValue.action === 'logout') {
            this.handleLogout();
        }
    }

    handleLogout() {
        // Notificar a otras pestañas
        const logoutData = {
            action: 'logout',
            timestamp: Date.now()
        };
        
        localStorage.setItem(this.storageKey, JSON.stringify(logoutData));
        
        // Redirigir solo si no estamos ya en login
        if (!window.location.pathname.includes('/login')) {
            window.location.href = '/login';
        }
    }

    // Método para ser llamado cuando el usuario hace logout
    notifyLogout() {
        this.handleLogout();
    }
}

// Inicializar solo una vez y cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    if (!window.authSync) {
        window.authSync = new AuthSync();
    }
});

// También inicializar si el script se carga después de DOMContentLoaded
if (document.readyState === 'loading') {
    // El DOM aún no está listo, esperar al evento DOMContentLoaded
} else {
    // El DOM ya está listo
    if (!window.authSync) {
        window.authSync = new AuthSync();
    }
}