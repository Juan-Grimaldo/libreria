<?php

$conn = new mysqli("localhost", "root", "", "libreria");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password = hash('sha512', $password);

$query = "INSERT INTO usuario (name, email, password) VALUES ('$name', '$email', '$password')";
$result = mysqli_query($conn, $query);

if ($result) {
    ?>
    <script>window.alert('¡Se ha registrado correctamente!🥵');
                    window.location.href = "../form.php";</script>
    <?php

} else {
    ?> 
    <script>window.alert('¡Ups ha ocurrido un error!😖');
                    window.location.href = "../form.php";</script>
    <?php

}


?>