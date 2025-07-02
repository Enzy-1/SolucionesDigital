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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="diseños/entregas.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

  <header class="header">
    <div class="header-container">
      <h1><i class="fas fa-tools"></i> Digital Solutions</h1>
      <a href="menu.php" class="btn-menu">
        <i class="fas fa-home"></i> Menú Principal
      </a>
    </div>
  </header>

  <main class="main-container">
    <section class="titulo-seccion">
      <h2><i class="fas fa-box-open"></i> Equipos Facturados para Entregar</h2>
      <p>Lista actualizada de dispositivos en estado <strong>Revisión</strong>.</p>
    </section>

    <section class="contenedor-tarjetas">
      <?php listarEntregas(); ?>
    </section>
  </main>

  <footer class="footer">
    <p>&copy; 2025 Digital Solutions. Todos los derechos reservados.</p>
  </footer>

</body>
</html>
