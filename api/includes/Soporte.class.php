<?php
require_once('Database.class.php');

class Soporte
{

    public static function create_client($nombre, $cedula, $telefono, $usuario_id, $csrf_token)
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

        $stmt = $conn->prepare('INSERT INTO clientes(nombre, cedula, telefono, usuario_id)
                VALUES(:nombre, :cedula, :telefono, :usuario_id)');
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':usuario_id', $usuario_id);

        if ($stmt->execute()) {
            header('HTTP/1.1 201 Cliente creado correctamente');
        } else {
            header('HTTP/1.1 404 Cliente no se ha creado correctamente');
        }
    }

    public static function get_all_entregas()
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT 
    f.fecha,
    f.total,
    f.estado_aprobacion,
    c.nombre AS cliente_nombre,
    c.telefono AS cliente_telefono,
    u.username AS usuario_nombre
FROM 
    factura f
JOIN 
    clientes c ON f.id_cliente = c.id
JOIN 
    usuarios u ON f.usuario_id = u.id
WHERE 
    f.estado_aprobacion = "Avisado";

');


        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            $variable = json_encode($result);
            //echo $variable;
            return json_encode($result);
            header('HTTP/1.1 201 OK');
        } else {
            header('HTTP/1.1 404 No se ha podido consultar el vehiculo');
        }
    }








    public static function get_all_soporte()
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT 
    f.*, 
    c.nombre AS cliente_nombre, 
    c.telefono AS cliente_telefono,
    u.username AS usuario_username
FROM 
    factura f
JOIN 
    clientes c ON f.id_cliente = c.id
JOIN 
    usuarios u ON f.usuario_id = u.id;

');


        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            $variable = json_encode($result);
            //echo $variable;
            return json_encode($result);
            header('HTTP/1.1 201 OK');
        } else {
            header('HTTP/1.1 404 No se ha podido consultar el vehiculo');
        }
    }






    




    
}

?>