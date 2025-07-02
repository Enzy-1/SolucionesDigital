<?php    
   include_once "../../api/includes/Soporte.class.php";    
   function listarDatos($metodo){
    if($metodo == 'GET'){
    return Soporte::get_all_entregas();
    } 
   }     

?>