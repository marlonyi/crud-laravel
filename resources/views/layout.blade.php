<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CRUD Estudiantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Sistema Universitario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="estudiantesDropdown" role="button" data-bs-toggle="dropdown">
                            Estudiantes
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="estudiantesDropdown">
                            <li><a class="dropdown-item" href="{{ route('estudiantes.index') }}">Ver Estudiantes</a></li>
                            <li><a class="dropdown-item" href="{{ route('estudiantes.create') }}">Nuevo Estudiante</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="materiasDropdown" role="button" data-bs-toggle="dropdown">
                            Materias
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="materiasDropdown">
                            <li><a class="dropdown-item" href="{{ route('materias.index') }}">Ver Materias</a></li>
                            <li><a class="dropdown-item" href="{{ route('materias.create') }}">Nueva Materia</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="inscripcionesDropdown" role="button" data-bs-toggle="dropdown">
                            Inscripciones
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="inscripcionesDropdown">
                            <li><a class="dropdown-item" href="{{ route('inscripciones.index') }}">Ver Inscripciones</a></li>
                            <li><a class="dropdown-item" href="{{ route('inscripciones.create') }}">Nueva Inscripción</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="calificacionesDropdown" role="button" data-bs-toggle="dropdown">
                            Calificaciones
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="calificacionesDropdown">
                            <li><a class="dropdown-item" href="{{ route('calificaciones.index') }}">Ver Calificaciones</a></li>
                            <li><a class="dropdown-item" href="{{ route('calificaciones.create') }}">Registrar Calificación</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <h4>Errores de validación:</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
