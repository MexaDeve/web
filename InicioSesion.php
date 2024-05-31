<?php
include 'ConexionBD.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Función para verificar la contraseña
    function verifyPassword($password, $hash) {
        // Aquí se podría utilizar password_verify si las contraseñas están hasheadas.
        // return password_verify($password, $hash);
        return $password === $hash;
    }

    $mensaje = "";
    $tipoUsuario = "";

    // Verificar en la tabla de clientes
    $sqlCliente = "SELECT * FROM cliente WHERE Nombre = ?";
    $stmtCliente = $conn->prepare($sqlCliente);
    $stmtCliente->bind_param("s", $username);
    $stmtCliente->execute();
    $resultCliente = $stmtCliente->get_result();

    if ($resultCliente->num_rows > 0) {
        $row = $resultCliente->fetch_assoc();
        if (verifyPassword($password, $row['Contraseña'])) {
            $_SESSION['id_cliente'] = $row['id_cliente'];
            $_SESSION['tipo_usuario'] = "cliente";
            header("Location: InterfazCliente.php");
            exit();
        }
    }

    // Verificar en la tabla de empleados si no se encontró en clientes
    if (empty($_SESSION['tipo_usuario'])) {
        $sqlEmpleado = "SELECT * FROM empleado_de_veterinaria WHERE Email = ?";
        $stmtEmpleado = $conn->prepare($sqlEmpleado);
        $stmtEmpleado->bind_param("s", $username);
        $stmtEmpleado->execute();
        $resultEmpleado = $stmtEmpleado->get_result();

        if ($resultEmpleado->num_rows > 0) {
            $row = $resultEmpleado->fetch_assoc();
            if (verifyPassword($password, $row['Contraseña'])) {
                $_SESSION['id_empleado'] = $row['id_empleado'];
                $_SESSION['tipo_usuario'] = "empleado";
                header("Location: InterfazEmpleado.php");
                exit();
            }
        }
    }

    // Verificar en la tabla de jefes si no se encontró en clientes o empleados
    if (empty($_SESSION['tipo_usuario'])) {
        $sqlJefe = "SELECT * FROM jefe_veterinaria WHERE Nombre = ?";
        $stmtJefe = $conn->prepare($sqlJefe);
        $stmtJefe->bind_param("s", $username);
        $stmtJefe->execute();
        $resultJefe = $stmtJefe->get_result();

        if ($resultJefe->num_rows > 0) {
            $row = $resultJefe->fetch_assoc();
            if (verifyPassword($password, $row['Contraseña'])) {
                $_SESSION['id_jefe'] = $row['id_jefe'];
                $_SESSION['tipo_usuario'] = "jefe";
                header("Location: InterfazAdmin.php");
                exit();
            }
        }
    }

    // Si no se encontró ningún usuario
    if (empty($_SESSION['tipo_usuario'])) {
        $mensaje = "Usuario o contraseña incorrectos.";
        echo "<script>alert('$mensaje'); window.location.href = 'InicioSesion.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Inicio de Sesión - Veterinaria</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
<div id="sidebar">
  <div id="logo">
    <h1><a href="#">Veterinaria "El Tucán".</a></h1>
    <p>A la vanguardia con tus mascotas.</p>
  </div>
</div>
<!-- end sidebar -->
<!-- start page -->
<div id="page">
  <div id="search">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    </form>
  </div>
  <!-- start content -->
  <div id="content">
    <div class="post">
      <div class="ct">
        <div class="l">
          <div class="r"></div>
        </div>
      </div>
      <div class="entry">
        <div class="login-container">
            <img src="https://i.imgur.com/JlT70ib.jpg" alt="LogoAqui" id="imgid">
            <h2>Iniciar Sesión</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                  <h3>Usuario:</h3>
                    <input type="text" name="username" placeholder="Usuario" required>
                </div>
                <div class="form-group">
                <h3>Contraseña:</h3>
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                <div class="form-group">
                  <a href="RegistrarNuevoUsuario.php">Registrarse como nuevo usuario</a>
                </div>
                <input type="submit" value="Iniciar Sesión">
            </form>
            <div class="footer">Veterinaria El Tucán</div>
        </div>
      </div>
      <div class="cb">
        <div class="l">
          <div class="r"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- end content -->
</div>
<!-- end page -->
</body>
</html>
