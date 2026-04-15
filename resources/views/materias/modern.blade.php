@extends('layouts.modern')

@section('title', 'Materias')

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
            <i class="bi bi-book-fill text-success me-2"></i>
            Gestión de Materias
        </h1>
        <p class="page-subtitle">Administra las materias y asignaturas del programa académico</p>
    </div>
    <a href="{{ route('materias.create') }}" class="btn-modern btn-modern-primary">
        <i class="bi bi-plus-lg"></i> Nueva Materia
    </a>
</div>

<!-- Search and Stats -->
<div class="chart-container mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control bg-light border-0" placeholder="Buscar materia..." id="searchInput">
            </div>
        </div>
        <div class="col-md-8 text-end">
            <span class="text-muted">
                <i class="bi bi-info-circle"></i>
                {{ $materias->total() }} materias registradas
            </span>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Total Materias</div>
                    <div class="stat-card-value">{{ $materias->total() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-book"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Con Inscritos</div>
                    <div class="stat-card-value">{{ $materias->filter(fn($m) => $m->inscripciones_count > 0)->count() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Créditos Totales</div>
                    <div class="stat-card-value">{{ $materias->sum('creditos') }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-award"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Materias Table -->
<div class="chart-container">
    <div class="table-responsive">
        <table class="table modern-table mb-0" id="materiasTable">
            <thead>
                <tr>
                    <th>
                        <i class="bi bi-code-square"></i> Código
                    </th>
                    <th>
                        <i class="bi bi-book"></i> Materia
                    </th>
                    <th>
                        <i class="bi bi-patch-check"></i> Créditos
                    </th>
                    <th>
                        <i class="bi bi-person-badge"></i> Profesor
                    </th>
                    <th>
                        <i class="bi bi-clock"></i> Horas/Semana
                    </th>
                    <th>
                        <i class="bi bi-people"></i> Inscritos
                    </th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materias as $materia)
                    <tr class="searchable-row">
                        <td>
                            <span class="badge-modern primary fw-bold">{{ $materia->codigo }}</span>
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $materia->nombre }}</div>
                                @if($materia->descripcion)
                                    <small class="text-muted">{{ Str::limit($materia->descripcion, 50) }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge-modern success">
                                <i class="bi bi-star"></i>
                                {{ $materia->creditos }} CR
                            </span>
                        </td>
                        <td>
                            @if($materia->profesor)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                        {{ substr($materia->profesor, 0, 2) }}
                                    </div>
                                    <span>{{ $materia->profesor }}</span>
                                </div>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            {{ $materia->horas_semana ?? 'N/A' }}h
                        </td>
                        <td>
                            <span class="badge-modern {{ $materia->inscripciones_count > 0 ? 'info' : 'secondary' }}">
                                <i class="bi bi-people"></i>
                                {{ $materia->inscripciones_count }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('materias.show', $materia->id) }}"
                                   class="btn-modern btn-modern-secondary"
                                   title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('materias.edit', $materia->id) }}"
                                   class="btn-modern btn-modern-secondary"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('materias.destroy', $materia->id) }}"
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
                            <h5 class="mt-3 text-muted">No hay materias registradas</h5>
                            <p class="text-muted mb-3">Comienza creando una nueva materia</p>
                            <a href="{{ route('materias.create') }}" class="btn-modern btn-modern-primary">
                                <i class="bi bi-plus-lg"></i> Nueva Materia
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($materias->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $materias->links() }}
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .pagination {
        gap: 0.25rem;
    }
    .page-item .page-link {
        border-radius: 0.5rem;
        border: none;
        color: var(--secondary);
        padding: 0.5rem 0.875rem;
        transition: all 0.2s ease;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
    }
    .page-item:hover .page-link {
        background: #f1f5f9;
    }
</style>
@endsection

<script>
    document.getElementById('searchInput')?.addEventListener('input', function(e) {
        const filter = e.target.value.toLowerCase();
        document.querySelectorAll('.searchable-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
