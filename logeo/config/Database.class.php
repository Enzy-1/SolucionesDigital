<?php
    class Database{
        private $host = 'localhost';
        private $user = 'root';
        private $password = '';
        private $database = 'code_pills';

        public function getConnection(){
            $hostDB = "mysql:host=".$this->host.";dbname=".$this->database.";";

            try{
                $connection = new PDO($hostDB,$this->user,$this->password);
                $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $connection;
            } catch(PDOException $e){
                die("ERROR: ".$e->getMessage());
            }

        }
        



        
    }

    // conexion.php
$conexion = new mysqli("localhost", "root", "", "code_pills");

// Verificar si la conexión tuvo éxito
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}




$host = 'localhost';
$dbname = 'code_pills';
$user = 'root';
$pass = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

?>