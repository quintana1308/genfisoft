# 📚 Módulo Guide - Instrucciones de Base de Datos

## ✅ Archivos Creados

Se han creado todos los archivos necesarios para el módulo **Guide**:

### Backend
- ✅ `app/Models/Guide.php` - Modelo con todas las funciones CRUD
- ✅ `app/Http/Controllers/GuideController.php` - Controlador con validaciones

### Frontend
- ✅ `resources/views/guide/index.blade.php` - Vista principal
- ✅ `public/paper/js/paper-guide.js` - JavaScript con DataTables

### Rutas
- ✅ `routes/web.php` - Rutas agregadas (líneas 86-91)

### Menú
- ✅ `resources/views/layouts/navbars/auth.blade.php` - Menú actualizado en sección Configuración

---

## 🗄️ Migración de Base de Datos

### Opción 1: Crear Migración con Artisan (Recomendado)

```bash
php artisan make:migration create_guides_table
```

Luego edita el archivo generado en `database/migrations/` y agrega:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->string('name', 100);
            $table->unsignedBigInteger('status_id')->default(1);
            
            // Índices
            $table->index('company_id');
            $table->index('user_id');
            $table->index('status_id');
            
            // Llaves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
```

Ejecutar la migración:
```bash
php artisan migrate
```

---

### Opción 2: SQL Directo

Si prefieres ejecutar SQL directamente en tu base de datos:

```sql
CREATE TABLE `guides` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `guides_company_id_index` (`company_id`),
  KEY `guides_user_id_index` (`user_id`),
  KEY `guides_status_id_index` (`status_id`),
  CONSTRAINT `guides_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `guides_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `guides_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 🎯 Estructura de la Tabla

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | BIGINT UNSIGNED | ID autoincremental |
| `user_id` | BIGINT UNSIGNED | ID del usuario que creó el registro |
| `company_id` | BIGINT UNSIGNED | ID de la empresa (multi-tenancy) |
| `name` | VARCHAR(100) | Nombre de la guía |
| `status_id` | BIGINT UNSIGNED | Estado (1=Activo, 2=Inactivo, 3=Referencia) |

---

## 🔗 Relaciones

- **BelongsTo User**: Cada guía pertenece a un usuario
- **BelongsTo Company**: Cada guía pertenece a una empresa
- **BelongsTo Status**: Cada guía tiene un estado

---

## 🚀 Rutas Disponibles

Una vez creada la tabla, estas rutas estarán disponibles:

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/guide` | Vista principal |
| GET | `/guide/data` | Obtener datos para DataTable |
| POST | `/guide/create` | Crear nueva guía |
| GET | `/guide/getGuide/{id}` | Obtener guía por ID |
| POST | `/guide/update` | Actualizar guía |

---

## 📝 Funcionalidades Implementadas

### ✅ CRUD Completo
- ✅ Crear guías
- ✅ Listar guías con DataTables
- ✅ Editar guías
- ✅ Cambiar estado (Activo/Inactivo/Referencia)
- ✅ Validación de duplicados por empresa

### ✅ Multi-Empresa
- ✅ Filtrado automático por empresa activa
- ✅ Aislamiento de datos entre empresas

### ✅ Seguridad
- ✅ Middleware de autenticación
- ✅ Validación de datos en servidor
- ✅ Protección CSRF

### ✅ UI/UX
- ✅ Interfaz responsive
- ✅ DataTables con búsqueda y exportación (Excel, PDF, Copiar)
- ✅ Formulario inline para crear/editar
- ✅ Mensajes de confirmación con SweetAlert2
- ✅ Iconos Font Awesome

---

## 🧪 Pruebas

### 1. Verificar que la tabla existe
```bash
php artisan tinker
>>> Schema::hasTable('guides');
# Debe retornar: true
```

### 2. Crear una guía de prueba
```bash
php artisan tinker
>>> $user = User::first();
>>> $company = Company::first();
>>> Guide::create([
    'name' => 'Guía de Prueba',
    'user_id' => $user->id,
    'company_id' => $company->id,
    'status_id' => 1
]);
```

### 3. Verificar en el navegador
1. Inicia sesión en la aplicación
2. Ve al menú **Configuración**
3. Haz clic en **Guía**
4. Deberías ver la interfaz completa funcionando

---

## 🔧 Solución de Problemas

### Error: "Table 'guides' doesn't exist"
**Solución**: Ejecuta la migración
```bash
php artisan migrate
```

### Error: "Route [guide.index] not defined"
**Solución**: Limpia la caché de rutas
```bash
php artisan route:clear
php artisan route:cache
```

### Error: "Class 'App\Http\Controllers\GuideController' not found"
**Solución**: Regenera el autoload de Composer
```bash
composer dump-autoload
```

### El menú no muestra "Guía"
**Solución**: Limpia la caché de vistas
```bash
php artisan view:clear
```

---

## 📦 Archivos Adicionales (Opcional)

### Seeder para datos de prueba

Crear: `database/seeders/GuideSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guide;
use App\Models\User;
use App\Models\Company;

class GuideSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $company = Company::first();

        $guides = [
            'Guía de Manejo',
            'Guía Sanitaria',
            'Guía de Alimentación',
            'Guía de Reproducción',
            'Guía de Registro',
        ];

        foreach ($guides as $guideName) {
            Guide::create([
                'name' => $guideName,
                'user_id' => $user->id,
                'company_id' => $company->id,
                'status_id' => 1
            ]);
        }
    }
}
```

Ejecutar:
```bash
php artisan db:seed --class=GuideSeeder
```

---

## ✨ Características del Módulo

- 🔒 **Seguro**: Validación en servidor y cliente
- 🏢 **Multi-empresa**: Datos aislados por empresa
- 📊 **DataTables**: Búsqueda, ordenamiento, exportación
- 🎨 **Responsive**: Funciona en móviles y tablets
- ⚡ **Rápido**: Consultas optimizadas con índices
- 🔄 **AJAX**: Sin recargar la página
- ✅ **Validado**: Previene duplicados

---

## 📞 Soporte

Si tienes algún problema:
1. Verifica que todos los archivos estén creados
2. Ejecuta las migraciones
3. Limpia todas las cachés
4. Revisa los logs en `storage/logs/laravel.log`

---

**¡El módulo Guide está listo para usar! 🎉**
