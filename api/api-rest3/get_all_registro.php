<?php    
   include_once "../../api/includes/Registro.class.php";    
   function listarDatos($metodo){
    if($metodo == 'GET'){
    return Registro::get_all_registro();
    } 
   }     

?>