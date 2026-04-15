@extends('layout')

@section('title', 'Estudiantes')

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formElement = this;
                Swal.fire({
                    title: '¿Eliminar estudiante?',
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
            <i class="bi bi-people-fill"></i>
            Estudiantes
        </h1>
        <p class="page-subtitle">Gestión de estudiantes del sistema universitario</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('estudiantes.create') }}" class="btn-modern btn-modern-primary">
            <i class="bi bi-plus-lg"></i> Nuevo Estudiante
        </a>
    </div>
</div>

<!-- Content Card -->
<div class="content-card animate-fade-in delay-1">
    <div class="content-card-body p-0">
        @if($estudiantes->isEmpty())
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <h5>No hay estudiantes registrados</h5>
                <p>Comienza agregando el primer estudiante al sistema</p>
                <a href="{{ route('estudiantes.create') }}" class="btn-modern btn-modern-primary mt-3">
                    <i class="bi bi-plus-lg"></i> Registrar Estudiante
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash"></i> ID</th>
                            <th><i class="bi bi-person"></i> Nombre Completo</th>
                            <th><i class="bi bi-envelope"></i> Email</th>
                            <th><i class="bi bi-card-text"></i> Cédula</th>
                            <th><i class="bi bi-telephone"></i> Teléfono</th>
                            <th class="text-end"><i class="bi bi-gear"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estudiantes as $estudiante)
                            <tr>
                                <td>
                                    <span class="badge-modern secondary">#{{ $estudiante->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">
                                            {{ substr($estudiante->nombre, 0, 1) }}{{ substr($estudiante->apellido, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $estudiante->nombre }} {{ $estudiante->apellido }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $estudiante->email }}" class="text-decoration-none">
                                        {{ $estudiante->email }}
                                    </a>
                                </td>
                                <td>
                                    <code class="bg-light px-2 py-1 rounded">{{ $estudiante->cedula }}</code>
                                </td>
                                <td>
                                    @if($estudiante->telefono)
                                        <span>{{ $estudiante->telefono }}</span>
                                    @else
                                        <span class="badge-modern secondary">N/A</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="btn-modern btn-modern-info btn-modern-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn-modern btn-modern-warning btn-modern-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('estudiantes.destroy', $estudiante->id) }}" class="delete-form">
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

            @if($estudiantes->hasPages())
                <div class="p-3 border-top">
                    {{ $estudiantes->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection