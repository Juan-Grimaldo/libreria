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
            <form action="" method="get">
              <div class="row g-3">
                <div class="col">
                  <input type="text" class="form-control" placeholder="Busqueda por titulo" name="busqueda" autocomplete="off">
                </div>
                <div class="col">
                  <input type="submit" class="btn btn-primary" name="enviar" value="Buscar">
                </div>
              </div>
            </form>
            <br>
            <div class="table-responsive">
              <table class="table table-small table-hover table-bordered">
                <thead>
                  <th>Id</th>
                  <th>Imagen</th>
                  <th>Titulo</th>
                  <th>Autor</th>
                  <th>Género</th>
                  <th>Precio</th>
                  <th>Sinopsis</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
                </thead>
                <tbody>
                  <?php
                  include '../conexion.php';
                  $resultados_por_pagina = 10;

                  // Determinar la página actual
                  $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                  // Calcular el índice inicial del primer resultado en la página actual
                  $indice_inicial = ($pagina_actual - 1) * $resultados_por_pagina;

                  if (isset($_GET['enviar'])) {
                    $busqueda = $_GET['busqueda'];
                    $query = "SELECT * FROM libro WHERE titulo LIKE '%$busqueda%' LIMIT $indice_inicial, $resultados_por_pagina";
                  } else {
                    // Consulta para obtener todos los libros
                    $query = "SELECT * FROM libro LIMIT $indice_inicial, $resultados_por_pagina";
                  }

                  $resultado = $conn->query($query);
                  if ($resultado->num_rows > 0) {
                    while ($row = $resultado->fetch_array()) {
                  ?>
                      <tr>
                        <td class="align-middle"><?php echo $row['id_libro'] ?></td>
                        <td><img height="100px" src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>"></td>
                        <td class="align-middle"><?php echo $row['titulo'] ?></td>
                        <td class="align-middle"><?php echo $row['autor'] ?></td>
                        <td class="align-middle"><?php echo $row['genero'] ?></td>
                        <td class="align-middle"><?php echo $row['precio'] ?></td>
                        <td class="align-middle">
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ventanaEmergente<?php echo $row['id_libro'] ?>">
                            <i class="fa-solid fa-circle-info" style="color: #ffffff;"></i>
                          </button>
                        </td>
                        <td class="align-middle">
                          <a href="form_update.php?id_libro=<?php echo $row['id_libro']; ?>" class="btn btn-warning">
                            <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                          </a>
                        </td>
                        <td class="align-middle">
                          <a href="form_delete.php?id_libro=<?php echo $row['id_libro']; ?>" class="btn btn-danger">
                            <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                          </a>
                        </td>
                      </tr>
                      <!-- Ventana Emergente -->
                      <div class="modal fade" id="ventanaEmergente<?php echo $row['id_libro'] ?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Sinopsis</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                              <?php echo $row['sinopsis'] ?>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                  <?php
                    }
                  } else {
                    echo "<tr><td colspan='8'>No se encontraron libros.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- Paginación -->
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                <?php
                // Calcular el número total de páginas
                $query_total = "SELECT COUNT(*) as total FROM libro";
                $resultado_total = $conn->query($query_total);
                $total_libros = $resultado_total->fetch_assoc()['total'];
                $total_paginas = ceil($total_libros / $resultados_por_pagina);

                // Mostrar enlaces de paginación
                for ($pagina = 1; $pagina <= $total_paginas; $pagina++) {
                  echo "<li class='page-item" . ($pagina == $pagina_actual ? " active" : "") . "'><a class='page-link' href='?pagina=" . $pagina . "'>" . $pagina . "</a></li>";
                }
                ?>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
<?php include '../footer.php' ?>

</html>