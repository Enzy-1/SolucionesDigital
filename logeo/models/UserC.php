<?php
require_once '../controllers/User.class.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new Usuario($db);
    }

    public function login($username, $password) {
        $user = $this->usuarioModel->login($username, $password);
        if ($user) {
            session_start();
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Genera un token único
            header("Location: ../../aplicacionMvc1/vista/menu.php");
        } else {
            echo '<div id="errorModal" style="display: block; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
            <div style="background-color: #FFF; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 300px; border-radius: 10px; text-align: center;">
                <span onclick="document.getElementById(\'errorModal\').style.display=\'none\'" style="color: #AAA; float: right; font-size: 20px; font-weight: bold; cursor: pointer;">&times;</span>
                <h3 style="color: #FF0000;">¡Error!</h3>
                <p>Usuario o contraseña incorrectos.</p>
            </div>
          </div>
          <script>
            // Cierra el modal cuando el usuario hace clic en cualquier lugar fuera del contenido
            window.onclick = function(event) {
                var modal = document.getElementById("errorModal");
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
          </script>';
        }
    }

    public function checkCsrfToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }
}
?>
