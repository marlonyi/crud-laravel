@extends('layouts.modern')

@section('title', 'Inscripciones')

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formElement = this;
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    background: 'rgba(255, 255, 255, 0.95)',
                    backdrop: 'rgba(0, 0, 0, 0.5)'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formElement.submit();
                    }
                });
            });
        });
    });
</script>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-journal-bookmark-fill text-info me-2"></i>
            Gestión de Inscripciones
        </h1>
        <p class="page-subtitle">Administra las inscripciones de estudiantes a materias</p>
    </div>
    <a href="{{ route('inscripciones.create') }}" class="btn-modern btn-modern-primary">
        <i class="bi bi-plus-lg"></i> Nueva Inscripción
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Total Inscripciones</div>
                    <div class="stat-card-value">{{ $inscripciones->total() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-journal-bookmark"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Activas</div>
                    <div class="stat-card-value">{{ $inscripciones->where('estado', 'activa')->count() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Completadas</div>
                    <div class="stat-card-value">{{ $inscripciones->where('estado', 'completada')->count() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-patch-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Canceladas</div>
                    <div class="stat-card-value">{{ $inscripciones->where('estado', 'cancelada')->count() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-x-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search -->
<div class="chart-container mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control bg-light border-0" placeholder="Buscar inscripción..." id="searchInput">
            </div>
        </div>
        <div class="col-md-8 text-end">
            <div class="btn-group" role="group">
                <button class="btn-modern btn-modern-secondary btn-sm" onclick="filterByEstado('all')">
                    Todas
                </button>
                <button class="btn-modern btn-modern-secondary btn-sm" onclick="filterByEstado('activa')">
                    <i class="bi bi-check-circle text-success"></i> Activas
                </button>
                <button class="btn-modern btn-modern-secondary btn-sm" onclick="filterByEstado('completada')">
                    <i class="bi bi-patch-check text-info"></i> Completadas
                </button>
                <button class="btn-modern btn-modern-secondary btn-sm" onclick="filterByEstado('cancelada')">
                    <i class="bi bi-x-circle text-danger"></i> Canceladas
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="chart-container">
    <div class="table-responsive">
        <table class="table modern-table mb-0" id="inscripcionesTable">
            <thead>
                <tr>
                    <th>
                        <i class="bi bi-hash"></i> ID
                    </th>
                    <th>
                        <i class="bi bi-person"></i> Estudiante
                    </th>
                    <th>
                        <i class="bi bi-book"></i> Materia
                    </th>
                    <th>
                        <i class="bi bi-calendar3"></i> Fecha Inscripción
                    </th>
                    <th>
                        <i class="bi bi-patch-check"></i> Estado
                    </th>
                    <th>
                        <i class="bi bi-graph-up"></i> Promedio
                    </th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inscripciones as $inscripcion)
                    <tr class="searchable-row" data-estado="{{ $inscripcion->estado instanceof \App\Enums\InscripcionEstado ? $inscripcion->estado->value : $inscripcion->estado }}">
                        <td>
                            <span class="badge-modern primary">#{{ $inscripcion->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar">
                                    {{ substr($inscripcion->estudiante->nombre, 0, 1) }}{{ substr($inscripcion->estudiante->apellido, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $inscripcion->estudiante->nombre }} {{ $inscripcion->estudiante->apellido }}</div>
                                    <small class="text-muted">{{ $inscripcion->estudiante->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $inscripcion->materia->nombre }}</div>
                                <small class="text-muted">{{ $inscripcion->materia->codigo }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <i class="bi bi-calendar3"></i>
                                {{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}
                            </div>
                        </td>
                        <td>
                            @php
                                $estadoValue = $inscripcion->estado instanceof \App\Enums\InscripcionEstado
                                    ? $inscripcion->estado->value
                                    : $inscripcion->estado;
                                $estadoLabel = $inscripcion->estado instanceof \App\Enums\InscripcionEstado
                                    ? $inscripcion->estado->label()
                                    : ucfirst($inscripcion->estado);
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
                                {{ $estadoLabel }}
                            </span>
                        </td>
                        <td>
                            @php $promedio = $inscripcion->promedio(); @endphp
                            @if($promedio)
                                <span class="fw-bold {{ $promedio >= 3.5 ? 'text-success' : ($promedio >= 3.0 ? 'text-warning' : 'text-danger') }}">
                                    {{ number_format($promedio, 2) }}
                                </span>
                            @else
                                <span class="text-muted">Sin notas</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('inscripciones.show', $inscripcion->id) }}"
                                   class="btn-modern btn-modern-secondary"
                                   title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('inscripciones.edit', $inscripcion->id) }}"
                                   class="btn-modern btn-modern-secondary"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('inscripciones.destroy', $inscripcion->id) }}"
                                      class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-modern btn-modern-secondary text-danger"
                                            title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">No hay inscripciones registradas</h5>
                            <p class="text-muted mb-3">Comienza creando una nueva inscripción</p>
                            <a href="{{ route('inscripciones.create') }}" class="btn-modern btn-modern-primary">
                                <i class="bi bi-plus-lg"></i> Nueva Inscripción
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($inscripciones->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $inscripciones->links() }}
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .pagination { gap: 0.25rem; }
    .page-item .page-link {
        border-radius: 0.5rem;
        border: none;
        color: var(--secondary);
        padding: 0.5rem 0.875rem;
        transition: all 0.2s ease;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #06b6d4, #22d3ee);
        color: white;
    }
    .page-item:hover .page-link { background: #f1f5f9; }
</style>
@endsection

<script>
    // Búsqueda en tiempo real
    document.getElementById('searchInput')?.addEventListener('input', function(e) {
        const filter = e.target.value.toLowerCase();
        document.querySelectorAll('.searchable-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Filtro por estado
    function filterByEstado(estado) {
        document.querySelectorAll('.searchable-row').forEach(row => {
            if (estado === 'all' || row.dataset.estado === estado) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
