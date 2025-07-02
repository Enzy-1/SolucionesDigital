<?php
echo getcwd();

include_once "../../api/includes/Registro.class.php";

    
    function crearRegistro($username, $celular, $email, $password, $csrf_token){
      if ($_SERVER['REQUEST_METHOD']=="POST"){
         Registro::create_registro($username, $celular, $email, $password, $csrf_token);
      }
    }
?>
    