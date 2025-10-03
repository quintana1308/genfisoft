# 🚀 Guía de Despliegue en Producción - GenfiSoft

## 🎯 Opciones de Despliegue

### 1. Servidor VPS/Dedicado (Recomendado)
### 2. Hosting Compartido
### 3. Servicios en la Nube (AWS, DigitalOcean, etc.)

---

## 🔧 Opción 1: Servidor VPS/Dedicado

### Requisitos del Servidor
- **OS**: Ubuntu 20.04+ / CentOS 8+ / Debian 11+
- **RAM**: Mínimo 2GB (Recomendado 4GB+)
- **Almacenamiento**: Mínimo 20GB SSD
- **CPU**: 2 cores mínimo
- **Ancho de banda**: Ilimitado o mínimo 100GB/mes

### 1. Preparación del Servidor

#### 1.1 Actualizar sistema
```bash
sudo apt update && sudo apt upgrade -y
```

#### 1.2 Instalar dependencias básicas
```bash
sudo apt install -y curl wget git unzip software-properties-common apt-transport-https ca-certificates gnupg lsb-release
```

### 2. Instalar Stack LAMP

#### 2.1 Instalar Apache
```bash
sudo apt install apache2 -y
sudo systemctl enable apache2
sudo systemctl start apache2
```

#### 2.2 Instalar MySQL
```bash
sudo apt install mysql-server -y
sudo systemctl enable mysql
sudo systemctl start mysql

# Configurar seguridad
sudo mysql_secure_installation
```

#### 2.3 Instalar PHP 8.1+
```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.1 php8.1-fpm php8.1-mysql php8.1-xml php8.1-curl php8.1-zip php8.1-gd php8.1-mbstring php8.1-bcmath php8.1-tokenizer php8.1-json php8.1-intl -y
```

#### 2.4 Instalar Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

#### 2.5 Instalar Node.js y NPM
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs -y
```

### 3. Configurar Base de Datos

#### 3.1 Crear base de datos y usuario
```sql
sudo mysql -u root -p

CREATE DATABASE genfisoft_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'genfisoft_user'@'localhost' IDENTIFIED BY 'PASSWORD_SEGURO_AQUI';
GRANT ALL PRIVILEGES ON genfisoft_prod.* TO 'genfisoft_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. Desplegar Aplicación

#### 4.1 Clonar repositorio
```bash
cd /var/www
sudo git clone [URL_DEL_REPOSITORIO] genfisoft
sudo chown -R www-data:www-data genfisoft
cd genfisoft
```

#### 4.2 Instalar dependencias
```bash
sudo -u www-data composer install --no-dev --optimize-autoloader
sudo -u www-data npm install --production
```

#### 4.3 Configurar entorno
```bash
sudo -u www-data cp .env.example .env
sudo -u www-data nano .env
```

Configuración de producción en `.env`:
```env
APP_NAME="GenfiSoft"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://tudominio.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=genfisoft_prod
DB_USERNAME=genfisoft_user
DB_PASSWORD=PASSWORD_SEGURO_AQUI

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=tu-servidor-smtp.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@dominio.com
MAIL_PASSWORD=tu-password-email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@tudominio.com"
MAIL_FROM_NAME="GenfiSoft"
```

#### 4.4 Configurar aplicación
```bash
sudo -u www-data php artisan key:generate
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan db:seed --force
sudo -u www-data npm run build
```

#### 4.5 Optimizar para producción
```bash
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan event:cache
```

### 5. Configurar Apache

#### 5.1 Crear VirtualHost
```bash
sudo nano /etc/apache2/sites-available/genfisoft.conf
```

Contenido del archivo:
```apache
<VirtualHost *:80>
    ServerName tudominio.com
    ServerAlias www.tudominio.com
    DocumentRoot /var/www/genfisoft/public
    
    <Directory /var/www/genfisoft/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/genfisoft_error.log
    CustomLog ${APACHE_LOG_DIR}/genfisoft_access.log combined
</VirtualHost>
```

#### 5.2 Habilitar sitio y módulos
```bash
sudo a2ensite genfisoft.conf
sudo a2enmod rewrite
sudo a2dissite 000-default.conf
sudo systemctl reload apache2
```

### 6. Configurar SSL con Let's Encrypt

#### 6.1 Instalar Certbot
```bash
sudo apt install certbot python3-certbot-apache -y
```

#### 6.2 Obtener certificado SSL
```bash
sudo certbot --apache -d tudominio.com -d www.tudominio.com
```

### 7. Configurar Firewall

```bash
sudo ufw enable
sudo ufw allow ssh
sudo ufw allow 'Apache Full'
sudo ufw status
```

### 8. Configurar Backup Automático

#### 8.1 Script de backup
```bash
sudo nano /usr/local/bin/genfisoft-backup.sh
```

Contenido del script:
```bash
#!/bin/bash

# Variables
APP_PATH="/var/www/genfisoft"
BACKUP_PATH="/var/backups/genfisoft"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="genfisoft_prod"
DB_USER="genfisoft_user"
DB_PASS="PASSWORD_SEGURO_AQUI"

# Crear directorio de backup
mkdir -p $BACKUP_PATH

# Backup de base de datos
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_PATH/db_backup_$DATE.sql

# Backup de archivos
tar -czf $BACKUP_PATH/files_backup_$DATE.tar.gz -C $APP_PATH storage public/uploads

# Limpiar backups antiguos (mantener últimos 7 días)
find $BACKUP_PATH -name "*.sql" -mtime +7 -delete
find $BACKUP_PATH -name "*.tar.gz" -mtime +7 -delete

echo "Backup completado: $DATE"
```

#### 8.2 Hacer ejecutable y programar
```bash
sudo chmod +x /usr/local/bin/genfisoft-backup.sh
sudo crontab -e

# Agregar línea para backup diario a las 2 AM
0 2 * * * /usr/local/bin/genfisoft-backup.sh >> /var/log/genfisoft-backup.log 2>&1
```

### 9. Configurar Monitoreo

#### 9.1 Instalar herramientas de monitoreo
```bash
sudo apt install htop iotop nethogs -y
```

#### 9.2 Configurar logs
```bash
sudo nano /etc/logrotate.d/genfisoft
```

Contenido:
```
/var/www/genfisoft/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    notifempty
    create 644 www-data www-data
}
```

---

## 🔧 Opción 2: Hosting Compartido

### Requisitos del Hosting
- PHP 8.1+
- MySQL 5.7+
- Composer disponible
- Acceso SSH (recomendado)
- Mínimo 1GB de espacio

### Pasos de Despliegue

#### 1. Preparar archivos localmente
```bash
# En tu máquina local
composer install --no-dev --optimize-autoloader
npm run build
```

#### 2. Subir archivos
- Sube todos los archivos EXCEPTO la carpeta `public/` al directorio raíz de tu hosting
- Sube el contenido de `public/` al directorio `public_html/` o `www/`

#### 3. Configurar .env
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com
# ... resto de configuración
```

#### 4. Configurar index.php
Edita `public_html/index.php`:
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

#### 5. Ejecutar comandos
```bash
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔧 Opción 3: Servicios en la Nube

### AWS EC2

#### 1. Crear instancia EC2
- AMI: Ubuntu Server 20.04 LTS
- Tipo: t3.medium (mínimo)
- Almacenamiento: 20GB GP2 SSD
- Grupo de seguridad: HTTP (80), HTTPS (443), SSH (22)

#### 2. Configurar dominio
- Route 53 para DNS
- Elastic IP para IP estática
- Application Load Balancer (opcional)

#### 3. Configurar RDS (opcional)
- Motor: MySQL 8.0
- Clase: db.t3.micro
- Almacenamiento: 20GB GP2

### DigitalOcean Droplet

#### 1. Crear Droplet
- Imagen: Ubuntu 20.04 x64
- Plan: Basic $12/mes (2GB RAM)
- Región: Más cercana a tus usuarios

#### 2. Configurar dominio
- Agregar dominio en panel de control
- Configurar registros DNS A y CNAME

---

## 🔒 Seguridad en Producción

### 1. Configuraciones de Seguridad

#### .env
```env
APP_DEBUG=false
APP_ENV=production
```

#### Permisos de archivos
```bash
sudo chown -R www-data:www-data /var/www/genfisoft
sudo chmod -R 755 /var/www/genfisoft
sudo chmod -R 775 /var/www/genfisoft/storage
sudo chmod -R 775 /var/www/genfisoft/bootstrap/cache
```

### 2. Configurar Fail2Ban
```bash
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### 3. Configurar ModSecurity (Apache)
```bash
sudo apt install libapache2-mod-security2 -y
sudo a2enmod security2
sudo systemctl restart apache2
```

---

## 📊 Mantenimiento

### Comandos de Mantenimiento Regular

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear

# Optimizar
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Actualizar aplicación
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm run build
php artisan config:cache
```

### Script de Actualización
```bash
#!/bin/bash
cd /var/www/genfisoft
sudo -u www-data git pull origin main
sudo -u www-data composer install --no-dev --optimize-autoloader
sudo -u www-data php artisan migrate --force
sudo -u www-data npm run build
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo systemctl reload apache2
echo "Actualización completada"
```

---

## 🆘 Solución de Problemas en Producción

### Logs importantes
```bash
# Logs de Laravel
tail -f /var/www/genfisoft/storage/logs/laravel.log

# Logs de Apache
tail -f /var/log/apache2/genfisoft_error.log

# Logs del sistema
tail -f /var/log/syslog
```

### Comandos de diagnóstico
```bash
# Estado de servicios
sudo systemctl status apache2
sudo systemctl status mysql

# Uso de recursos
htop
df -h
free -h

# Conectividad de base de datos
php artisan tinker
>>> DB::connection()->getPdo();
```

---

**⚠️ Importante**: 
- Cambia todas las contraseñas por defecto
- Mantén el sistema actualizado
- Realiza backups regulares
- Monitorea el rendimiento constantemente
- Usa HTTPS siempre en producción
