<?php
   require_once '../config/Database.class.php'; 
   include "../controllers/User.class.php";
   include "../models/UserC.php";

   $usuarioController = new UsuarioController($db);

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       if (isset($_POST['action'])) {
           if ($_POST['action'] === 'register') {
               $usuarioController->register($_POST['username'], $_POST['password'], $_POST['email']);
           } elseif ($_POST['action'] === 'login') {
               $usuarioController->login($_POST['email'], $_POST['password']);
           }
       }
   }
   
   session_start();


   

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <script>
        function showForm(formType) {
            document.getElementById('registerForm').classList.remove('active');
            document.getElementById('loginForm').classList.remove('active');
            document.getElementById(formType).classList.add('active');
        }
    </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="index.css" />
</head>
<body>
    <div class="login-container">
        <h1><i class="fas fa-laptop-code"></i> Digital Solutions</h1>
        <h2>Iniciar Sesión</h2>
        <form id="loginForm" method="POST">
            <div class="input-group">
                <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="ejemplo@dominio.com" required>
            </div>
            <div class="input-group">
                <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>
            <input type="hidden" name="action" value="login">
            <button type="submit" class="btn-submit">Iniciar sesión</button>
        </form>

    </div>
</body>
</html>