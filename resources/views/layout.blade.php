<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistema Universitario</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #818cf8;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
            --dark: #1e293b;
            --light: #f8fafc;
            --sidebar-width: 260px;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
        }

        /* ========== SIDBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            padding: 1.25rem;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 1.75rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand i {
            font-size: 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.25rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 0.625rem;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2), rgba(118, 75, 162, 0.2));
            color: white;
            transform: translateX(4px);
        }

        .sidebar-menu a i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }

        .sidebar-menu .menu-header {
            color: #475569;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin: 1.25rem 0 0.5rem 0.75rem;
            font-weight: 600;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            min-height: 100vh;
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 1.25rem;
            border-radius: 0.875rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .page-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .page-title i {
            color: var(--primary);
        }

        .page-subtitle {
            color: var(--secondary);
            font-size: 0.85rem;
            margin-top: 0.2rem;
        }

        .page-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* ========== STAT CARDS ========== */
        .stat-card {
            background: white;
            border-radius: 0.875rem;
            padding: 1.25rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 0.875rem 0.875rem 0 0;
        }

        .stat-card.primary::before { background: linear-gradient(90deg, #4f46e5, #818cf8); }
        .stat-card.success::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .stat-card.warning::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .stat-card.info::before { background: linear-gradient(90deg, #06b6d4, #22d3ee); }
        .stat-card.danger::before { background: linear-gradient(90deg, #ef4444, #f87171); }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            color: white;
        }

        .stat-card.primary .stat-card-icon { background: linear-gradient(135deg, #4f46e5, #818cf8); }
        .stat-card.success .stat-card-icon { background: linear-gradient(135deg, #10b981, #34d399); }
        .stat-card.warning .stat-card-icon { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
        .stat-card.info .stat-card-icon { background: linear-gradient(135deg, #06b6d4, #22d3ee); }
        .stat-card.danger .stat-card-icon { background: linear-gradient(135deg, #ef4444, #f87171); }

        .stat-card-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.15rem;
        }

        .stat-card-label {
            color: var(--secondary);
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* ========== CONTENT CARDS ========== */
        .content-card {
            background: white;
            border-radius: 0.875rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .content-card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .content-card-title i {
            color: var(--primary);
        }

        .content-card-body {
            padding: 1.25rem;
        }

        /* ========== MODERN TABLE ========== */
        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table thead {
            background: linear-gradient(135deg, var(--dark), #334155);
        }

        .modern-table thead th {
            padding: 0.875rem 1rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: white;
            border: none;
        }

        .modern-table thead th i {
            margin-right: 0.35rem;
            opacity: 0.8;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .modern-table tbody tr:hover {
            background: linear-gradient(90deg, rgba(79, 70, 229, 0.04), transparent);
        }

        .modern-table tbody td {
            padding: 0.875rem 1rem;
            vertical-align: middle;
            color: var(--dark);
            font-size: 0.9rem;
        }

        /* ========== BADGES ========== */
        .badge-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.35rem 0.65rem;
            border-radius: 0.4rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-modern.success { background: rgba(16, 185, 129, 0.12); color: var(--success); }
        .badge-modern.warning { background: rgba(245, 158, 11, 0.12); color: var(--warning); }
        .badge-modern.danger { background: rgba(239, 68, 68, 0.12); color: var(--danger); }
        .badge-modern.info { background: rgba(6, 182, 212, 0.12); color: var(--info); }
        .badge-modern.primary { background: rgba(79, 70, 229, 0.12); color: var(--primary); }
        .badge-modern.secondary { background: rgba(100, 116, 139, 0.12); color: var(--secondary); }

        /* ========== BUTTONS ========== */
        .btn-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: none;
            text-decoration: none;
        }

        .btn-modern-primary {
            background: linear-gradient(135deg, #4f46e5, #818cf8);
            color: white;
        }

        .btn-modern-primary:hover {
            background: linear-gradient(135deg, #4338ca, #6366f1);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        }

        .btn-modern-success {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
        }

        .btn-modern-success:hover {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.35);
        }

        .btn-modern-warning {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
        }

        .btn-modern-warning:hover {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.35);
        }

        .btn-modern-danger {
            background: linear-gradient(135deg, #ef4444, #f87171);
            color: white;
        }

        .btn-modern-danger:hover {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35);
        }

        .btn-modern-info {
            background: linear-gradient(135deg, #06b6d4, #22d3ee);
            color: white;
        }

        .btn-modern-info:hover {
            background: linear-gradient(135deg, #0891b2, #06b6d4);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(6, 182, 212, 0.35);
        }

        .btn-modern-secondary {
            background: #f1f5f9;
            color: var(--dark);
        }

        .btn-modern-secondary:hover {
            background: #e2e8f0;
            color: var(--dark);
            transform: translateY(-2px);
        }

        .btn-modern-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
        }

        /* ========== FORMS ========== */
        .form-label {
            font-weight: 500;
            color: var(--dark);
            font-size: 0.9rem;
            margin-bottom: 0.35rem;
        }

        .form-label.required::after {
            content: ' *';
            color: var(--danger);
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.6rem 0.875rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
            background: white;
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            font-size: 0.8rem;
            color: var(--danger);
        }

        .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.6rem 0.875rem;
            font-size: 0.9rem;
            background-color: #f8fafc;
        }

        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        /* ========== DETAIL VIEW ========== */
        .detail-row {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 140px;
            font-weight: 600;
            color: var(--secondary);
            font-size: 0.85rem;
        }

        .detail-value {
            flex: 1;
            color: var(--dark);
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
        }

        .empty-state i {
            font-size: 3.5rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .empty-state h5 {
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* ========== ALERTS ========== */
        .alert-modern {
            border-radius: 0.625rem;
            border: none;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-modern.alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #047857;
        }

        .alert-modern.alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #b91c1c;
        }

        .alert-modern.alert-info {
            background: rgba(6, 182, 212, 0.1);
            color: #0e7490;
        }

        /* ========== USER AVATAR ========== */
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* ========== ANIMATIONS ========== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.4s ease forwards;
        }

        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }

        /* ========== MOBILE RESPONSIVE ========== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1050;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .mobile-toggle {
                display: flex !important;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
                display: none;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }

        .mobile-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            background: rgba(255,255,255,0.95);
            border: none;
            color: var(--dark);
            font-size: 1.25rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* ========== PAGINATION ========== */
        .pagination {
            gap: 0.25rem;
        }

        .page-link {
            border-radius: 0.5rem;
            border: none;
            color: var(--secondary);
            padding: 0.4rem 0.7rem;
            font-size: 0.85rem;
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

    @yield('styles')
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-mortarboard-fill"></i>
            <span>Sistema Universitario</span>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Principal</li>
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-header">Académico</li>
            <li>
                <a href="{{ route('estudiantes.index') }}" class="{{ request()->routeIs('estudiantes.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Estudiantes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('materias.index') }}" class="{{ request()->routeIs('materias.*') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i>
                    <span>Materias</span>
                </a>
            </li>
            <li>
                <a href="{{ route('inscripciones.index') }}" class="{{ request()->routeIs('inscripciones.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Inscripciones</span>
                </a>
            </li>
            <li>
                <a href="{{ route('calificaciones.index') }}" class="{{ request()->routeIs('calificaciones.*') ? 'active' : '' }}">
                    <i class="bi bi-award-fill"></i>
                    <span>Calificaciones</span>
                </a>
            </li>

            <li class="menu-header">Sistema</li>
            <li>
                <a href="{{ route('audits.index') }}" class="{{ request()->routeIs('audits.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-check"></i>
                    <span>Auditoría</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @if ($errors->any())
            <div class="alert-modern alert-danger mb-3">
                <i class="bi bi-exclamation-circle"></i>
                <div>
                    <strong>Errores de validación:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="alert-modern alert-success mb-3">
                <i class="bi bi-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebarOverlay')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            this.classList.remove('active');
        });

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                background: 'rgba(255, 255, 255, 0.98)',
                backdrop: 'rgba(0, 0, 0, 0.4)'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 5000,
                showConfirmButton: true,
                background: 'rgba(255, 255, 255, 0.98)',
                backdrop: 'rgba(0, 0, 0, 0.4)'
            });
        </script>
    @endif

    @yield('scripts')
</body>
</html>