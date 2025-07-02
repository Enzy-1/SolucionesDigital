<?php
require_once '../fpdf186/fpdf.php';



// Procesamiento del formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    
    // Verificar si se envía el formulario de creación de cliente
    if (isset($_POST['procesar']) && isset($_POST['id_cliente']) && isset($_POST['id_marca']) && isset($_POST['imei_serial']) && isset($_POST['modelo'])  && isset($_POST['observaciones']) &&  isset($_POST['reparacion']) &&  isset($_POST['total']) &&  isset($_POST['abono']) &&  isset($_POST['usuario_id'])) {
        include "../../api/api-rest1/create_factura.php"; 
        $id_cliente = $_POST['id_cliente'];
        $id_marca = $_POST['id_marca'];
        $imei_serial = $_POST['imei_serial'];
        $modelo = $_POST['modelo'];
        $observaciones = $_POST['observaciones'];
        $reparacion = $_POST['reparacion'];
        $total = $_POST['total'];
        $abono = $_POST['abono'];
        $usuario_id = $_POST['usuario_id'];
        $csrf_token= $_POST['csrf_token'];
        $imagenes = $_FILES['imagenes'];
        crearFactura(
            $id_cliente,
            $id_marca,
            $imei_serial,
            $modelo,
            $observaciones,
            $reparacion,
            $total,
            $abono,
            $usuario_id,
            $csrf_token,
            $imagenes // <--- Añadir esto
        );   
     }





// === 1. Capturar datos del formulario ===
$cliente_id = $_POST['id_cliente'];
$marca = $_POST['id_marca'];
$imei_serial = $_POST['imei_serial'];
$modelo = $_POST['modelo'];
$observaciones = $_POST['observaciones'];
$reparacion = $_POST['reparacion'];
$total = $_POST['total'];
$abono = $_POST['abono'];

// === 2. Obtener datos del cliente ===
try {
    $conexion = new Database();
    $conn = $conexion->getConnection();

    // Obtener cliente
    $stmt = $conn->prepare("SELECT nombre, telefono, cedula FROM clientes WHERE id = ?");
    $stmt->execute([$cliente_id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        die("Cliente no encontrado.");
    }

    $nombre_cliente = $cliente['nombre'];
    $telefono = $cliente['telefono'];
    $cedula = $cliente['cedula'];

    // Obtener nombre de la marca
    $stmt_marca = $conn->prepare("SELECT nombre FROM marcas WHERE id = ?");
    $stmt_marca->execute([$marca]);
    $fila_marca = $stmt_marca->fetch(PDO::FETCH_ASSOC);
    $nombre_marca = $fila_marca ? $fila_marca['nombre'] : "Marca desconocida";

    // Obtener imágenes desde la base de datos (factura)
    $stmt_imgs = $conn->prepare("SELECT imagenes, numero_factura FROM factura WHERE imei_serial = ?");
    $stmt_imgs->execute([$imei_serial]);
    $fila_imgs = $stmt_imgs->fetch(PDO::FETCH_ASSOC);

    $numeroFactura = $fila_imgs['numero_factura']; // Ya disponible para el PDF

    $imagenes = [];
    if ($fila_imgs && !empty($fila_imgs['imagenes'])) {
        $imagenes = json_decode($fila_imgs['imagenes']);
        var_dump($imagenes); // DEBUG
    }
    

} catch (Exception $e) {
    die("Error al obtener datos: " . $e->getMessage());
}


$pdf = new FPDF();
$pdf->AddPage();

// ENCABEZADO
$pdf->Image('../img/logo.png', 10, 10, 35);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('DIGITAL SOLUTIONS - SOPORTE TÉCNICO'), 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, utf8_decode('Centro Comercial Caña Dulce, Jamundí'), 0, 1, 'C');
$pdf->Cell(0, 6, utf8_decode('Email: solutionsdigital343@gmail.com'), 0, 1, 'C');
$pdf->Cell(0, 6, utf8_decode('WhatsApp: 317 662 7475 | NIT: 1.112.479.489-1'), 0, 1, 'C');
$pdf->Cell(0, 6, utf8_decode('NO SOMOS RESPONSABLES DE IVA'), 0, 1, 'C');

// LÍNEA DIVISORIA
$pdf->Ln(5);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(8);

// DATOS DE LA FACTURA
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, utf8_decode('Número de Factura: ' . $numeroFactura), 0, 1);
$pdf->Cell(0, 8, utf8_decode('Fecha: ' . date('d/m/Y')), 0, 1);

// LÍNEA DIVISORIA
$pdf->Ln(4);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(8);

// DATOS DEL CLIENTE
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, utf8_decode('Datos del Cliente'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 8, utf8_decode('Nombre:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($nombre_cliente), 0, 1);
$pdf->Cell(50, 8, utf8_decode('Cédula:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($cedula), 0, 1);
$pdf->Cell(50, 8, utf8_decode('Marca:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($nombre_marca), 0, 1);
$pdf->Cell(50, 8, utf8_decode('Modelo:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($modelo), 0, 1);
$pdf->Cell(50, 8, utf8_decode('IMEI o Serial:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($imei_serial), 0, 1);

// OBSERVACIONES
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, utf8_decode('Observaciones'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 8, utf8_decode($observaciones), 1);

// REPARACIÓN
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, utf8_decode('Reparación Realizada'), 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 8, utf8_decode($reparacion), 1);

// COSTOS
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, utf8_decode('Costo Total:'), 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '$ ' . number_format($total, 0, ',', '.'), 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, utf8_decode('Abono:'), 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '$ ' . number_format($abono, 0, ',', '.'), 0, 1);

$saldo = $total - $abono;
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, utf8_decode('Saldo Pendiente:'), 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '$ ' . number_format($saldo, 0, ',', '.'), 0, 1);

// PIE DE PÁGINA
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, utf8_decode('Gracias por confiar en Digital Solutions. Tu equipo está en buenas manos.'), 0, 1, 'C');

// SEGUNDA PÁGINA PARA IMÁGENES
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Imágenes del equipo'), 0, 1, 'C');
$pdf->Ln(5);

// Mostrar imágenes
if (!empty($imagenes)) {
    $x = 10;
    $y = $pdf->GetY();
    $img_width = 90;
    $img_height = 90;
    $max_per_row = 2;
    $count = 0;

    foreach ($imagenes as $img_path) {
        $localPath = "../../api/" . $img_path;

        if (file_exists($localPath)) {
            try {
                $pdf->Image($localPath, $x, $y, $img_width, $img_height);
                $x += $img_width + 10;
                $count++;

                if ($count % $max_per_row == 0) {
                    $x = 10;
                    $y += $img_height + 10;
                }
            } catch (Exception $e) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(0, 10, utf8_decode("Error al cargar imagen."), 0, 1);
            }
        } else {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 10, utf8_decode("Imagen no encontrada."), 0, 1);
        }
    }

    // Actualizar posición para la firma electrónica
    if ($count % $max_per_row != 0) {
        $y += $img_height + 10;
    }
    $pdf->SetY($y + 10);

} else {
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, utf8_decode('No se encontraron imágenes.'), 0, 1);
}

// FIRMA ELECTRÓNICA
date_default_timezone_set('America/Bogota');
$fechaFirma = date('d-m-Y H:i');
$pdf->SetFont('Arial', 'I', 10);
$pdf->MultiCell(0, 8, utf8_decode("Firmado electrónicamente por $nombre_cliente\nCC $cedula\nFecha: $fechaFirma"), 0, 'L');



// === 4. Guardar PDF ===   
$filename = "reporte_$numeroFactura.pdf";
$carpeta_pdfs = __DIR__ . '/../pdfs';
if (!file_exists($carpeta_pdfs)) {
    mkdir($carpeta_pdfs, 0777, true);
}
$ruta_pdf = $carpeta_pdfs . '/' . $filename;
$pdf->Output("F", $ruta_pdf);

// Crear mensaje con link al PDF
$url_pdf_publica = "http://localhost/programacompleto/aplicacionMvc1/pdfs/$filename";
$mensaje = "Hola $nombre_cliente, gracias por confiar en Digital Solutions. Aquí tienes el comprobante de tu reparación: $url_pdf_publica";
$telefono_internacional = "57" . preg_replace('/[^0-9]/', '', $telefono);
$link_whatsapp = "https://wa.me/$telefono_internacional?text=" . urlencode($mensaje);


// ESTA FUNCION DESCARGA EL PDF AUTOMATICAMENTE
//header('Content-Type: application/pdf');
//header('Content-Disposition: attachment; filename="' . $filename . '"');
//readfile($ruta_pdf);



// Redirigir directamente a WhatsApp
header("Location: redirigir_a_whatsapp.php?link=$link_whatsapp");
exit;
    
}



?>
