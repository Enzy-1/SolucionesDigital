<?php
require_once('Database.class.php');

class Client
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



    public static function delete_client_by_id($id)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('DELETE FROM conferencias WHERE id=:id');
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            header('HTTP/1.1 201 Vehiculo borrad correctamente');
        } else {
            header('HTTP/1.1 404 Vehiculo no se ha podido borrar correctamente');
        }
    }


    public static function get_all_clientes_lista()
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT id,nombre FROM clientes');
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return json_encode($result);

            header('HTTP/1.1 201 OK');
        } else {
            header('HTTP/1.1 404 No se ha podido consultar los clientes');
        }
    }



    public static function get_all_clients()
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT * FROM clientes');


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


    
    public static function get_one_clients_lista($id)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT * FROM clientes where id=:id');
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            echo json_encode($result);
        } else {
            header('HTTP/1.1 404 No se ha podido consultar el vehiculo');
        }
    }



    public static function update_client($id, $nombre, $cedula, $telefono)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $stmt = $conn->prepare('UPDATE clientes SET nombre=:nombre, cedula=:cedula, telefono=:telefono WHERE id=:id');
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        

    }



    
}

?>