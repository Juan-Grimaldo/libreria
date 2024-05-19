<?php

include '../conexion.php';

$email = $_POST['email'];
$password = $_POST['password'];

$query = ("SELECT * FROM admin WHERE email = '$email' AND password = '$password'");
$result = $conn->query($query);

if ($result->num_rows > 0) {
    session_start();
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $_SESSION['id'] = $id;
    $_SESSION['admin_log'] = true;
    echo "<script>  window.alert('¡Bienvenido al modo administrador!😁');
                    window.location.href = 'index_admin.php';</script>";
} else {
    echo "<script>  window.alert('¡Ups, ha ocurrido un error!😕');
                    window.location.href = '../form.php';</script>";
}
