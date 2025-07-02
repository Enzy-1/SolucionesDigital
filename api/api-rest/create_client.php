<?php
echo getcwd();

include_once "../../api/includes/Client.class.php";

    
    function crearCliente($nombre, $cedula, $telefono, $usuario_id, $csrf_token){
      if ($_SERVER['REQUEST_METHOD']=="POST"){
         Client::create_client($nombre, $cedula, $telefono, $usuario_id, $csrf_token);
      }
    }
?>
    