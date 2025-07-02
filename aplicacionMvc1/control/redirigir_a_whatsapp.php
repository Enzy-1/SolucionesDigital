<?php
// Obtener el link de WhatsApp desde la URL
$link_whatsapp = isset($_GET['link']) ? $_GET['link'] : '';

// Si no hay link, redirigir a una página de error o algo similar
if (empty($link_whatsapp)) {
    header("Location: error.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirigiendo a WhatsApp...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }

        button {
            background-color: #25d366; /* Color de WhatsApp */
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #128c7e;
        }

        #loadingMessage {
            display: none;
            margin-top: 20px;
            font-size: 18px;
            color: #25d366;
        }

        #thankYouMessage {
            display: none;
            margin-top: 20px;
            font-size: 20px;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <h1>¡Redirigiendo a WhatsApp!</h1>
    <button onclick="abrirWhatsApp()">Abrir WhatsApp</button>
    <div id="loadingMessage">Cargando... Por favor espera...</div>
    <div id="thankYouMessage">¡Gracias! Redirigiendo...</div>

    <script>
        function abrirWhatsApp() {
            // Mostrar el mensaje de carga
            document.getElementById("loadingMessage").style.display = "block";
            document.querySelector("button").style.display = "none"; // Ocultar el botón mientras se carga

            // Intentar abrir WhatsApp en una nueva pestaña
            var whatsappWindow = window.open("<?php echo $link_whatsapp; ?>", "_blank");

            // Asegurarse de que la ventana de WhatsApp se abrió correctamente
            if (whatsappWindow) {
                // Si se abrió correctamente, mostrar un mensaje de agradecimiento y redirigir después de un pequeño retraso
                setTimeout(function() {
                    document.getElementById("loadingMessage").style.display = "none"; // Ocultar mensaje de carga
                    document.getElementById("thankYouMessage").style.display = "block"; // Mostrar mensaje de agradecimiento
                    setTimeout(function() {
                        window.location.href = "../vista/RolesV.php";  // Redirigir a la página que desees
                    }, 2000);  // Espera 2 segundos antes de redirigir
                }, 1000);  // 1 segundo de espera para dar tiempo a abrir WhatsApp
            } else {
                // Si no se pudo abrir la ventana (posiblemente bloqueado por el navegador), redirigir directamente
                window.location.href = "../vista/RolesV.php";
            }
        }
    </script>
</body>
</html>
