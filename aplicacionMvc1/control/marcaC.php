<?php




// Procesamiento del formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)) {
    
    // Verificar si se envía el formulario de creación de cliente
    if (isset($_POST['procesar']) && isset($_POST['titulo']) && isset($_POST['conferencista_id']) && isset($_POST['descripcion']) && isset($_POST['area']) && isset($_POST['usuario_id'])) {
        include "../../api/api-rest/create_client.php"; 
        $titulo = $_POST['titulo'];
        $conferencista_id = $_POST['conferencista_id'];
        $descripcion = $_POST['descripcion'];
        $area = $_POST['area'];
        $usuario_id = $_POST['usuario_id'];
        $csrf_token= $_POST['csrf_token'];
        crearCliente($titulo, $conferencista_id, $descripcion, $area, $usuario_id, $csrf_token);
    }
    



    // Verificar si se envía el formulario para borrar un cliente
    if (isset($_POST['borrar']) && isset($_POST['codigo'])) {
        include "../../api/api-rest/delete_client.php";  
        borrarCliente($_POST['codigo']);
    }
    
    // Redirigir a la vista RolesV después de procesar el formulario
    echo "<script type='text/javascript'>   
              location.href = '../vista/RolesV.php'; 
          </script>";
}

function llenar_Lista_marca() {
    include "../../api/api-rest/get_all_marca_Lista.php"; 
    
    // Obtener los datos en formato JSON y decodificarlos   
    $data = json_decode(listarDatosListaDesplegable_marca("GET"), true);
    
    // Generar la lista desplegable con marcas
    echo "<select name='id_marca' id='id_marca' class='form-select w-100'>";
    echo "<option value='' disabled selected>Selecciona la Marca del equipo</option>";
    foreach ($data as $item) {
        // Asegúrate de que $item['icono'] sea algo como 'fab fa-apple'
        echo "<option value='" . $item['id'] . "' data-icon='" . $item['icono'] . "'>" . $item['nombre'] . "</option>";
    }
    echo "</select>";
    
    
}


// Función para listar todos los clientes en una tabla
function listarM() {
    include "../../api/api-rest/get_all_client.php"; 
    
    // Obtener los datos en formato JSON y decodificarlos
    $data = json_decode(listarDatos("GET"), true);
    
    // Generar la tabla con los datos de los clientes
    echo "<table class='client-table'>";
    echo "<tr>
            <th>ID</th>
            <th>Titulos</th>
            <th>Conferencistas</th>
            <th>Descripcion</th>
            <th>Area de Conocimiento</th>
          </tr>";
    
    foreach ($data as $item) {
        echo "<tr>
                <td>" . $item['id'] . "</td>
                <td>" . $item['titulo'] . "</td>
                <td>" . $item['conferencista_id'] . "</td>
                <td>" . $item['descripcion'] . "</td>
                <td>" . $item['area'] . "</td>
              </tr>";
    }
    
    echo "</table>";
}

function listarInscritossss() {
    include "../../api/api-rest/get_all_inscritos.php"; 
    
    // Obtener los datos en formato JSON y decodificarlos
    $data = json_decode(listarDatos("GET"), true);
    
    // Generar la tabla con los datos de los clientes
    echo "<table class='client-table'>";
    echo "<tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Programa</th>
          </tr>";
    
    foreach ($data as $item) {
        echo "<tr>
                <td>" . $item['usuario_id'] . "</td>
                <td>" . $item['username'] . "</td>
                <td>" . $item['apellido'] . "</td>
                <td>" . $item['programas_id'] . "</td>
              </tr>";
    }
    
    echo "</table>";
}
?>
