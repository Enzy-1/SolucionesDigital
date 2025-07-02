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
      <?php listarAviso(); ?>
    </section>
  </main>

  <footer class="footer">
    <p>&copy; 2025 Digital Solutions. Todos los derechos reservados.</p>
  </footer>

</body>
</html>
