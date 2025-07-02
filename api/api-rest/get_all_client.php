<?php    
   include_once "../../api/includes/Client.class.php";    
   function listarDatos($metodo){
    if($metodo == 'GET'){
    return Client::get_all_clients();
    } 
   }     

?>