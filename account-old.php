<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';
$conn = new mysqli("localhost", "root", "", "libreria");
$id = $_REQUEST['id'];
$query = "SELECT * FROM usuario WHERE id='$id'";
$sql = "SELECT imagen FROM usuario WHERE id='$id'";
$resultado = $conn->query($query);
$result = $conn->query($sql);
$row = $resultado->fetch_assoc();
?>

<head>
    <link rel="stylesheet" href="./estilos/style2.css">
</head>

<main>
    <hr>
    <div class="product-details">
        <div class="left-column">
            <?php
                if(!empty($row['imagen'])){
                    ?> <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>" alt="Imagen de usuario" style="width: 350px; height: auto;"> <?php
                } else {
                    ?> <img src="https://cdn-icons-png.freepik.com/512/1077/1077063.png" alt="Imagen de usuario"> <?php  
                }
            ?>      
        </div>
        <div class="right-column">
            <h3 class="tittle">Datos del usuario</h3>

            <h3>Nombre de usuario</h3>
            <p><?php echo $row['name'] ?></p>

            <h3>Email / Correo</h3>
            <p><?php echo $row['email'] ?></p>
            <a href="./user/logout1.php">Cerrar sesión</a>
        </div>
    </div>
</main>

</html>