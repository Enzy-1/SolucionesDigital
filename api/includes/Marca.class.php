<?php
require_once('Database.class.php');

class Marca
{

    public static function create_client($titulo, $conferencista_id, $descripcion, $area, $usuario_id, $csrf_token)
    {
        session_start(); // Asegúrate de que la sesión esté iniciada para acceder al token

        // Verificar el token de seguridad
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            header('HTTP/1.1 403 Token de seguridad inválido');
            echo "Token de seguridad inválido.";
            exit;
        }

        $database = new Database();
        $conn = $database->getConnection();

        $stmt = $conn->prepare('INSERT INTO conferencias(titulo, conferencista_id, descripcion, area, usuario_id)
                VALUES(:titulo, :conferencista_id, :descripcion, :area, :usuario_id)');
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':conferencista_id', $conferencista_id);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':area', $area);
        $stmt->bindParam(':usuario_id', $usuario_id);

        if ($stmt->execute()) {
            header('HTTP/1.1 201 Vehículo creado correctamente');
        } else {
            header('HTTP/1.1 404 Vehículo no se ha creado correctamente');
        }
    }




    public static function get_all_marca_lista()
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT * FROM marcas');
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return json_encode($result);

            header('HTTP/1.1 201 OK');
        } else {
            header('HTTP/1.1 404 No se ha podido consultar los clientes');
        }
    }









    
}

?>