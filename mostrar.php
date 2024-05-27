<?php

// Crear conexión
include 'conexion.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la URL del archivo
$sql = "SELECT imagen_url FROM libro WHERE titulo='imagen'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $imagen_url = $row["imagen_url"];
        echo "<img src='" . $imagen_url . "' alt='Mi Imagen'>";
    }
} else {
    echo "0 resultados";
}


?>