<?php
echo getcwd();

include_once "../../api/includes/Factura.class.php";

    
function crearFactura($id_cliente, $id_marca, $imei_serial, $modelo, $observaciones, $reparacion, $total, $abono, $usuario_id, $csrf_token, $imagenes)
{
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        Factura::create_factura($id_cliente, $id_marca, $imei_serial, $modelo, $observaciones, $reparacion, $total, $abono, $usuario_id, $csrf_token, $imagenes);
    }
}
?>
    