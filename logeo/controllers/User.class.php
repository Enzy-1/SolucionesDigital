<?php
require_once '../config/Database.class.php';
class Usuario {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($username, $celular, $password, $email) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO usuarios (username, celular, password, email) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $celular, $passwordHash, $email]);
    }

    
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $email = $stmt->fetch();

        if ($email && password_verify($password, $email['password'])) {
            return $email;
        }
        return false;
    }
}



function obtenerProgramas() {
    // Conexión a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'code_pills');
    
    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Consulta para obtener los nombres de la tabla programas
    $consulta = "SELECT * FROM programas";
    $resultado = $conexion->query($consulta);
    
    // Verificar si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        // Recorrer los resultados y mostrar las opciones en la lista desplegable
        while($fila = $resultado->fetch_assoc()) {
            echo "<option value='" . $fila['id'] . "'>" . $fila['nombre'] . "</option>";
        }
    } else {
        echo "<option>No hay programas disponibles</option>";
    }

    // Cerrar la conexión
    $conexion->close();
}


?>
