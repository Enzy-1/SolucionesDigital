<?php


if (isset($_POST['actualizar_estado'])) {
    $id = $_POST['id'];
    $estado = $_POST['estado_aprobacion'];

    require_once '../../api/includes/Database.class.php';
    $database = new Database();
    $conn = $database->getConnection();

    $stmt = $conn->prepare("UPDATE factura SET estado_aprobacion = ? WHERE id_factura = ?");
    $stmt->bindParam(1, $estado);
    $stmt->bindParam(2, $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: ../vista/soporte.php?mensaje=Factura Actualizado");
        exit();  
    } else {
        header("Location: ../vista/soporte.php?error=Fallo en Actualizacion");
        exit(); 
    }
}





// Función para listar todos los clientes en una tabla
function listarSoportes()
{
    include "../../api/api-rest2/get_all_soporte.php";

    // Obtener los datos en formato JSON y decodificarlos
    $data = json_decode(listarDatos("GET"), true);

    // Generar la tabla con los datos de los clientes
    echo "<table class='table table-hover table-bordered text-center' id='tablaClientes'>";
    echo "<thead class='table-primary'>
    <tr>
        <th>No - Factura</th>
        <th>Tecnico</th>
        <th>Equipo</th>
        <th>Reparacion</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    </thead>";
    
    foreach ($data as $item) {
        echo "<tbody>
        <tr>
            <td>" . $item['numero_factura'] . "</td>
            <td>" . $item['usuario_username'] . "</td>
            <td>" . $item['modelo'] . "</td>
            <td>" . $item['reparacion'] . "</td>
            <td>" . $item['fecha'] . "</td>
            <td>
                <form method='POST' action='../control/soporteC.php' class='d-flex justify-content-center align-items-center'>
                    <input type='hidden' name='id' value='" . $item['id_factura'] . "'>";

                    if ($item['estado_aprobacion'] == 'Cancelado') {
                        echo "
        <select name='estado_aprobacion' class='form-select form-select-sm' style='width: auto; display:inline-block;' disabled>
            <option value='Cancelado' selected>Cancelado</option>
        </select>";
      } else {
    // Mostrar el formulario editable
    echo "
        <select name='estado_aprobacion' class='form-select form-select-sm' style='width: auto; display:inline-block;'>
            <option value='Revision' " . ($item['estado_aprobacion'] == 'Revision' ? 'selected' : '') . ">Revision</option>
            <option value='Entregado' " . ($item['estado_aprobacion'] == 'Entregado' ? 'selected' : '') . ">Entregado</option>
            <option value='Cancelado' " . ($item['estado_aprobacion'] == 'Cancelado' ? 'selected' : '') . ">Cancelado</option>
        </select>
        <button type='submit' name='actualizar_estado' class='btn btn-success btn-sm ms-1'><i class='fas fa-check'></i></button>";
}

echo "
    </form>
            </td>
            <td>
                <button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#detalleModal" . $item['id_factura'] . "'>
  <i class='fas fa-eye'></i> Más detalles
</button>
            </td>
        </tr>

        
        <!-- Modal -->
<div class='modal fade' id='detalleModal" . $item['id_factura'] . "' tabindex='-1' aria-labelledby='detalleModalLabel" . $item['id_factura'] . "' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered modal-lg'>
    <div class='modal-content'>
      <div class='modal-header bg-primary text-white'>
        <h5 class='modal-title' id='detalleModalLabel" . $item['id_factura'] . "'>Detalles de la Factura #" . $item['numero_factura'] . "</h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
      </div>
      <div class='modal-body'>
        <p><strong>Cliente:</strong> " . $item['cliente_nombre'] . "</p>
        <p><strong>Teléfono:</strong> " . $item['cliente_telefono'] . "</p>
        <hr>
        <p><strong>Modelo:</strong> " . $item['modelo'] . "</p>
        <p><strong>IMEI:</strong> " . $item['imei_serial'] . "</p>
        <p><strong>Reparación:</strong> " . $item['reparacion'] . "</p>
        <p><strong>Observaciones:</strong> " . $item['observaciones'] . "</p>
        <p><strong>Estado de Aprobación:</strong> " . $item['estado_aprobacion'] . "</p>
        <p><strong>Fecha:</strong> " . $item['fecha'] . "</p>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
      </div>
    </div>
  </div>
</div>

        </tbody>";
    }
    
    echo "</table>";
}



function listarEntregas()
{
    include "../../api/api-rest2/get_all_entregas.php";

    // Obtener los datos en formato JSON y decodificarlos
    $data = json_decode(listarDatos("GET"), true);

    echo "<div class='contenedor-tarjetas'>";

    foreach ($data as $item) {
        echo "<div class='tarjeta-entrega'>";
        echo "<h3>Cliente: " . htmlspecialchars($item['cliente_nombre']) . "</h3>";
        echo "<p><strong>Teléfono:</strong> " . htmlspecialchars($item['cliente_telefono']) . "</p>";
        echo "<p><strong>Técnico:</strong> " . htmlspecialchars($item['usuario_nombre']) . "</p>";
        echo "<p><strong>Fecha:</strong> " . htmlspecialchars($item['fecha']) . "</p>";
        echo "<p><strong>Estado:</strong> <span class='estado'>" . htmlspecialchars($item['estado_aprobacion']) . "</span></p>";
        echo "<p><strong>Total:</strong> $" . htmlspecialchars($item['total']) . "</p>";
        echo "<button class='btn btn-warning' onclick='abrirModal(" . json_encode($item) . ")'>
                <i class='fas fa-edit'></i> Editar
              </button>";
        echo "</div>";
    }

    echo "</div>";
}



?>