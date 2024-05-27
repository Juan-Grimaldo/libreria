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
    <script src="https://kit.fontawesome.com/dd0247d67c.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                        <table class="table table-small table-hover table-bordered">
                            <thead>
                                <th>Id</th>
                                <th>Imagen</th>
                                <th>Titulo</th>
                                <th>Autor</th>
                                <th>Género</th>
                                <th>Sinopsis</th>
                                <th>Precio</th>
                            </thead>
                            <?php
                            include '../conexion.php';
                            $id_libro = $_REQUEST['id_libro'];
                            $query = "SELECT * FROM libro WHERE id_libro='$id_libro'";
                            $resultado = $conn->query($query);
                            $row = $resultado->fetch_assoc();
                            ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $row['id_libro'] ?></td>
                                    <td><img height="100px" src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>"></td>
                                    <td><?php echo $row['titulo'] ?></td>
                                    <td><?php echo $row['autor'] ?></td>
                                    <td><?php echo $row['genero'] ?></td>
                                    <td><?php echo $row['sinopsis'] ?></td>
                                    <td><?php echo $row['precio'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <p class="error">¿Estas seguro de eliminar este registro? Una vez eliminado no podrá ser recuperado.</p>
                        <form action="procesos/delete.php?id_libro=<?php echo $row['id_libro']; ?>" method="post">
                            <input type="text" value="<?php echo $row['id_libro'] ?>" name="id" hidden>
                            <button class="btn btn-danger">
                                <i class="fa-solid fa-trash" style="color: #ffffff;"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>