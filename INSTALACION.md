# 📋 Guía de Instalación - GenfiSoft

## 🔧 Requisitos del Sistema

### Requisitos Mínimos
- **PHP**: 8.1 o superior
- **Composer**: 2.0 o superior
- **Node.js**: 16.0 o superior
- **NPM**: 8.0 o superior
- **MySQL**: 8.0 o superior (o MariaDB 10.4+)
- **Apache/Nginx**: Servidor web

### Extensiones PHP Requeridas
```bash
php-mbstring
php-xml
php-curl
php-zip
php-gd
php-mysql
php-bcmath
php-tokenizer
php-json
php-openssl
```

## 🚀 Instalación Paso a Paso

### 1. Clonar el Repositorio
```bash
git clone [URL_DEL_REPOSITORIO] genfisoft
cd genfisoft
```

### 2. Instalar Dependencias de PHP
```bash
composer install
```

### 3. Instalar Dependencias de Node.js
```bash
npm install
```

### 4. Configuración del Entorno

#### 4.1 Copiar archivo de configuración
```bash
cp .env.example .env
```

#### 4.2 Configurar variables de entorno en `.env`
```env
APP_NAME="GenfiSoft"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost/genfisoft

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=genfisoft
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### 5. Generar Clave de Aplicación
```bash
php artisan key:generate
```

### 6. Configurar Base de Datos

#### 6.1 Crear base de datos
```sql
CREATE DATABASE genfisoft CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### 6.2 Ejecutar migraciones
```bash
php artisan migrate
```

#### 6.3 Ejecutar seeders (datos iniciales)
```bash
php artisan db:seed
```

### 7. Configurar Permisos (Linux/Mac)
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 8. Compilar Assets
```bash
# Para desarrollo
npm run dev

# Para producción
npm run build
```

### 9. Configurar Servidor Web

#### Apache (.htaccess ya incluido)
Asegúrate de que el DocumentRoot apunte a la carpeta `public/`

#### Nginx
```nginx
server {
    listen 80;
    server_name genfisoft.local;
    root /path/to/genfisoft/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 10. Configurar Cron Jobs (Opcional)
```bash
# Agregar al crontab
* * * * * cd /path/to/genfisoft && php artisan schedule:run >> /dev/null 2>&1
```

### 11. Configurar Queue Workers (Opcional)
```bash
# Instalar supervisor
sudo apt install supervisor

# Crear configuración
sudo nano /etc/supervisor/conf.d/genfisoft-worker.conf
```

Contenido del archivo:
```ini
[program:genfisoft-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/genfisoft/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/genfisoft/storage/logs/worker.log
stopwaitsecs=3600
```

### 12. Verificar Instalación

#### 12.1 Verificar configuración
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 12.2 Acceder a la aplicación
- URL: `http://localhost/genfisoft` (o tu dominio configurado)
- Usuario admin por defecto: `admin@genfisoft.com`
- Contraseña por defecto: `password`

## 🔍 Solución de Problemas Comunes

### Error de permisos
```bash
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Error de clave de aplicación
```bash
php artisan key:generate
php artisan config:clear
```

### Error de base de datos
1. Verificar credenciales en `.env`
2. Verificar que la base de datos existe
3. Ejecutar: `php artisan migrate:fresh --seed`

### Error de composer
```bash
composer install --no-dev --optimize-autoloader
```

### Error de npm
```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```

## 📚 Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev

# Verificar estado
php artisan about
php artisan route:list
php artisan migrate:status
```

## 🆘 Soporte

Si encuentras problemas durante la instalación:

1. Verifica que cumples todos los requisitos
2. Revisa los logs en `storage/logs/laravel.log`
3. Verifica la configuración del servidor web
4. Consulta la documentación de Laravel 10.x

---

**Nota**: Esta guía asume un entorno de desarrollo local. Para producción, consulta `DESPLIEGUE.md`.
