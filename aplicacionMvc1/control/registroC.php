<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["accion"]) && $_POST["accion"] === "actualizar") {
        include "../../api/includes/Registro.class.php";
        $username = $_POST["username"];
        $celular = $_POST["celular"];
        $email = $_POST["email"];
        $id = $_POST["id"];
        header("Location: ../vista/registro.php"); // Redirige de nuevo a la tabla
        Registro::update_registro($id,$username, $email, $password);
        exit();
    }
}


// Procesamiento del formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {

    // Verificar si se envía el formulario de creación de cliente
    if (isset($_POST['procesar']) && isset($_POST['username']) && isset($_POST['celular']) && isset($_POST['email']) && isset($_POST['password'])) {
        include "../../api/api-rest3/create_registro.php";
        $username = $_POST['username'];
        $celular = $_POST['celular'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $csrf_token = $_POST['csrf_token'];
        crearRegistro($username, $celular, $email, $password, $csrf_token);
    }
// Redirigir a la vista menu.php después de procesar el formulario
echo "<script>
    alert('Formulario procesado correctamente');
    window.location.href = '../vista/registro.php';
</script>";




}



// Función para listar todos los clientes en una tabla
function listarUsuarios()
{
    include "../../api/api-rest3/get_all_registro.php";

    // Obtener los datos en formato JSON y decodificarlos
    $data = json_decode(listarDatos("GET"), true);

    echo "<table class='table table-hover table-bordered text-center' id='tablaClientes'>";
    echo "<thead class='table-primary'>
        <tr>
            <th>Usuario</th>
            <th>Numero de Telefono</th>
            <th>Correo Electronico</th>
            <th>Acciones</th>
        </tr>
    </thead>";
    
    foreach ($data as $item) {
        echo "<tbody>
            <tr>
                <td>" . htmlspecialchars($item['username']) . "</td>
                <td>" . htmlspecialchars($item['celular']) . "</td>
                <td>" . htmlspecialchars($item['email']) . "</td>
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