<?php
include_once "../../api/includes/Database.class.php";
include_once "../control/RolesC.php";
include_once "../control/marcaC.php";
include_once "../control/clientesC.php";
include_once "../../api/includes/Client.class.php";
include_once "../../api/includes/Marca.class.php";


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
    <title>Soporte Técnico | Digital Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="diseños/estilos-comunes.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <!-- CSS de Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- JS de jQuery (requerido por Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JS de Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



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

        [data-theme="dark"] .select2-container--default .select2-selection--single {
            background-color: #232b3e;
            color: #64B5F6;
            border: 1px solid #64B5F6;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        [data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #64B5F6;
        }

        [data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #64B5F6 transparent transparent transparent;
        }

        [data-theme="dark"] .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #64B5F6;
            color: #232b3e;
        }

        [data-theme="dark"] .select2-dropdown {
            background-color: #232b3e;
            color: #64B5F6;
            border: 1px solid #64B5F6;
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
            <a class="nav-link" href="../../logeo/controllers/logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Salir</span>
            </a>
        </nav>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        <div class="container fade-in">
            <h2 class="text-center mb-4">
                <i class="fas fa-tools me-2"></i> Gestión de Soporte Técnico
            </h2>

            <form method="POST" action="../control/RolesC.php" class="needs-validation" novalidate>
                <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="row">
                    <!-- Columna Izquierda -->
                    <div class="col-md-6">
                        <!-- Cliente -->
                        <div class="mb-4">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <div class="d-flex gap-2">
                                <?php llenar_Lista_clientes(); ?>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalAgregarCliente">
                                    <i class="fas fa-user-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Marca del Equipo -->
                        <div class="mb-4">
                            <label for="marca" class="form-label">Marca del Equipo</label>
                            <div class="d-flex">
                                <?php llenar_Lista_marca(); ?>
                            </div>
                        </div>

                        <!-- Imei o Serial -->
                        <div class="mb-4">
                            <label for="imei_serial" class="form-label">Imei o Serial</label>
                            <input type="text" name="imei_serial" id="imei_serial" class="form-control" required>
                        </div>


                        <div class="mb-4">
                            <label for="modelo" class="form-label">Modelo del equipo</label>
                            <input type="text" name="modelo" id="modelo" class="form-control" required>
                        </div>


                        <div class="mb-4">
                            <label for="observaciones" class="form-label">Observaciones del equipo</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" rows="4"
                                required></textarea>
                        </div>

                    </div>

                    <!-- Columna Derecha -->
                    <div class="col-md-6">

                        <!-- Descripción del Problema -->
                        <div class="mb-4">
                            <label for="reparacion" class="form-label">Tipo de reparacion</label>
                            <input type="text" name="reparacion" id="reparacion" class="form-control" required>

                        </div>

                        <div class="mb-4">
                            <label for="total" class="form-label">Costo Total</label>
                            <input type="text" name="total" id="total" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="abono" class="form-label">Abono del Cliente</label>
                            <input type="text" name="abono" id="abono" class="form-control" required>
                        </div>

                        <!-- Imágenes up to 4 -->
                        <div class="mb-3">
                            <label for="imagenes" class="form-label">Imagenes del equipo</label>
                            <input type="file" name="imagenes[]" id="imagenes" class="form-control" accept="image/*"
                                multiple
                                onchange="if(this.files.length>4){ alert('Sólo puedes subir hasta 4 imágenes'); this.value=''; }">
                            <div class="form-label">Selecciona entre 1 y 4 archivos.</div>
                            <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['usuario_id']; ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        </div>
                    </div>

                    <!-- Botón enviar con ID 'procesar' -->
                    <div class="text-center mt-4">
                        <button type="submit" id="procesar" name="procesar" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-save me-2"></i>Guardar Soporte
                        </button>
                    </div>
            </form>
        </div>

    </div>

    <!-- Modal Agregar Cliente -->
    <div class="modal fade" id="modalAgregarCliente" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">
                        <i class="fas fa-user-plus me-2"></i>Agregar Nuevo Cliente
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarCliente" method="POST" action="../control/clientesC.php">
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

    <!-- Botón y script de cambio de tema -->
    <div class="theme-switch" data-tooltip="Cambiar tema">
        <i class="fas fa-moon"></i>
    </div>

    <script>
        $(document).ready(function () {
            $('#id_cliente').select2({
                width: '100%',
                placeholder: 'Selecciona un cliente',
                theme: 'default' // usamos el tema base, pero luego lo personalizamos
            });
        });
    </script>



    <script>
        $(document).ready(function () {
            // Validación del formulario
            const form = document.querySelector('.needs-validation');
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
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