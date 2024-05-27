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
    <style>
        .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
    </style>
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
            <a href="./validate.php?id=<?php echo $id ?>"><button class="btn" style="background-color:black">Actualizar información</button></a><br><br>
            <a href="./user/logout1.php"><button class="btn" style="background-color:#EA4F4F">Cerrar sesión</button></a>
        </div>
    </div>
    <div class="product-details">
        <div class="table-container">
            <h1 style="text-align: center; color:#EA4F4F;">Compras realizadas</h1>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <th>ID</th>
                    <th>Libro</th>
                    <th>Autor</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                    <th>Estado del pago</th>
                    <th>Estado entrega</th>
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
                        $precio_bd = $row1['precio'];
                        $precio_formateado = number_format($precio_bd, 0, ',', '.');
                    ?>
                        <tr>
                            <td class="align-middle"><?php echo $row1['detalleventa_id'] ?></td>
                            <td class="align-middle"><?php echo $row1['titulo'] ?></td>
                            <td class="align-middle"><?php echo $row1['autor'] ?></td>
                            <td class="align-middle">$<?php echo $precio_formateado ?></td>
                            <td class="align-middle"><?php echo $row1['Fecha'] ?></td>
                            <td class="align-middle"><?php echo $row1['status'] ?></td>
                            <td class="align-middle"><?php echo $row1['ESTADO'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script src="./scriptmain.js"></script>
<?php include 'footer.php' ?>
</html>