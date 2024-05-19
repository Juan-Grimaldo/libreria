<?php
// Conexión a la base de datos
include 'conexion.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener todos los libros
$query = "SELECT * FROM libro";
$result = mysqli_query($conn, $query);

// Verificar si hubo errores en la consulta
if (!$result) {
    die("Error al ejecutar la consulta: " . $conn->error);
}

// Crear un array para almacenar los libros
$libros = array();

// Recorrer los resultados de la consulta y agregarlos al array
while ($row = $result->fetch_assoc()) {
    $libros[] = $row;
}

// Devolver los libros en formato JSON
header('Content-Type: application/json');
echo json_encode($libros);
?>
