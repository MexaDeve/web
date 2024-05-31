<?php
include 'ConexionBD.php';
session_start();

// Obtener el id del cliente de la sesión
$id_cliente = $_SESSION['id_cliente'];

// Consultar las mascotas asociadas al cliente
$sql_mascotas = "SELECT id_mascota, Nombre FROM mascota WHERE id_cliente = $id_cliente";
$result_mascotas = $conn->query($sql_mascotas);

$mascotas = [];

if ($result_mascotas->num_rows > 0) {
    // Recorrer los resultados y agregarlos al array de mascotas
    while ($row = $result_mascotas->fetch_assoc()) {
        $mascotas[] = $row;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Devolver el array de mascotas como JSON
echo json_encode($mascotas);
?>
