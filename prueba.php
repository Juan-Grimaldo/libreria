<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NubeLiteraria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Coming+Soon&family=Lobster&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./estilos/a.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>

    </style>
</head>

<body>

    <!-- Formulario de búsqueda -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
        <input type="text" name="busqueda" placeholder="Buscar por título">
        <input type="submit" name="enviar" value="Buscar">
    </form>

    <?php
    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "libreria");

    // Verificar si se ha enviado el formulario de búsqueda
    if (isset($_GET['enviar'])) {
        // Obtener el término de búsqueda
        $busqueda = $_GET['busqueda'];
        
        // Consulta para obtener los libros que coincidan con el término de búsqueda
        $query = "SELECT * FROM libro WHERE titulo LIKE '%$busqueda%'";
        $resultado = $conn->query($query);

        // Verificar si se han obtenido resultados
        if ($resultado->num_rows > 0) {
            // Recorrer los resultados y mostrar los libros
            while ($row = $resultado->fetch_array()) {
    ?>
                <tr>
                    <td><?php echo $row['id_libro'] ?></td>
                    <td><img height="100px" src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>"></td>
                    <td class="align-middle"><?php echo $row['titulo'] ?></td>
                    <td class="align-middle"><?php echo $row['autor'] ?></td>
                    <td class="align-middle"><?php echo $row['genero'] ?></td>
                    <td class="align-middle"><?php echo $row['sinopsis'] ?></td>
                    <td class="align-middle"><?php echo $row['precio'] ?></td>
                    <td class="align-middle">
                        <a href="form_update.php?id_libro=<?php echo $row['id_libro']; ?>" class="btn btn-warning">
                            <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                        </a>
                        <a href="form_delete.php?id_libro=<?php echo $row['id_libro']; ?>" class="btn btn-danger">
                            <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                        </a>
                    </td>
                </tr>
    <?php
            }
        } else {
            // Si no se encontraron libros, mostrar un mensaje
            echo "<tr><td colspan='8'>No se encontraron libros.</td></tr>";
        }
    } else {
        // Consulta para obtener todos los libros
        $query = "SELECT * FROM libro";
        $resultado = $conn->query($query);

        // Verificar si se han obtenido resultados
        if ($resultado->num_rows > 0) {
            // Recorrer los resultados y mostrar los libros
            while ($row = $resultado->fetch_array()) {
    ?>
                <tr>
                    <td><?php echo $row['id_libro'] ?></td>
                    <td><img height="100px" src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>"></td>
                    <td class="align-middle"><?php echo $row['titulo'] ?></td>
                    <td class="align-middle"><?php echo $row['autor'] ?></td>
                    <td class="align-middle"><?php echo $row['genero'] ?></td>
                    <td class="align-middle"><?php echo $row['sinopsis'] ?></td>
                    <td class="align-middle"><?php echo $row['precio'] ?></td>
                    <td class="align-middle">
                        <a href="form_update.php?id_libro=<?php echo $row['id_libro']; ?>" class="btn btn-warning">
                            <i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i>
                        </a>
                        <a href="form_delete.php?id_libro=<?php echo $row['id_libro']; ?>" class="btn btn-danger">
                            <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                        </a>
                    </td>
                </tr>
    <?php
            }
        } else {
            // Si no se encontraron libros, mostrar un mensaje
            echo "<tr><td colspan='8'>No se encontraron libros.</td></tr>";
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>

</html>