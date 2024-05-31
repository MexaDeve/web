<?php
include 'ConexionBD.php';

// Consultar empleados de la base de datos
$sqlEmpleados = "SELECT * FROM empleado_de_veterinaria";
$resultEmpleados = $conn->query($sqlEmpleados);

// Verificar si se encontraron empleados
if ($resultEmpleados->num_rows > 0) {
    // Construir la tabla de empleados
    $empleadosHTML = "";
    while ($row = $resultEmpleados->fetch_assoc()) {
        $empleadosHTML .= "<tr>";
        $empleadosHTML .= "<td>" . $row['id_empleado'] . "</td>";
        $empleadosHTML .= "<td>" . $row['Nombre'] . "</td>";
        $empleadosHTML .= "<td>" . $row['Email'] . "</td>";
        $empleadosHTML .= "<td>";
        $empleadosHTML .= "<button>Editar</button>";
        $empleadosHTML .= "<button>Eliminar</button>";
        $empleadosHTML .= "</td>";
        $empleadosHTML .= "</tr>";
    }
} else {
    // Mostrar un mensaje si no se encontraron empleados
    $empleadosHTML = "<tr><td colspan='4'>No hay empleados registrados</td></tr>";
}

// Consultar citas de la base de datos
$sqlCitas = "SELECT * FROM cita";
$resultCitas = $conn->query($sqlCitas);

// Verificar si se encontraron citas
if ($resultCitas->num_rows > 0) {
    // Construir la tabla de citas
    $citasHTML = "";
    while ($row = $resultCitas->fetch_assoc()) {
        $citasHTML .= "<tr>";
        $citasHTML .= "<td>" . $row['id_cita'] . "</td>";
        $citasHTML .= "<td>" . $row['Fecha'] . "</td>";
        $citasHTML .= "<td>" . $row['Hora'] . "</td>";
        $citasHTML .= "<td>" . $row['Tipo'] . "</td>";
        $citasHTML .= "<td>" . $row['id_mascota'] . "</td>";
        $citasHTML .= "<td>" . $row['id_cliente'] . "</td>";
        $citasHTML .= "<td>";
        $citasHTML .= "<button>Editar</button>";
        $citasHTML .= "<button>Eliminar</button>";
        $citasHTML .= "</td>";
        $citasHTML .= "</tr>";
    }
} else {
    // Mostrar un mensaje si no se encontraron citas
    $citasHTML = "<tr><td colspan='7'>No hay citas programadas</td></tr>";
}

// Consultar productos de la base de datos
$sqlProductos = "SELECT * FROM producto";
$resultProductos = $conn->query($sqlProductos);

// Verificar si se encontraron productos
if ($resultProductos->num_rows > 0) {
    // Construir la tabla de productos
    $productosHTML = "";
    while ($row = $resultProductos->fetch_assoc()) {
        $productosHTML .= "<tr>";
        $productosHTML .= "<td>" . $row['id_producto'] . "</td>";
        $productosHTML .= "<td>" . $row['Nombre'] . "</td>";
        $productosHTML .= "<td>" . $row['Tipo'] . "</td>";
        $productosHTML .= "<td>" . $row['Marca'] . "</td>";
        $productosHTML .= "<td>" . $row['Precio'] . "</td>";
        $productosHTML .= "<td>" . $row['Fe_Caducidad'] . "</td>";
        $productosHTML .= "<td>" . $row['Estado_Uso'] . "</td>";
        $productosHTML .= "<td>" . $row['Estado_Caducidad'] . "</td>";
        $productosHTML .= "<td>";
        $productosHTML .= "<button>Editar</button>";
        $productosHTML .= "<button>Eliminar</button>";
        $productosHTML .= "</td>";
        $productosHTML .= "</tr>";
    }
} else {
    // Mostrar un mensaje si no se encontraron productos
    $productosHTML = "<tr><td colspan='9'>No hay productos disponibles</td></tr>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - Veterinaria El Tucán</title>
    <link rel="stylesheet" href="Style.css">
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
        <h2>Acciones</h2>
        <ul>
          <li><a href="AltaEmpleado.php" class="menu-item">Alta de Empleado</a></li>
          <li><a href="AltaMedicamento.php" class="menu-item">Alta de Medicamento</a></li>
          <li><a href="Prescripcion.php" class="menu-item">Anotaciones y Prescripciones</a></li>
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
    <h1 class="pagetitle">Panel de Administrador</h1>
    <div class="post">
      <div class="entry">
        <div class="admin-container">
          <img src="https://i.imgur.com/JlT70ib.jpg" alt="LogoAqui" id="imgid">
          <h2>Panel de Administrador - Veterinaria "El Tucán"</h2>

          <h3>Gestionar Empleados</h3>
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- Aquí se mostrarían los empleados de la base de datos -->
              <?php echo $empleadosHTML; ?>
            </tbody>
          </table>

          <h3>Gestionar Citas</h3>
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Tipo</th>
                <th>Mascota</th>
                <th>Cliente</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- Aquí se mostrarían las citas de la base de datos -->
              <?php echo $citasHTML; ?>
            </tbody>
          </table>

          <h3>Gestionar Productos</h3>
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Fecha de Caducidad</th>
                <th>Estado de Uso</th>
                <th>Vigencia</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- Aquí se mostrarían los productos de la base de datos -->
              <?php echo $productosHTML; ?>
            </tbody>
          </table>

          <div class="footer">© 2024 Veterinaria El Tucán. Todos los derechos reservados.</div>
        </div>
      </div>
    </div>
  </div>
  <!-- end content -->
</div>
<!-- end page -->
</body>
</html>
