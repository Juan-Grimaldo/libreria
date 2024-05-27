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
                                    include '../conexion.php';
                                    $query = "SELECT tbldetalleventa.ID AS detalleventa_id, tbldetalleventa.*, libro.*, tblventas.*
                                              FROM tbldetalleventa
                                              INNER JOIN libro ON tbldetalleventa.IDPRODUCTO = libro.id_libro
                                              INNER JOIN tblventas ON tbldetalleventa.IDVENTA = tblventas.ID";

                                    $resultado = $conn->query($query);
                                    while ($row = $resultado->fetch_assoc()) {
                                        $precio_bd = $row['precio'];
                                        $precio_formateado = number_format($precio_bd, 0, ',', '.');
                                    ?>
                                        <tr>
                                            <td class="align-middle"><?php echo $row['detalleventa_id'] ?></td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#ventanaEmergente1_<?php echo $row['detalleventa_id']; ?>">
                                                    <i class="fa-solid fa-circle-info"></i> Detalles
                                                </button>
                                            </td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#ventanaEmergente2_<?php echo $row['detalleventa_id']; ?>">
                                                    <i class="fa-solid fa-circle-info"></i> Detalles
                                                </button>
                                            </td>
                                            <td class="align-middle">$<?php echo $row['PRECIOUNITARIO'] ?>.000</td>
                                            <td class="align-middle"><?php echo $row['CANTIDAD'] ?></td>
                                            <td class="align-middle"><?php echo $row['ESTADO'] ?></td>
                                            <td class="align-middle">
                                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#ventanaEmergente3_<?php echo $row['detalleventa_id']; ?>">
                                                    <i class="fa-solid fa-pen-to-square"></i> Modificar
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Primera Ventana Emergente -->
                                        <div class="modal fade" id="ventanaEmergente1_<?php echo $row['detalleventa_id']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Descripción de la venta</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>ID de la venta:</strong> <?php echo $row['ID']; ?></p>
                                                        <p><strong>Clave de la transacción:</strong> <?php echo $row['ClaveTransaccion']; ?></p>
                                                        <p><strong>Fecha en que se realizó:</strong> <?php echo $row['Fecha']; ?></p>
                                                        <p><strong>Correo registrado:</strong> <?php echo $row['Correo']; ?></p>
                                                        <p><strong>Total de la venta:</strong> $<?php echo $row['Total']; ?>.000</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Segunda Ventana Emergente -->
                                        <div class="modal fade" id="ventanaEmergente2_<?php echo $row['detalleventa_id']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Descripción del libro</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>ID del producto:</strong> <?php echo $row['id_libro']; ?></p>
                                                        <p><strong>Titulo:</strong> <?php echo $row['titulo']; ?></p>
                                                        <p><strong>Autor:</strong> <?php echo $row['autor']; ?></p>
                                                        <p><strong>Genero:</strong> <?php echo $row['genero']; ?></p>
                                                        <p><strong>Precio:</strong> $<?php echo $precio_formateado; ?></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Ventana emergente cambio status -->
                                        <div class="modal fade" id="ventanaEmergente3_<?php echo $row['detalleventa_id']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Descripción del libro</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="error">¿Está seguro de modificar el estado del pedido a: ENTREGADO?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="procesos/status.php?ID=<?php echo $row['detalleventa_id']; ?>" method="post">
                                                            <input type="text" value="<?php echo $row['detalleventa_id']; ?>" name="id" hidden>
                                                            <button type="submit" class="btn btn-primary">Confirmar</button>
                                                        </form>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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