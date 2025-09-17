# Database Migrations

Este directorio contiene las migraciones de la base de datos para el sistema de gestión de usuarios.

## Migraciones Base (Laravel)
- `0001_01_01_000000_create_users_table.php` - Tabla de usuarios base
- `0001_01_01_000001_create_cache_table.php` - Tabla de caché
- `0001_01_01_000002_create_jobs_table.php` - Tabla de trabajos en cola

## Migraciones del Proyecto

### Campos de Perfil
- `2025_09_16_035030_add_profile_fields_to_users_table.php`
  - Agrega: `phone`, `address`, `province`, `city`
  - Campos adicionales para información de contacto del usuario

### Autenticación OAuth
- `2025_09_16_151645_add_oauth_provider_to_users_table.php`
  - Agrega: `oauth_provider`, `oauth_id`
  - Soporte para autenticación con proveedores externos

### Sistema de Roles
- `2025_09_17_163203_add_role_to_users_table.php`
  - Agrega: `role` (enum: 'admin', 'client')
  - Sistema básico de roles para diferenciación de usuarios

### Estado de Cuenta
- `2025_09_17_181847_add_account_status_fields_to_users_table.php`
  - Agrega: `is_suspended`, `suspended_until`, `suspension_reason`, `last_login_at`
  - Sistema simplificado de suspensión de cuentas (solo activo/suspendido)

## Historial de Cambios

### Simplificación del Sistema de Estados
El sistema originalmente incluía múltiples estados (banned, active, suspended), pero se simplificó a solo dos estados:
- **Activo**: Usuario puede acceder normalmente
- **Suspendido**: Usuario no puede acceder, con fecha opcional de reactivación

### Migraciones Eliminadas
Se eliminaron migraciones que se cancelaban entre sí:
- Session ID: Se agregó y eliminó en la misma sesión de desarrollo
- Estados complejos: Se simplificó de 4 estados a 2 estados

## Estructura Final de la Tabla Users

```php
Schema::create('users', function (Blueprint $table) {
    // Campos base de Laravel
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
    
    // Campos de perfil
    $table->string('phone')->nullable();
    $table->text('address')->nullable();
    $table->string('province')->nullable();
    $table->string('city')->nullable();
    
    // OAuth
    $table->string('oauth_provider')->nullable();
    $table->string('oauth_id')->nullable();
    
    // Sistema de roles
    $table->enum('role', ['admin', 'client'])->default('client');
    
    // Estado de cuenta
    $table->boolean('is_suspended')->default(false);
    $table->timestamp('suspended_until')->nullable();
    $table->string('suspension_reason')->nullable();
    $table->timestamp('last_login_at')->nullable();
});
```