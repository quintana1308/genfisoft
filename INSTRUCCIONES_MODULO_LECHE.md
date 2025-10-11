# 📋 Instrucciones Completas - Módulo de Producción de Leche

## 🎯 Funcionalidades Implementadas

### ✅ **1. Registro Diario de Producción**
- Registrar producción de leche por vaca por día
- Solo vacas (hembras) activas disponibles
- Campos: Vaca, Fecha, Litros, Precio por Litro, Observaciones
- Cálculo automático del total (litros × precio)
- Validación: No permitir duplicados (misma vaca, misma fecha)
- Filtro por fecha para ver producción del día

### ✅ **2. Reporte Semanal**
- Selección de rango de fechas (inicio - fin)
- Por defecto: Lunes a Viernes de la semana actual
- Resumen general:
  - Total de litros producidos
  - Total de ingresos
  - Precio promedio por litro
- Tabla detallada por vaca:
  - Código de la vaca
  - Días producidos
  - Total de litros
  - Precio promedio por litro
  - Total de ingresos
- Totales al pie de la tabla

---

## 📁 Archivos Creados

### **Backend**

1. **Migración**: `database/migrations/2025_01_15_000004_create_milk_production_table.php`
2. **Modelo**: `app/Models/MilkProduction.php`
3. **Controlador**: `app/Http/Controllers/MilkProductionController.php`

### **Frontend**

4. **Vista Registro**: `resources/views/milk/index.blade.php`
5. **Vista Reporte**: `resources/views/milk/report.blade.php`
6. **JavaScript Registro**: `public/paper/js/paper-milk.js`
7. **JavaScript Reporte**: `public/paper/js/paper-milk-report.js`

### **Rutas**

8. **Rutas agregadas** en `routes/web.php`

### **Menú**

9. **Item de menú agregado** en `resources/views/layouts/navbars/auth.blade.php`

---

## 🗄️ Estructura de la Base de Datos

### **Tabla: `milk_production`**

```sql
CREATE TABLE `milk_production` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT(20) NULL,
  `company_id` BIGINT(20) NULL,
  `cattle_id` BIGINT(20) NULL,
  `production_date` DATE NOT NULL,
  `liters` DECIMAL(10, 2) NOT NULL,
  `price_per_liter` DECIMAL(10, 2) NOT NULL,
  `total_price` DECIMAL(10, 2) NOT NULL,
  `observations` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `milk_production_company_id_cattle_id_production_date_index` (`company_id`, `cattle_id`, `production_date`),
  UNIQUE KEY `milk_production_cattle_id_production_date_unique` (`cattle_id`, `production_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### **Campos:**

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | BIGINT | ID único del registro |
| `user_id` | BIGINT | Usuario que registró |
| `company_id` | BIGINT | Empresa |
| `cattle_id` | BIGINT | ID de la vaca |
| `production_date` | DATE | Fecha de producción |
| `liters` | DECIMAL(10,2) | Litros producidos |
| `price_per_liter` | DECIMAL(10,2) | Precio por litro |
| `total_price` | DECIMAL(10,2) | Total (litros × precio) |
| `observations` | TEXT | Observaciones opcionales |
| `created_at` | TIMESTAMP | Fecha de creación |
| `updated_at` | TIMESTAMP | Fecha de actualización |

### **Índices:**

- ✅ Índice compuesto: `(company_id, cattle_id, production_date)`
- ✅ Restricción única: `(cattle_id, production_date)` - Evita duplicados

---

## 🚀 Pasos para Activar el Módulo

### 1️⃣ **Ejecutar Migración**

```bash
php artisan migrate
```

O ejecutar manualmente la consulta SQL proporcionada arriba.

### 2️⃣ **Limpiar Cachés**

```bash
php artisan route:clear
php artisan view:clear
php artisan config:clear
composer dump-autoload
```

### 3️⃣ **Verificar en el Navegador**

1. Recarga la página (Ctrl+F5)
2. Ve al menú lateral
3. ✅ Debe aparecer "Producción de Leche" con ícono de gota 💧
4. Submenu:
   - Registro Diario
   - Reporte Semanal

---

## 📍 Rutas del Módulo

```
/milk                    → Registro diario (index)
/milk/data              → DataTable de producción diaria
/milk/create            → Crear registro de producción
/milk/getProduction/{id}→ Ver detalle de producción
/milk/delete/{id}       → Eliminar registro
/milk/report            → Vista de reporte semanal
/milk/weeklyReport      → Obtener datos del reporte
```

---

## 🎨 Interfaz de Usuario

### **Registro Diario**

```
┌─────────────────────────────────────────────────────┐
│  Listado (8 columnas)    │  Formulario (4 columnas) │
│  ┌──────────────────┐    │  ┌──────────────────┐   │
│  │ [Fecha: ____]    │    │  │ Registrar        │   │
│  │                  │    │  │ Producción       │   │
│  │ DataTable        │    │  │                  │   │
│  │ - Código Vaca    │    │  │ - Vaca           │   │
│  │ - Litros         │    │  │ - Fecha          │   │
│  │ - Precio/L       │    │  │ - Litros         │   │
│  │ - Total          │    │  │ - Precio/L       │   │
│  │ - Acciones       │    │  │ - Observaciones  │   │
│  │   (Ver, Eliminar)│    │  │ [Registrar]      │   │
│  └──────────────────┘    │  └──────────────────┘   │
└─────────────────────────────────────────────────────┘
```

### **Reporte Semanal**

```
┌─────────────────────────────────────────────────────┐
│ 📊 Reporte Semanal de Producción                    │
├─────────────────────────────────────────────────────┤
│ Fecha Inicio: [____] Fecha Fin: [____] [Generar]   │
├─────────────────────────────────────────────────────┤
│ ┌─────────────┐ ┌─────────────┐ ┌─────────────┐   │
│ │ Total       │ │ Total       │ │ Precio      │   │
│ │ Litros      │ │ Ingresos    │ │ Promedio/L  │   │
│ │ 1,250.50 L  │ │ $2,500.00   │ │ $2.00       │   │
│ └─────────────┘ └─────────────┘ └─────────────┘   │
├─────────────────────────────────────────────────────┤
│ Código │ Días │ Litros │ Precio/L │ Total        │
│ V001   │  5   │ 250 L  │ $2.00    │ $500.00      │
│ V002   │  5   │ 300 L  │ $2.00    │ $600.00      │
│ TOTALES│ 10   │ 550 L  │ $2.00    │ $1,100.00    │
└─────────────────────────────────────────────────────┘
```

---

## 🔍 Validaciones Implementadas

### **Al Registrar Producción**
- ✅ Vaca requerida
- ✅ Fecha requerida
- ✅ Litros requeridos (mayor a 0)
- ✅ Precio por litro requerido (mayor a 0)
- ✅ No permitir duplicados (misma vaca + misma fecha)
- ✅ Solo vacas activas (no muertas ni vendidas)
- ✅ Solo vacas hembras

### **Al Generar Reporte**
- ✅ Fecha inicio requerida
- ✅ Fecha fin requerida
- ✅ Fecha inicio no puede ser mayor a fecha fin

---

## 🧪 Pruebas

### **1. Probar Registro Diario**

```
1. Ve a /milk
2. Selecciona una vaca
3. Ingresa:
   - Fecha: Hoy
   - Litros: 25.50
   - Precio/L: 2.00
4. Click en "Registrar"
5. ✅ Debe mostrar mensaje de éxito
6. ✅ La tabla debe actualizarse
7. ✅ El formulario debe limpiarse
8. ✅ Total debe ser: $51.00
```

### **2. Probar Validación de Duplicados**

```
1. Intenta registrar la misma vaca en la misma fecha
2. ✅ Debe mostrar error: "Ya existe un registro..."
```

### **3. Probar Filtro por Fecha**

```
1. Cambia la fecha en el filtro
2. ✅ La tabla debe actualizarse automáticamente
3. ✅ Solo debe mostrar producción de esa fecha
```

### **4. Probar Ver Detalle**

```
1. Click en el botón Ver (👁)
2. ✅ Debe abrir modal con información completa
```

### **5. Probar Eliminar**

```
1. Click en el botón Eliminar (🗑)
2. ✅ Debe pedir confirmación
3. Confirma
4. ✅ Debe eliminar y actualizar tabla
```

### **6. Probar Reporte Semanal**

```
1. Ve a /milk/report
2. ✅ Debe mostrar fechas por defecto (lunes a viernes)
3. Click en "Generar Reporte"
4. ✅ Debe mostrar:
   - Tarjetas con totales
   - Tabla con datos por vaca
   - Totales al pie
```

### **7. Probar Rango de Fechas Personalizado**

```
1. Cambia las fechas
2. Click en "Generar Reporte"
3. ✅ Debe mostrar datos del nuevo rango
```

---

## 📊 Consultas SQL Útiles

### **Ver producción de hoy**

```sql
SELECT 
    c.code,
    mp.liters,
    mp.price_per_liter,
    mp.total_price
FROM milk_production mp
INNER JOIN cattles c ON mp.cattle_id = c.id
WHERE mp.production_date = CURDATE()
  AND mp.company_id = [TU_COMPANY_ID]
ORDER BY c.code;
```

### **Reporte semanal**

```sql
SELECT 
    c.code,
    COUNT(*) as dias_producidos,
    SUM(mp.liters) as total_litros,
    AVG(mp.price_per_liter) as precio_promedio,
    SUM(mp.total_price) as total_ingresos
FROM milk_production mp
INNER JOIN cattles c ON mp.cattle_id = c.id
WHERE mp.production_date BETWEEN '2025-01-13' AND '2025-01-17'
  AND mp.company_id = [TU_COMPANY_ID]
GROUP BY c.id, c.code
ORDER BY c.code;
```

### **Producción mensual**

```sql
SELECT 
    DATE_FORMAT(production_date, '%Y-%m') as mes,
    SUM(liters) as total_litros,
    SUM(total_price) as total_ingresos,
    AVG(price_per_liter) as precio_promedio
FROM milk_production
WHERE company_id = [TU_COMPANY_ID]
GROUP BY DATE_FORMAT(production_date, '%Y-%m')
ORDER BY mes DESC;
```

### **Vaca más productiva**

```sql
SELECT 
    c.code,
    SUM(mp.liters) as total_litros,
    COUNT(*) as dias_producidos,
    AVG(mp.liters) as promedio_diario
FROM milk_production mp
INNER JOIN cattles c ON mp.cattle_id = c.id
WHERE mp.company_id = [TU_COMPANY_ID]
GROUP BY c.id, c.code
ORDER BY total_litros DESC
LIMIT 10;
```

---

## 🔄 Flujo de Trabajo

### **Registro Diario**

```
Usuario accede a /milk
    ↓
Selecciona fecha (por defecto: hoy)
    ↓
Ve producción del día en DataTable
    ↓
Llena formulario (Vaca, Litros, Precio/L)
    ↓
Click en "Registrar"
    ↓
Backend valida:
  - No duplicados
  - Campos requeridos
  - Calcula total
    ↓
Guarda en BD
    ↓
Mensaje de éxito
    ↓
Tabla se actualiza
```

### **Reporte Semanal**

```
Usuario accede a /milk/report
    ↓
Selecciona rango de fechas
    ↓
Click en "Generar Reporte"
    ↓
Backend consulta BD:
  - Agrupa por vaca
  - Suma litros y totales
  - Calcula promedios
    ↓
Muestra:
  - Tarjetas con totales generales
  - Tabla detallada por vaca
  - Totales al pie
```

---

## ✨ Características Especiales

### **1. Solo Vacas Hembras**
- El sistema automáticamente filtra solo vacas (sexo = 'Hembra')
- No aparecen machos en el select

### **2. Solo Vacas Activas**
- Excluye animales muertos (status_id = 2)
- Excluye animales vendidos (status_id = 4)

### **3. Prevención de Duplicados**
- Restricción única en BD: `(cattle_id, production_date)`
- Validación en backend antes de guardar

### **4. Cálculo Automático**
- El total se calcula automáticamente: `litros × precio_por_litro`
- No requiere ingreso manual

### **5. Fechas Inteligentes**
- Registro: Por defecto fecha actual
- Reporte: Por defecto lunes a viernes de la semana actual

### **6. Filtro Dinámico**
- Al cambiar la fecha, la tabla se actualiza automáticamente
- No requiere recargar la página

---

## 🎉 ¡Todo Listo!

### **Resumen de Comandos**

```bash
# 1. Ejecutar migración
php artisan migrate

# 2. Limpiar cachés
php artisan route:clear
php artisan view:clear
php artisan config:clear
composer dump-autoload
```

### **Acceso al Módulo**

```
Menú → Producción de Leche
    ├── Registro Diario (/milk)
    └── Reporte Semanal (/milk/report)
```

---

## 📈 Próximas Mejoras (Opcional)

- ✅ Exportar reporte a Excel
- ✅ Exportar reporte a PDF
- ✅ Gráficos de producción
- ✅ Comparativa entre vacas
- ✅ Alertas de baja producción
- ✅ Proyecciones de producción

---

**¡El módulo de Producción de Leche está completo y listo para usar!** 🚀🥛
