# Sistema Universitario CRUD - Laravel 12 con PostgreSQL

## 📋 Tabla de Contenidos
1. [Introducción](#introducción)
2. [Características](#características)
3. [Tecnologías Utilizadas](#tecnologías-utilizadas)
4. [Estructura del Proyecto](#estructura-del-proyecto)
5. [Instalación y Configuración](#instalación-y-configuración)
6. [Módulos del Sistema](#módulos-del-sistema)
7. [Dashboard](#dashboard)
8. [Consultas PostgreSQL](#consultas-postgresql)
9. [Rutas y Endpoints](#rutas-y-endpoints)
10. [Cómo Usar el Sistema](#cómo-usar-el-sistema)

---

## 🎯 Introducción

**Sistema Universitario** es una aplicación web completa desarrollada con **Laravel 12** y **PostgreSQL** para gestionar la información académica de una universidad. Permite administrar estudiantes, materias/cursos, inscripciones de estudiantes en materias, y registro de calificaciones con cálculo automático de promedios.

### ¿Qué puedes hacer?
- ✅ **Gestionar Estudiantes** - Crear, editar, listar y eliminar estudiantes
- ✅ **Gestionar Materias** - Crear cursos/asignaturas, asignar profesores
- ✅ **Gestionar Inscripciones** - Inscribir estudiantes en materias, prevenir duplicados
- ✅ **Registrar Calificaciones** - Ingresar notas (0-5), calcular promedios automáticamente
- ✅ **Dashboard** - Visualizar estadísticas, estudiantes con bajo rendimiento, materias populares
- ✅ **Base de datos relacional** - Integridad referencial con Foreign Keys

---

## ⭐ Características

| Característica | Descripción |
|---|---|
| **4 Módulos CRUD** | Estudiantes, Materias, Inscripciones, Calificaciones |
| **Relations** | Relaciones OneToMany y ManyToOne entre modelos |
| **Validaciones** | Prevención de duplicados, emails únicos, rangos de notas |
| **Dashboard** | 8 widgets con estadísticas, gráficos y alertas |
| **Promedio Automático** | Cálculo de promedio por curso y promedio general |
| **Bootstrap 5** | Interfaz responsiva y moderna |
| **PostgreSQL** | Base de datos robusta y escalable |
| **Blade Templating** | Vistas dinámicas y eficientes |

---

---

## 🛠️ Tecnologías Utilizadas

| Tecnología | Versión | Propósito |
|-----------|---------|----------|
| **Laravel** | 12.56.0 | Framework PHP moderno para desarrollo web |
| **PHP** | 8.2.12 | Lenguaje de programación del servidor |
| **PostgreSQL** | 12+ | Base de datos relacional robusto |
| **Blade** | (Laravel) | Motor de plantillas para HTML dinámico |
| **Bootstrap** | 5.3.0 | Framework CSS para diseño responsivo |
| **Composer** | - | Gestor de paquetes de PHP |
| **Vite** | 7.3.2 | Herramienta de compilación de frontend |
| **Node.js** | 20.x LTS | Runtime de JavaScript (necesario para Vite) |

---

## 📁 Estructura del Proyecto

```
crud-laravel/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php      ← Dashboard
│   │       ├── EstudianteController.php     ← CRUD Estudiantes
│   │       ├── MateriaController.php        ← CRUD Materias
│   │       ├── InscripcionController.php    ← CRUD Inscripciones
│   │       └── CalificacionController.php   ← CRUD Calificaciones
│   └── Models/
│       ├── Estudiante.php
│       ├── Materia.php
│       ├── Inscripcion.php
│       └── Calificacion.php
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── 0001_01_01_000001_create_cache_table.php
│       ├── 0001_01_01_000002_create_jobs_table.php
│       ├── 2026_04_13_202124_create_estudiantes_table.php
│       ├── 2026_04_14_173831_create_materias_table.php
│       ├── 2026_04_14_173832_create_inscripcions_table.php
│       └── 2026_04_14_173833_create_calificacions_table.php
├── resources/views/
│   ├── layout.blade.php                    ← Layout base con navbar
│   ├── dashboard/
│   │   └── index.blade.php                 ← Dashboard principal
│   ├── estudiantes/
│   │   ├── index.blade.php, create.blade.php, edit.blade.php, show.blade.php
│   ├── materias/
│   │   ├── index.blade.php, create.blade.php, edit.blade.php, show.blade.php
│   ├── inscripciones/
│   │   ├── index.blade.php, create.blade.php, edit.blade.php, show.blade.php
│   └── calificaciones/
│       ├── index.blade.php, create.blade.php, edit.blade.php, show.blade.php
├── routes/
│   └── web.php                             ← Rutas
├── .env                                    ← Configuración
├── composer.json                           ← Dependencias PHP
└── README.md                               ← Este archivo
```

---

## 🚀 Instalación y Configuración

### Requisitos Previos
- PHP 8.2 o superior
- Composer instalado
- Node.js 20.x LTS o superior
- Git (opcional)

### Paso 1: Clonar o descargar el proyecto
```bash
cd crud-laravel
```

### Paso 2: Instalar dependencias PHP
```bash
composer install
```

**¿Qué hace?**
- Descarga todas las librerías PHP necesarias (Laravel, validadores, etc.)
- Crea la carpeta `vendor/` con todo el código de terceros
- Genera el autoloader para cargar clases automáticamente

### Paso 3: Configurar archivo .env
El archivo `.env` ya está configurado, pero verifica:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=crud-laravel
DB_USERNAME=postgres
DB_PASSWORD=12345678
```

**Asegúrate de que:**
- PostgreSQL esté corriendo en puerto 5432
- La base de datos `crud-laravel` exista
- Las credenciales sean correctas

### Paso 4: Generar clave de aplicación
```bash
php artisan key:generate
```

### Paso 5: Ejecutar migraciones
```bash
php artisan migrate
```

Esto crea 10 tablas:
- `users`, `cache`, `jobs`, `password_reset_tokens`, `sessions` (Laravel)
- `estudiantes`, `materias`, `inscripcions`, `calificacions` (nuestras tablas)

### Paso 6: Instalar dependencias Node.js
```bash
npm install
```

### Paso 7: Iniciar servidor de desarrollo
```bash
composer run dev
```

**Accede aquí:** http://localhost:8000

---

## 📚 Módulos del Sistema

### 1. 👥 Estudiantes
**Descripción:** Gestión de información de estudiantes universitarios

**Campos:**
- Nombre, Apellido, Email (único), Cédula (única)
- Fecha de Nacimiento, Teléfono, Dirección
- Timestamps (created_at, updated_at)

**Funcionalidades:**
- CRUD completo (Crear, Leer, Actualizar, Eliminar)
- Validación de email y cédula únicos
- Cálculo de promedio general por estudiante
- Relación con inscripciones (muchas inscripciones por estudiante)

**Rutas:**
- `GET /estudiantes` - Listar todos
- `GET /estudiantes/create` - Formulario crear
- `POST /estudiantes` - Guardar
- `GET /estudiantes/{id}` - Ver detalles
- `GET /estudiantes/{id}/edit` - Formulario editar
- `PUT /estudiantes/{id}` - Actualizar
- `DELETE /estudiantes/{id}` - Eliminar

---

### 2. 📖 Materias
**Descripción:** Gestión de cursos/asignaturas universitarias

**Campos:**
- Nombre, Código (único), Créditos, Descripción
- Horas por Semana, Profesor
- Timestamps

**Funcionalidades:**
- CRUD completo
- Código de materia único (ej: MAT101, FIS201)
- Validación de créditos (1-10)
- Lista de estudiantes inscritos
- Relación con inscripciones

**Rutas:**
- `GET /materias` - Listar todas
- `GET /materias/create` - Formulario crear
- `POST /materias` - Guardar
- `GET /materias/{id}` - Ver detalles
- `GET /materias/{id}/edit` - Formulario editar
- `PUT /materias/{id}` - Actualizar
- `DELETE /materias/{id}` - Eliminar

---

### 3. 📋 Inscripciones
**Descripción:** Registro de estudiantes inscritos en materias

**Campos:**
- estudiante_id (FK), materia_id (FK)
- Fecha de Inscripción, Estado (activa/completada/cancelada)
- Timestamps

**Funcionalidades:**
- CRUD completo
- Prevención de inscripciones duplicadas (constraint único)
- Cálculo automático de promedio por inscripción
- Relación con calificaciones
- Validación de estudiante y materia existentes

**Estados:**
- `activa` - Inscripción vigente
- `completada` - Materia terminada
- `cancelada` - Inscripción cancelada

**Rutas:**
- `GET /inscripciones` - Listar todas
- `GET /inscripciones/create` - Formulario crear
- `POST /inscripciones` - Guardar
- `GET /inscripciones/{id}` - Ver detalles
- `GET /inscripciones/{id}/edit` - Formulario editar
- `PUT /inscripciones/{id}` - Actualizar
- `DELETE /inscripciones/{id}` - Eliminar

---

### 4. 📊 Calificaciones
**Descripción:** Registro de notas y evaluaciones por inscripción

**Campos:**
- inscripcion_id (FK), Nota (0-5), Tipo (Parcial 1, Parcial 2, Final, etc)
- Fecha de Evaluación, Observaciones
- Timestamps

**Funcionalidades:**
- CRUD completo
- Validación de nota entre 0 y 5
- Colores dinámicos: verde (≥4.0), naranja (≥3.0), rojo (<3.0)
- Múltiples evaluaciones por inscripción
- Cálculo automático de promedio

**Tipos de Evaluación:**
- Parcial 1, Parcial 2, Parcial 3
- Final
- Trabajo Práctico

**Rutas:**
- `GET /calificaciones` - Listar todas
- `GET /calificaciones/create` - Formulario crear
- `POST /calificaciones` - Guardar
- `GET /calificaciones/{id}` - Ver detalles
- `GET /calificaciones/{id}/edit` - Formulario editar
- `PUT /calificaciones/{id}` - Actualizar
- `DELETE /calificaciones/{id}` - Eliminar

---

## 📊 Dashboard

**URL:** `GET /` (página principal)

El dashboard muestra:

### Tarjetas de Resumen (4)
- **Total Estudiantes** (azul) - Contador y enlace
- **Total Materias** (verde) - Contador y enlace
- **Total Inscripciones** (cian) - Contador y enlace
- **Total Calificaciones** (naranja) - Contador y enlace

### Resumen Académico (2)
- **Promedio General** - Promedio de todas las calificaciones con indicador visual
- **Calificaciones Bajas** - Monitoreo de estudiantes con notas < 3.0

### Datos Recientes (3)
- **Estudiantes Recientes** - Últimos 5 estudiantes registrados
- **Materias Más Inscritas** - Top 5 con contador de inscritos
- **Inscripciones Recientes** - Tabla con últimas 5 inscripciones

---

## 🗄️ Consultas PostgreSQL

### Conexión a PostgreSQL
```bash
# Desde terminal
psql -h 127.0.0.1 -U postgres -d crud-laravel

# Contraseña: 12345678
```

### Consultas Útiles

#### 1. ✅ Ver todas las tablas creadas
```sql
SELECT table_name 
FROM information_schema.tables 
WHERE table_schema = 'public' 
ORDER BY table_name;
```
**Resultado:** Lista de 10 tablas (users, cache, jobs, sessions, password_reset_tokens, estudiantes, materias, inscripcions, calificacions)

---

#### 2. 👥 Listar todos los estudiantes con sus emails
```sql
SELECT id, nombre, apellido, email, cedula 
FROM estudiantes 
ORDER BY nombre;
```
**Descripción:** Obtiene información básica de todos los estudiantes registrados.

---

#### 3. 📖 Listar todas las materias con profesor y créditos
```sql
SELECT id, nombre, codigo, profesor, creditos 
FROM materias 
ORDER BY nombre;
```
**Descripción:** Muestra todas las materias disponibles con su información.

---

#### 4. 📋 Ver inscripciones con nombre de estudiante y materia
```sql
SELECT 
    i.id,
    e.nombre || ' ' || e.apellido AS estudiante,
    m.nombre AS materia,
    i.fecha_inscripcion,
    i.estado
FROM inscripcions i
JOIN estudiantes e ON i.estudiante_id = e.id
JOIN materias m ON i.materia_id = m.id
ORDER BY i.fecha_inscripcion DESC;
```
**Descripción:** Muestra todas las inscripciones con información del estudiante y materia asociada. Ordenado por más reciente primero.

---

#### 5. 📊 Ver calificaciones de un estudiante
```sql
SELECT 
    e.nombre || ' ' || e.apellido AS estudiante,
    m.nombre AS materia,
    c.tipo,
    c.nota,
    c.fecha
FROM calificacions c
JOIN inscripcions i ON c.inscripcion_id = i.id
JOIN estudiantes e ON i.estudiante_id = e.id
JOIN materias m ON i.materia_id = m.id
WHERE e.nombre = 'Marlon'  -- Cambiar por nombre del estudiante
ORDER BY m.nombre, c.fecha;
```
**Descripción:** Obtiene todas las calificaciones de un estudiante específico organizadas por materia.

---

#### 6. 🎯 Calcular promedio por estudiante
```sql
SELECT 
    e.id,
    e.nombre || ' ' || e.apellido AS estudiante,
    ROUND(AVG(c.nota)::numeric, 2) AS promedio_general
FROM estudiantes e
LEFT JOIN inscripcions i ON e.id = i.estudiante_id
LEFT JOIN calificacions c ON i.id = c.inscripcion_id
GROUP BY e.id, e.nombre, e.apellido
ORDER BY promedio_general DESC;
```
**Descripción:** Calcula el promedio general de cada estudiante en todas sus materias. ROUND redondea a 2 decimales.

---

#### 7. ⚠️ Estudiantes con bajo rendimiento (< 3.0)
```sql
SELECT 
    e.nombre || ' ' || e.apellido AS estudiante,
    m.nombre AS materia,
    ROUND(AVG(c.nota)::numeric, 2) AS promedio_materia
FROM estudiantes e
JOIN inscripcions i ON e.id = i.estudiante_id
JOIN materias m ON i.materia_id = m.id
JOIN calificacions c ON i.id = c.inscripcion_id
GROUP BY e.id, e.nombre, e.apellido, m.id, m.nombre
HAVING AVG(c.nota) < 3.0
ORDER BY promedio_materia;
```
**Descripción:** Identifica estudiantes con promedio menor a 3.0 por materia para seguimiento académico.

---

#### 8. 📚 Materias más inscritas
```sql
SELECT 
    m.id,
    m.nombre,
    m.codigo,
    COUNT(i.id) AS cantidad_inscritos
FROM materias m
LEFT JOIN inscripcions i ON m.id = i.materia_id
GROUP BY m.id, m.nombre, m.codigo
ORDER BY cantidad_inscritos DESC;
```
**Descripción:** Muestra cuántos estudiantes están inscritos en cada materia.

---

#### 9. 🏆 Estudiante con mejor promedio
```sql
SELECT 
    e.id,
    e.nombre || ' ' || e.apellido AS estudiante,
    ROUND(AVG(c.nota)::numeric, 2) AS promedio_general
FROM estudiantes e
JOIN inscripcions i ON e.id = i.estudiante_id
JOIN calificacions c ON i.id = c.inscripcion_id
GROUP BY e.id, e.nombre, e.apellido
ORDER BY promedio_general DESC
LIMIT 1;
```
**Descripción:** Obtiene el estudiante con el mejor promedio académico.

---

#### 10. 📈 Estadísticas generales de calificaciones
```sql
SELECT 
    COUNT(*) AS total_calificaciones,
    ROUND(AVG(nota)::numeric, 2) AS promedio_general,
    ROUND(MIN(nota)::numeric, 2) AS nota_minima,
    ROUND(MAX(nota)::numeric, 2) AS nota_maxima,
    ROUND(STDDEV(nota)::numeric, 2) AS desviacion_estandar
FROM calificacions;
```
**Descripción:** Mostrar estadísticas generales: cantidad de notas, promedio, mínimo, máximo y desviación estándar.

---

#### 11. 🔄 Inscripciones activas de un estudiante
```sql
SELECT 
    e.nombre || ' ' || e.apellido AS estudiante,
    m.nombre AS materia,
    m.profesor,
    i.estado,
    i.fecha_inscripcion
FROM inscripcions i
JOIN estudiantes e ON i.estudiante_id = e.id
JOIN materias m ON i.materia_id = m.id
WHERE e.cedula = '1143349074' AND i.estado = 'activa'  -- Cambiar cédula
ORDER BY m.nombre;
```
**Descripción:** Ver todas las materias activas en las que está inscrito un estudiante específico.

---

#### 12. 📋 Profesores y sus materias
```sql
SELECT 
    profesor,
    COUNT(*) AS cantidad_materias,
    STRING_AGG(nombre, ', ' ORDER BY nombre) AS materias
FROM materias
GROUP BY profesor
ORDER BY cantidad_materias DESC;
```
**Descripción:** Muestra cada profesor con la cantidad de materias que imparte y sus nombres.

---

#### 13. 🎓 Transcripción académica completa
```sql
SELECT 
    e.nombre || ' ' || e.apellido AS estudiante,
    e.cedula,
    m.nombre AS materia,
    m.codigo,
    m.creditos,
    ROUND(AVG(c.nota)::numeric, 2) AS nota_final
FROM estudiantes e
JOIN inscripcions i ON e.id = i.estudiante_id
JOIN materias m ON i.materia_id = m.id
LEFT JOIN calificacions c ON i.id = c.inscripcion_id
WHERE e.id = 1  -- Cambiar por ID del estudiante
GROUP BY e.id, e.nombre, e.apellido, e.cedula, m.id, m.nombre, m.codigo, m.creditos
ORDER BY m.nombre;
```
**Descripción:** Genera una transcripción académica completa de un estudiante específico con créditos.

---

## 🛣️ Rutas y Endpoints

### Ruta Principal
| Método | URL | Controlador | Método |
|--------|-----|-------------|--------|
| GET | `/` | DashboardController | index |
| GET | `/dashboard` | DashboardController | index |

### Rutas CRUD (4 módulos × 7 rutas = 28 rutas)

Cada módulo (estudiantes, materias, inscripciones, calificaciones) sigue el patrón estándar RESTful:

```
GET    /estudiantes              → index    (listar)
GET    /estudiantes/create       → create   (formulario crear)
POST   /estudiantes              → store    (guardar)
GET    /estudiantes/{id}         → show     (ver detalles)
GET    /estudiantes/{id}/edit    → edit     (formulario editar)
PUT    /estudiantes/{id}         → update   (actualizar)
DELETE /estudiantes/{id}         → destroy  (eliminar)
```

Lo mismo para `/materias`, `/inscripciones`, `/calificaciones`.

---

## 💻 Cómo Usar el Sistema

### 1. Acceder al Dashboard
```
http://localhost:8000
```

Verás una página con resumen de estadísticas y enlaces a cada módulo.

### 2. Crear un Estudiante
1. Haz clic en "Estudiantes" → "Nuevo Estudiante"
2. Completa:
   - Nombre, Apellido
   - Email (único)
   - Cédula (única)
   - Fecha de Nacimiento, Teléfono, Dirección (opcionales)
3. Haz clic en "Guardar"

### 3. Crear una Materia
1. Haz clic en "Materias" → "Nueva Materia"
2. Completa:
   - Nombre
   - Código (ej: MAT101 - debe ser único)
   - Créditos (1-10)
   - Profesor
   - Descripción, Horas por Semana
3. Haz clic en "Guardar"

### 4. Inscribir Estudiante en Materia
1. Haz clic en "Inscripciones" → "Nueva Inscripción"
2. Selecciona:
   - Estudiante (dropdown)
   - Materia (dropdown)
   - Fecha de Inscripción
   - Estado (activa/completada/cancelada)
3. Si el estudiante ya está inscrito, verás un error
4. Haz clic en "Guardar"

### 5. Registrar Calificaciones
1. Haz clic en "Calificaciones" → "Registrar Calificación"
2. Completa:
   - Inscripción (dropdown: mostrar estudiante + materia)
   - Nota (0.00 - 5.00)
   - Tipo (Parcial 1, Parcial 2, Final, etc)
   - Fecha
   - Observaciones (opcional)
3. Haz clic en "Guardar"
4. **El promedio se calcula automáticamente** en la vista de inscripción

### 6. Ver Promedios
En la lista de **Inscripciones**, ves el promedio de cada una.
En el **Dashboard**, ves el promedio general de todos los estudiantes.

### 7. Monitorear Bajo Rendimiento
En el **Dashboard**, la sección "Calificaciones Bajas" muestra automáticamente estudiantes con notas < 3.0.

---

## 🔑 Características Técnicas Implementadas

- ✅ **Relaciones Eloquent**
  - `Estudiante hasMany Inscripcion`
  - `Materia hasMany Inscripcion`
  - `Inscripcion hasMany Calificacion`

- ✅ **Métodos Calculados**
  - `Estudiante::promedio_general()` - Promedio total
  - `Inscripcion::promedio()` - Promedio por materia

- ✅ **Validaciones**
  - Email y cédula únicos
  - Código de materia único
  - Prevención de inscripciones duplicadas
  - Rango de notas (0-5)

- ✅ **Sincronización Automática**
  - Campos `created_at`, `updated_at`
  - Eliminación cascada (borrar inscripción elimina calificaciones)

- ✅ **Bootstrap 5**
  - Tablas responsivas
  - Formularios con validación visual
  - Badges y colores dinámicos
  - Navbar con dropdowns

---

## 📞 Soporte y Documentación

Para más información sobre Laravel:
- [Documentación oficial de Laravel](https://laravel.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Blade Templating](https://laravel.com/docs/blade)

Para PostgreSQL:
- [Documentación oficial](https://www.postgresql.org/docs/current/)
- [psql comands](https://www.postgresql.org/docs/current/app-psql.html)

---

**Última actualización:** 14 de Abril de 2026
