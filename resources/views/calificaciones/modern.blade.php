@extends('layouts.modern')

@section('title', 'Calificaciones')

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
            <i class="bi bi-award-fill text-warning me-2"></i>
            Gestión de Calificaciones
        </h1>
        <p class="page-subtitle">Registra y administra las calificaciones de los estudiantes</p>
    </div>
    <a href="{{ route('calificaciones.create') }}" class="btn-modern btn-modern-primary">
        <i class="bi bi-plus-lg"></i> Registrar Calificación
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Total Calificaciones</div>
                    <div class="stat-card-value">{{ $calificaciones->total() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-award"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Aprobadas (≥3.0)</div>
                    <div class="stat-card-value">{{ $calificaciones->where('nota', '>=', 3.0)->count() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card danger">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Reprobadas (<3.0)</div>
                    <div class="stat-card-value">{{ $calificaciones->where('nota', '<', 3.0)->count() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-x-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Promedio General</div>
                    <div class="stat-card-value">{{ number_format($calificaciones->avg('nota') ?? 0, 2) }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="chart-container mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control bg-light border-0" placeholder="Buscar calificación..." id="searchInput">
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select bg-light border-0" id="notaFilter">
                <option value="all">Todas las notas</option>
                <option value="excelente">Excelente (4.5-5.0)</option>
                <option value="buena">Buena (3.5-4.4)</option>
                <option value="aprobada">Aprobada (3.0-3.4)</option>
                <option value="reprobada">Reprobada (<3.0)</option>
            </select>
        </div>
        <div class="col-md-4 text-end">
            <span class="text-muted">
                <i class="bi bi-info-circle"></i>
                {{ $calificaciones->total() }} registros
            </span>
        </div>
    </div>
</div>

<!-- Table -->
<div class="chart-container">
    <div class="table-responsive">
        <table class="table modern-table mb-0" id="calificacionesTable">
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
                        <i class="bi bi-clipboard-check"></i> Tipo
                    </th>
                    <th>
                        <i class="bi bi-calendar3"></i> Fecha
                    </th>
                    <th>
                        <i class="bi bi-graph-up"></i> Nota
                    </th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($calificaciones as $calificacion)
                    <tr class="searchable-row"
                        data-nota="{{ $calificacion->nota }}"
                        data-estado="{{ $calificacion->nota >= 3.0 ? 'aprobada' : 'reprobada' }}">
                        <td>
                            <span class="badge-modern primary">#{{ $calificacion->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar">
                                    {{ substr($calificacion->inscripcion->estudiante->nombre, 0, 1) }}{{ substr($calificacion->inscripcion->estudiante->apellido, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $calificacion->inscripcion->estudiante->nombre }} {{ $calificacion->inscripcion->estudiante->apellido }}</div>
                                    <small class="text-muted">{{ $calificacion->inscripcion->estudiante->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $calificacion->inscripcion->materia->nombre }}</div>
                                <small class="text-muted">{{ $calificacion->inscripcion->materia->codigo }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge-modern secondary">
                                <i class="bi bi-tag"></i>
                                {{ $calificacion->tipo->label() }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 text-muted">
                                <i class="bi bi-calendar3"></i>
                                {{ $calificacion->fecha->format('d/m/Y') }}
                            </div>
                        </td>
                        <td>
                            @php
                                $notaClass = $calificacion->nota >= 4.5 ? 'success' :
                                           ($calificacion->nota >= 3.5 ? 'info' :
                                           ($calificacion->nota >= 3.0 ? 'warning' : 'danger'));
                                $notaIcon = $calificacion->nota >= 3.0 ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
                            @endphp
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi {{ $notaIcon }} text-{{ $notaClass }}"></i>
                                <span class="fw-bold text-{{ $notaClass }}" style="font-size: 1.25rem;">
                                    {{ number_format($calificacion->nota, 2) }}
                                </span>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('calificaciones.show', $calificacion->id) }}"
                                   class="btn-modern btn-modern-secondary"
                                   title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('calificaciones.edit', $calificacion->id) }}"
                                   class="btn-modern btn-modern-secondary"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('calificaciones.destroy', $calificacion->id) }}"
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
                            <h5 class="mt-3 text-muted">No hay calificaciones registradas</h5>
                            <p class="text-muted mb-3">Comienza registrando una nueva calificación</p>
                            <a href="{{ route('calificaciones.create') }}" class="btn-modern btn-modern-primary">
                                <i class="bi bi-plus-lg"></i> Registrar Calificación
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($calificaciones->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $calificaciones->links() }}
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
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
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

    // Filtro por rango de notas
    document.getElementById('notaFilter')?.addEventListener('change', function(e) {
        const filter = e.target.value;
        document.querySelectorAll('.searchable-row').forEach(row => {
            const nota = parseFloat(row.dataset.nota);
            let show = false;

            switch(filter) {
                case 'excelente':
                    show = nota >= 4.5;
                    break;
                case 'buena':
                    show = nota >= 3.5 && nota < 4.5;
                    break;
                case 'aprobada':
                    show = nota >= 3.0 && nota < 3.5;
                    break;
                case 'reprobada':
                    show = nota < 3.0;
                    break;
                default:
                    show = true;
            }

            row.style.display = show ? '' : 'none';
        });
    });
</script>
