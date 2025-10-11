# 📋 Instrucciones Completas - Módulo de Ventas y Eliminación de price_farm

## 🎯 TAREA 1: Módulo de Ventas

### ✅ Archivos Creados

1. **Migración**: `database/migrations/2025_01_15_000003_create_sales_table.php`
2. **Modelo**: `app/Models/Sale.php`
3. **Controlador**: `app/Http/Controllers/SaleController.php`
4. **Vista**: `resources/views/sale/index.blade.php`
5. **JavaScript**: `public/paper/js/paper-sale.js`

### 📝 Consulta SQL para crear tabla `sales`

```sql
CREATE TABLE `sales` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT(20) NULL,
  `company_id` BIGINT(20) NULL,
  `cattle_id` BIGINT(20) NULL,
  `sale_price` DECIMAL(10, 2) NOT NULL,
  `sale_date` DATE NOT NULL,
  `observations` TEXT NULL,
  `status_id` BIGINT(20) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `sales_company_id_cattle_id_index` (`company_id`, `cattle_id`),
  INDEX `sales_sale_date_index` (`sale_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 🔧 Funcionalidades Implementadas

#### ✅ **Registrar Venta**
- Formulario con campos:
  - Animal (select con animales disponibles)
  - Precio de Venta
  - Fecha de Venta
  - Observaciones (opcional)
- Al registrar:
  - Crea el registro en la tabla `sales`
  - Cambia automáticamente el estado del animal a **Vendido** (status_id = 4)

#### ✅ **Listar Ventas**
- DataTable con:
  - Código del Animal
  - Precio de Venta
  - Fecha de Venta
  - Estado
  - Botón Ver

#### ✅ **Ver Detalle de Venta**
- Modal con información completa de la venta

#### ✅ **Animales Vendidos - Restricciones**
1. **No se pueden editar**: El botón de editar NO aparece si `status_id = 4`
2. **Solo se pueden visualizar**: El botón de ver siempre está disponible
3. **No aparecen en selects**: Los animales vendidos NO aparecen en:
   - Select de Padre
   - Select de Madre
   - Select de Animal (en el módulo de Ventas)

### 📍 Ruta de Acceso

```
/sale
```

### 🗄️ Cambios en Base de Datos

**Tabla `cattles`**: Cuando se registra una venta, el campo `status_id` cambia a `4` (Vendido)

---

## 🎯 TAREA 2: Eliminar Campo "Precio en finca"

### ✅ Archivos Modificados

1. **Modelo**: `app/Models/Cattle.php`
   - Eliminado de `$fillable`
   - Eliminado de `createCattle()`
   - Eliminado de `getCattle()`
   - Eliminado de `updateCattle()`

2. **Vista Crear**: `resources/views/cattle/create.blade.php`
   - Eliminado campo completo del formulario

3. **Vista Index**: `resources/views/cattle/index.blade.php`
   - Eliminado del modal de ver
   - Eliminado del modal de editar

4. **JavaScript**: `public/paper/js/paper-cattle.js`
   - Eliminada línea en `viewCattle()`

### 📝 Consulta SQL para eliminar columna `price_farm`

```sql
ALTER TABLE `cattles` DROP COLUMN `price_farm`;
```

### ✅ Verificación

Después de ejecutar la consulta, verifica:

```sql
DESCRIBE cattles;
```

La columna `price_farm` ya NO debe aparecer.

---

## 🚀 Pasos para Activar Todo

### 1️⃣ **Crear tabla de ventas**

```sql
CREATE TABLE `sales` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT(20) NULL,
  `company_id` BIGINT(20) NULL,
  `cattle_id` BIGINT(20) NULL,
  `sale_price` DECIMAL(10, 2) NOT NULL,
  `sale_date` DATE NOT NULL,
  `observations` TEXT NULL,
  `status_id` BIGINT(20) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `sales_company_id_cattle_id_index` (`company_id`, `cattle_id`),
  INDEX `sales_sale_date_index` (`sale_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 2️⃣ **Eliminar columna price_farm**

```sql
ALTER TABLE `cattles` DROP COLUMN `price_farm`;
```

### 3️⃣ **Limpiar cachés**

```bash
php artisan route:clear
php artisan view:clear
php artisan config:clear
composer dump-autoload
```

### 4️⃣ **Verificar en el navegador**

1. Ve a `/sale` para ver el módulo de Ventas
2. Registra una venta
3. Verifica que el animal cambie a estado "Vendido"
4. Intenta editar el animal vendido (no debe aparecer el botón)
5. Verifica que en crear/editar animal ya NO aparece "Precio en finca"

---

## 📊 Flujo de Venta

```
Usuario accede a /sale
    ↓
Click en "Nueva Venta"
    ↓
Selecciona Animal (solo disponibles, no vendidos ni muertos)
    ↓
Ingresa Precio y Fecha
    ↓
Click en "Registrar Venta"
    ↓
Backend:
  - Crea registro en tabla sales
  - Cambia cattle.status_id = 4 (Vendido)
    ↓
Animal YA NO puede editarse
Animal YA NO aparece en selects
Animal solo puede VISUALIZARSE
```

---

## 🔍 Validaciones Implementadas

### **Al Registrar Venta**
- ✅ Verifica que el animal exista
- ✅ Verifica que el animal NO esté ya vendido
- ✅ Usa transacción DB para garantizar integridad

### **Al Listar Animales Disponibles**
- ✅ Excluye animales con `status_id = 2` (Muertos)
- ✅ Excluye animales con `status_id = 4` (Vendidos)

### **Al Mostrar Botón Editar**
- ✅ NO muestra botón si `status_id = 4`

### **Al Seleccionar Padre/Madre**
- ✅ Excluye animales con `status_id IN (2, 3, 4)`

---

## 🎨 Interfaz de Usuario

### **Módulo de Ventas**
```
┌─────────────────────────────────────────┐
│ 💵 Ventas              [+ Nueva Venta]  │
├─────────────────────────────────────────┤
│ Código │ Precio │ Fecha │ Estado │ Ver │
│ A001   │ $500   │ 10/01 │ Activo │ 👁  │
│ A002   │ $750   │ 11/01 │ Activo │ 👁  │
└─────────────────────────────────────────┘
```

### **Modal Nueva Venta**
```
┌─────────────────────────────────┐
│ Nueva Venta                  ✕  │
├─────────────────────────────────┤
│ Animal: [Seleccione...      ▼] │
│ Precio: [$____________]        │
│ Fecha:  [dd/mm/yyyy]           │
│ Observaciones:                 │
│ [_____________________________]│
│                                │
│         [✓ Registrar Venta]    │
└─────────────────────────────────┘
```

---

## 🧪 Pruebas

### **Probar Módulo de Ventas**

1. **Crear Venta**
   ```
   - Ve a /sale
   - Click en "Nueva Venta"
   - Selecciona un animal
   - Ingresa precio: 500
   - Selecciona fecha
   - Click en "Registrar Venta"
   - ✅ Debe mostrar mensaje de éxito
   ```

2. **Verificar Estado del Animal**
   ```
   - Ve a /cattle
   - Busca el animal vendido
   - ✅ Debe mostrar estado "Vendido"
   - ✅ NO debe aparecer botón de editar
   - ✅ Solo debe aparecer botón de ver
   ```

3. **Verificar que NO aparece en Selects**
   ```
   - Ve a /cattleCreate
   - Abre select de Padre o Madre
   - ✅ El animal vendido NO debe aparecer
   ```

4. **Intentar Vender Animal Ya Vendido**
   ```
   - Ve a /sale
   - Intenta vender el mismo animal
   - ✅ Debe mostrar error: "Este animal ya está vendido"
   ```

### **Probar Eliminación de price_farm**

1. **Formulario Crear**
   ```
   - Ve a /cattleCreate
   - ✅ NO debe aparecer campo "Precio en finca"
   - ✅ Solo debe aparecer "Precio de compra"
   ```

2. **Modal Editar**
   ```
   - Ve a /cattle
   - Click en editar un animal
   - ✅ NO debe aparecer campo "Precio en finca"
   ```

3. **Modal Ver**
   ```
   - Ve a /cattle
   - Click en ver un animal
   - ✅ NO debe aparecer "Precio en finca"
   ```

---

## 🔧 Solución de Problemas

### ❌ Error: "Table 'sales' doesn't exist"
**Solución**: Ejecuta la consulta SQL para crear la tabla

```sql
CREATE TABLE `sales` ...
```

### ❌ Error: "Unknown column 'price_farm'"
**Solución**: Ejecuta la consulta SQL para eliminar la columna

```sql
ALTER TABLE `cattles` DROP COLUMN `price_farm`;
```

### ❌ El botón de editar sigue apareciendo en animales vendidos
**Solución**: Limpia la caché

```bash
php artisan view:clear
```

### ❌ Los animales vendidos siguen apareciendo en los selects
**Solución**: Verifica que el `status_id` del animal sea 4

```sql
SELECT id, code, status_id FROM cattles WHERE id = [ID_DEL_ANIMAL];
```

---

## 📈 Estadísticas Útiles

### **Consultas SQL de Reporte**

```sql
-- Total de ventas por mes
SELECT 
    DATE_FORMAT(sale_date, '%Y-%m') as mes,
    COUNT(*) as total_ventas,
    SUM(sale_price) as total_ingresos
FROM sales
WHERE company_id = [TU_COMPANY_ID]
GROUP BY DATE_FORMAT(sale_date, '%Y-%m')
ORDER BY mes DESC;

-- Animales vendidos
SELECT 
    c.code,
    s.sale_price,
    s.sale_date
FROM cattles c
INNER JOIN sales s ON c.id = s.cattle_id
WHERE c.company_id = [TU_COMPANY_ID]
ORDER BY s.sale_date DESC;

-- Animales disponibles para venta
SELECT 
    code,
    price_purchase,
    income_weight
FROM cattles
WHERE company_id = [TU_COMPANY_ID]
  AND status_id NOT IN (2, 4) -- No muertos ni vendidos
ORDER BY code;
```

---

## ✨ Características Finales

### **Módulo de Ventas**
- ✅ Registro de ventas con precio y fecha
- ✅ Cambio automático de estado a "Vendido"
- ✅ Listado de todas las ventas
- ✅ Vista detallada de cada venta
- ✅ Validación para evitar vender animales ya vendidos

### **Restricciones de Animales Vendidos**
- ✅ No se pueden editar
- ✅ Solo se pueden visualizar
- ✅ No aparecen en select de Padre
- ✅ No aparecen en select de Madre
- ✅ No aparecen en select de Animal (Ventas)

### **Eliminación de price_farm**
- ✅ Eliminado de modelo
- ✅ Eliminado de vistas (crear, editar, ver)
- ✅ Eliminado de JavaScript
- ✅ Consulta SQL proporcionada

---

## 🎉 ¡Todo Listo!

### **Resumen de Consultas SQL**

```sql
-- 1. Crear tabla de ventas
CREATE TABLE `sales` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT(20) NULL,
  `company_id` BIGINT(20) NULL,
  `cattle_id` BIGINT(20) NULL,
  `sale_price` DECIMAL(10, 2) NOT NULL,
  `sale_date` DATE NOT NULL,
  `observations` TEXT NULL,
  `status_id` BIGINT(20) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `sales_company_id_cattle_id_index` (`company_id`, `cattle_id`),
  INDEX `sales_sale_date_index` (`sale_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Eliminar columna price_farm
ALTER TABLE `cattles` DROP COLUMN `price_farm`;
```

### **Comandos de Limpieza**

```bash
php artisan route:clear
php artisan view:clear
composer dump-autoload
```

**¡El módulo de Ventas está completo y el campo price_farm ha sido eliminado!** 🚀
