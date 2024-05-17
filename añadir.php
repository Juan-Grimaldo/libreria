<?php

// Crear conexión
$conn = new mysqli("localhost", "root", "", "libreria");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Datos del archivo
$titulo = "imagen";
$imagen_url = "https://cdn.jsdelivr.net/gh/Juan-Grimaldo/libreria@main/imagenes-libros/content.jpeg";

// Insertar en la base de datos
$sql = "INSERT INTO libro (titulo, imagen_url) VALUES ('$titulo', '$imagen_url')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo registro creado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


?>