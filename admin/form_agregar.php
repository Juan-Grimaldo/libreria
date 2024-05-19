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
                        <a href="logout.php" class="btn btn-danger mt-2">
                            <i class="fa-solid fa-right-from-bracket" style="color: #ffffff;"></i> Cerrar sesión
                        </a>
                        <hr>
                        <h3>Agregar libro</h3>
                        <form action="procesos/add.php" method="post" class="formregistro" autocomplete="off" enctype="multipart/form-data">
                            <label for="formFile" class="form-label">Imagen</label>
                            <input class="form-control" type="file" id="imagen" name="imagen" required>
                            <label for="">Titulo</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digíte el titulo del libro" required>
                            <label for="">Autor</label>
                            <input type="text" class="form-control" id="autor" name="autor" placeholder="Digíte el autor del libro" required>
                            <label for="">Género</label>
                            <input type="text" class="form-control" id="genero" name="genero" placeholder="Digíte el género del libro" required>
                            <label for="">Sinopsis</label>
                            <input type="text" class="form-control" id="sinopsis" name="sinopsis" placeholder="Digíte la sinopsis del libro" required>
                            <label for="">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" placeholder="Digíte el precio del libro" required><br>
                            <input type="submit" class="btn btn-primary" value="Agregar" name="add" id="add">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>