<?php    
    include "../../api/includes/Client.class.php";    

    return Client::get_one_clients_lista($_GET["id"]);


?>