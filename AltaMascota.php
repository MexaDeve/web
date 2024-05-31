<?php
include 'ConexionBD.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombreMascota']);
    $tipo = $conn->real_escape_string($_POST['tipoMascota']);
    $raza = $conn->real_escape_string($_POST['raza']);
    $edad = $conn->real_escape_string($_POST['edadMascota']);
    $sexo = $conn->real_escape_string($_POST['sexoMascota']);
    $color = $conn->real_escape_string($_POST['colorMascota']);
    $peso = $conn->real_escape_string($_POST['PesoMascota']);

    $id_cliente = 1;

    $sql = "INSERT INTO mascota (Nombre, Tipo, Raza, Edad, Sexo, Color, Peso, id_cliente) 
            VALUES ('$nombre', '$tipo', '$raza', '$edad', '$sexo', '$color', '$peso', '$id_cliente')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "Alta de mascota exitosa.";
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
    <title>Alta de Mascota - Veterinaria El Tucán</title>
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
            } else {
                var mensajeId = form.dataset.mensajeId;
                document.getElementById(mensajeId).innerText = "Alta de mascota exitosa.";
                event.preventDefault(); // Prevenir el envío inmediato del formulario
                setTimeout(function() {
                    form.submit(); // Enviar el formulario después de un breve retraso
                }, 1000);
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
            <li><a href="PerfilUsuario.php">Mi Perfil</a></li>
            <li><a href="AltaMascota.php">Dar de Alta una mascota</a></li>
            <li><a href="CierreSesion.php">Cerrar Sesión</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>

<div id="page">
  <div id="content">
    <h1 class="pagetitle">Veterinaria "El Tucán"</h1>
    <div class="post">
      <div class="entry">
        <h2 class="title">Alta de Mascota</h2>
        <form action="AltaMascota.php" method="post" onsubmit="validarFormulario(event)" data-mensaje-id="mensajeAltaMascota">
            <div class="form-group">
                <label for="nombreMascota"><h3>Nombre de la Mascota:</h3></label>
                <input type="text" id="nombreMascota" name="nombreMascota" required>
            </div>
            <div class="form-group">
                <label for="tipoMascota"><h3>Tipo de Mascota:</h3></label>
                <select id="tipoMascota" name="tipoMascota" required>
                    <option value="" disabled selected>Seleccione</option>
                    <option value="Perro">Perro</option>
                    <option value="Gato">Gato</option>
                    <option value="Ave">Ave</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="raza"><h3>Raza:</h3></label>
                <input type="text" id="raza" name="raza" required>
            </div>
            <div class="form-group">
                <label for="edadMascota"><h3>Edad:</h3></label>
                <input type="number" id="edadMascota" name="edadMascota" required>
            </div>
            <div class="form-group">
                <label for="sexoMascota"><h3>Sexo:</h3></label>
                <select id="sexoMascota" name="sexoMascota" required>
                    <option value="" disabled selected>Seleccione</option>
                    <option value="Macho">Macho</option>
                    <option value="Hembra">Hembra</option>
                </select>
            </div>
            <div class="form-group">
                <label for="colorMascota"><h3>Color:</h3></label>
                <input type="text" id="colorMascota" name="colorMascota" required>
            </div>
            <div class="form-group">
                <label for="PesoMascota"><h3>Peso (Kg):</h3></label>
                <input type="number" id="PesoMascota" name="PesoMascota" required>
            </div>
            <input type="submit" value="Dar de Alta">
            <p id="mensajeAltaMascota" class="mensaje"><?= $mensaje ?></p>
        </form>
        <div class="footer">© 2024 Veterinaria El Tucán. Todos los derechos reservados.</div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
