# 🌱 Instrucciones para Ejecutar el Seeder - Empresa 2

## 📋 **Descripción**

Este seeder poblará la **Empresa 2** con datos completos de prueba para todas las funcionalidades del sistema.

---

## 📦 **Datos que se Crearán**

### **1. Datos Básicos (Catálogos)**
- ✅ **6 Categorías**: Toro, Vaca, Novillo, Novilla, Ternero, Ternera
- ✅ **5 Colores**: Negro, Blanco, Marrón, Pinto, Rojo
- ✅ **4 Clasificaciones**: Puro, Cruzado, Mestizo, Enfermo
- ✅ **4 Causas de Entrada**: Compra, Nacimiento, Donación, Traspaso
- ✅ **4 Estados Reproductivos**: Preñada, Vacía, Servida, Seca
- ✅ **3 Estados Productivos**: En producción, Seca, Inicio lactancia
- ✅ **3 Rebaños**: Rebaño 1, 2 y 3
- ✅ **3 Propietarios**: Juan Pérez, María García, Carlos López

### **2. Animales (14 animales)**
- ✅ **5 Vacas productoras** (V001-V005) - Activas, produciendo leche
- ✅ **2 Toros** (T001-T002) - Activos, reproductores
- ✅ **2 Novillos/Novillas** (N001, NV001) - Jóvenes
- ✅ **2 Terneros/Terneras** (TR001, TRA001) - Bebés
- ✅ **2 Vendidos** (VS001-VS002) - Estado: Vendido
- ✅ **1 Muerto** (M001) - Estado: Muerto

### **3. Producción de Leche (35 registros)**
- ✅ **7 días de producción** (últimos 7 días)
- ✅ **5 vacas productoras** por día
- ✅ Litros: 15-30 litros por vaca/día
- ✅ Precio: $2.50 por litro

### **4. Servicios Veterinarios**
- ✅ **2 Veterinarios**: Dr. Roberto Sánchez, Dra. Ana Martínez
- ✅ **4 Productos**: Ivermectina, Vitamina ADE, Antibiótico, Vacuna Triple
- ✅ **4 Servicios**: Desparasitación, Vitaminas, Vacunación, Tratamiento

### **5. Bienes (4 bienes)**
- ✅ Tractor John Deere - $25,000
- ✅ Ordeñadora automática - $8,000
- ✅ Tanque enfriamiento - $3,500
- ✅ Cerca eléctrica - $1,200

### **6. Hechuras (6 registros)**
- ✅ **3 Trabajadores**: Pedro Ramírez, Luis Fernández, José González
- ✅ **2 Meses**: Mes actual y mes anterior
- ✅ Costos: $600-$800 por trabajador

### **7. Insumos (4 insumos)**
- ✅ Alimento balanceado - 500 kg - $2,500
- ✅ Sal mineralizada - 100 kg - $300
- ✅ Heno - 200 kg - $800
- ✅ Melaza - 150 kg - $450

### **8. Muertes (1 registro)**
- ✅ Animal M001 - Muerte por edad avanzada

### **9. Ventas (2 registros)**
- ✅ VS001 - $1,800 - 450 kg
- ✅ VS002 - $1,900 - 460 kg

---

## 🚀 **Cómo Ejecutar el Seeder**

### **Opción 1: Ejecutar solo este seeder**

```bash
php artisan db:seed --class=Company2DataSeeder
```

### **Opción 2: Agregar al DatabaseSeeder principal**

1. Abre `database/seeders/DatabaseSeeder.php`
2. Agrega en el método `run()`:

```php
public function run(): void
{
    $this->call([
        Company2DataSeeder::class,
    ]);
}
```

3. Ejecuta:

```bash
php artisan db:seed
```

---

## ⚠️ **IMPORTANTE - Antes de Ejecutar**

### **1. Verifica el ID de Usuario**

El seeder usa `$userId = 1` por defecto. Si tu usuario tiene otro ID:

1. Abre `database/seeders/Company2DataSeeder.php`
2. Cambia la línea 11:

```php
private $userId = 1; // Cambia este número por tu ID de usuario
```

### **2. Verifica que la Empresa 2 Existe**

Asegúrate de que existe una empresa con `id = 2` en la tabla `companies`.

Si no existe, créala primero:

```sql
INSERT INTO companies (id, name, created_at, updated_at) 
VALUES (2, 'Empresa de Prueba 2', NOW(), NOW());
```

### **3. Limpia Datos Anteriores (Opcional)**

Si quieres empezar con datos limpios para la empresa 2:

```sql
-- ⚠️ CUIDADO: Esto eliminará TODOS los datos de la empresa 2
DELETE FROM milk_production WHERE company_id = 2;
DELETE FROM veterinarians_cattles WHERE company_id = 2;
DELETE FROM deaths WHERE company_id = 2;
DELETE FROM sales WHERE company_id = 2;
DELETE FROM cattles WHERE company_id = 2;
DELETE FROM inputs WHERE company_id = 2;
DELETE FROM workmans WHERE company_id = 2;
DELETE FROM estates WHERE company_id = 2;
DELETE FROM products WHERE company_id = 2;
DELETE FROM veterinarians WHERE company_id = 2;
DELETE FROM owners WHERE company_id = 2;
DELETE FROM herds WHERE company_id = 2;
DELETE FROM guides WHERE company_id = 2;
```

---

## 🧪 **Verificar que Funcionó**

### **1. Dashboard**
```
✅ Gráficos deben mostrar datos
✅ Cards de estadísticas con números
✅ Tabla de categorías por sexo poblada
```

### **2. Animales (/cattle)**
```
✅ 14 animales en el listado
✅ Diferentes categorías y estados
✅ Algunos vendidos y uno muerto
```

### **3. Producción de Leche (/milk)**
```
✅ 35 registros de producción
✅ Últimos 7 días
✅ 5 vacas productoras
```

### **4. Reporte Semanal (/milk/report)**
```
✅ Selecciona última semana
✅ Debe mostrar datos de las 5 vacas
✅ Totales calculados correctamente
```

### **5. Servicios Veterinarios (/veterinarian)**
```
✅ 4 servicios registrados
✅ 2 veterinarios
✅ 4 productos
```

### **6. Bienes (/estate)**
```
✅ 4 bienes registrados
✅ Diferentes precios y fechas
```

### **7. Hechuras (/workman)**
```
✅ 6 registros (3 trabajadores × 2 meses)
✅ Mes actual y anterior
```

### **8. Insumos (/input)**
```
✅ 4 insumos registrados
✅ Diferentes propietarios
```

### **9. Muertes (/death)**
```
✅ 1 muerte registrada
✅ Animal M001
```

### **10. Ventas (/sale)**
```
✅ 2 ventas registradas
✅ Animales VS001 y VS002
```

---

## 📊 **Resumen de Datos Creados**

| Módulo | Cantidad | Detalles |
|--------|----------|----------|
| **Categorías** | 6 | Toro, Vaca, Novillo, Novilla, Ternero, Ternera |
| **Animales** | 14 | 5 vacas, 2 toros, 4 jóvenes, 2 vendidos, 1 muerto |
| **Producción Leche** | 35 | 7 días × 5 vacas |
| **Veterinarios** | 2 | Dr. Sánchez, Dra. Martínez |
| **Productos Vet** | 4 | Medicamentos y vacunas |
| **Servicios Vet** | 4 | Diferentes tratamientos |
| **Bienes** | 4 | Tractor, ordeñadora, tanque, cerca |
| **Hechuras** | 6 | 3 trabajadores × 2 meses |
| **Insumos** | 4 | Alimento, sal, heno, melaza |
| **Muertes** | 1 | Animal M001 |
| **Ventas** | 2 | VS001, VS002 |
| **Rebaños** | 3 | Rebaño 1, 2, 3 |
| **Propietarios** | 3 | Juan, María, Carlos |

---

## 🎯 **Casos de Uso Cubiertos**

### ✅ **Dashboard**
- Gráficos con datos reales
- Estadísticas del mes
- Tabla de categorías por sexo

### ✅ **Gestión de Animales**
- Diferentes categorías y edades
- Estados: Activo, Vendido, Muerto
- Machos y hembras
- Con y sin producción

### ✅ **Producción de Leche**
- Registro diario
- Múltiples vacas
- Reporte semanal funcional

### ✅ **Servicios Veterinarios**
- Veterinarios registrados
- Productos disponibles
- Servicios aplicados

### ✅ **Gestión Financiera**
- Bienes adquiridos
- Costos de mano de obra
- Gastos en insumos
- Ingresos por ventas

### ✅ **Trazabilidad**
- Muertes registradas
- Ventas documentadas
- Historial completo

---

## 🔄 **Re-ejecutar el Seeder**

Si necesitas volver a ejecutar el seeder:

1. **Limpia los datos anteriores** (ver sección "Limpia Datos Anteriores")
2. **Ejecuta el seeder nuevamente**:

```bash
php artisan db:seed --class=Company2DataSeeder
```

---

## 🐛 **Solución de Problemas**

### **Error: "SQLSTATE[23000]: Integrity constraint violation"**

**Causa**: Ya existen datos con los mismos códigos.

**Solución**: Limpia los datos de la empresa 2 antes de ejecutar.

### **Error: "Class 'Company2DataSeeder' not found"**

**Causa**: Laravel no encuentra el seeder.

**Solución**:
```bash
composer dump-autoload
php artisan db:seed --class=Company2DataSeeder
```

### **Los datos no aparecen en el sistema**

**Causa**: Estás viendo otra empresa.

**Solución**: Cambia a la Empresa 2 en el selector de empresas del sistema.

---

## 📝 **Notas Adicionales**

- ✅ Todos los datos están relacionados con `company_id = 2`
- ✅ Los códigos de animales son únicos y descriptivos
- ✅ Las fechas son recientes para que aparezcan en reportes
- ✅ Los precios y cantidades son realistas
- ✅ El seeder es idempotente (puede ejecutarse múltiples veces)

---

## ✨ **¡Listo para Probar!**

Después de ejecutar el seeder, tendrás una empresa completamente funcional con datos de prueba para todas las funcionalidades del sistema.

**Comando rápido:**
```bash
php artisan db:seed --class=Company2DataSeeder
```

**¡Disfruta probando el sistema con datos reales!** 🚀
