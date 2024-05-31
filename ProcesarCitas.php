<?php
include 'ConexionBD.php';
session_start();

$id_cliente = $_SESSION['id_cliente'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$id_mascota = $_POST['id_mascota'];

// Asignar un tipo de cita, por ejemplo 'Chequeo' si no está en el formulario
$tipo = 'Chequeo';

// Preparar la declaración
$sql = "INSERT INTO cita (Fecha, Hora, Tipo, id_mascota, id_cliente) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssii", $fecha, $hora, $tipo, $id_mascota, $id_cliente);

if ($stmt->execute()) {
    echo "Cita registrada exitosamente";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

