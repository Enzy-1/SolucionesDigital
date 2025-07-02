<?php
include_once "../control/soporteC.php";

session_start();
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['csrf_token'])) {
    header("Location: ../../logeo/views/index.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Soportes Técnicos | Digital Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="diseños/estilos-comunes.css" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        [data-theme="dark"] body {
            background-color: #181c24;
        }
        [data-theme="dark"] .sidebar {
            background: linear-gradient(135deg, #232b3e 60%, #1565C0 100%);
            color: #fff;
        }
        [data-theme="dark"] .sidebar .logo,
        [data-theme="dark"] .sidebar .nav-link {
            color: #fff;
        }
        [data-theme="dark"] .sidebar .nav-link.active,
        [data-theme="dark"] .sidebar .nav-link:hover {
            background: rgba(100,181,246,0.15);
            color: #fff;
        }
        [data-theme="dark"] .main-content {
            background: #20232a;
        }
        [data-theme="dark"] .container,
        [data-theme="dark"] .card {
            background: #232b3e;
            color: #fff;
            border: 1px solid #2d3a4a;
            box-shadow: 0 2px 12px rgba(0,0,0,0.25);
        }
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: #232b3e;
            color: #fff;
            border: 1.5px solid #3a4a5a;
        }
        [data-theme="dark"] .form-control:focus {
            background: #232b3e;
            color: #fff;
            border-color: #64B5F6;
        }
        [data-theme="dark"] .btn-primary {
            background: #64B5F6;
            color: #181c24;
            border: none;
        }
        [data-theme="dark"] .btn-primary:hover {
            background: #42A5F5;
            color: #fff;
        }
        [data-theme="dark"] .btn-outline-primary {
            border-color: #64B5F6;
            color: #64B5F6;
        }
        [data-theme="dark"] .btn-outline-primary:hover {
            background: #64B5F6;
            color: #181c24;
        }
        [data-theme="dark"] .theme-switch {
            background: #232b3e;
            color: #64B5F6;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        [data-theme="dark"] .form-check-label {
            color: #b0c4d9;
        }
        [data-theme="dark"] .card-title,
        [data-theme="dark"] h5,
        [data-theme="dark"] h6 {
            color: #64B5F6;
        }
        [data-theme="dark"] .text-muted {
            color: #b0c4d9 !important;
        }
    </style>
</head>
<body>
    <!-- Botón de menú móvil -->
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-microchip"></i>
            <span>Digital Solutions</span>
        </div>
        <nav>
            <a class="nav-link" href="menu.php">
                <i class="fas fa-tachometer-alt"></i>
                <span>Panel de Control</span>
            </a>
            <a class="nav-link" href="RolesV.php">
                <i class="fas fa-wrench"></i>
                <span>Registrar Soporte</span>
            </a>
            <a class="nav-link" href="soporte.php">
                <i class="fas fa-clipboard-list"></i>
                <span>Ver Soportes</span>
            </a>
            <a class="nav-link" href="clientes.php">
                <i class="fas fa-users"></i>
                <span>Clientes</span>
            </a>
            <a class="nav-link" href="registro.php">
                <i class="fas fa-user-plus"></i>
                <span>Añadir Nuevos Usuarios</span>
            </a>
            <a class="nav-link" href="../../logeo/views/logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Salir</span>
            </a>
        </nav>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        <div class="container fade-in">
            <h2 class="mb-4">
                <i class="fas fa-tools me-2"></i>Equipos Facturados
            </h2>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="search-container w-50">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="buscadorSoportes" placeholder="Buscar soporte...">
                </div>
                <div class="btn-group">
                    <button class="btn btn-outline-primary" id="btnFiltrarPendientes">
                        <i class="fas fa-clock me-2"></i>Revisiones
                    </button>
                    <button class="btn btn-outline-primary" id="btnFiltrarEnProceso">
                        <i class="fas fa-cogs me-2"></i>Cancelados
                    </button>
                    <button class="btn btn-outline-primary" id="btnFiltrarCompletados">
                        <i class="fas fa-check me-2"></i>Entregados
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <?php listarSoportes(); ?>
            </div>
        </div>
    </div>

    <!-- Botón y script de cambio de tema -->
    <div class="theme-switch" data-tooltip="Cambiar tema">
        <i class="fas fa-moon"></i>
    </div>
    <script>
        // Búsqueda de soportes
        document.getElementById('buscadorSoportes').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });

        // Filtros por estado
        document.getElementById('btnFiltrarPendientes').addEventListener('click', function() {
            filtrarPorEstado('Revision');
        });

        document.getElementById('btnFiltrarEnProceso').addEventListener('click', function() {
            filtrarPorEstado('Cancelado');
        });

        document.getElementById('btnFiltrarCompletados').addEventListener('click', function() {
            filtrarPorEstado('Entregado');
        });

function filtrarPorEstado(estado) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        // Buscar el <select> dentro de la sexta celda
        const estadoSelect = row.querySelector('td:nth-child(6) select');
        if (estadoSelect && estadoSelect.value.trim().toLowerCase() === estado.toLowerCase()) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

        // Funcionalidad del menú móvil
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            menuToggle.querySelector('i').classList.toggle('fa-bars');
            menuToggle.querySelector('i').classList.toggle('fa-times');
        });

        // Cerrar menú al hacer clic fuera en móvil
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 576) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                    menuToggle.querySelector('i').classList.add('fa-bars');
                    menuToggle.querySelector('i').classList.remove('fa-times');
                }
            }
        });

        // Ajustar layout al cambiar tamaño de ventana
        window.addEventListener('resize', function() {
            if (window.innerWidth > 576) {
                sidebar.classList.remove('active');
                menuToggle.querySelector('i').classList.add('fa-bars');
                menuToggle.querySelector('i').classList.remove('fa-times');
            }
        });

        const themeSwitch = document.querySelector('.theme-switch');
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
            themeSwitch.querySelector('i').classList.replace('fa-moon', 'fa-sun');
        }
        themeSwitch.addEventListener('click', () => {
            const currentTheme = document.body.getAttribute('data-theme');
            const icon = themeSwitch.querySelector('i');
            if (currentTheme === 'dark') {
                document.body.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
                icon.classList.replace('fa-sun', 'fa-moon');
            } else {
                document.body.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                icon.classList.replace('fa-moon', 'fa-sun');
            }
        });
    </script>
</body>
</html>
