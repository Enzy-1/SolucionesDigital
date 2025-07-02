<?php    
    include_once "../../api/includes/Marca.class.php";    
   function listarDatosListaDesplegable_marca($metodo){
    if($metodo == 'GET'){
    return Marca::get_all_marca_lista();
    } 
   }     

?>