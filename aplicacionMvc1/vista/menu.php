<?php
include_once "../../api/includes/Database.class.php";
include_once "../control/menuC.php";

session_start();
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['csrf_token'])) {
    header("Location: ../../logeo/views/index.php"); 
     exit;
  }

// Obtener el nombre del archivo actual
$current_page = basename($_SERVER['PHP_SELF']);

// Definir la ruta base usando el directorio del documento
$document_root = $_SERVER['DOCUMENT_ROOT'];
$project_folder = 'programaCompleto';
$vista_folder = 'aplicacionMvc1/vista';
$logeo_folder = 'logeo';

// Construir las rutas absolutas desde la raíz del servidor
$project_path = "/{$project_folder}";
$vista_path = "{$project_path}/{$vista_folder}";
$logeo_path = "{$project_path}/{$logeo_folder}";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Digital Solutions - Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="diseños/estilos-comunes.css" rel="stylesheet">
        <link href="diseños/menu.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

<div class="main-content" id="main">
        <div class="dashboard-header">
            <h1>Panel de Control</h1>
            <div class="date-filter">
                <button class="time-btn active">Hoy</button>
                <button class="time-btn">Semana</button>
                <button class="time-btn">Mes</button>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-box gradient-purple">
                <div class="stat-info">
                    <h3>Total Clientes</h3>
                    <div class="stat-number"><?php echo $totalActual; ?></div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span><?php echo $porcentajeTexto; ?>% mes anterior</span>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>

            <div class="stat-box gradient-blue">
                <div class="stat-info">
                    <h3>En Revisión</h3>
                    <div class="stat-number"><?php echo $totalRevision; ?></div>
                    <div class="stat-trend">
                        <span>Equipos pendientes</span>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-tools"></i>
                </div>
            </div>

            <div class="stat-box gradient-orange">
                <div class="stat-info">
                    <h3>En Proceso</h3>
                    <div class="stat-number"><?php echo $totalProceso; ?></div>
                    <div class="stat-trend">
                        <span>En reparación</span>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-cog fa-spin"></i>
                </div>
            </div>

            <div class="stat-box gradient-green">
                <div class="stat-info">
                    <h3>Completados</h3>
                    <div class="stat-number"><?php echo $totalCompletados; ?></div>
                    <div class="stat-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>Este mes</span>
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="charts-container">
            <div class="chart-box">
                <h3>Estado de Equipos</h3>
                <div id="equipmentDonut"></div>
            </div>
            
            <div class="chart-box">
                <h3>Servicios por Mes</h3>
                <div id="servicesLine"></div>
            </div>
        </div>

        <div class="bottom-grid">
            <div class="recent-services">
                <h3>Servicios Más Solicitados</h3>
                <div class="service-bars">
                    <div class="service-bar">
                        <div class="bar-label">Mantenimiento</div>
                        <div class="bar-container">
                            <div class="bar" style="width: 85%;"></div>
                            <span>85%</span>
                        </div>
                    </div>
                    <div class="service-bar">
                        <div class="bar-label">Reparación</div>
                        <div class="bar-container">
                            <div class="bar" style="width: 65%;"></div>
                            <span>65%</span>
                        </div>
                    </div>
                    <div class="service-bar">
                        <div class="bar-label">Diagnóstico</div>
                        <div class="bar-container">
                            <div class="bar" style="width: 45%;"></div>
                            <span>45%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <h3>Acciones Rápidas</h3>
                <div class="action-buttons">
                    <button class="action-btn">
                        <i class="fas fa-plus-circle"></i>
                        Nuevo Servicio
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-user-plus"></i>
                        Nuevo Cliente
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-file-alt"></i>
                        Generar Reporte
                    </button>
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
    // Gráfica de Dona para Estado de Equipos
    var donutOptions = {
        series: [44, 55, 32, 33],
        chart: {
            type: 'donut',
            height: 300
        },
        labels: ['En Revisión', 'En Proceso', 'Completados', 'Pendientes'],
        colors: ['#4361ee', '#ff6b6b', '#46d160', '#ffd93d'],
        plotOptions: {
            pie: {
                donut: {
                    size: '70%'
                }
            }
        },
        legend: {
            position: 'bottom'
        }
    };

    var donutChart = new ApexCharts(document.querySelector("#equipmentDonut"), donutOptions);
    donutChart.render();

    // Gráfica de Línea para Servicios por Mes
    var lineOptions = {
        series: [{
            name: 'Servicios',
            data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
        }],
        chart: {
            height: 300,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: ['#4361ee'],
        xaxis: {
            categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep']
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'horizontal',
                shadeIntensity: 0.5,
                opacityFrom: 1,
                opacityTo: 0.7
            }
        }
    };

    var lineChart = new ApexCharts(document.querySelector("#servicesLine"), lineOptions);
    lineChart.render();

    // Tema oscuro/claro
    const themeSwitch = document.querySelector('.theme-switch');
    
    // Verificar preferencia guardada
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.setAttribute('data-theme', 'dark');
        themeSwitch.querySelector('i').classList.replace('fa-moon', 'fa-sun');
    }

    // Cambiar tema
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

        // Actualizar colores de las gráficas
        updateChartsTheme(currentTheme === 'dark' ? 'light' : 'dark');
    });

    // Función para actualizar el tema de las gráficas
    function updateChartsTheme(theme) {
        const isDark = theme === 'dark';
        const textColor = isDark ? '#ffffff' : '#333333';
        const gridColor = isDark ? '#404040' : '#e0e0e0';
        const backgroundColor = isDark ? '#2d2d2d' : '#ffffff';

        // Actualizar gráfica de dona
        donutChart.updateOptions({
            chart: {
                foreColor: textColor,
                background: backgroundColor
            },
            legend: {
                labels: {
                    colors: textColor
                }
            }
        });

        // Actualizar gráfica de línea
        lineChart.updateOptions({
            chart: {
                foreColor: textColor,
                background: backgroundColor
            },
            grid: {
                borderColor: gridColor
            },
            xaxis: {
                labels: {
                    style: {
                        colors: textColor
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: textColor
                    }
                }
            }
        });
    }
</script>
</body>
</html>