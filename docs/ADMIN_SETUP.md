# Configuración de Administradores

Este documento explica las diferentes formas de crear y gestionar usuarios administradores en el sistema.

## 🔐 Estrategias de Creación de Administradores

### 1. **Comando Artisan (Recomendado para Producción)**

```bash
# Crear admin interactivamente
php artisan admin:create

# Crear admin con parámetros
php artisan admin:create --email=admin@company.com --name="Admin Name" --password=secure123

# Forzar creación aunque ya exista un admin
php artisan admin:create --force
```

**Ventajas:**
- ✅ Seguro para producción
- ✅ Validación de datos
- ✅ Verificación de admin existente
- ✅ Interfaz interactiva
- ✅ Selección de provincia/ciudad válida

### 2. **Seeder con Variables de Entorno**

```bash
# Configurar en .env
ADMIN_EMAIL="admin@quality.com"
ADMIN_PASSWORD="secure-password"

# Ejecutar seeder
php artisan db:seed --class=AdminUserSeeder
```

**Ventajas:**
- ✅ Automático en deploy
- ✅ Configurable por entorno
- ✅ Integrable en CI/CD

### 3. **Sistema de Emergencia (Solo Producción)**

Si no existe ningún admin en producción, el sistema automáticamente buscará estas variables:

```env
EMERGENCY_ADMIN_EMAIL="emergency@company.com"
EMERGENCY_ADMIN_PASSWORD="very-secure-password"
```

**Características:**
- ⚠️ Solo se activa en producción
- ⚠️ Solo si NO existe ningún admin
- ⚠️ Se registra en logs

## 🚀 Configuración Recomendada para Producción

### 1. Variables de Entorno (.env)

```env
# Admin principal (para seeders)
ADMIN_NAME="System Administrator"
ADMIN_EMAIL="admin@yourcompany.com"
ADMIN_PASSWORD="very-secure-password-here"
ADMIN_PHONE="+593987654321"
ADMIN_ADDRESS="Company Address"
ADMIN_PROVINCE="Guayas"
ADMIN_CITY="Guayaquil"

# Admin de emergencia (safety net)
EMERGENCY_ADMIN_EMAIL="emergency@yourcompany.com"
EMERGENCY_ADMIN_PASSWORD="different-very-secure-password"
```

### 2. Proceso de Deploy

```bash
# 1. Ejecutar migraciones
php artisan migrate --force

# 2. Crear admin (si no existe)
php artisan admin:create --email=$ADMIN_EMAIL --name="$ADMIN_NAME" --password=$ADMIN_PASSWORD

# 3. O usar seeder
php artisan db:seed --class=AdminUserSeeder --force
```

## 🛡️ Seguridad

### ✅ Buenas Prácticas

- Usar contraseñas seguras (mínimo 8 caracteres)
- Cambiar credenciales por defecto
- No commitear credenciales reales al repositorio
- Usar diferentes credenciales por entorno
- Monitorear logs de creación de admins

### ❌ Evitar

- Credenciales hardcodeadas en código
- Contraseñas simples
- Mismo password en dev/prod
- Usuarios admin innecesarios

## 📋 Comandos Útiles

```bash
# Ver todos los usuarios y sus roles
php artisan users:show

# Verificar si existe admin
php artisan tinker --execute="App\Models\User::where('role', 'admin')->count()"

# Crear admin de prueba en desarrollo
php artisan admin:create --email=test@admin.com --name="Test Admin" --password=test123
```

## 🔧 Troubleshooting

### Error: "Admin user already exists"
```bash
# Usar --force para crear otro admin
php artisan admin:create --force
```

### Error de validación de provincia/ciudad
- Verificar que la provincia esté en `config/ecuador.php`
- Verificar que la ciudad pertenezca a esa provincia

### No hay admin en producción
- Verificar logs: `/storage/logs/laravel.log`
- Configurar variables `EMERGENCY_ADMIN_*`
- Ejecutar `php artisan admin:create` manualmente