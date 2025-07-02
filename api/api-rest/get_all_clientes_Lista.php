<?php    
    include_once "../../api/includes/Client.class.php";    
   function listarDatosListaDesplegable_clientes($metodo){
    if($metodo == 'GET'){
    return Client::get_all_clientes_lista();
    } 
   }     

?>