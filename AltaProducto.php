<?php
include 'ConexionBD.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $conn->real_escape_string($_POST['nombreMedicamento']);
    $tipo = $conn->real_escape_string($_POST['tipo']);
    $marca = $conn->real_escape_string($_POST['marca']);
    $precio = $conn->real_escape_string($_POST['precio']);
    $fe_caducidad = $conn->real_escape_string($_POST['fe_caducidad']);
    $estado_uso = $conn->real_escape_string($_POST['estado_uso']);
    $estado_caducidad = $conn->real_escape_string($_POST['estado_caducidad']);

    // SQL para insertar el nuevo producto
    $sql = "INSERT INTO producto (Nombre, Tipo, Marca, Precio, Fe_Caducidad, Estado_Uso, Estado_Caducidad) 
            VALUES ('$nombre', '$tipo', '$marca', '$precio', '$fe_caducidad', '$estado_uso', '$estado_caducidad')";

    // Ejecutar la consulta e imprimir cualquier error
    if ($conn->query($sql) === TRUE) {
        $mensaje = "Nuevo producto registrado exitosamente";
    } else {
        $mensaje = "Error: " . $sql . "<br>" . $conn->error;
        error_log("Error en la inserción de producto: " . $conn->error);
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Producto - Veterinaria El Tucán</title>
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
                document.getElementById(mensajeId).innerText = "Registro exitoso.";
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
          <li><a href="AltaEmpleado.php" class="menu-item">Alta de Empleado</a></li>
          <li><a href="AltaProducto.php" class="menu-item">Alta de Productos</a></li>
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
    <h1 class="pagetitle">Alta de Productos</h1>
    <div class="post">
      <div class="entry">
        <div class="full-page-container">
          <div class="container">
            <h2>Registrar Productos</h2>
            
            <form action="AltaProducto.php" method="post" onsubmit="validarFormulario(event)" data-mensaje-id="mensajeRegistroMedicamento">
                <div class="form-group">
                    <label for="nombreMedicamento"><h3>Nombre del Producto:</h3></label>
                    <input type="text" id="nombreMedicamento" name="nombreMedicamento" required>
                </div>
                <div class="form-group">
                    <label for="tipo"><h3>Tipo:</h3></label>
                    <select id="tipo" name="tipo" required>
                        <option value="">Seleccione el tipo</option>
                        <option value="Antibiótico">Antibiótico</option>
                        <option value="Analgésico">Analgésico</option>
                        <option value="Antiparasitario">Antiparasitario</option>
                        <!-- Más opciones aquí -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="marca"><h3>Marca:</h3></label>
                    <select id="marca" name="marca" required>
                        <option value="">Seleccione la marca</option>
                        <option value="Marca A">BIGON</option>
                        <option value="Marca B">Bachoco</option>
                        <option value="Marca C">Pedigrie</option>
                        <!-- Más opciones aquí -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio"><h3>Precio:</h3></label>
                    <input type="number" step="0.01" id="precio" name="precio" required>
                </div>
                <div class="form-group">
                    <label for="fe_caducidad"><h3>Fecha de Caducidad:</h3></label>
                    <input type="date" id="fe_caducidad" name="fe_caducidad" required>
                </div>
                <div class="form-group">
                    <label for="estado_uso"><h3>Estado de Uso:</h3></label>
                    <select id="estado_uso" name="estado_uso" required>
                        <option value="">Seleccione el estado de uso</option>
                        <option value="En Almacen">En almacen</option>
                        <option value="Usado en el local">Usado en el local</option>
                        <option value="Vendido">Vendido</option>
                        <!-- Más opciones aquí -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="estado_caducidad"><h3>Estado de Caducidad:</h3></label>
                    <select id="estado_caducidad" name="estado_caducidad" required>
                        <option value="">Seleccione el estado de caducidad</option>
                        <option value="Vigente">Vigente</option>
                        <option value="Caducado">Caducado</option>
                        <!-- Más opciones aquí -->
                    </select>
                </div>
                <input type="submit" value="Registrar Producto">
                <p id="mensajeRegistroMedicamento" class="mensaje"><?php echo $mensaje; ?></p>
            </form>
            
            <div class="footer">© 2024 Veterinaria El Tucán. Todos los derechos reservados.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end content -->
</div>
<!-- end page -->
</body>
</html>
