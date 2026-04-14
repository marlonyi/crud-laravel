@extends('layout')

@section('title', 'Dashboard')

@section('content')
<h1 class="mb-4">Dashboard - Sistema Universitario</h1>

<!-- Tarjetas de Resumen -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Estudiantes</h5>
                <p class="display-4">{{ $totalEstudiantes }}</p>
                <a href="{{ route('estudiantes.index') }}" class="btn btn-light btn-sm mt-2">Ver Todos</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Materias</h5>
                <p class="display-4">{{ $totalMaterias }}</p>
                <a href="{{ route('materias.index') }}" class="btn btn-light btn-sm mt-2">Ver Todos</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Inscripciones</h5>
                <p class="display-4">{{ $totalInscripciones }}</p>
                <a href="{{ route('inscripciones.index') }}" class="btn btn-light btn-sm mt-2">Ver Todos</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5 class="card-title">Calificaciones</h5>
                <p class="display-4">{{ $totalCalificaciones }}</p>
                <a href="{{ route('calificaciones.index') }}" class="btn btn-dark btn-sm mt-2">Ver Todos</a>
            </div>
        </div>
    </div>
</div>

<!-- Resumen Académico -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">📊 Promedio General</h5>
            </div>
            <div class="card-body text-center">
                <p class="display-3 fw-bold
                    @if($promedioGeneral >= 4.0) text-success
                    @elseif($promedioGeneral >= 3.0) text-warning
                    @else text-danger
                    @endif">
                    {{ number_format($promedioGeneral, 2) }}/5.00
                </p>
                <p class="text-muted">Promedio de todas las calificaciones registradas</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">⚠️ Calificaciones Bajas</h5>
            </div>
            <div class="card-body">
                @if($calificacionesBajas->isEmpty())
                    <p class="text-success">✓ No hay calificaciones por debajo de 3.0</p>
                @else
                    <p class="text-muted">{{ $calificacionesBajas->count() }} estudiantes con notas menores a 3.0</p>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Estudiante</th>
                                    <th>Nota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calificacionesBajas as $cal)
                                    <tr>
                                        <td>{{ $cal->inscripcion->estudiante->nombre }}</td>
                                        <td><span class="badge bg-danger">{{ number_format($cal->nota, 2) }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Datos Recientes -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">👥 Estudiantes Recientes</h5>
            </div>
            <div class="card-body">
                @if($estudiantesRecientes->isEmpty())
                    <p class="text-muted">No hay estudiantes registrados</p>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($estudiantesRecientes as $estudiante)
                            <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</h6>
                                    <small class="text-muted">{{ $estudiante->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 small text-muted">{{ $estudiante->email }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">📚 Materias Más Inscritas</h5>
            </div>
            <div class="card-body">
                @if($materiasPopulares->isEmpty())
                    <p class="text-muted">No hay materias registradas</p>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($materiasPopulares as $materia)
                            <a href="{{ route('materias.show', $materia->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>{{ $materia->nombre }}</span>
                                <span class="badge bg-primary rounded-pill">{{ $materia->inscripciones_count }} inscritos</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Inscripciones Recientes -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">📝 Inscripciones Recientes</h5>
            </div>
            <div class="card-body">
                @if($inscripcionesRecientes->isEmpty())
                    <p class="text-muted">No hay inscripciones registradas</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Estudiante</th>
                                    <th>Materia</th>
                                    <th>Fecha Inscripción</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inscripcionesRecientes as $inscripcion)
                                    <tr>
                                        <td>{{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }}</td>
                                        <td>{{ $inscripcion->materia->nombre }}</td>
                                        <td>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($inscripcion->estado === 'activa') bg-success
                                                @elseif($inscripcion->estado === 'completada') bg-primary
                                                @else bg-danger
                                                @endif">
                                                {{ ucfirst($inscripcion->estado) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('inscripciones.show', $inscripcion->id) }}" class="btn btn-sm btn-info">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
