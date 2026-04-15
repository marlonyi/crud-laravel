@extends('layouts.modern')

@section('title', 'Estudiantes')

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
            <i class="bi bi-people-fill text-primary me-2"></i>
            Gestión de Estudiantes
        </h1>
        <p class="page-subtitle">Administra el registro de estudiantes del sistema</p>
    </div>
    <a href="{{ route('estudiantes.create') }}" class="btn-modern btn-modern-primary">
        <i class="bi bi-plus-lg"></i> Nuevo Estudiante
    </a>
</div>

<!-- Search and Filters -->
<div class="chart-container mb-4">
    <div class="row g-3 align-items-center">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control bg-light border-0" placeholder="Buscar estudiante..." id="searchInput">
            </div>
        </div>
        <div class="col-md-8 text-end">
            <span class="text-muted">
                <i class="bi bi-info-circle"></i>
                {{ $estudiantes->total() }} estudiantes registrados
            </span>
        </div>
    </div>
</div>

<!-- Students Table -->
<div class="chart-container">
    <div class="table-responsive">
        <table class="table modern-table mb-0" id="studentsTable">
            <thead>
                <tr>
                    <th>
                        <i class="bi bi-hash"></i> ID
                    </th>
                    <th>
                        <i class="bi bi-person"></i> Estudiante
                    </th>
                    <th>
                        <i class="bi bi-envelope"></i> Email
                    </th>
                    <th>
                        <i class="bi bi-card-text"></i> Cédula
                    </th>
                    <th>
                        <i class="bi bi-telephone"></i> Teléfono
                    </th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($estudiantes as $estudiante)
                    <tr class="searchable-row">
                        <td>
                            <span class="badge-modern primary">#{{ $estudiante->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar">
                                    {{ substr($estudiante->nombre, 0, 1) }}{{ substr($estudiante->apellido, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</div>
                                    <small class="text-muted">
                                        @if($estudiante->fecha_nacimiento)
                                            <i class="bi bi-calendar3"></i> {{ $estudiante->fecha_nacimiento->format('d/m/Y') }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="mailto:{{ $estudiante->email }}" class="text-decoration-none">
                                {{ $estudiante->email }}
                            </a>
                        </td>
                        <td>
                            <span class="fw-medium">{{ $estudiante->cedula }}</span>
                        </td>
                        <td>
                            {{ $estudiante->telefono ?? 'N/A' }}
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                   class="btn-modern btn-modern-secondary"
                                   title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('estudiantes.edit', $estudiante->id) }}"
                                   class="btn-modern btn-modern-secondary"
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('estudiantes.destroy', $estudiante->id) }}"
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
                            <h5 class="mt-3 text-muted">No hay estudiantes registrados</h5>
                            <p class="text-muted mb-3">Comienza creando un nuevo estudiante</p>
                            <a href="{{ route('estudiantes.create') }}" class="btn-modern btn-modern-primary">
                                <i class="bi bi-plus-lg"></i> Nuevo Estudiante
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($estudiantes->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $estudiantes->links() }}
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
        background: linear-gradient(135deg, #4f46e5, #818cf8);
        color: white;
    }
    .page-item:hover .page-link {
        background: #f1f5f9;
    }
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
</script>
