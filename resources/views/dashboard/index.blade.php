@extends('layout')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </h1>
        <p class="page-subtitle">Sistema Universitario - Panel de Control</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card primary animate-fade-in delay-1">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Estudiantes</div>
                    <div class="stat-card-value">{{ $totalEstudiantes }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <a href="{{ route('estudiantes.index') }}" class="btn-modern btn-modern-sm btn-modern-secondary mt-2">
                Ver todos <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card success animate-fade-in delay-2">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Materias</div>
                    <div class="stat-card-value">{{ $totalMaterias }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-book-fill"></i>
                </div>
            </div>
            <a href="{{ route('materias.index') }}" class="btn-modern btn-modern-sm btn-modern-secondary mt-2">
                Ver todas <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card info animate-fade-in delay-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Inscripciones</div>
                    <div class="stat-card-value">{{ $totalInscripciones }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
            </div>
            <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-modern-sm btn-modern-secondary mt-2">
                Ver todas <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card warning animate-fade-in delay-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Calificaciones</div>
                    <div class="stat-card-value">{{ $totalCalificaciones }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-award-fill"></i>
                </div>
            </div>
            <a href="{{ route('calificaciones.index') }}" class="btn-modern btn-modern-sm btn-modern-secondary mt-2">
                Ver todas <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Academic Summary -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="content-card animate-fade-in delay-2">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-graph-up"></i>
                    Promedio General
                </h5>
            </div>
            <div class="content-card-body text-center py-4">
                @php
                    $promedioClass = $promedioGeneral >= 4.0 ? 'success' : ($promedioGeneral >= 3.0 ? 'warning' : 'danger');
                @endphp
                <span class="badge-modern {{ $promedioClass }}" style="font-size: 1.5rem; padding: 0.75rem 1.5rem;">
                    {{ number_format($promedioGeneral, 2) }}/5.00
                </span>
                <p class="text-muted mt-3 mb-0">Promedio de todas las calificaciones registradas</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-card animate-fade-in delay-3">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-exclamation-triangle"></i>
                    Calificaciones Bajas
                </h5>
                @if(!$calificacionesBajas->isEmpty())
                    <span class="badge-modern danger">{{ $calificacionesBajas->count() }} alertas</span>
                @endif
            </div>
            <div class="content-card-body p-0">
                @if($calificacionesBajas->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">No hay calificaciones por debajo de 3.0</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
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
                                        <td>
                                            <span class="badge-modern danger">{{ number_format($cal->nota, 2) }}</span>
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

<!-- Recent Data -->
<div class="row g-3">
    <div class="col-md-6">
        <div class="content-card animate-fade-in delay-3">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-people"></i>
                    Estudiantes Recientes
                </h5>
            </div>
            <div class="content-card-body p-0">
                @if($estudiantesRecientes->isEmpty())
                    <div class="empty-state py-3">
                        <p class="text-muted mb-0">No hay estudiantes registrados</p>
                    </div>
                @else
                    @foreach($estudiantesRecientes as $estudiante)
                        <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="d-flex align-items-center gap-3 p-3 border-bottom text-decoration-none text-dark hover-bg">
                            <div class="user-avatar">
                                {{ substr($estudiante->nombre, 0, 1) }}{{ substr($estudiante->apellido, 0, 1) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</div>
                                <small class="text-muted">{{ $estudiante->email }}</small>
                            </div>
                            <small class="text-muted">{{ $estudiante->created_at->diffForHumans() }}</small>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-card animate-fade-in delay-4">
            <div class="content-card-header">
                <h5 class="content-card-title">
                    <i class="bi bi-book"></i>
                    Materias Más Inscritas
                </h5>
            </div>
            <div class="content-card-body p-0">
                @if($materiasPopulares->isEmpty())
                    <div class="empty-state py-3">
                        <p class="text-muted mb-0">No hay materias registradas</p>
                    </div>
                @else
                    @foreach($materiasPopulares as $materia)
                        <a href="{{ route('materias.show', $materia->id) }}" class="d-flex align-items-center justify-content-between p-3 border-bottom text-decoration-none text-dark">
                            <div>
                                <div class="fw-semibold">{{ $materia->nombre }}</div>
                                <small class="text-muted">{{ $materia->codigo }}</small>
                            </div>
                            <span class="badge-modern primary">{{ $materia->inscripciones_count }} inscritos</span>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Enrollments -->
<div class="content-card mt-4 animate-fade-in delay-4">
    <div class="content-card-header">
        <h5 class="content-card-title">
            <i class="bi bi-journal-bookmark"></i>
            Inscripciones Recientes
        </h5>
    </div>
    <div class="content-card-body p-0">
        @if($inscripcionesRecientes->isEmpty())
            <div class="empty-state py-4">
                <i class="bi bi-journal-bookmark" style="font-size: 2rem;"></i>
                <p class="text-muted mb-0 mt-2">No hay inscripciones registradas</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Materia</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th class="text-end">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inscripcionesRecientes as $inscripcion)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">
                                            {{ substr($inscripcion->estudiante->nombre, 0, 1) }}
                                        </div>
                                        <span>{{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }}</span>
                                    </div>
                                </td>
                                <td>{{ $inscripcion->materia->nombre }}</td>
                                <td>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $estadoClass = match($inscripcion->estado) {
                                            'activa' => 'success',
                                            'completada' => 'info',
                                            default => 'danger'
                                        };
                                    @endphp
                                    <span class="badge-modern {{ $estadoClass }}">
                                        {{ ucfirst($inscripcion->estado) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('inscripciones.show', $inscripcion->id) }}" class="btn-modern btn-modern-info btn-modern-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .hover-bg:hover {
        background: linear-gradient(90deg, rgba(79, 70, 229, 0.04), transparent);
    }
</style>
@endpush
@endsection