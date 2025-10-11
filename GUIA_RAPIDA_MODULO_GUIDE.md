# 🚀 Guía Rápida - Módulo Guide

## ✅ Archivos Creados Automáticamente

### Backend (PHP)
- ✅ `app/Models/Guide.php`
- ✅ `app/Http/Controllers/GuideController.php`
- ✅ `database/migrations/2025_01_15_000001_create_guides_table.php`
- ✅ `database/seeders/GuideSeeder.php`

### Frontend (Blade + JS)
- ✅ `resources/views/guide/index.blade.php`
- ✅ `public/paper/js/paper-guide.js`

### Configuración
- ✅ `routes/web.php` (actualizado)
- ✅ `resources/views/layouts/navbars/auth.blade.php` (menú actualizado)

### Documentación
- ✅ `MODULO_GUIDE_INSTRUCCIONES.md`
- ✅ `GUIA_RAPIDA_MODULO_GUIDE.md`

---

## 📋 Pasos para Activar el Módulo

### 1️⃣ Ejecutar la Migración
```bash
php artisan migrate
```

### 2️⃣ (Opcional) Cargar Datos de Prueba
```bash
php artisan db:seed --class=GuideSeeder
```

### 3️⃣ Limpiar Cachés
```bash
php artisan route:clear
php artisan view:clear
php artisan config:clear
composer dump-autoload
```

### 4️⃣ Verificar en el Navegador
1. Inicia sesión en tu aplicación
2. Ve al menú **Configuración** (ícono de engranaje)
3. Haz clic en **Guía** (ícono de libro)
4. ¡Listo! Ya puedes crear, editar y gestionar guías

---

## 🎯 Funcionalidades Disponibles

### ✨ Crear Guía
1. Completa el formulario en el panel derecho
2. Haz clic en "Registrar"
3. La guía aparecerá en la tabla

### ✏️ Editar Guía
1. Haz clic en el ícono de editar (lápiz)
2. Modifica los datos en el formulario
3. Cambia el estado si es necesario
4. Haz clic en "Actualizar"

### 🔍 Buscar Guías
- Usa el campo de búsqueda en la tabla
- Ordena por cualquier columna
- Exporta a Excel, PDF o copia los datos

### 🏢 Multi-Empresa
- Cada empresa ve solo sus propias guías
- Los datos están completamente aislados
- Cambiar de empresa muestra diferentes guías

---

## 🗄️ Estructura de la Base de Datos

```sql
Table: guides
├── id (BIGINT) - Primary Key
├── user_id (BIGINT) - Foreign Key → users.id
├── company_id (BIGINT) - Foreign Key → companies.id
├── name (VARCHAR 100) - Nombre de la guía
└── status_id (BIGINT) - Foreign Key → statuses.id
```

---

## 🔗 Rutas Creadas

| Método | URL | Acción |
|--------|-----|--------|
| GET | `/guide` | Mostrar vista principal |
| GET | `/guide/data` | Obtener datos (AJAX) |
| POST | `/guide/create` | Crear nueva guía |
| GET | `/guide/getGuide/{id}` | Obtener guía específica |
| POST | `/guide/update` | Actualizar guía |

---

## 🎨 Iconos Utilizados

- **Menú**: 📖 `fa-book` (libro)
- **Formulario**: ✅ `fa-check` (check)
- **Editar**: ✏️ `fa-pen-to-square` (editar)
- **Estado**: 🔄 `fa-spinner` (estado)
- **Nombre**: 🔤 `fa-a` (letra A)

---

## 🐛 Solución Rápida de Problemas

### ❌ Error: "Table 'guides' doesn't exist"
```bash
php artisan migrate
```

### ❌ Error: "Route [guide.index] not defined"
```bash
php artisan route:clear
php artisan route:cache
```

### ❌ Error: "Class GuideController not found"
```bash
composer dump-autoload
```

### ❌ El menú no muestra "Guía"
```bash
php artisan view:clear
# Luego recarga la página con Ctrl+F5
```

### ❌ Error 500 al crear guía
1. Verifica que la tabla `guides` existe
2. Verifica que la tabla `statuses` tiene registros
3. Revisa `storage/logs/laravel.log`

---

## 📊 Ejemplo de Uso

### Crear una guía desde código
```php
use App\Models\Guide;

Guide::create([
    'name' => 'Guía de Vacunación',
    'user_id' => auth()->id(),
    'company_id' => auth()->user()->active_company_id,
    'status_id' => 1
]);
```

### Obtener guías de la empresa activa
```php
$guides = Guide::where('company_id', auth()->user()->active_company_id)
    ->where('status_id', 1)
    ->get();
```

---

## 🔐 Seguridad Implementada

- ✅ Autenticación requerida (middleware `auth`)
- ✅ Filtrado automático por empresa activa
- ✅ Validación de datos en servidor
- ✅ Protección CSRF en formularios
- ✅ Prevención de duplicados por empresa
- ✅ Sanitización de entradas

---

## 📱 Responsive Design

El módulo funciona perfectamente en:
- 💻 Desktop
- 📱 Tablets
- 📱 Móviles

---

## 🎉 ¡Todo Listo!

El módulo **Guide** está completamente funcional y listo para usar.

### Comandos Finales (Resumen)
```bash
# 1. Ejecutar migración
php artisan migrate

# 2. (Opcional) Datos de prueba
php artisan db:seed --class=GuideSeeder

# 3. Limpiar cachés
php artisan route:clear
php artisan view:clear
php artisan config:clear
composer dump-autoload

# 4. Verificar que todo funciona
php artisan route:list | grep guide
```

### Verificación Final
```bash
# En Tinker
php artisan tinker
>>> Schema::hasTable('guides');
# Debe retornar: true

>>> Guide::count();
# Debe retornar: número de guías (0 o más)
```

---

## 📞 Contacto

Si necesitas ayuda adicional o quieres agregar más funcionalidades al módulo, no dudes en preguntar.

**¡Disfruta tu nuevo módulo Guide! 🎊**
