<?php    
  
    if($_SERVER['REQUEST_METHOD'] == 'DELETE' ){
        include "../../api/includes/Client.class.php";    
        Client::delete_client_by_id($_GET["codigo"]);
    } 




?>