# Sistema CRUD Universitario - QWEN Context

## Project Overview

This is a **University Management System (Sistema de Gestión Universitaria)** built with **Laravel 12** and **PostgreSQL**. It's a full-featured web application for managing academic information including students, courses, enrollments, and grades with automatic GPA calculation.

### Key Features
- **4 CRUD Modules**: Students (Estudiantes), Courses (Materias), Enrollments (Inscripciones), Grades (Calificaciones)
- **AI Chatbot**: Integrated Groq-powered chat assistant for querying database in natural language (Spanish)
- **RESTful API**: Versioned API (v1) with Sanctum authentication
- **Dashboard**: Statistics, low-performance alerts, popular courses, recent activity
- **Automatic Calculations**: Per-enrollment GPA and overall student GPA
- **Audit Trail**: Complete audit log tracking all CRUD operations
- **Data Validation**: Unique emails/IDs, no duplicate enrollments, grade range (0-5)
- **Responsive UI**: Bootstrap 5 with modern design

### Technical Stack

| Technology | Version | Purpose |
|-----------|---------|---------|
| Laravel | 12.56.0 | PHP web framework |
| PHP | 8.2+ | Backend language |
| PostgreSQL | 12+ | Relational database |
| Blade | (Laravel) | Template engine |
| Bootstrap | 5.3.0 | CSS framework |
| Vite | 7.3.2 | Frontend build tool |
| Tailwind CSS | 4.0.0 | Utility CSS |
| Alpine.js | 3.4.2 | Lightweight JS framework |
| Groq API | Mixtral 8x7b | AI chatbot LLM |
| Laravel Sanctum | 4.3 | API authentication |

---

## Project Structure

```
crud-laravel/
├── app/
│   ├── Enums/                          # Status/type enums
│   │   ├── CalificacionTipo.php        # Grade types (Parcial, Final, etc)
│   │   └── InscripcionEstado.php       # Enrollment states (activa, completada, cancelada)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/V1/                 # API controllers (RESTful)
│   │   │   ├── Auth/                   # Authentication controllers
│   │   │   ├── AuditController.php     # Audit log controller
│   │   │   ├── ChatController.php      # AI chatbot controller
│   │   │   ├── DashboardController.php # Dashboard controller
│   │   │   └── [Resource Controllers]  # CRUD controllers
│   │   └── Requests/                   # Form request validation
│   ├── Models/                         # Eloquent models
│   │   ├── Audit.php                   # Audit log model
│   │   ├── Calificacion.php            # Grade model
│   │   ├── Estudiante.php              # Student model
│   │   ├── Inscripcion.php             # Enrollment model
│   │   ├── Materia.php                 # Course model
│   │   └── User.php                    # User model
│   ├── Services/                       # Business logic services
│   │   ├── DashboardService.php        # Dashboard statistics
│   │   ├── GradeCalculationService.php # GPA calculations
│   │   └── GroqService.php             # AI chatbot integration
│   ├── Traits/
│   │   └── Auditable.php               # Audit trail trait
│   └── View/                           # View components
├── database/migrations/                # Database schema
├── resources/views/                    # Blade templates
│   ├── components/                     # Reusable components
│   │   └── chat-widget.blade.php       # AI chat bubble
│   ├── layouts/                        # Layout templates
│   ├── [module]/                       # Module-specific views
│   └── dashboard/                      # Dashboard views
├── routes/
│   ├── web.php                         # Web routes
│   └── auth.php                        # Authentication routes
├── tests/                              # PHPUnit tests
├── config/                             # Laravel configuration
├── public/                             # Public assets
└── storage/                            # File storage
```

---

## Database Schema

### Models & Relationships

```
Estudiante (Student)
├── hasMany → Inscripcion
├── Methods: promedio_general(), nombre_completo (accessor)
└── Scopes: buscar(), recientes(), conPromedio()

Materia (Course)
├── hasMany → Inscripcion
└── Unique: codigo (e.g., MAT101)

Inscripcion (Enrollment)
├── belongsTo → Estudiante
├── belongsTo → Materia
├── hasMany → Calificacion
├── Methods: promedio(), esActiva(), estaCompletada()
├── Scopes: activas(), completadas(), canceladas()
└── Enum: estado (InscripcionEstado)

Calificacion (Grade)
├── belongsTo → Inscripcion
├── Validation: nota (0.00 - 5.00)
└── Enum: tipo (CalificacionTipo)

Audit (Audit Log)
├── tracks: created, updated, deleted actions
├── stores: old_values, new_values, user_id, ip_address
└── Applied via: Auditable trait on models
```

### Key Database Constraints
- **Unique**: student email, student cedula (ID), course codigo
- **Foreign Keys**: inscripcion → estudiante, inscripcion → materia, calificacion → inscripcion
- **Unique Composite**: estudiante_id + materia_id (prevent duplicate enrollments)
- **Check**: nota range 0-5

---

## Building and Running

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 20.x LTS+
- PostgreSQL 12+

### Initial Setup

```bash
# Install PHP dependencies
composer install

# Copy and configure .env (PostgreSQL already configured)
# Database: crud-laravel, User: postgres, Password: 123456789

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Install Node dependencies
npm install

# Start development server (PHP server, queue worker, and Vite)
composer run dev
```

**Access the application at:** http://localhost:8000

### Common Commands

```bash
# Run tests
composer run test

# Build frontend assets
npm run build

# Clear configuration cache
php artisan config:clear

# Full setup (install, migrate, build)
composer run setup

# Start development server
composer run dev
```

### Available Scripts (composer.json)

| Command | Description |
|---------|-------------|
| `composer run setup` | Full setup: install deps, generate key, migrate, npm install, build |
| `composer run dev` | Start dev server (PHP, queue, Vite) |
| `composer run test` | Clear config and run tests |

---

## Routes

### Dashboard
- `GET /` → DashboardController@index (authenticated)
- `GET /dashboard` → DashboardController@index (authenticated)

### CRUD Resources (4 modules × 7 routes = 28 routes)
All resources follow standard RESTful pattern with `auth` middleware:

| Resource | Base URL | Controller |
|----------|----------|------------|
| Students | `/estudiantes` | EstudianteController |
| Courses | `/materias` | MateriaController |
| Enrollments | `/inscripciones` | InscripcionController |
| Grades | `/calificaciones` | CalificacionController |

Standard routes per resource:
- `GET /{resource}` → index (list all)
- `GET /{resource}/create` → create (form)
- `POST /{resource}` → store (save)
- `GET /{resource}/{id}` → show (details)
- `GET /{resource}/{id}/edit` → edit (form)
- `PUT /{resource}/{id}` → update (save)
- `DELETE /{resource}/{id}` → destroy (delete)

### Audit Log
- `GET /audits` → AuditController@index
- `GET /audits/{id}` → AuditController@show

### API Endpoints (v1)
Prefix: `/api/v1` with `auth:sanctum` middleware:
- `GET/POST/PUT/DELETE /api/v1/estudiantes`
- `GET/POST/PUT/DELETE /api/v1/materias`
- `GET/POST/PUT/DELETE /api/v1/inscripciones`
- `GET/POST/PUT/DELETE /api/v1/calificaciones`

### Chat
- `POST /api/chat/ask` → ChatController@ask (authenticated)

---

## Development Conventions

### Code Style
- Laravel conventions with PSR-4 autoloading
- Eloquent ORM for database operations
- Resource controllers for CRUD operations
- Form Request classes for validation
- Policy-based authorization
- Service classes for business logic
- Traits for shared functionality (e.g., Auditable)

### Architecture Patterns
- **Services**: Business logic separated from controllers (e.g., GradeCalculationService, GroqService)
- **Enums**: Type-safe status values (InscripcionEstado, CalificacionTipo)
- **Traits**: Reusable behavior (Auditable trait logs all model changes)
- **Scopes**: Query scopes for common queries (recientes, activas, etc.)
- **Policies**: Resource-level authorization
- **Form Requests**: Validation in dedicated request classes

### Validation
- Laravel Form Request classes
- Database-level constraints (unique, foreign keys, check constraints)
- Custom error messages in Spanish

### Views
- Blade template engine
- Bootstrap 5 for responsive design
- Shared layout with navbar
- Dynamic color coding (green ≥4.0, orange ≥3.0, red <3.0)
- Alpine.js for interactive components
- Chat widget component (floating bubble)

### Testing
- PHPUnit for unit and feature tests
- Separate test suites: Unit and Feature
- SQLite in-memory database for testing
- Tests directory: `tests/Unit` and `tests/Feature`

---

## Key Business Logic

1. **Grade Calculation**: GPAs calculated automatically via GradeCalculationService using optimized SQL queries
2. **Enrollment Prevention**: Duplicate enrollments blocked at database level (unique constraint)
3. **Cascade Deletion**: Deleting an enrollment deletes associated grades
4. **State Tracking**: Enrollments track state (activa/completada/cancelada) via enum
5. **Audit Trail**: All CRUD operations logged automatically via Auditable trait
6. **AI Chatbot**: Groq-powered assistant answers natural language queries about database
7. **Dashboard Analytics**: Low-performing students, popular courses, recent activity

---

## Configuration

- **Database**: PostgreSQL (configured in .env)
- **Sessions**: Database driver
- **Cache**: Database driver
- **Queues**: Database driver
- **File Storage**: Local
- **Mail**: Log driver (development)
- **API Auth**: Laravel Sanctum

---

## Environment Variables (.env)

Key variables to configure:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=crud-laravel
DB_USERNAME=postgres
DB_PASSWORD=123456789

GROQ_API_KEY=your-groq-api-key  # For AI chatbot
```

---

## Additional Features

### AI Chatbot (Database AI Chat)
- **Location**: Floating bubble in bottom-left corner (authenticated pages)
- **Language**: Spanish responses
- **Powered by**: Groq API (Mixtral 8x7b)
- **Capabilities**: Answer questions about students, courses, grades, enrollments, audit logs
- **Setup**: Add GROQ_API_KEY to .env file
- **Documentation**: See CHATBOT.md for full details

### Audit System
- Automatic logging of all create, update, delete operations
- Tracks: user, action, old/new values, IP address, user agent
- Accessible via `/audits` route
- Applied through Auditable trait on models

### API (v1)
- RESTful API with Sanctum authentication
- Versioned under `/api/v1` prefix
- Covers all 4 main resources
- JSON responses

---

## Important Files

- `routes/web.php` - All web route definitions
- `app/Models/*.php` - Eloquent models with relationships
- `app/Http/Controllers/*.php` - Resource controllers
- `app/Services/GradeCalculationService.php` - GPA calculation logic
- `app/Services/GroqService.php` - AI chatbot integration
- `app/Traits/Auditable.php` - Audit trail implementation
- `resources/views/layout.blade.php` - Master layout
- `database/migrations/` - Database schema definitions
- `composer.json` - PHP dependencies and scripts
- `package.json` - Node dependencies and build scripts
- `.env` - Environment configuration

---

## Language Note

**This project uses Spanish as its primary language.**
- Model names, methods, and variables may be in Spanish (e.g., `Estudiante`, `promedio_general`, `fecha_inscripcion`)
- Validation and error messages are in Spanish
- User interface is entirely in Spanish
- AI chatbot responds in Spanish

---

**Last Updated:** April 15, 2026
**Laravel Version:** 12.56.0
**PHP Version:** 8.2+
