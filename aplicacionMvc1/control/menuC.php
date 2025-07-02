<?php
include_once "../../api/includes/Database.class.php";

// Crear una instancia de la clase y obtener la conexión
$db = new Database();
$conn = $db->getConnection();

// Obtener mes y año actual y anterior
$mesActual = date('m');
$anioActual = date('Y');
$mesAnterior = date('m', strtotime('-1 month'));
$anioAnterior = date('Y', strtotime('-1 month'));

// Total clientes actuales
$sqlTotal = "SELECT COUNT(*) AS total_actual FROM clientes";
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->execute();
$row = $stmtTotal->fetch(PDO::FETCH_ASSOC);
$totalActual = isset($row['total_actual']) ? (int) $row['total_actual'] : 0;

// Total de facturas en revisión
$sqlRevision = "SELECT COUNT(*) AS total_revision FROM factura WHERE estado_aprobacion = 'Revision'";
$stmtRevision = $conn->prepare($sqlRevision);
$stmtRevision->execute();
$row = $stmtRevision->fetch(PDO::FETCH_ASSOC);
$totalRevision = isset($row['total_revision']) ? (int) $row['total_revision'] : 0;

// Total de facturas en proceso
$sqlProceso = "SELECT COUNT(*) AS total_revision FROM factura WHERE estado_aprobacion = 'Revision'";
$stmtProceso = $conn->prepare($sqlProceso);
$stmtProceso->execute();
$row = $stmtProceso->fetch(PDO::FETCH_ASSOC);
$totalProceso = isset($row['total_revision']) ? (int) $row['total_revision'] : 0;

// Total de facturas en completados
$sqlCompletados = "SELECT COUNT(*) AS total_revision FROM factura WHERE estado_aprobacion = 'Revision'";
$stmtCompletados = $conn->prepare($sqlCompletados);
$stmtCompletados->execute();
$row = $stmtCompletados->fetch(PDO::FETCH_ASSOC);
$totalCompletados= isset($row['total_revision']) ? (int) $row['total_revision'] : 0;




// Total clientes del mes anterior
$sqlAnterior = "SELECT COUNT(*) AS total_anterior 
                FROM clientes 
                WHERE MONTH(fecha_registro) = :mes AND YEAR(fecha_registro) = :anio";
$stmtAnterior = $conn->prepare($sqlAnterior);
$stmtAnterior->execute([
    ':mes' => $mesAnterior,
    ':anio' => $anioAnterior
]);
$totalAnterior = $stmtAnterior->fetch(PDO::FETCH_ASSOC)['total_anterior'];

// Calcular el porcentaje de cambio
if ($totalAnterior > 0) {
    $porcentaje = (($totalActual - $totalAnterior) / $totalAnterior) * 100;
} else {
    $porcentaje = $totalActual > 0 ? 100 : 0;
}

$icono = $porcentaje >= 0 ? "fa-arrow-up" : "fa-arrow-down";
$claseTrend = $porcentaje >= 0 ? "positive" : "negative";
$porcentajeTexto = number_format(abs($porcentaje), 2);
?>