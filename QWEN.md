# Sistema CRUD Universitario - Contexto QWEN

## Descripción del Proyecto

Este es un **Sistema de Gestión Universitaria CRUD** construido con **Laravel 12** y **PostgreSQL**. Proporciona una aplicación web completa para gestionar la información académica de una universidad, incluyendo estudiantes, materias, inscripciones y calificaciones con cálculo automático de promedios.

### Características Principales
- **4 Módulos CRUD**: Estudiantes, Materias, Inscripciones, Calificaciones
- **Base de Datos Relacional**: Claves foráneas completas e integridad referencial
- **Dashboard**: Estadísticas, alertas de bajo rendimiento, materias populares
- **Cálculos Automáticos**: Promedio por curso y promedio general del estudiante
- **Validación de Datos**: Prevención de duplicados, emails únicos, validación de rango de notas (0-5)
- **UI Responsiva**: Bootstrap 5 con diseño moderno

## Tecnologías

| Tecnología | Versión | Propósito |
|-----------|---------|----------|
| Laravel | 12.56.0 | Framework PHP para desarrollo web |
| PHP | 8.2+ | Lenguaje del Backend |
| PostgreSQL | 12+ | Base de datos |
| Blade | (Laravel) | Motor de plantillas |
| Bootstrap | 5.3.0 | Framework CSS |
| Vite | 7.3.2 | Herramienta de compilación frontend |
| Tailwind CSS | 4.0.0 | CSS utilitario |

## Estructura del Proyecto

```
crud-laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── EstudianteController.php
│   │   ├── MateriaController.php
│   │   ├── InscripcionController.php
│   │   └── CalificacionController.php
│   └── Models/
│       ├── Estudiante.php
│       ├── Materia.php
│       ├── Inscripcion.php
│       └── Calificacion.php
├── database/migrations/
│   ├── 2026_04_13_202124_create_estudiantes_table.php
│   ├── 2026_04_14_173831_create_materias_table.php
│   ├── 2026_04_14_173832_create_inscripcions_table.php
│   └── 2026_04_14_173833_create_calificacions_table.php
├── resources/views/
│   ├── layout.blade.php
│   ├── dashboard/index.blade.php
│   ├── estudiantes/{index,create,edit,show}.blade.php
│   ├── materias/{index,create,edit,show}.blade.php
│   ├── inscripciones/{index,create,edit,show}.blade.php
│   └── calificaciones/{index,create,edit,show}.blade.php
├── routes/web.php
├── composer.json
├── package.json
└── vite.config.js
```

## Esquema de la Base de Datos

### Modelos y Relaciones

- **Estudiante**
  - hasMany → Inscripcion
  - Método: `promedio_general()` - calcula el GPA general del estudiante
  
- **Materia**
  - hasMany → Inscripcion
  
- **Inscripcion**
  - belongsTo → Estudiante
  - belongsTo → Materia
  - hasMany → Calificacion
  - Método: `promedio()` - calcula el promedio de notas por inscripción
  
- **Calificacion**
  - belongsTo → Inscripcion

### Restricciones Clave
- Emails y cédulas únicos para estudiantes
- Códigos de materia únicos (ej: MAT101, FIS201)
- Prevención de inscripciones duplicadas (restricción única en estudiante+materia)
- Rango de notas: 0.00 - 5.00

## Construcción y Ejecución

### Requisitos Previos
- PHP 8.2+
- Composer
- Node.js 20.x LTS+
- PostgreSQL 12+

### Comandos de Configuración

```bash
# Instalar dependencias PHP
composer install

# Copiar y configurar .env (ya configurado para PostgreSQL)
# Base de datos por defecto: crud-laravel, Usuario: postgres, Contraseña: 123456789

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones de base de datos
php artisan migrate

# Instalar dependencias de Node.js
npm install

# Iniciar servidor de desarrollo (ejecuta servidor PHP, queue worker y Vite)
composer run dev
```

**Accede a la aplicación en:** http://localhost:8000

### Comandos Útiles

```bash
# Ejecutar pruebas
composer run test

# Compilar assets del frontend
npm run build

# Limpiar caché de configuración
php artisan config:clear

# Configuración completa (instalar, migrar, compilar)
composer run setup
```

## Rutas

### Dashboard
- `GET /` → DashboardController@index
- `GET /dashboard` → DashboardController@index

### Recursos CRUD (28 rutas en total)
Cada módulo sigue el patrón RESTful:
- `GET /{recurso}` → index (listar todos)
- `GET /{recurso}/create` → create (formulario)
- `POST /{recurso}` → store (guardar)
- `GET /{recurso}/{id}` → show (detalles)
- `GET /{recurso}/{id}/edit` → edit (formulario)
- `PUT /{recurso}/{id}` → update (actualizar)
- `DELETE /{recurso}/{id}` → destroy (eliminar)

Recursos: `estudiantes`, `materias`, `inscripciones`, `calificaciones`

## Convenciones de Desarrollo

### Estilo de Código
- Convenciones estándar de Laravel
- Autocarga PSR-4
- Eloquent ORM para operaciones de base de datos
- Controladores de recursos para operaciones CRUD

### Validación
- Validación a nivel de controlador con Laravel Validator
- Restricciones a nivel de base de datos (únicos, claves foráneas)
- Mensajes de error personalizados en español

### Vistas
- Motor de plantillas Blade
- Bootstrap 5 para diseño responsivo
- Layout compartido con barra de navegación
- Codificación de colores dinámica (verde ≥4.0, naranja ≥3.0, rojo <3.0)

### Pruebas
- PHPUnit para pruebas unitarias
- Directorio tests para archivos de prueba

## Notas de Configuración

- Base de datos: PostgreSQL (configurado en .env)
- Sesiones: Driver de base de datos
- Caché: Driver de base de datos
- Colas: Driver de base de datos
- Sistema de archivos: Almacenamiento local
- Correo: Driver de registro (desarrollo)

## Lógica de Negocio Clave

1. **Cálculo de Calificaciones**: Los promedios se calculan automáticamente desde los registros de notas relacionados
2. **Prevención de Inscripciones**: Las inscripciones duplicadas se bloquean a nivel de base de datos
3. **Eliminación en Cascada**: Eliminar una inscripción elimina las calificaciones asociadas
4. **Seguimiento de Estado**: Las inscripciones rastrean estado (activa/completada/cancelada)
5. **Analíticas del Dashboard**: Muestra estudiantes de bajo rendimiento, materias populares, actividad reciente

## Archivos Importantes

- `routes/web.php` - Todas las definiciones de rutas
- `app/Models/*.php` - Modelos Eloquent con relaciones
- `app/Http/Controllers/*.php` - Controladores de recursos
- `resources/views/layout.blade.php` - Layout maestro
- `database/migrations/` - Definiciones del esquema de base de datos

## Idioma del Proyecto

**Este proyecto utiliza español como idioma principal.** Todas las interacciones, respuestas, documentación y comunicación deben realizarse en **español**.

- Nombres de variables, métodos y clases pueden estar en español (ej: `Estudiante`, `promedio_general`, `fecha_inscripcion`)
- Mensajes de validación y errores en español
- Documentación y comentarios en español
- Interfaz de usuario completamente en español

