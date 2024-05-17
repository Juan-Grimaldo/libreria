<?php

// Crear conexión
$conn = new mysqli("localhost", "root", "", "libreria");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Datos del archivo
$nombre = "imagen";
$url = "https://cdn.jsdelivr.net/gh/tu-usuario/mi-repo@main/mi-imagen.jpg";

// Insertar en la base de datos
$sql = "INSERT INTO archivos (nombre, url) VALUES ('$nombre', '$url')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo registro creado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>