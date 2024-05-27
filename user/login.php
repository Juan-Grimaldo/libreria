<?php

$conn = new mysqli("localhost", "root", "", "libreria");

$email = $_POST['email'];
$password = $_POST['password'];
$password = hash('sha512', $password);

$query = ("SELECT * FROM usuario WHERE email = '$email' AND password = '$password'");
$result = $conn->query($query);

if ($result->num_rows > 0) {
    session_start();
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $id = $row['id'];
    $_SESSION['id'] = $id;
    $_SESSION['user_log'] = true;
    $_SESSION['email'] = $row['email'];
    echo "<script>  window.alert('¡Bienvenido, $name!😁');
    window.location.href = '../index.php';</script>";
} else {
    echo "<script>  window.alert('¡Ups, correo y/o contraseña incorrectos!😕');
    window.location.href = '../form.php';</script>";
}
