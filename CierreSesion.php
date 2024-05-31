<?php
session_start();
session_unset();
session_destroy();
header("Location: InicioSesion.php"); // Redirigir a la página de inicio de sesión
exit;
?>
