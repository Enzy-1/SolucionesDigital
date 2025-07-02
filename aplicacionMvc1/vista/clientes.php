<?php
include_once "../control/clientesC.php";


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
    <title>Gestión de Clientes | Digital Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link href="diseños/estilos-comunes.css" rel="stylesheet">
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
            background: rgba(100, 181, 246, 0.15);
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
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
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

              .modal-dialog {
            top: 50% !important;
            transform: translateY(-50%) !important;
            margin: 0 auto !important;
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
                <i class="fas fa-users me-2"></i>Gestión de Clientes
            </h2>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="search-container w-50">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="buscadorClientes" placeholder="Buscar cliente...">
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarCliente">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Cliente
                </button>
            </div>

            <div class="table-responsive">
                <?php listarClientes(); ?>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Cliente -->
    <div class="modal fade" id="modalAgregarCliente" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>Agregar Nuevo Cliente
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarCliente" method="POST" action="../control/clientesC.php"
                        class="needs-validation" novalidate>
                        <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="cedula" class="form-label">Cédula</label>
                            <input type="number" class="form-control" id="cedula" name="cedula" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Cliente -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Editar Cliente
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarCliente" method="POST" action="../control/clientesC.php"
                        class="needs-validation" novalidate>
                        <input type="hidden" name="accion" value="actualizar">
                        <input type="hidden" name="id" id="edit-id">

                        <div class="mb-3">
                            <label for="edit-nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="edit-nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-cedula" class="form-label">Cédula</label>
                            <input type="text" class="form-control" name="cedula" id="edit-cedula" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" id="edit-telefono" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón y script de cambio de tema -->
    <div class="theme-switch" data-tooltip="Cambiar tema">
        <i class="fas fa-moon"></i>
    </div>
    <script>
        // Función para abrir el modal de edición
        function abrirModal(cliente) {
            document.getElementById('edit-id').value = cliente.id;
            document.getElementById('edit-nombre').value = cliente.nombre;
            document.getElementById('edit-cedula').value = cliente.cedula;
            document.getElementById('edit-telefono').value = cliente.telefono;

            const modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
            modal.show();
        }

        // Validación de formularios
        const forms = document.querySelectorAll('.needs-validation');
        forms.forEach(form => {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });

        // Búsqueda de clientes
        document.getElementById('buscadorClientes').addEventListener('keyup', function () {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });

        // Funcionalidad del menú móvil
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        menuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            menuToggle.querySelector('i').classList.toggle('fa-bars');
            menuToggle.querySelector('i').classList.toggle('fa-times');
        });

        // Cerrar menú al hacer clic fuera en móvil
        document.addEventListener('click', function (event) {
            if (window.innerWidth <= 576) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                    menuToggle.querySelector('i').classList.add('fa-bars');
                    menuToggle.querySelector('i').classList.remove('fa-times');
                }
            }
        });

        // Ajustar layout al cambiar tamaño de ventana
        window.addEventListener('resize', function () {
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