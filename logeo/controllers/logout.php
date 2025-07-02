<?php
session_start();
session_unset();    // Elimina todas las variables de sesión
session_destroy();  // Destruye la sesión
header("Location: ../views/index.php"); // Redirige al login o donde quieras
exit();
?>
