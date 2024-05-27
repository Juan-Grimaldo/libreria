<?php
include 'conexion.php';
session_start();

$data = json_decode(file_get_contents("php://input"), true);
$password = $data['password'];

// Aquí debes obtener el id del usuario que está intentando actualizar los datos
$id = $_SESSION['id'];

// Obtener la contraseña almacenada en la base de datos
$query = "SELECT password FROM usuario WHERE id='$id'";
$resultado = $conn->query($query);
$row = $resultado->fetch_assoc();

// Verificar la contraseña
if (password_verify($password, $row['password'])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>