<?php
include 'ConexionBD.php';
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_cliente'])) {
    header("Location: InicioSesion.php");
    exit();
}

$id_cliente = $_SESSION['id_cliente'];

// Manejar el formulario de agendar cita
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $conn->real_escape_string($_POST['fecha']);
    $hora = $conn->real_escape_string($_POST['hora']);
    $id_mascota = $conn->real_escape_string($_POST['id_mascota']);
    $tipo = 'Chequeo'; // Asignar un tipo de cita por defecto si no está en el formulario

    $sql = "INSERT INTO cita (Fecha, Hora, Tipo, id_mascota, id_cliente) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $fecha, $hora, $tipo, $id_mascota, $id_cliente);

    if ($stmt->execute()) {
        $mensaje = "Cita registrada exitosamente";
    } else {
        $mensaje = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Obtener citas del cliente
$citas = [];
$sql_citas = "SELECT cita.*, mascota.Nombre AS NombreMascota FROM cita 
              INNER JOIN mascota ON cita.id_mascota = mascota.id_mascota
              WHERE cita.id_cliente = ?";
$stmt_citas = $conn->prepare($sql_citas);
$stmt_citas->bind_param("i", $id_cliente);
$stmt_citas->execute();
$result_citas = $stmt_citas->get_result();
if ($result_citas->num_rows > 0) {
    while($row = $result_citas->fetch_assoc()) {
        $citas[] = $row;
    }
}

// Obtener las mascotas del cliente
$mascotas = [];
$sql_mascotas = "SELECT * FROM mascota WHERE id_cliente = ?";
$stmt_mascotas = $conn->prepare($sql_mascotas);
$stmt_mascotas->bind_param("i", $id_cliente);
$stmt_mascotas->execute();
$result_mascotas = $stmt_mascotas->get_result();
if ($result_mascotas->num_rows > 0) {
    while($row = $result_mascotas->fetch_assoc()) {
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
    <title>Cliente - Veterinaria El Tucán</title>
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
            }
        }

        function cargarMascotas() {
            var mascotas = <?php echo json_encode($mascotas); ?>;
            var selectMascotas = document.getElementById("mascota");
            selectMascotas.innerHTML = "";
            mascotas.forEach(function(mascota) {
                var option = document.createElement("option");
                option.text = mascota.Nombre;
                option.value = mascota.id_mascota;
                selectMascotas.appendChild(option);
            });
        }
    </script>
</head>
<body onload="cargarMascotas()">
    <div id="sidebar">
        <div id="logo">
            <h1><a href="#">Veterinaria "El Tucán"</a></h1>
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
                        <li><a href="CerrarSesion.php">Cerrar Sesión</a></li>
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
                    <div class="agendar-y-agenda">
                        <!-- Sección de agendar cita -->
                        <div class="agendar-cita">
                            <h2 class="title">Agendar Cita</h2>
                            <form action="InterfazCliente.php" method="post" onsubmit="validarFormulario(event)">
                                <div class="form-group">
                                    <label for="fecha"><h3>Fecha:</h3></label>
                                    <input type="date" id="fecha" name="fecha" required>
                                </div>
                                <div class="form-group">
                                    <label for="hora"><h3>Hora:</h3></label>
                                    <input type="time" id="hora" name="hora" required>
                                </div>
                                <div class="form-group">
                                    <label for="tipo"><h3>Tipo:</h3></label>
                                    <input type="text" id="tipo" name="tipo" required>
                                </div>
                                <div class="form-group">
                                    <label for="mascota"><h3>Mascota:</h3></label>
                                    <select id="mascota" name="id_mascota" required>
                                        <!-- Las opciones se cargarán dinámicamente mediante JavaScript -->
                                    </select>
                                </div>
                                <input type="submit" value="Agendar Cita">
                                <?php if (isset($mensaje)): ?>
                                    <p><?php echo $mensaje; ?></p>
                                <?php endif; ?>
                            </form>
                        </div>
                        <!-- Sección de agenda -->
                        <div class="agenda-citas">
                            <h2 class="title">Agenda de Citas</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID Cita</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Tipo</th>
                                        <th>Mascota</th>
                                        <th>Cliente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($citas as $cita): ?>
                                        <tr>
                                            <td><?php echo $cita['id_cita']; ?></td>
                                            <td><?php echo $cita['Fecha']; ?></td>
                                            <td><?php echo $cita['Hora']; ?></td>
                                            <td><?php echo $cita['Tipo']; ?></td>
                                            <td><?php echo $cita['NombreMascota']; ?></td>
                                            <td><?php echo $cita['id_cliente']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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
