<?php
require_once('Database.class.php');

class Factura
{

    public static function create_factura($id_cliente, $id_marca, $imei_serial, $modelo, $observaciones, $reparacion, $total, $abono, $usuario_id, $csrf_token, $imagenes)
    {
        session_start();
    
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            header('HTTP/1.1 403 Token de seguridad inválido');
            echo "Token de seguridad inválido.";
            exit;
        }
    
        $database = new Database();
        $conn = $database->getConnection();
        $anioActual = date('Y');
    
        // Generar número de factura
        $sql = "SELECT numero_factura FROM factura 
                WHERE numero_factura LIKE :anio_pattern 
                ORDER BY id_factura DESC LIMIT 1";
    
        $pattern = 'FAC-' . $anioActual . '-%';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':anio_pattern', $pattern);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $nuevoConsecutivo = ($row && isset($row['numero_factura'])) ? intval(explode('-', $row['numero_factura'])[2]) + 1 : 1;
        $numeroFactura = 'FAC-' . $anioActual . '-' . str_pad($nuevoConsecutivo, 4, '0', STR_PAD_LEFT);
    
// Procesar imágenes
$rutasImagenes = [];
if (!empty($imagenes['name'][0])) {
    $uploadDir = __DIR__ . "/../uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    for ($i = 0; $i < count($imagenes['name']); $i++) {
        if ($imagenes['error'][$i] === UPLOAD_ERR_OK) {
            $nombreTmp = $imagenes['tmp_name'][$i];
            $nombreArchivo = uniqid('img_') . "_" . basename($imagenes['name'][$i]);
            $rutaDestino = $uploadDir . $nombreArchivo;
            $rutaRelativa = "uploads/" . $nombreArchivo;

            if (move_uploaded_file($nombreTmp, $rutaDestino)) {
                $rutasImagenes[] = $rutaRelativa;
            } else {
                echo "❌ Error al mover el archivo: " . $imagenes['name'][$i];
            }
        } else {
            echo "⚠️ Error en archivo {$imagenes['name'][$i]}: código {$imagenes['error'][$i]}<br>";
        }
    }
}

    
        $imagenesJSON = json_encode($rutasImagenes);
    
        // Insertar en la base de datos
        $stmt = $conn->prepare('INSERT INTO factura (
            numero_factura, id_cliente, id_marca, imei_serial, modelo, observaciones, reparacion, total, abono, usuario_id, imagenes
        ) VALUES (
            :numero_factura, :id_cliente, :id_marca, :imei_serial, :modelo, :observaciones, :reparacion, :total, :abono, :usuario_id, :imagenes
        )');
        
        // Primero haces los bindParam
        $stmt->bindParam(':numero_factura', $numeroFactura);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_marca', $id_marca);
        $stmt->bindParam(':imei_serial', $imei_serial);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':observaciones', $observaciones);
        $stmt->bindParam(':reparacion', $reparacion);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':abono', $abono);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':imagenes', $imagenesJSON);
        
        // Y solo después ejecutas
        $stmt->execute();
        
    }
    
    
    




}

?>