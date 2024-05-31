<?php
include 'ConexionBD.php';

$mensaje = "";
$tipoMensaje = ""; // 'exito' o 'error'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombreCliente']);
    $email = $conn->real_escape_string($_POST['email']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $edad = $conn->real_escape_string($_POST['edad']);
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $password = $conn->real_escape_string($_POST['password']);

    // Verificar si el correo electrónico o el número de teléfono ya existen
    $check_sql = "SELECT * FROM cliente WHERE Correo = '$email' OR Telefono = '$telefono'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $mensaje = "El correo electrónico o el número de teléfono ya están registrados.";
        $tipoMensaje = "error";
    } else {
        $sql = "INSERT INTO cliente (Nombre, Edad, Correo, Sexo, Telefono, Contraseña) 
                VALUES ('$nombre', '$edad', '$email', '$sexo', '$telefono', '$password')";

        if ($conn->query($sql) === TRUE) {
            $mensaje = "Registro exitoso.";
            $tipoMensaje = "exito";
        } else {
            $mensaje = "Error: " . $sql . "<br>" . $conn->error;
            $tipoMensaje = "error";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - Veterinaria El Tucán</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validarFormulario(event) {
            var form = event.target;
            var inputs = form.querySelectorAll('input[required]');
            var valido = true;

            inputs.forEach(function(input) {
                if (input.value.trim() === "") {
                    valido = false;
                }
            });

            if (!valido) {
                alert("Por favor, complete todos los campos.");
                event.preventDefault();
            } else {
                var mensajeId = form.dataset.mensajeId;
                document.getElementById(mensajeId).innerText = "Registro exitoso.";
                event.preventDefault(); // Prevenir el envío inmediato del formulario
                setTimeout(function() {
                    form.submit(); // Enviar el formulario después de un breve retraso
                }, 1000);
            }
        }

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var checkbox = document.getElementById('mostrarContrasena');
            if (checkbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</head>
<body>
    <div id="sidebar">
        <div id="logo">
            <h1><a href="#">Veterinaria El Tucán.</a></h1>
            <p>A la vanguardia con tus mascotas.</p>
        </div>
        <div id="widgets">
            <div id="widgets-top"></div>
            <ul>
                <li>
                    <h2>Acciones.</h2>
                    <ul>
                        <li><a href="InicioSesion.php">Iniciar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- end sidebar -->
    <!-- start page -->
    <div id="page">
        <div id="content">
            <h1 class="pagetitle">Veterinaria "El Tucán"</h1>
            <div class="post">
                <div class="entry">
                    <h2 class="title">Registro de Nuevo Usuario</h2>
                    <form action="RegistrarNuevoUsuario.php" method="post" onsubmit="validarFormulario(event)" data-mensaje-id="mensajeRegistro">
                        <div class="form-group">
                            <label for="nombreCliente"><h3>Nombre Completo:</h3></label>
                            <input type="text" id="nombreCliente" name="nombreCliente" required>
                        </div>
                        <div class="form-group">
                            <label for="email"><h3>Correo Electrónico:</h3></label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono"><h3>Teléfono:</h3></label>
                            <input type="text" id="telefono" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion"><h3>Dirección:</h3></label>
                            <input type="text" id="direccion" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label for="edad"><h3>Edad:</h3></label>
                            <input type="number" id="edad" name="edad" required>
                        </div>
                        <div class="form-group">
                            <label for="sexo"><h3>Sexo:</h3></label>
                            <select id="sexo" name="sexo" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password"><h3>Contraseña:</h3></label>
                            <input type="password" id="password" name="password" required>
                            <div>
                                <input type="checkbox" id="mostrarContrasena" onclick="togglePasswordVisibility()"> Mostrar Contraseña
                            </div>
                        </div>
                        <input type="submit" value="Registrarse">
                        <p id="mensajeRegistro"></p>
                    </form>
                </div>
                <div class="footer">© 2024 Veterinaria El Tucán. Todos los derechos reservados.</div>
            </div>
        </div>
        <!-- end content -->
    </div>
    <!-- end page -->

    <!-- JavaScript para mostrar mensajes de alerta -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mensaje = "<?= $mensaje ?>";
            var tipoMensaje = "<?= $tipoMensaje ?>";

            if (mensaje) {
                if (tipoMensaje === "exito") {
                    alert("Éxito: " + mensaje);
                } else if (tipoMensaje === "error") {
                    alert("Error: " + mensaje);
                }
            }
        });
    </script>
</body>
</html>
