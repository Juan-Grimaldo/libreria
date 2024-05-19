<!DOCTYPE html>
<html lang="en">

<?php
include 'header.php';
include 'conexion.php';

//Validar que este una sesion activa
if (!isset($_SESSION['user_log']) || !$_SESSION['user_log']) {
    echo "<script>window.alert('¡Ou, debes iniciar sesión primero!😴');
          window.location.href = 'form.php';</script>";
    exit;
}

//Consultas para traer información del usuario
$id = $_REQUEST['id'];
$query = "SELECT * FROM usuario WHERE id='$id'";
$sql = "SELECT imagen FROM usuario WHERE id='$id'";
$resultado = $conn->query($query);
$result = $conn->query($sql);
$row = $resultado->fetch_assoc();
$correo = $row['email'];
?>

<head>
    <link rel="stylesheet" href="./estilos/style2.css">
</head>

<!-- INICIO ACCOUNT -->
<main>
    <hr>
    <div class="product-details">
        <div class="left-column">
            <?php
            if (!empty($row['imagen'])) {
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
            <p><?php echo $row['email'] ?></p><br>
            <a href="./account/validate.php?id=<?php echo $id ?>"><button style="background-color:black">Actualizar información</button></a><br><br>
            <a href="./user/logout1.php"><button style="background-color:#EA4F4F">Cerrar sesión</button></a>
        </div>
    </div>
    <hr>
    <div class="product-details">
        <table class="table table-small table-hover table-bordered">
            <thead>
                <th>ID</th>
                <th>Venta</th>
                <th>Libro</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Estado del pedido</th>
                <th>Modificar estado</th>
            </thead>
            <tbody>
                <?php
                $consulta = "SELECT tbldetalleventa.ID AS detalleventa_id, tbldetalleventa.*, libro.*, tblventas.*
                            FROM tbldetalleventa
                            INNER JOIN libro ON tbldetalleventa.IDPRODUCTO = libro.id_libro
                            INNER JOIN tblventas ON tbldetalleventa.IDVENTA = tblventas.ID
                            WHERE tblventas.Correo = '$correo'";
                $resultado = $conn->query($consulta);
                while ($row1 = $resultado->fetch_assoc()) {
                ?>
                    <tr>
                        <td class="align-middle"><?php echo $row1['detalleventa_id'] ?></td>
                        <td class="align-middle"><?php echo $row1['titulo'] ?></td>
                    </tr>
                    <?php
                }
    ?>
            </tbody>
        </table>
    
    </div>
</main>
<?php include 'footer.php' ?>

</html>