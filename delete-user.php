<?php
include 'conexion.php';
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['user_log']) || !$_SESSION['user_log']) {
    echo "<script>window.alert('¡Ou, debes iniciar sesión primero!😴');
          window.location.href = 'form.php';</script>";
    exit;
}

// Obtener el ID del usuario
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

if (!$id || !$password) {
    echo "<script>
            window.alert('Datos incompletos. Por favor, verifica los campos.');
            window.location.href = 'account.php';
          </script>";
    exit;
}

// Encriptar la contraseña ingresada para compararla con la de la base de datos
$hashedPassword = hash('sha512', $password);

// Verificar la contraseña
$query = "SELECT password FROM usuario WHERE id='$id'";
$resultado = $conn->query($query);
$row = $resultado->fetch_assoc();

if ($hashedPassword !== $row['password']) {
    echo "<script>
            window.alert('Contraseña incorrecta. Por favor, intenta de nuevo.');
            window.location.href = 'account.php';
          </script>";
    exit;
}

// Eliminar el usuario de la base de datos
$query = "DELETE FROM usuario WHERE id='$id'";
$resultado = $conn->query($query);

if ($resultado) {
    session_destroy();
    echo "<script>
            window.alert('¡Cuenta eliminada correctamente! 😢');
            window.location.href = 'form.php';
          </script>";
} else {
    echo "<script>
            window.alert('¡Ups, ha ocurrido un error al eliminar la cuenta! 😕');
            window.location.href = 'account.php';
          </script>";
}

$conn->close();
?>