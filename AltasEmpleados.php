<?php
include 'ConexionBD.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombreEmpleado']);
    $edad = $conn->real_escape_string($_POST['edad']);
    $sexo = $conn->real_escape_string($_POST['sexo']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $contraseña = $conn->real_escape_string($_POST['password']);
    
    // Encriptar la contraseña antes de guardar en la base de datos
    $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT);

    $sql = "INSERT INTO empleado_de_veterinaria (Nombre, Edad, Sexo, Telefono, Direccion, Contraseña) 
            VALUES ('$nombre', '$edad', '$sexo', '$telefono', '$direccion', '$contraseña_encriptada')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "Nuevo empleado registrado exitosamente";
    } else {
        $mensaje = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
