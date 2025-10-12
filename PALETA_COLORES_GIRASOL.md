# 🌻 Paleta de Colores Girasol - GenfiSoft

## Descripción
Este documento describe la paleta de colores inspirada en girasoles aplicada a todo el sistema GenfiSoft. La paleta combina tonos cálidos y naturales de verdes, amarillos y naranjas para crear una interfaz armoniosa y profesional.

---

## 🎨 Colores Principales

### Verdes
- **Verde Oscuro** (`#4A5D23`) - Color primario del sistema
- **Verde Oliva** (`#A8A060`) - Color informativo
- **Verde Medio** (`#6B7C2E`) - Color de éxito
- **Verde Oliva Claro** (`#8B9556`) - Color de texto secundario

### Naranjas
- **Naranja Oscuro** (`#D85F1F`) - Color de peligro/alerta
- **Naranja Medio** (`#F39237`) - Color secundario
- **Naranja Terracota** (`#C67D35`) - Color complementario

### Amarillos
- **Amarillo Brillante** (`#FFD700`) - Color de acento
- **Amarillo Mostaza** (`#E8B923`) - Color de advertencia
- **Amarillo Suave** (`#FFC857`) - Color complementario

---

## 📁 Archivos Modificados

### 1. **Gráficos del Dashboard**
**Archivo:** `resources/views/dashboard.blade.php`

Se actualizaron los tres gráficos principales:
- Inventario Actual (categoryChart)
- Situación Reproductiva Actual (reproductiveChart)
- Situación Productiva Actual (productiveChart)

**Paleta aplicada:**
```javascript
const colorPalette = [
    '#4A5D23', // Verde oscuro
    '#A8A060', // Verde oliva/beige
    '#D85F1F', // Naranja oscuro
    '#F39237', // Naranja medio
    '#FFD700', // Amarillo brillante
    '#E8B923', // Amarillo mostaza
    '#6B7C2E', // Verde medio
    '#C67D35', // Naranja terracota
    '#FFC857', // Amarillo suave
    '#8B9556'  // Verde oliva claro
];
```

### 2. **Tema CSS Personalizado**
**Archivo:** `public/css/sunflower-theme.css` (NUEVO)

Este archivo contiene todas las definiciones de colores y estilos para:
- Botones (primary, secondary, success, warning, danger, info)
- Textos con colores
- Iconos
- Badges y etiquetas
- Alertas
- Tarjetas (cards)
- Tablas
- Formularios
- Navegación y sidebar
- Paginación
- Progress bars
- Links
- Modales
- DataTable buttons

### 3. **Variables CSS Globales**
**Archivo:** `public/css/style.css`

Se actualizaron las variables CSS principales:
```css
:root {
  --color-bg-light: #FFFEF7;
  --color-header-light: #4A5D23;
  --color-header-update: #F39237;
  --color-btn-gradient-1: linear-gradient(to right, #4A5D23, #6B7C2E, #8B9556, #A8A060);
  --color-btn-gradient-2: linear-gradient(to right, #D85F1F, #F39237, #E8B923, #FFD700);
  --color-background-color-verde: #6B7C2E;
}
```

### 4. **Layout Principal**
**Archivo:** `resources/views/layouts/app.blade.php`

Se agregó la referencia al nuevo archivo CSS de tema:
```html
<!-- Sunflower Theme - Paleta de colores personalizada -->
<link href="{{ asset('css') }}/sunflower-theme.css" rel="stylesheet" />
```

---

## 🎯 Uso de Colores por Contexto

### Acciones Principales
- **Botones primarios:** Verde oscuro (`#4A5D23`)
- **Botones secundarios:** Naranja medio (`#F39237`)
- **Enlaces:** Verde oscuro (`#4A5D23`)

### Estados del Sistema
- **Éxito:** Verde medio (`#6B7C2E`)
- **Advertencia:** Amarillo mostaza (`#E8B923`)
- **Error/Peligro:** Naranja oscuro (`#D85F1F`)
- **Información:** Verde oliva (`#A8A060`)

### Elementos Visuales
- **Encabezados:** Verde oscuro (`#4A5D23`)
- **Iconos de éxito:** Verde medio (`#6B7C2E`)
- **Iconos de advertencia:** Amarillo mostaza (`#E8B923`)
- **Iconos de error:** Naranja oscuro (`#D85F1F`)

---

## 🔄 Gradientes Disponibles

### Gradiente Verde (Primario)
```css
linear-gradient(135deg, #4A5D23 0%, #6B7C2E 100%)
```

### Gradiente Cálido
```css
linear-gradient(135deg, #F39237 0%, #FFD700 100%)
```

### Gradiente Atardecer
```css
linear-gradient(135deg, #D85F1F 0%, #F39237 50%, #FFD700 100%)
```

---

## 📊 Aplicación en Componentes

### Botones
```html
<button class="btn btn-primary">Acción Principal</button>
<button class="btn btn-success">Guardar</button>
<button class="btn btn-warning">Advertencia</button>
<button class="btn btn-danger">Eliminar</button>
<button class="btn btn-info">Información</button>
```

### Textos e Iconos
```html
<i class="fa-solid fa-check text-success"></i>
<i class="fa-solid fa-exclamation text-warning"></i>
<i class="fa-solid fa-times text-danger"></i>
<span class="text-primary">Texto primario</span>
```

### Badges
```html
<span class="badge badge-success">Activo</span>
<span class="badge badge-warning">Pendiente</span>
<span class="badge badge-danger">Inactivo</span>
```

---

## ✅ Ventajas de la Paleta

1. **Coherencia Visual:** Todos los elementos del sistema utilizan la misma paleta
2. **Accesibilidad:** Colores con buen contraste para legibilidad
3. **Identidad de Marca:** Paleta única inspirada en la naturaleza
4. **Profesionalismo:** Combinación armoniosa de colores cálidos
5. **Versatilidad:** Suficientes variaciones para diferentes contextos

---

## 🚀 Implementación

La paleta se aplica automáticamente a:
- ✅ Todos los gráficos del dashboard
- ✅ Todos los botones del sistema
- ✅ Todos los iconos y textos con colores
- ✅ Todas las tablas y formularios
- ✅ Todos los modales y alertas
- ✅ Navegación y sidebar
- ✅ Elementos de DataTables

---

## 📝 Notas Importantes

1. El archivo `sunflower-theme.css` se carga después de los estilos base, por lo que tiene prioridad
2. Se utilizan `!important` en casos necesarios para asegurar la aplicación de los estilos
3. Los colores son consistentes en modo claro (el modo oscuro mantiene sus propios estilos)
4. La paleta es escalable y se puede extender fácilmente

---

## 🔧 Mantenimiento

Para modificar la paleta en el futuro:
1. Editar las variables en `public/css/sunflower-theme.css`
2. Actualizar las variables en `public/css/style.css`
3. Modificar los arrays de colores en `resources/views/dashboard.blade.php`

---

**Fecha de implementación:** 12 de octubre de 2025
**Versión:** 1.0
**Sistema:** GenfiSoft
