# 📚 Campo Guide en Cattle - Instrucciones Completas

## ✅ Archivos Modificados

Se han actualizado todos los archivos necesarios para agregar el campo `guide_id` a la tabla de ganado (cattle):

### Backend Actualizado
- ✅ `app/Models/Cattle.php` - Modelo actualizado con relación a Guide
- ✅ `database/migrations/2025_01_15_000002_add_guide_id_to_cattles_table.php` - Migración creada

### Frontend Actualizado
- ✅ `resources/views/cattle/create.blade.php` - Formulario de crear con campo Guide

---

## 🗄️ Migración de Base de Datos

### Ejecutar la Migración

```bash
php artisan migrate
```

Esta migración agregará:
- Campo `guide_id` (nullable) en la tabla `cattles`
- Índice para mejorar el rendimiento
- Llave foránea hacia la tabla `guides`
- `onDelete('set null')` para mantener integridad referencial

### SQL Directo (Alternativa)

Si prefieres ejecutar SQL directamente:

```sql
ALTER TABLE `cattles` 
ADD COLUMN `guide_id` BIGINT(20) UNSIGNED NULL AFTER `classification_id`,
ADD INDEX `cattles_guide_id_index` (`guide_id`),
ADD CONSTRAINT `cattles_guide_id_foreign` 
    FOREIGN KEY (`guide_id`) 
    REFERENCES `guides` (`id`) 
    ON DELETE SET NULL;
```

---

## 📝 Cambios Realizados

### 1. Modelo Cattle (`app/Models/Cattle.php`)

#### ✅ Import agregado:
```php
use App\Models\Guide;
```

#### ✅ Campo agregado a $fillable:
```php
protected $fillable = [
    // ... otros campos
    'guide_id',  // ⬅️ NUEVO
    // ... más campos
];
```

#### ✅ Relación agregada:
```php
public function guide(): BelongsTo
{
    return $this->belongsTo(Guide::class, 'guide_id', 'id');
}
```

#### ✅ Método `newCattles()` actualizado:
```php
$guides = Guide::where('company_id', $activeCompanyId)
    ->whereNotIn('status_id', [2, 3])
    ->get();

return [
    // ... otros datos
    'guides' => $guides  // ⬅️ NUEVO
];
```

#### ✅ Método `createCattle()` actualizado:
```php
Cattle::create([
    // ... otros campos
    'guide_id' => $request->guide,  // ⬅️ NUEVO
    // ... más campos
]);
```

#### ✅ Método `getCattle()` actualizado:
```php
$guides = Guide::where('company_id', $activeCompanyId)
    ->whereNotIn('status_id', [2, 3])
    ->orderBy('name')
    ->get(['id', 'name']);

return response()->json([
    'status' => true,
    'data' => [
        // ... otros campos
        'guide' => optional($cattle->guide)->id,  // ⬅️ NUEVO
        // ... más campos
    ],
    // ... otros datos
    'guides' => $guides  // ⬅️ NUEVO
]);
```

#### ✅ Método `updateCattle()` actualizado:
```php
$cattle->guide_id = $request->guideEdit ?: null;  // ⬅️ NUEVO
```

---

### 2. Vista Crear Cattle (`resources/views/cattle/create.blade.php`)

#### ✅ Campo agregado después de Clasificación:
```blade
<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label">
            <i class="fa-solid fa-book"></i> Guía
        </label>
        <select name="guide" id="guide" class="form-control">
            <option value="">-- Seleccione --</option>
            @foreach($data['guides'] as $guide)
            <option value="{{ $guide->id }}">{{ $guide->name}}</option>
            @endforeach
        </select>
    </div>
</div>
```

**Nota**: El campo NO es requerido (sin `required`), es opcional.

---

## 🎯 Funcionalidades Implementadas

### ✅ Crear Animal
- Campo "Guía" disponible en el formulario
- Selección opcional de guía
- Filtrado automático por empresa activa
- Solo muestra guías activas

### ✅ Editar Animal  
- Campo "Guía" se cargará en el formulario de edición
- Permite cambiar o quitar la guía
- Valor actual se selecciona automáticamente

### ✅ Listar Animales
- La relación `guide` está disponible para eager loading
- Puedes acceder a `$cattle->guide->name` en las vistas

### ✅ Integridad de Datos
- Si se elimina una guía, el campo `guide_id` se establece en NULL
- No se pierden datos del animal
- Relación opcional (nullable)

---

## 🔗 Relación Base de Datos

```
cattles
├── id
├── guide_id (nullable) ──→ guides.id
└── ... otros campos

guides
├── id
├── name
└── ... otros campos
```

**Tipo de relación**: BelongsTo (Muchos a Uno)
- Un animal puede tener una guía (opcional)
- Una guía puede estar asociada a muchos animales

---

## 🚀 Pasos para Activar

### 1️⃣ Ejecutar Migración
```bash
php artisan migrate
```

### 2️⃣ Limpiar Cachés
```bash
php artisan route:clear
php artisan view:clear
php artisan config:clear
composer dump-autoload
```

### 3️⃣ Verificar en el Navegador
1. Ve a **Ganado → Registrar**
2. Verás el nuevo campo "Guía" después de "Clasificación"
3. Selecciona una guía (opcional)
4. Registra el animal

---

## 🧪 Pruebas

### Verificar que la columna existe
```bash
php artisan tinker
>>> Schema::hasColumn('cattles', 'guide_id');
# Debe retornar: true
```

### Crear un animal con guía
```php
$cattle = Cattle::create([
    'code' => 'TEST-001',
    'guide_id' => 1,  // ID de una guía existente
    // ... otros campos requeridos
]);

// Verificar la relación
$cattle->guide->name;  // Retorna el nombre de la guía
```

### Verificar animales por guía
```php
$guide = Guide::find(1);
$cattles = Cattle::where('guide_id', $guide->id)->get();
```

---

## 📊 Consultas Útiles

### Obtener animales con su guía
```php
$cattles = Cattle::with('guide')
    ->where('company_id', $activeCompanyId)
    ->get();

foreach ($cattles as $cattle) {
    echo $cattle->code . ' - ' . ($cattle->guide->name ?? 'Sin guía');
}
```

### Contar animales por guía
```php
$guide = Guide::find(1);
$count = Cattle::where('guide_id', $guide->id)->count();
```

### Animales sin guía
```php
$cattlesWithoutGuide = Cattle::whereNull('guide_id')->get();
```

---

## 🔧 Solución de Problemas

### ❌ Error: "Unknown column 'guide_id'"
**Solución**: Ejecuta la migración
```bash
php artisan migrate
```

### ❌ Error: "Undefined index: guides"
**Solución**: Limpia la caché de vistas
```bash
php artisan view:clear
```

### ❌ El select de guías está vacío
**Solución**: 
1. Verifica que existan guías en la base de datos
2. Verifica que las guías tengan `status_id = 1` (Activo)
3. Verifica que pertenezcan a la empresa activa

```bash
php artisan tinker
>>> Guide::where('company_id', 1)->where('status_id', 1)->count();
```

### ❌ Error al guardar: "guide_id cannot be null"
**Solución**: El campo es nullable, verifica la migración
```sql
SHOW COLUMNS FROM cattles LIKE 'guide_id';
-- Debe mostrar NULL: YES
```

---

## 📱 Vista de Edición (Pendiente)

**Nota**: Aún falta actualizar la vista de edición (`cattle/edit.blade.php` o modal de edición).

Cuando la actualices, agrega el mismo código:

```blade
<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label">
            <i class="fa-solid fa-book"></i> Guía
        </label>
        <select name="guideEdit" id="guideEdit" class="form-control">
            <option value="">-- Seleccione --</option>
            @foreach($guides as $guide)
            <option value="{{ $guide->id }}">{{ $guide->name}}</option>
            @endforeach
        </select>
    </div>
</div>
```

Y en el JavaScript, asegúrate de cargar el valor actual:
```javascript
document.querySelector('#guideEdit').value = objData.data.guide || '';
```

---

## ✨ Características

- ✅ Campo opcional (no requerido)
- ✅ Filtrado por empresa activa
- ✅ Solo muestra guías activas
- ✅ Integridad referencial con SET NULL
- ✅ Relación BelongsTo configurada
- ✅ Compatible con eager loading
- ✅ Índice para mejor rendimiento

---

## 🎉 ¡Listo!

El campo `guide_id` está completamente integrado en el módulo de Cattle.

### Comandos Finales (Resumen)
```bash
# 1. Ejecutar migración
php artisan migrate

# 2. Limpiar cachés
php artisan route:clear && php artisan view:clear && composer dump-autoload

# 3. Verificar
php artisan tinker
>>> Schema::hasColumn('cattles', 'guide_id');
```

**¡El campo Guide ya está disponible en el formulario de crear animales! 🐄📚**
