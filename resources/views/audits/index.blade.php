@extends('layout')

@section('title', 'Auditoría')

@section('content')
<!-- Page Header -->
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">
            <i class="bi bi-shield-check"></i>
            Registro de Auditoría
        </h1>
        <p class="page-subtitle">Historial de cambios realizados en el sistema</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card primary animate-fade-in delay-1">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Total Registros</div>
                    <div class="stat-card-value">{{ $audits->total() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-journal-text"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card success animate-fade-in delay-2">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Creaciones</div>
                    <div class="stat-card-value">{{ $audits->where('action', 'created')->count() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-plus-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card warning animate-fade-in delay-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Actualizaciones</div>
                    <div class="stat-card-value">{{ $audits->where('action', 'updated')->count() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-pencil"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card danger animate-fade-in delay-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-card-label">Eliminaciones</div>
                    <div class="stat-card-value">{{ $audits->where('action', 'deleted')->count() }}</div>
                </div>
                <div class="stat-card-icon">
                    <i class="bi bi-trash"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="content-card mb-4 animate-fade-in delay-2">
    <div class="content-card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control bg-light border-start-0" placeholder="Buscar en auditoría..." id="searchInput">
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" id="actionFilter">
                    <option value="all">Todas las acciones</option>
                    <option value="created">Creaciones</option>
                    <option value="updated">Actualizaciones</option>
                    <option value="deleted">Eliminaciones</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <span class="text-muted">
                    <i class="bi bi-clock"></i>
                    {{ $audits->total() }} registros
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Audit Table -->
<div class="content-card animate-fade-in delay-3">
    <div class="content-card-body p-0">
        <div class="table-responsive">
            <table class="modern-table" id="auditsTable">
                <thead>
                    <tr>
                        <th><i class="bi bi-hash"></i> ID</th>
                        <th><i class="bi bi-lightning"></i> Acción</th>
                        <th><i class="bi bi-file-earmark"></i> Modelo</th>
                        <th><i class="bi bi-person"></i> Usuario</th>
                        <th><i class="bi bi-pc-display"></i> IP</th>
                        <th><i class="bi bi-calendar3"></i> Fecha</th>
                        <th class="text-end"><i class="bi bi-eye"></i> Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($audits as $audit)
                        <tr class="searchable-row" data-action="{{ $audit->action }}">
                            <td>
                                <span class="badge-modern secondary">#{{ $audit->id }}</span>
                            </td>
                            <td>
                                @php
                                    $actionConfig = [
                                        'created' => ['class' => 'success', 'icon' => 'bi-plus-circle', 'label' => 'Creado'],
                                        'updated' => ['class' => 'warning', 'icon' => 'bi-pencil', 'label' => 'Actualizado'],
                                        'deleted' => ['class' => 'danger', 'icon' => 'bi-trash', 'label' => 'Eliminado'],
                                    ];
                                    $config = $actionConfig[$audit->action] ?? ['class' => 'secondary', 'icon' => 'bi-circle', 'label' => $audit->action];
                                @endphp
                                <span class="badge-modern {{ $config['class'] }}">
                                    <i class="bi {{ $config['icon'] }}"></i>
                                    {{ $config['label'] }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    <span class="badge-modern primary">
                                        {{ class_basename($audit->auditable_type) }}
                                    </span>
                                    <small class="text-muted d-block mt-1">
                                        #{{ $audit->auditable_id }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                @if($audit->user)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            {{ substr($audit->user->name, 0, 2) }}
                                        </div>
                                        <span>{{ $audit->user->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">
                                        <i class="bi bi-robot"></i> Sistema
                                    </span>
                                @endif
                            </td>
                            <td>
                                <code class="text-muted">{{ $audit->ip_address ?? 'N/A' }}</code>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">{{ $audit->created_at->format('d/m/Y') }}</span>
                                    <small class="text-muted">{{ $audit->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('audits.show', $audit->id) }}" class="btn-modern btn-modern-info btn-modern-sm">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state py-5">
                                    <i class="bi bi-shield-check" style="font-size: 3rem;"></i>
                                    <h5 class="mt-3">No hay registros de auditoría</h5>
                                    <p class="text-muted mb-0">Los cambios realizados en el sistema aparecerán aquí</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($audits->hasPages())
            <div class="p-3 border-top">
                {{ $audits->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Real-time search
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            const filter = e.target.value.toLowerCase();
            document.querySelectorAll('.searchable-row').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // Action filter
        document.getElementById('actionFilter')?.addEventListener('change', function(e) {
            const filter = e.target.value;
            document.querySelectorAll('.searchable-row').forEach(row => {
                if (filter === 'all' || row.dataset.action === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection