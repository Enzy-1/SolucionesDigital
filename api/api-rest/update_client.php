<?php


if (
    $_SERVER['REQUEST_METHOD'] == 'POST'
    && isset($_GET['id'], $_GET['nombre']) && isset($_GET['cedula']) && isset($_GET['telefono'])
) {
    include "../../api/includes/Client.class.php";
    Client::update_client($_GET['id'], $_GET['nombre'], $_GET['cedula'], $_GET['telefono']);
}







?>