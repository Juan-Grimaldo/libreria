<?php

include '../conexion.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password = hash('sha512', $password);

$query = "SELECT * FROM usuario WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
?>
    <script>
        window.alert('¡El correo electrónico ya está registrado!😖');
        window.location.href = "../form.php";
    </script>
    <?php
} else {
    // Si no hay resultados, procedemos a realizar la inserción
    $query_insert = "INSERT INTO usuario (name, email, password, date) VALUES ('$name', '$email', '$password', NOW())";
    $result_insert = mysqli_query($conn, $query_insert);
    if ($result_insert) {
    ?>
        <script>
            window.alert('¡Se ha registrado correctamente!🥵');
            window.location.href = "../form.php";
        </script>
    <?php

    } else {
    ?>
        <script>
            window.alert('¡Ups ha ocurrido un error!😖');
            window.location.href = "../form.php";
        </script>
<?php

    }
}

?>