<?php
include 'ConexionBD.php';
session_start();

if (!isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];

// Obtener información del cliente
$sql_cliente = "SELECT * FROM cliente WHERE id_cliente = $id_cliente";
$result_cliente = $conn->query($sql_cliente);
$cliente = $result_cliente->fetch_assoc();

// Obtener las mascotas asociadas al cliente
$sql_mascotas = "SELECT id_mascota, Nombre FROM mascota WHERE id_cliente = $id_cliente";
$result_mascotas = $conn->query($sql_mascotas);

$mascotas = [];
if ($result_mascotas->num_rows > 0) {
    while ($row = $result_mascotas->fetch_assoc()) {
        $mascotas[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - Veterinaria El Tucán</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function activarEdicion() {
            var labels = document.querySelectorAll('.editable-label');
            var inputs = document.querySelectorAll('.editable-input');

            labels.forEach(function(label) {
                label.style.display = 'none';
            });

            inputs.forEach(function(input) {
                input.style.display = 'block';
            });

            document.getElementById('botonEditar').style.display = 'none';
            document.getElementById('botonGuardar').style.display = 'block';
        }

        function confirmarBaja(event) {
            if (!confirm("¿Está seguro de que desea darse de baja del sistema? Esta acción no se puede deshacer.")) {
                event.preventDefault();
            }
        }

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
            }
        }

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('contrasena');
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
            <h1><a href="#">Veterinaria El Tucán</a></h1>
            <p>A la vanguardia con tus mascotas.</p>
        </div>
        <div id="widgets">
            <div id="widgets-top"></div>
            <ul>
                <li>
                    <h2>Acciones</h2>
                    <ul>
                        <li><a href="InterfazCliente.php">Inicio</a></li>
                        <li><a href="AltaMascota.php">Dar de Alta una mascota</a></li>
                        <li><a href="CierreSesion.php">Cerrar Sesión</a></li>
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
                    <h2 class="title">Perfil de Usuario</h2>
                    <div class="perfil-usuario">
                        <form action="actualizarPerfil.php" method="post" onsubmit="validarFormulario(event)">
                            <div class="form-group">
                                <label for="nombreCliente"><h3>Nombre Completo:</h3></label>
                                <span class="editable-label" id="nombreClienteLabel"><?php echo $cliente['Nombre']; ?></span>
                                <input type="text" id="nombreCliente" name="nombreCliente" value="<?php echo $cliente['Nombre']; ?>" required class="editable-input" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="email"><h3>Correo Electrónico:</h3></label>
                                <span class="editable-label" id="emailLabel"><?php echo $cliente['Correo']; ?></span>
                                <input type="email" id="email" name="email" value="<?php echo $cliente['Correo']; ?>" required class="editable-input" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="telefono"><h3>Teléfono:</h3></label>
                                <span class="editable-label" id="telefonoLabel"><?php echo $cliente['Telefono']; ?></span>
                                <input type="text" id="telefono" name="telefono" value="<?php echo $cliente['Telefono']; ?>" required class="editable-input" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="direccion"><h3>Dirección:</h3></label>
                                <span class="editable-label" id="direccionLabel"><?php echo $cliente['Direccion']; ?></span>
                                <input type="text" id="direccion" name="direccion" value="<?php echo $cliente['Direccion']; ?>" required class="editable-input" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="edad"><h3>Edad:</h3></label>
                                <span class="editable-label" id="edadLabel"><?php echo $cliente['Edad']; ?></span>
                                <input type="number" id="edad" name="edad" value="<?php echo $cliente['Edad']; ?>" required class="editable-input" style="display: none;">
                            </div>
                            <div class="form-group">
                                <label for="sexo"><h3>Sexo:</h3></label>
                                <span class="editable-label" id="sexoLabel"><?php echo $cliente['Sexo']; ?></span>
                                <select id="sexo" name="sexo" required class="editable-input" style="display: none;">
                                    <option value="Masculino" <?php echo $cliente['sexo'] == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="Femenino" <?php echo $cliente['sexo'] == 'Femenino' ? 'selected' : ''; ?>>Femenino</option>
                                    <option value="Otro" <?php echo $cliente['sexo'] == 'Otro' ? 'selected' : ''; ?>>Otro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="contrasena"><h3>Contraseña:</h3></label>
                                <span class="editable-label" id="contrasenaLabel">********</span>
                                <input type="password" id="contrasena" name="contrasena" value="" required class="editable-input" style="display: none;">
                                <div style="display: none;" class="editable-input">
                                    <input type="checkbox" id="mostrarContrasena" onclick="togglePasswordVisibility()"> Mostrar Contraseña
                                </div>
                            </div>
                            <div class="botones-accion">
                                <button type="button" id="botonEditar" onclick="activarEdicion()">Editar mi Información</button>
                                <button type="submit" id="botonGuardar" style="display: none;">Guardar Cambios</button>
                            </div>
                        </form>
                        <form action="eliminarPerfil.php" method="post" onsubmit="confirmarBaja(event)" class="form-eliminar">
                            <input type="submit" value="Eliminar Perfil">
                        </form>
                    </div>
                    <div class="mascotas-usuario">
                        <h3>Mascotas</h3>
                        <ul>
                            <?php foreach ($mascotas as $mascota): ?>
                                <li><?php echo $mascota['Nombre']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="footer">© 2024 Veterinaria El Tucán. Todos los derechos reservados.</div>
            </div>
        </div>
        <!-- end content -->
    </div>
    <!-- end page -->
</body>
</html>
