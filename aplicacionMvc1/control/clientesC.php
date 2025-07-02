<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["accion"]) && $_POST["accion"] === "actualizar") {
        include "../../api/includes/Client.class.php";
        $nombre = $_POST["nombre"];
        $cedula = $_POST["cedula"];
        $telefono = $_POST["telefono"];
        $id = $_POST["id"];
        header("Location: ../vista/clientes.php"); // Redirige de nuevo a la tabla
        Client::update_client($id,$nombre, $cedula, $telefono);
        exit();
    }
}

// Procesamiento del formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {

    // Verificar si se envía el formulario de creación de cliente
    if (isset($_POST['procesar']) && isset($_POST['nombre']) && isset($_POST['cedula']) && isset($_POST['telefono']) && isset($_POST['usuario_id'])) {
        include "../../api/api-rest/create_client.php";
        $nombre = $_POST['nombre'];
        $cedula = $_POST['cedula'];
        $telefono = $_POST['telefono'];
        $usuario_id = $_POST['usuario_id'];
        $csrf_token = $_POST['csrf_token'];
        crearCliente($nombre, $cedula, $telefono, $usuario_id, $csrf_token);
    }




    // Verificar si se envía el formulario para borrar un cliente
    if (isset($_POST['borrar']) && isset($_POST['codigo'])) {
        include "../../api/api-rest/delete_client.php";
        borrarCliente($_POST['codigo']);
    }

// Redirigir a la vista menu.php después de procesar el formulario
echo "<script>
    alert('Formulario procesado correctamente');
    window.location.href = '../vista/menu.php';
</script>";




}

function llenar_Lista_clientes()
{
    include "../../api/api-rest/get_all_clientes_Lista.php";

    // Obtener los datos en formato JSON y decodificarlos   
    $data = json_decode(listarDatosListaDesplegable_clientes("GET"), true);

    // Generar la lista desplegable con los clientes
    echo "<select name='id_cliente' id='id_cliente' class='form-select w-100'>";
    echo "<option value='' disabled selected>Selecciona un cliente</option>"; // Opción por defecto
    foreach ($data as $item) {
        echo "<option value='" . $item['id'] . "'>" . $item['nombre'] . "</option>";
    }
    echo "</select>";
}


// Función para listar todos los clientes en una tabla
function listarClientes()
{
    include "../../api/api-rest/get_all_client.php";

    // Obtener los datos en formato JSON y decodificarlos
    $data = json_decode(listarDatos("GET"), true);

    echo "<table class='table table-hover table-bordered text-center' id='tablaClientes'>";
    echo "<thead class='table-primary'>
        <tr>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>";
    
    foreach ($data as $item) {
        echo "<tbody>
            <tr>
                <td>" . htmlspecialchars($item['nombre']) . "</td>
                <td>" . htmlspecialchars($item['cedula']) . "</td>
                <td>" . htmlspecialchars($item['telefono']) . "</td>
                <td>
                    <button class='btn btn-warning btn-sm' onclick='abrirModal(" . json_encode($item) . ")'>
                        <i class='fas fa-edit'></i> Editar
                    </button>
                </td>
            </tr>
        </tbody>";
    }
    echo "</table>";
    
}






?>