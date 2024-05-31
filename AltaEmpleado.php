<?php
include 'ConexionBD.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombreEmpleado']);
    $edad = $conn->real_escape_string($_POST['edad']);
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $email = $conn->real_escape_string($_POST['email']);
    $contraseña = $conn->real_escape_string($_POST['password']);
    
    // Encriptar la contraseña antes de guardar en la base de datos
    $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT);

    $sql = "INSERT INTO empleado_de_veterinaria (Nombre, Edad, Sexo, Telefono, Direccion, Email, Contraseña) 
            VALUES ('$nombre', '$edad', '$sexo', '$telefono', '$direccion', '$email', '$contraseña_encriptada')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "Nuevo empleado registrado exitosamente";
    } else {
        $mensaje = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Empleado - Veterinaria El Tucán</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validarFormulario(event) {
            var form = event.target;
            var inputs = form.querySelectorAll('input[required], select[required]');
            var valido = true;

            inputs.forEach(function(input) {
                if (input.value.trim() === "") {
                    valido = false;
                }
            });

            if (!valido) {
                alert("Por favor, complete todos los campos.");
                event.preventDefault();
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
            <h1><a href="#">Veterinaria "El Tucán".</a></h1>
            <p>A la vanguardia con tus mascotas.</p>
        </div>
        <div id="widgets">
            <div id="widgets-top"></div>
            <ul>
                <li>
                    <h2>Acciones</h2>
                    <ul>
                        <li><a href="InterfazAdmin.php" class="menu-item">Menú Inicial</a></li>
                        <li><a href="AltaEmpleado.php" class="menu-item">Alta de Empleado</a></li>
                        <li><a href="AltaProducto.php" class="menu-item">Alta de Medicamento</a></li>
                        <li><a href="Prescripcion.php" class="menu-item">Anotaciones y Prescripciones</a></li>
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
                    <h2 class="title">Alta de Empleado</h2>
                    <?php if (!empty($mensaje)): ?>
                        <div class="alert">
                            <?php echo $mensaje; ?>
                        </div>
                    <?php endif; ?>
                    <form action="AltaEmpleado.php" method="post" onsubmit="validarFormulario(event)">
                        <div class="form-group">
                            <label for="nombreEmpleado"><h3>Nombre Completo:</h3></label>
                            <input type="text" id="nombreEmpleado" name="nombreEmpleado" required>
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
                            <label for="telefono"><h3>Teléfono:</h3></label>
                            <input type="text" id="telefono" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion"><h3>Dirección:</h3></label>
                            <input type="text" id="direccion" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label for="email"><h3>Correo Electrónico:</h3></label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password"><h3>Contraseña:</h3></label>
                            <input type="password" id="password" name="password" required>
                            <div>
                                <input type="checkbox" id="mostrarContrasena" onclick="togglePasswordVisibility()"> Mostrar Contraseña
                            </div>
                        </div>
                        <input type="submit" value="Dar de Alta">
                        <p id="mensajeAltaEmpleado" class="mensaje"></p>
                    </form>
                </div>
                <div class="footer">© 2024 Veterinaria El Tucán. Todos los derechos reservados.</div>
            </div>
        </div>
        <!-- end content -->
    </div>
    <!-- end page -->
</body>
</html>
