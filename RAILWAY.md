# Guía de Despliegue en Railway 🚀

Esta guía te ayudará a desplegar tu proyecto Laravel en **Railway** paso a paso.

## 1. Preparativos
Asegúrate de que tu proyecto tenga los archivos actualizados en tu repositorio (GitHub).

### Archivos Requeridos
Railway detectará automáticamente que es un proyecto Laravel, pero para asegurar que todo funcione (especialmente Vite), verificaremos el comando de inicio.

## 2. Crear Proyecto en Railway
1.  Ingresa a [Railway.app](https://railway.app/) y loguéate con tu GitHub.
2.  Haz clic en **"New Project"**.
3.  Selecciona **"Deploy from GitHub repo"**.
4.  Busca y selecciona tu repositorio.
5.  Haz clic en **"Deploy Now"**.

> **Nota:** El primer deploy fallará porque faltan las variables de entorno. No te preocupes.

## 3. Configurar Base de Datos (PostgreSQL)
El proyecto requiere PostgreSQL.
1.  En la vista de tu proyecto en Railway, haz clic derecho en el lienzo vacío (o botón "New").
2.  Selecciona **Database** > **Add PostgreSQL**.
3.  Espera a que se cree la base de datos.

## 4. Configurar Variables de Entorno
1.  Haz clic en tu tarjeta de servicio (la de tu código Laravel).
2.  Ve a la pestaña **"Variables"**.
3.  Agrega las siguientes variables una por una (o usa el "Raw Editor" para pegar todo de una vez):

```env
APP_NAME=Quality
APP_ENV=production
APP_DEBUG=false
APP_URL=https://<TU_DOMINIO_DE_RAILWAY>.up.railway.app
APP_KEY=<COPIA_TU_APP_KEY_DEL_ENV_LOCAL_O_GENERA_UNA_NUEVA>

# Base de Datos (Railway provee una variable DATABASE_URL mágica, pero configura esto por si acaso)
DB_CONNECTION=pgsql
# El resto de variables DB_ se llenan solas si usas DATABASE_URL o las vinculas

# Configuración de NIXPACKS (Para decirle a Railway qué versiones usar)
NIXPACKS_PHP_VERSION=8.2
NIXPACKS_NODE_VERSION=20
```

**Vinculación Automática de Base de Datos:**
1.  Ve a la pestaña **Variables** de tu servicio Laravel.
2.  Haz clic en **"Variable Reference"**.
3.  Busca `DATABASE_URL` y selecciónala de tu servicio PostgreSQL.

## 5. Configurar Comandos de Build y Start
Para asegurarnos de que Vite compile los assets y las migraciones corran:

1.  Ve a la pestaña **Settings** de tu servicio Laravel.
2.  Buscá la sección **"Build"**.
3.  **Build Command:**
    ```bash
    npm install && npm run build && composer install --no-dev --optimize-autoloader
    ```
    *(Esto instala dependencias de Node, compila los assets con Vite, e instala dependencias de PHP)*

4.  **Start Command:**
    ```bash
    php artisan migrate --force && php artisan db:seed --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=$PORT
    ```
    *(Nota: `db:seed` correrá en cada deploy. Asegúrate de que tus seeders no dupliquen datos si ya existen)*

## 6. Generar Dominio Público
1.  Ve a la pestaña **Settings**.
2.  En la sección **"Networking"**, haz clic en **"Generate Domain"**.
3.  Copia este dominio (ej: `quality-production.up.railway.app`).
4.  Vuelve a la pestaña **Variables** y actualiza `APP_URL` con este valor (incluyendo `https://`).

## 7. Redeploy
1.  Una vez configurado todo, ve a la pestaña **Deployments**.
2.  Haz clic en **"Redeploy"** (o en los tres puntos del último commit > Redeploy).

¡Listo! Tu aplicación debería estar funcionando.

## Solución de Problemas Comunes
*   **Error 500 / Pantalla Blanca:** Revisa los logs en la pestaña "Deployments" > "View Logs". Puede ser que falte la `APP_KEY` o error de conexión a DB.
*   **Assets (CSS/JS) no cargan:** Asegúrate de que `APP_URL` sea exactamente igual a la URL del navegador (con https). Vite usa esto para cargar los estilos.
*   **Error de Base de Datos:** Verifica que `DB_CONNECTION=pgsql` esté seteado.
