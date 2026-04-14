# CRUD de Estudiantes - Laravel 12 con PostgreSQL

## 📋 Tabla de Contenidos
1. [Introducción](#introducción)
2. [Problemas Solucionados](#problemas-solucionados)
3. [Tecnologías Utilizadas](#tecnologías-utilizadas)
4. [Estructura del Proyecto](#estructura-del-proyecto)
5. [Instalación y Configuración](#instalación-y-configuración)
6. [Explicación Técnica del CRUD](#explicación-técnica-del-crud)
7. [Rutas y Endpoints](#rutas-y-endpoints)
8. [Modelos y Base de Datos](#modelos-y-base-de-datos)
9. [Comandos Utilizados](#comandos-utilizados)
10. [Cómo Usar el CRUD](#cómo-usar-el-crud)

---

## 🎯 Introducción

Este proyecto es un **CRUD (Create, Read, Update, Delete) de estudiantes** desarrollado con **Laravel 12** y **PostgreSQL**. Permite gestionar un registro de estudiantes con campos como nombre, apellido, email, cédula, fecha de nacimiento, teléfono y dirección.

El proyecto incluye:
- ✅ Base de datos PostgreSQL (servidor robusto y profesional)
- ✅ Interfaces web con Blade (HTML interactivo)
- ✅ Validación de formularios
- ✅ Gestión completa de estudiantes (crear, listar, editar, eliminar)
- ✅ Bootstrap 5 para diseño responsivo

---

## 🔧 Problemas Solucionados

### Problema 1: Incompatibilidad de Node.js v24 con Vite
**Síntoma:** Error `SyntaxError: Invalid or unexpected token` al ejecutar `composer run dev`

**Causa:** Node.js v24 es demasiado nuevo y no es compatible con Vite (herramienta de compilación de frontend)

**Solución:** 
- Cambiar la configuración a usar **SQLite** en lugar de PostgreSQL
- Limpiar el caché de Node.js y reinstalar dependencias
- Actualizar autoloader de Composer

### Problema 2: Falta de extensión PCNTL en Windows
**Síntoma:** Comando `php artisan pail` no funciona

**Causa:** PCNTL es una extensión de PHP solo disponible en Linux/Unix

**Solución:** 
- Eliminar la línea `php artisan pail --timeout=0` del comando de desarrollo en `composer.json`

### Problema 3: Controlador no reconocido
**Síntoma:** Error `Target class [EstudianteController] does not exist`

**Causa:** Caché desactualizado de rutas

**Solución:**
- Regenerar autoloader con `composer dump-autoload`
- Limpiar caché de rutas con `php artisan route:clear`

### Problema 4: Fechas como strings en la vista
**Síntoma:** Error `Call to a member function format() on string`

**Causa:** Laravel no convertía el campo `fecha_nacimiento` a objeto DateTime

**Solución:**
- Agregar `casts` al modelo para convertir la fecha automáticamente

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
│   │       └── EstudianteController.php    ← Controlador CRUD
│   └── Models/
│       └── Estudiante.php                  ← Modelo de datos
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── 0001_01_01_000001_create_cache_table.php
│       ├── 0001_01_01_000002_create_jobs_table.php
│       └── 2026_04_13_202124_create_estudiantes_table.php  ← Nuestra tabla
├── resources/
│   ├── views/
│   │   ├── layout.blade.php                ← Layout base con navbar
│   │   └── estudiantes/
│   │       ├── index.blade.php             ← Listar estudiantes
│   │       ├── create.blade.php            ← Formulario crear
│   │       ├── show.blade.php              ← Ver detalles
│   │       └── edit.blade.php              ← Formulario editar
├── routes/
│   └── web.php                             ← Definición de rutas
├── .env                                    ← Configuración del proyecto
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

### Paso 3: Configurar variables de entorno
El archivo `.env` ya viene configurado con:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=crud-laravel
DB_USERNAME=postgres
DB_PASSWORD=12345678
APP_URL=http://localhost
```

**Si necesitas cambiar algo:**
- Abre `.env` y edita los valores
- Asegúrate de que PostgreSQL esté corriendo en tu máquina

### Paso 4: Generar clave de encriptación
```bash
php artisan key:generate
```

**¿Qué hace?** Genera una clave única para encriptar datos sensibles (sesiones, cookies, etc.)

### Paso 5: Ejecutar las migraciones
```bash
php artisan migratePostgreSQL
```

**¿Qué hace?** 
- Lee los archivos en `database/migrations/`
- Crea las tablas en la base de datos SQLite:
  - `users` (usuarios del sistema)
  - `cache` (almacenamiento en caché)
  - `jobs` (trabajos en cola)
  - `estudiantes` (nuestra tabla)

### Paso 6: Instalar dependencias de Node.js (Frontend)
```bash
npm install
```

**¿Qué hace?** Descarga paquetes JavaScript necesarios para compilar Vite

### Paso 7: Iniciar el servidor de desarrollo
```bash
composer run dev
```

**¿Qué hace?** Ejecuta simultáneamente:
- `php artisan serve` - Servidor Laravel en puerto 8000
- `php artisan queue:listen` - Procesador de trabajos en cola
- `npm run dev` - Compilador Vite en puerto 5173

**Accede aquí:** http://127.0.0.1:8000/estudiantes

---

## 🏗️ Explicación Técnica del CRUD

### ¿Qué es un CRUD?
**CRUD** es un acrónimo que significa:
- Create (Crear) - Agregar nuevos registros
- Read (Leer) - Consultar registros existentes
- Update (Actualizar) - Modificar registros
- Delete (Eliminar) - Borrar registros

### Flujo de Funcionamiento

```
Usuario hace clic en URL
    ↓
Laravel busca en routes/web.php
    ↓
Encuentra EstudianteController
    ↓
Ejecuta el método correspondiente (index, create, show, edit, etc.)
    ↓
Controlador accede al modelo Estudiante
    ↓
Modelo consulta la base de datos SQLite
    ↓
Datos se envían a la vista Blade
    ↓
Blade genera HTML y lo envía al navegador
    ↓
Usuario ve la página
```

### 1. Modelo Estudiante (`app/Models/Estudiante.php`)

```php
class Estudiante extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'email', 'cedula',
        'fecha_nacimiento', 'telefono', 'direccion',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];
}
```

**¿Qué hace?**
- **Hereda de `Model`**: Indica que representa una tabla en la BD
- **`$fillable`**: Lista de campos que se pueden asignar masivamente (protección contra inyección)
- **`$casts`**: Convierte automáticamente `fecha_nacimiento` a un objeto Date (permite usar `->format()`)

### 2. Controlador (`app/Http/Controllers/EstudianteController.php`)

El controlador tiene 7 métodos principales:

#### a. `index()` - Listar todos
```php
public function index()
{
    $estudiantes = Estudiante::all();
    return view('estudiantes.index', compact('estudiantes'));
}
```
- Obtiene todos los estudiantes: `Estudiante::all()`
- Envía a la vista `estudiantes.index` con los datos

#### b. `create()` - Mostrar formulario de creación
```php
public function create()
{
    return view('estudiantes.create');
}
```
- Retorna una vista con un formulario vacío

#### c. `store()` - Guardar nuevo estudiante
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|unique:estudiantes,email',
        // ... más validaciones
    ]);
    
    Estudiante::create($validated);
    return redirect()->route('estudiantes.index');
}
```
- Valida los datos del formulario
- Crea un nuevo registro en la BD
- Redirige a la lista

**Validaciones:**
- `required` - Campo obligatorio
- `email` - Debe ser un email válido
- `unique` - No puede repetirse en la BD
- `max:255` - Máximo 255 caracteres

#### d. `show()` - Ver detalles de un estudiante
```php
public function show(Estudiante $estudiante)
{
    return view('estudiantes.show', compact('estudiante'));
}
```
- Laravel inyecta automáticamente el estudiante (Route Model Binding)
- Muestra todos los datos del estudiante

#### e. `edit()` - Mostrar formulario de edición
```php
public function edit(Estudiante $estudiante)
{
    return view('estudiantes.edit', compact('estudiante'));
}
```
- Similar a `create()` pero con los datos pre-rellenados

#### f. `update()` - Guardar cambios
```php
public function update(Request $request, Estudiante $estudiante)
{
    $validated = $request->validate([...]);
    
    $estudiante->update($validated);
    return redirect()->route('estudiantes.index');
}
```
- Valida y actualiza los datos
- Las validaciones de `unique` incluyen una exclusión del ID actual

#### g. `destroy()` - Eliminar
```php
public function destroy(Estudiante $estudiante)
{
    $estudiante->delete();
    return redirect()->route('estudiantes.index');
}
```
- Elimina el registro
- Redirige a la lista

### 3. Migraciones (`database/migrations/`)

Una migración crea la estructura de la tabla:

```php
public function up(): void
{
    Schema::create('estudiantes', function (Blueprint $table) {
        $table->id();                                    // ID auto-incremental
        $table->string('nombre');                       // VARCHAR(255)
        $table->string('apellido');                     // VARCHAR(255)
        $table->string('email')->unique();              // Email único
        $table->string('cedula')->unique();             // Cédula única
        $table->date('fecha_nacimiento')->nullable();   // Fecha (opcional)
        $table->string('telefono')->nullable();         // VARCHAR (opcional)
        $table->text('direccion')->nullable();          // Texto largo (opcional)
        $table->timestamps();                           // created_at, updated_at
    });
}
```

---

## 🛣️ Rutas y Endpoints

Las rutas se definen en `routes/web.php`:

```php
Route::resource('estudiantes', EstudianteController::class);
```

Esto genera automáticamente 7 rutas:

| Método HTTP | URL | Acción | Vista |
|-------------|-----|--------|-------|
| GET | `/estudiantes` | Listar todos | index |
| GET | `/estudiantes/create` | Mostrar formulario | create |
| POST | `/estudiantes` | Guardar nuevo | (redirige) |
| GET | `/estudiantes/{id}` | Ver detalles | show |
| GET | `/estudiantes/{id}/edit` | Mostrar para editar | edit |
| PUT/PATCH | `/estudiantes/{id}` | Actualizar | (redirige) |
| DELETE | `/estudiantes/{id}` | Eliminar | (redirige) |

---

## 🗄️ Modelos y Base de Datos

### PostgreSQL

**Configuración de PostgreSQL en este proyecto:**

PostreSQL es un sistema de administración de bases de datos relacional robusto, escalable y profesional. Es ideal para:
- Aplicaciones en producción
- Seguridad mejorada
- Características avanzadas (transacciones, integridad referencial, etc.)
- Mejor rendimiento en aplicaciones grandes

**Configuración utilizada:**
- **Host:** 127.0.0.1 (localhost)
- **Puerto:** 5432 (puerto por defecto)
- **Base de datos:** crud-laravel
- **Usuario:** postgres
- **Contraseña:** 12345678

### Archivo de Base de Datos

La BD de PostgreSQL se almacena en el servidor PostgreSQL local. No es un archivo como en SQLite, sino un servidor que gestiona los datos automáticamente.

---

## 💻 Comandos Utilizados

### Comandos de Composer (PHP)

```bash
# Instalar dependencias
composer install

# Crear modelo y migración juntos
php artisan make:model Estudiante -m

# Crear controlador CRUD
php artisan make:controller EstudianteController -r

# Ejecutar migraciones
php artisan migrate

# Ejecutar migraciones desde cero (peligroso en producción)
php artisan migrate:fresh

# Regenerar autoloader
composer dump-autoload

# Limpiar caches
php artisan config:cache
php artisan route:cache
php artisan route:clear
php artisan view:clear

# Iniciar servidor de desarrollo
php artisan serve

# Procesar trabajos en cola
php artisan queue:listen
```

### Comandos de NPM (Node.js)

```bash
# Instalar paquetes
npm install

# Compilar assets (producción)
npm run build

# Compilar con observación en tiempo real (desarrollo)
npm run dev
```

### Comandos de Desarrollo

```bash
# Comando personalizado que ejecuta todo junto
composer run dev
```

En `composer.json` está definido como:
```json
"dev": [
    "Composer\\Config::disableProcessTimeout",
    "npx concurrently ... \"php artisan serve\" \"php artisan queue:listen\" \"npm run dev\""
]
```

---

## 📱 Cómo Usar el CRUD

### 1. Acceder a la aplicación
```
Abre tu navegador y ve a: http://127.0.0.1:8000/estudiantes
```

### 2. Ver estudiantes
- Se muestra una tabla con todos los estudiantes registrados
- Cada fila tiene botones: **Ver**, **Editar**, **Eliminar**

### 3. Crear un nuevo estudiante
- Haz clic en "Nuevo Estudiante"
- Completa el formulario:
  - **Nombre** (obligatorio)
  - **Apellido** (obligatorio)
  - **Email** (obligatorio, debe ser único)
  - **Cédula** (obligatoria, debe ser única)
  - **Fecha de Nacimiento** (opcional)
  - **Teléfono** (opcional)
  - **Dirección** (opcional)
- Haz clic en "Guardar"

### 4. Ver detalles de un estudiante
- En la tabla, haz clic en "Ver"
- Se muestra toda la información del estudiante
- Muestra además las fechas de creación y última actualización

### 5. Editar un estudiante
- En la tabla, haz clic en "Editar"
- Modifica los campos que desees
- Haz clic en "Guardar Cambios"

### 6. Eliminar un estudiante
- En la tabla o en la vista de detalles, haz clic en "Eliminar"
- Confirma la eliminación
- El estudiante se borra permanentemente

---

## 🎨 Vistas Blade Explicadas

### `layout.blade.php` - Layout base
```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <!-- Navegación -->
    </nav>
    
    <div class="container mt-5">
        @if ($errors->any())
            <!-- Mostrar errores de validación -->
        @endif
        
        @if (session('success'))
            <!-- Mostrar mensajes de éxito -->
        @endif
        
        @yield('content')  <!-- Contenido específico de cada vista -->
    </div>
</body>
</html>
```

**Conceptos Blade:**
- `@if`, `@else`, `@endif` - Condicionales
- `@yield('content')` - Espacio donde va el contenido de cada vista
- `{{ $variable }}` - Imprime una variable (escapada por seguridad)
- `{!! $html !!}` - Imprime HTML sin escapar (cuidado con inyecciones)

### `index.blade.php` - Listar estudiantes
```blade
@extends('layout')  <!-- Hereda de layout.blade.php -->

@section('title', 'Listado de Estudiantes')

@section('content')
    <h1>Estudiantes</h1>
    
    @if($estudiantes->isEmpty())
        <p>No hay estudiantes</p>
    @else
        <table class="table">
            @foreach($estudiantes as $estudiante)
                <tr>
                    <td>{{ $estudiante->nombre }}</td>
                    <!-- ... más columnas ... -->
                </tr>
            @endforeach
        </table>
    @endif
@endsection
```

### `create.blade.php` y `edit.blade.php` - Formularios
```blade
<form method="POST" action="{{ route('estudiantes.store') }}">
    @csrf  <!-- Token CSRF para seguridad -->
    
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" 
               name="nombre" 
               value="{{ old('nombre') }}"
               class="form-control @error('nombre') is-invalid @enderror">
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- ... más campos ... -->
    
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
```

**Conceptos importantes:**
- `@csrf` - Token CSRF (protección contra ataques)
- `old('campo')` - Rellena el campo con datos anteriores si hubo error
- `@error('campo')` - Muestra errores de validación
- `route('nombre_ruta')` - Genera URLs automáticamente

---

## 🔐 Seguridad Implementada

### 1. **Validación de entrada**
```php
$request->validate([
    'nombre' => 'required|string|max:255',
    'email' => 'required|email|unique:estudiantes,email',
]);
```
- Los datos se validan antes de guardarse en la BD

### 2. **Protección CSRF**
```blade
@csrf
```
- Cada formulario incluye un token CSRF único
- Laravel verifica que el formulario venga de tu aplicación

### 3. **Escapado en vistas**
```blade
{{ $estudiante->nombre }}  <!-- Escapa HTML automáticamente -->
```
- Las variables se escapan por defecto (previene XSS)

### 4. **SQL Injection prevención**
```php
Estudiante::where('email', $email)->first();  // Usa prepared statements
```
- Laravel usa prepared statements automáticamente

---

## 📊 Base de Datos - Tabla Estudiantes

```sql
CREATE TABLE estudiantes (
    id INTEGER PRIMARY KEY,
    nombre VARCHAR(255),
    apellido VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    cedula VARCHAR(255) UNIQUE,
    fecha_nacimiento DATE,
    telefono VARCHAR(255),
    direccion TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🚨 Problemas Comunes

### Error: "Target class [EstudianteController] does not exist"
**Solución:**
```bash
composer dump-autoload
php artisan route:clear
```

### Error: "No such table: estudiantes"
**Solución:**
```bash
php artisan migrate
```

### Error: "SQLSTATE[HY000]: General error"
**Solución:**
```bash
php artisan migrate:fresh
```
⚠️ Esto borra todos los datos. Úsalo solo en desarrollo.

### Cambios en código no aparecen
**Solución:**
```bash
php artisan config:cache
php artisan route:cache
```

---

## 📈 Próximas Mejoras Posibles

- [ ] Agregar autenticación de usuarios
- [ ] Implementar paginación en la lista
- [ ] Agregar búsqueda y filtros
- [ ] Exportar a PDF o Excel
- [ ] Agregar fotos/avatares
- [ ] Implementar API REST (JSON)
- [ ] Agregar tests automatizados
- [ ] Desplegar en producción con PostgreSQL

---

## 📚 Recursos Útiles

- [Documentación oficial de Laravel](https://laravel.com/docs)
- [Blade - Motor de plantillas](https://laravel.com/docs/12.x/blade)
- [Validación en Laravel](https://laravel.com/docs/12.x/validation)
- [Eloquent ORM](https://laravel.com/docs/12.x/eloquent)
- [Bootstrap 5](https://getbootstrap.com/)

---

## 👨‍💻 Autor
Proyecto CRUD de Estudiantes - Abril 2026
