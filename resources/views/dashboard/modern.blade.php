@extends('layouts.modern')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in-up">
    <div>
        <h1 class="page-title">Dashboard Académico</h1>
        <p class="page-subtitle">Panel de control y estadísticas del sistema</p>
    </div>
    <div class="user-menu">
        <div class="text-end">
            <div class="fw-semibold">{{ auth()->user()->name }}</div>
            <small class="text-muted">Administrador</small>
        </div>
        <div class="user-avatar">
            {{ substr(auth()->user()->name, 0, 2) }}
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6 animate-fade-in-up">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Total Estudiantes</div>
                    <div class="stat-card-value">{{ number_format($totalEstudiantes) }}</div>
                    <div class="stat-card-trend up">
                        <i class="bi bi-arrow-up-short"></i>
                        <span>Activos</span>
                    </div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <a href="{{ route('estudiantes.index') }}" class="btn-modern btn-modern-secondary mt-3 w-100 justify-content-center">
                <i class="bi bi-eye"></i> Ver todos
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-fade-in-up delay-1">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Total Materias</div>
                    <div class="stat-card-value">{{ number_format($totalMaterias) }}</div>
                    <div class="stat-card-trend up">
                        <i class="bi bi-book"></i>
                        <span>Disponibles</span>
                    </div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-book-fill"></i>
                </div>
            </div>
            <a href="{{ route('materias.index') }}" class="btn-modern btn-modern-secondary mt-3 w-100 justify-content-center">
                <i class="bi bi-eye"></i> Ver todas
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-fade-in-up delay-2">
        <div class="stat-card info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Total Inscripciones</div>
                    <div class="stat-card-value">{{ number_format($totalInscripciones) }}</div>
                    <div class="stat-card-trend up">
                        <i class="bi bi-arrow-up-short"></i>
                        <span>Este período</span>
                    </div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
            </div>
            <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-modern-secondary mt-3 w-100 justify-content-center">
                <i class="bi bi-eye"></i> Ver todas
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-fade-in-up delay-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Total Calificaciones</div>
                    <div class="stat-card-value">{{ number_format($totalCalificaciones) }}</div>
                    <div class="stat-card-trend up">
                        <i class="bi bi-award"></i>
                        <span>Registradas</span>
                    </div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-award-fill"></i>
                </div>
            </div>
            <a href="{{ route('calificaciones.index') }}" class="btn-modern btn-modern-secondary mt-3 w-100 justify-content-center">
                <i class="bi bi-eye"></i> Ver todas
            </a>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-lg-8 animate-fade-in-up delay-4">
        <div class="chart-container" style="height: 400px;">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="bi bi-bar-chart-line text-primary me-2"></i>
                    Rendimiento Académico por Materia
                </h5>
            </div>
            <canvas id="materiasChart"></canvas>
        </div>
    </div>

    <div class="col-lg-4 animate-fade-in-up delay-4">
        <div class="chart-container" style="height: 400px;">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="bi bi-pie-chart text-info me-2"></i>
                    Distribución de Notas
                </h5>
            </div>
            <canvas id="notasChart"></canvas>
        </div>
    </div>
</div>

<!-- KPI Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 animate-fade-in-up">
        <div class="chart-container h-100">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="bi bi-speedometer2 text-success me-2"></i>
                    Promedio General
                </h5>
                <span class="badge-modern {{ $promedioGeneral >= 3.5 ? 'success' : ($promedioGeneral >= 3.0 ? 'warning' : 'danger') }}">
                    {{ number_format($promedioGeneral, 2) }} / 5.0
                </span>
            </div>
            <div class="text-center py-4">
                <div class="display-1 fw-bold {{ $promedioGeneral >= 4.0 ? 'text-success' : ($promedioGeneral >= 3.0 ? 'text-warning' : 'text-danger') }}">
                    {{ number_format($promedioGeneral, 2) }}
                </div>
                <p class="text-muted mb-0">
                    @if($promedioGeneral >= 4.0)
                        <i class="bi bi-emoji-smile"></i> Excelente rendimiento
                    @elseif($promedioGeneral >= 3.0)
                        <i class="bi bi-emoji-neutral"></i> Rendimiento aceptable
                    @else
                        <i class="bi bi-emoji-frown"></i> Requiere atención
                    @endif
                </p>
                <div class="progress mt-3" style="height: 8px;">
                    @php
                        $percentage = ($promedioGeneral / 5.0) * 100;
                        $progressClass = $percentage >= 80 ? 'bg-success' : ($percentage >= 60 ? 'bg-warning' : 'bg-danger');
                    @endphp
                    <div class="progress-bar {{ $progressClass }}" role="progressbar"
                         style="width: {{ $percentage }}%"
                         aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 animate-fade-in-up delay-1">
        <div class="chart-container h-100">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="bi bi-graph-up text-primary me-2"></i>
                    Estadísticas de Calificaciones
                </h5>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Nota Máxima</div>
                        <div class="h3 mb-0 text-success">
                            <i class="bi bi-arrow-up-circle"></i>
                            {{ number_format($estadisticasCalificaciones['maxima'] ?? 0, 2) }}
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Nota Mínima</div>
                        <div class="h3 mb-0 text-danger">
                            <i class="bi bi-arrow-down-circle"></i>
                            {{ number_format($estadisticasCalificaciones['minima'] ?? 0, 2) }}
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Desviación Est.</div>
                        <div class="h3 mb-0 text-info">
                            ±{{ number_format($estadisticasCalificaciones['desviacion'] ?? 0, 2) }}
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Total Registros</div>
                        <div class="h3 mb-0 text-primary">
                            {{ number_format($estadisticasCalificaciones['total'] ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Data Tables -->
<div class="row g-4">
    <div class="col-lg-6 animate-fade-in-up">
        <div class="chart-container">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="bi bi-clock-history text-warning me-2"></i>
                    Estudiantes Recientes
                </h5>
                <a href="{{ route('estudiantes.index') }}" class="btn-modern btn-modern-primary btn-sm">
                    Ver todos <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="list-group list-group-flush">
                @forelse($estudiantesRecientes as $estudiante)
                    <a href="{{ route('estudiantes.show', $estudiante['id']) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-avatar" style="width: 40px; height: 40px; font-size: 0.875rem;">
                                {{ substr($estudiante['nombre'], 0, 1) }}{{ substr($estudiante['apellido'], 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-medium">{{ $estudiante['nombre'] }} {{ $estudiante['apellido'] }}</div>
                                <small class="text-muted">{{ $estudiante['email'] }}</small>
                            </div>
                        </div>
                        <small class="text-muted">{{ $estudiante['created_at']['diff_for_humans'] ?? 'Reciente' }}</small>
                    </a>
                @empty
                    <p class="text-muted text-center py-4">No hay estudiantes registrados</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-6 animate-fade-in-up delay-1">
        <div class="chart-container">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="bi bi-fire text-danger me-2"></i>
                    Materias Más Populares
                </h5>
                <a href="{{ route('materias.index') }}" class="btn-modern btn-modern-primary btn-sm">
                    Ver todas <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="list-group list-group-flush">
                @forelse($materiasPopulares as $materia)
                    <a href="{{ route('materias.show', $materia['id']) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-card-icon" style="width: 40px; height: 40px; font-size: 1rem;">
                                <i class="bi bi-book"></i>
                            </div>
                            <div>
                                <div class="fw-medium">{{ $materia['nombre'] }}</div>
                                <small class="text-muted">{{ $materia['codigo'] ?? '' }}</small>
                            </div>
                        </div>
                        <span class="badge-modern primary">
                            <i class="bi bi-people"></i>
                            {{ $materia['inscripciones_count'] ?? 0 }} inscritos
                        </span>
                    </a>
                @empty
                    <p class="text-muted text-center py-4">No hay materias registradas</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Inscripciones Recientes -->
<div class="row g-4 mt-4">
    <div class="col-12 animate-fade-in-up delay-2">
        <div class="chart-container">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="bi bi-journal-check text-success me-2"></i>
                    Últimas Inscripciones
                </h5>
                <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-modern-primary btn-sm">
                    Ver todas <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table modern-table mb-0">
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Materia</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscripcionesRecientes as $inscripcion)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            {{ substr($inscripcion['estudiante']['nombre'], 0, 1) }}{{ substr($inscripcion['estudiante']['apellido'], 0, 1) }}
                                        </div>
                                        <span class="fw-medium">{{ $inscripcion['estudiante']['nombre'] }} {{ $inscripcion['estudiante']['apellido'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium">{{ $inscripcion['materia']['nombre'] }}</span>
                                    <br><small class="text-muted">{{ $inscripcion['materia']['codigo'] ?? '' }}</small>
                                </td>
                                <td>
                                    <i class="bi bi-calendar3 text-muted me-1"></i>
                                    {{ \Carbon\Carbon::parse($inscripcion['fecha_inscripcion']['date'])->format('d/m/Y') }}
                                </td>
                                <td>
                                    @php
                                        $estadoValue = is_string($inscripcion['estado']) ? $inscripcion['estado'] : $inscripcion['estado']->value;
                                        $estadoClass = match($estadoValue) {
                                            'activa' => 'success',
                                            'completada' => 'info',
                                            'cancelada' => 'danger',
                                            default => 'secondary'
                                        };
                                        $estadoIcon = match($estadoValue) {
                                            'activa' => 'bi-check-circle',
                                            'completada' => 'bi-patch-check',
                                            'cancelada' => 'bi-x-circle',
                                            default => 'bi-circle'
                                        };
                                    @endphp
                                    <span class="badge-modern {{ $estadoClass }}">
                                        <i class="bi {{ $estadoIcon }}"></i>
                                        {{ is_string($inscripcion['estado']) ? ucfirst($inscripcion['estado']) : $inscripcion['estado']->label() }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('inscripciones.show', $inscripcion['id']) }}"
                                       class="btn-modern btn-modern-secondary btn-sm">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox display-4"></i>
                                    <p class="mt-2">No hay inscripciones registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Configuración global de Chart.js
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#64748b';

// Colores del tema
const colors = {
    primary: '#4f46e5',
    success: '#10b981',
    warning: '#f59e0b',
    danger: '#ef4444',
    info: '#06b6d4',
    gradient1: ['#4f46e5', '#818cf8'],
    gradient2: ['#10b981', '#34d399'],
    gradient3: ['#f59e0b', '#fbbf24'],
    gradient4: ['#06b6d4', '#22d3ee']
};

// Gráfico de Materias (Bar Chart)
@if($materiasPopulares->count() > 0)
const materiasCtx = document.getElementById('materiasChart').getContext('2d');
const materiasGradient = materiasCtx.createLinearGradient(0, 0, 0, 400);
materiasGradient.addColorStop(0, colors.primary);
materiasGradient.addColorStop(1, '#818cf8');

new Chart(materiasCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($materiasPopulares->pluck('nombre')) !!},
        datasets: [{
            label: 'Inscripciones',
            data: {!! json_encode($materiasPopulares->pluck('inscripciones_count')) !!},
            backgroundColor: materiasGradient,
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});
@endif

// Gráfico de Distribución de Notas (Doughnut)
@if($totalCalificaciones > 0)
@php
    $aprobadas = $calificacionesBajas->count();
    $reprobadas = $totalCalificaciones - $aprobadas;
    $porcentajeAprobadas = ($aprobadas / $totalCalificaciones) * 100;
    $porcentajeReprobadas = 100 - $porcentajeAprobadas;
@endphp
const notasCtx = document.getElementById('notasChart').getContext('2d');
new Chart(notasCtx, {
    type: 'doughnut',
    data: {
        labels: ['Aprobadas (≥3.0)', 'Bajas (<3.0)'],
        datasets: [{
            data: [{{ $porcentajeAprobadas }}, {{ $porcentajeReprobadas }}],
            backgroundColor: [
                colors.success,
                colors.danger
            ],
            borderWidth: 0,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 20, usePointStyle: true }
            }
        }
    }
});
@endif

// Animaciones al hacer scroll
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-fade-in-up').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.5s ease';
        observer.observe(el);
    });
});
</script>
@endsection
