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
    <title>NubeLiteraria</title>
    <style>
        body {
            background-image: url('https://acortar.link/Jxzr5l');
        }

        .mt-4 {
            margin-bottom: 24px;
        }

        hr {
            background-color: gray;
            height: 0.2px;
            border: none;
        }
    </style>
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
                                    <th>Venta</th>
                                    <th>Libro</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                </thead>
                                <tbody>
                                    <?php
                                    include '../conexion.php';
                                    $query = "SELECT * FROM tbldetalleventa";
                                    $resultado = $conn->query($query);
                                    while ($row = $resultado->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td class="align-middle"><?php echo $row['ID'] ?></td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ventanaEmergente1_<?php echo $row['IDVENTA']; ?>">
                                                    <i class="fa-solid fa-circle-info" style="color: #ffffff;"></i>
                                                </button>
                                            </td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ventanaEmergente2_<?php echo $row['IDPRODUCTO']; ?>">
                                                    <i class="fa-solid fa-circle-info" style="color: #ffffff;"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Primera Ventana Emergente -->
                                        <div class="modal fade" id="ventanaEmergente1_<?php echo $row['IDVENTA']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">VENTA</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        $query1 = "SELECT tblventas.* FROM tbldetalleventa INNER JOIN tblventas ON tbldetalleventa.IDVENTA = tblventas.ID";
                                                        $resultado1 = $conn->query($query1);
                                                        $row1 = $resultado1->fetch_assoc();
                                                        ?>
                                                        <p>ID: <?php echo $row1['ID']; ?></p>
                                                        <p>Clave transacción: <?php echo $row1['ClaveTransaccion']; ?></p>
                                                        <p>Fecha: <?php echo $row1['Fecha']; ?></p>
                                                        <p>Correo: <?php echo $row1['Correo']; ?></p>
                                                        <p>Total: <?php echo $row1['Total']; ?></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Segunda Ventana Emergente -->
                                        <div class="modal fade" id="ventanaEmergente2_<?php echo $row['IDPRODUCTO']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Sinopsis 2</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        $query2 = "SELECT libro.* FROM tbldetalleventa INNER JOIN libro ON tbldetalleventa.IDPRODUCTO = libro.id_libro";
                                                        $resultado2 = $conn->query($query2);
                                                        $row2 = $resultado2->fetch_assoc();
                                                        ?>
                                                        <p>ID: <?php echo $row2['id_libro']; ?></p>
                                                        <p>Titulo: <?php echo $row2['titulo']; ?></p>
                                                        <p>Autor: <?php echo $row2['autor']; ?></p>
                                                        <p>Genero: <?php echo $row2['genero']; ?></p>
                                                        <p>Precio: <?php echo $row2['precio']; ?></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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