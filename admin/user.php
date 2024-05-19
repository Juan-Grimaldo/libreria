<?php
require_once 'validate_sesion.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/dd0247d67c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilos/styleadmin.css">
    <title>NubeLiteraria</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card mt-4">
                    <div class="card-body">
                        <h2>Modo administrador</h2>
                        <a href="index_admin.php" class="btn btn-dark mt-2">
                            <i class="fa-solid fa-house" style="color: #ffffff;"></i> Inicio
                        </a>
                        <a href="form_agregar.php" class="btn btn-dark mt-2">
                            <i class="fa-solid fa-book" style="color: #ffffff;"></i> Agregar libro
                        </a>
                        <a href="user.php" class="btn btn-dark mt-2">
                            <i class="fa-solid fa-user" style="color: #ffffff;"></i> Usuarios registrados
                        </a>
                        <a href="order.php" class="btn btn-dark mt-2">
                            <i class="fa-solid fa-shop" style="color: #ffffff;"></i> Pedidos
                        </a>
                        <a href="logout.php" class="btn btn-danger mt-2">
                            <i class="fa-solid fa-right-from-bracket" style="color: #ffffff;"></i> Cerrar sesión
                        </a>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-small table-hover table-bordered">
                                <thead>
                                    <th>Id</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Fecha registro</th>
                                </thead>
                                <tbody>
                                    <?php
                                    include '../conexion.php';
                                    $query = "SELECT * FROM usuario";
                                    $resultado = $conn->query($query);
                                    while ($row = $resultado->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td class="align-middle"><?php echo $row['id'] ?></td>
                                            <td class="align-middle">
                                                <?php
                                                if (!empty($row['imagen'])) {
                                                ?> <img height="70px" src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']);
                                                                                                    ?>" alt="Imagen de usuario" style="width: 350px; height: auto;"> <?php
                                                                                                                                                                    } else {
                                                                                                                                                                        ?> <img height="70px" src="https://cdn-icons-png.freepik.com/512/1077/1077063.png" alt="Imagen de usuario"> <?php
                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                    ?>
                                            </td>
                                            <td class="align-middle"><?php echo $row['name'] ?></td>
                                            <td class="align-middle"><?php echo $row['email'] ?></td>
                                            <td class="align-middle"><?php echo $row['date'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<?php include '../footer.php' ?>

</html>