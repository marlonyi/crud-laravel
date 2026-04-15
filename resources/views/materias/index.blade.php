@extends('layout')

@section('title', 'Materias')

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formElement = this;
                Swal.fire({
                    title: '¿Eliminar materia?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
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
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">
            <i class="bi bi-book-fill"></i>
            Materias
        </h1>
        <p class="page-subtitle">Gestión de materias del sistema universitario</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('materias.create') }}" class="btn-modern btn-modern-primary">
            <i class="bi bi-plus-lg"></i> Nueva Materia
        </a>
    </div>
</div>

<!-- Content Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-body p-0">
        @if($materias->isEmpty())
            <div class="empty-state">
                <i class="bi bi-book"></i>
                <h5>No hay materias registradas</h5>
                <p>Comienza agregando la primera materia al sistema</p>
                <a href="{{ route('materias.create') }}" class="btn-modern btn-modern-primary mt-3">
                    <i class="bi bi-plus-lg"></i> Registrar Materia
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash"></i> Código</th>
                            <th><i class="bi bi-bookmark"></i> Nombre</th>
                            <th><i class="bi bi-award"></i> Créditos</th>
                            <th><i class="bi bi-person-badge"></i> Profesor</th>
                            <th><i class="bi bi-clock"></i> Horas/Semana</th>
                            <th class="text-end"><i class="bi bi-gear"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materias as $materia)
                            <tr>
                                <td>
                                    <span class="badge-modern primary">{{ $materia->codigo }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $materia->nombre }}</div>
                                </td>
                                <td>
                                    <span class="badge-modern info">{{ $materia->creditos }} créditos</span>
                                </td>
                                <td>
                                    @if($materia->profesor)
                                        <span>{{ $materia->profesor }}</span>
                                    @else
                                        <span class="badge-modern secondary">Sin asignar</span>
                                    @endif
                                </td>
                                <td>
                                    @if($materia->horas_semana)
                                        <span>{{ $materia->horas_semana }}h</span>
                                    @else
                                        <span class="badge-modern secondary">N/A</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('materias.show', $materia->id) }}" class="btn-modern btn-modern-info btn-modern-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('materias.edit', $materia->id) }}" class="btn-modern btn-modern-warning btn-modern-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('materias.destroy', $materia->id) }}" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-modern btn-modern-danger btn-modern-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($materias->hasPages())
                <div class="p-3 border-top">
                    {{ $materias->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection