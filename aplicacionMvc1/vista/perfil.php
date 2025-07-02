<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['csrf_token'])) {
    header("Location: ../../logeo/views/index.php");
    exit;
}

// Aquí iría la lógica para obtener los datos del usuario de la base de datos
$user_id = $_SESSION['usuario_id'];
$user_email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil | Digital Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="diseños/estilos-comunes.css" rel="stylesheet">
    <style>
        /* Mejoras para tema oscuro y contraste */
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
        [data-theme="dark"] .activity-icon {
            background: #181c24 !important;
            color: #64B5F6 !important;
            border: 1.5px solid #64B5F6;
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
        [data-theme="dark"] .profile-image {
            border: 2px solid #64B5F6;
        }
    </style>
</head>
<body>
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
            <a class="nav-link active" href="perfil.php">
                <i class="fas fa-user-circle"></i>
                <span>Mi Perfil</span>
            </a>
            <a class="nav-link" href="../../logeo/controllers/logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Salir</span>
            </a>
        </nav>
    </div>

    <!-- Contenido Principal -->
    <div class="main-content">
        <div class="container py-4">
            <div class="row">
                <!-- Perfil -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="position-relative d-inline-block mb-3">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user_email); ?>&background=2196F3&color=fff" 
                                     alt="Foto de perfil" 
                                     class="rounded-circle profile-image"
                                     style="width: 150px; height: 150px;">
                                <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle" 
                                        data-tooltip="Cambiar foto">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                            <h5 class="card-title mb-1"><?php echo htmlspecialchars($user_email); ?></h5>
                            <p class="text-muted mb-3">Usuario Activo</p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary" data-tooltip="Editar perfil">
                                    <i class="fas fa-edit me-2"></i>Editar Perfil
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Preferencias -->
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-3">Preferencias</h6>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="themeSwitch">
                                <label class="form-check-label" for="themeSwitch">Tema Oscuro</label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="notificationsSwitch" checked>
                                <label class="form-check-label" for="notificationsSwitch">Notificaciones</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información y Actividad -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Información Personal</h5>
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" value="Usuario">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" value="<?php echo htmlspecialchars($user_email); ?>" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" placeholder="Agregar teléfono">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Rol</label>
                                        <input type="text" class="form-control" value="Usuario" readonly>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Guardar Cambios
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Actividad Reciente -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Actividad Reciente</h5>
                            <div class="activity-timeline">
                                <div class="activity-item d-flex mb-3">
                                    <div class="activity-icon bg-primary text-white rounded-circle p-2 me-3">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Inicio de sesión</h6>
                                        <p class="text-muted mb-0">Hace 5 minutos</p>
                                    </div>
                                </div>
                                <div class="activity-item d-flex mb-3">
                                    <div class="activity-icon bg-success text-white rounded-circle p-2 me-3">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Soporte completado</h6>
                                        <p class="text-muted mb-0">Hace 2 horas</p>
                                    </div>
                                </div>
                                <div class="activity-item d-flex">
                                    <div class="activity-icon bg-info text-white rounded-circle p-2 me-3">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Nuevo cliente registrado</h6>
                                        <p class="text-muted mb-0">Hace 1 día</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Switcher -->
    <div class="theme-switch" data-tooltip="Cambiar tema">
        <i class="fas fa-moon"></i>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tema oscuro/claro
        const themeSwitch = document.querySelector('.theme-switch');
        const themeSwitchCheckbox = document.getElementById('themeSwitch');
        
        // Verificar preferencia guardada
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
            themeSwitchCheckbox.checked = true;
        }

        // Cambiar tema
        themeSwitch.addEventListener('click', () => {
            const currentTheme = document.body.getAttribute('data-theme');
            if (currentTheme === 'dark') {
                document.body.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
                themeSwitchCheckbox.checked = false;
            } else {
                document.body.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                themeSwitchCheckbox.checked = true;
            }
        });

        // Cambiar tema desde el switch
        themeSwitchCheckbox.addEventListener('change', () => {
            if (themeSwitchCheckbox.checked) {
                document.body.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>
</body>
</html> 