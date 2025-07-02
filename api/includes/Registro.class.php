<?php
require_once('Database.class.php');

class Registro
{

    public static function create_registro($username, $celular, $email, $password, $csrf_token)
    {
        session_start(); // Asegúrate de que la sesión esté iniciada para acceder al token

        // Verificar el token de seguridad
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            header('HTTP/1.1 403 Token de seguridad inválido');
            echo "Token de seguridad inválido.";
            exit;
        }

            // Hashear la contraseña antes de guardarla
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $database = new Database();
        $conn = $database->getConnection();

        $stmt = $conn->prepare('INSERT INTO usuarios(username, celular, email, password)
                VALUES(:username, :celular, :email, :password)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hashed);

        if ($stmt->execute()) {
            header('HTTP/1.1 201 Usuario creado correctamente');
        } else {
            header('HTTP/1.1 404 Usuario no se ha creado correctamente');
        }
    }

    public static function delete_registro_by_id($id)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('DELETE FROM usuarios WHERE id=:id');
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            header('HTTP/1.1 201 Usuario borrado correctamente');
        } else {
            header('HTTP/1.1 404 Usuario no se ha podido borrar correctamente');
        }
    }


    
    public static function get_all_registro()
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT * FROM usuarios');


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


    public static function update_registro($id, $username, $celular, $email)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $stmt = $conn->prepare('UPDATE usuarios SET username=:username, celular=:celular, email:email WHERE id=:id');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        

    }
    


 



    
}

?>