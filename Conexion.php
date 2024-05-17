<?php
// Información de conexión a la base de datos
$servername = "127.0.0.1"; // Servidor de la base de datos (localhost)
$username = "root"; // Nombre de usuario de la base de datos
$password = ""; // Contraseña de la base de datos (en este caso, podría ser una cadena vacía)
$database = "libreria"; // Nombre de la base de datos que deseas utilizar

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
