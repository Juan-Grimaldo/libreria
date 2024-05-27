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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dd0247d67c.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/styleadmin.css">
</head>

<!-- INICIO ACCOUNT -->
<main>
<div class="container">
        <div class="row">
            <div class="col">
                <div class="card mt-4">
                    <div class="card-body">
                        <h2>Actualizar datos</h2>
                        <hr>
                        <?php
                        include './conexion.php';
                        $id = $_REQUEST['id'];
                        $query = "SELECT * FROM usuario WHERE id='$id'";
                        $resultado = $conn->query($query);
                        $row = $resultado->fetch_assoc();
                        ?>
                        <form action="procesos/update.php?id_libro=<?php echo $row['id']; ?>" method="POST" class="formregistro" autocomplete="off" enctype="multipart/form-data">
                            <label for="formFile" class="form-label">Imagen</label>
                            <img height="100px" src="<?php echo $row['imagen']; ?>" alt="Descripción de la imagen">
                            <input class="form-control" type="file" id="imagen" name="imagen" value="" required>
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" id="name" name="titulo" value="<?php echo $row['name']; ?>" required>
                            <label for="">Email</label>
                            <input type="email" class="form-control" id="email" name="autor" value="<?php echo $row['email']; ?>" required>
                            <label for="">password</label>
                            <input type="text" class="form-control" id="genero" name="genero" value="<?php echo $row['password']; ?>" required>
                            <input type="submit" class="btn btn-primary" value="Actualizar" id="update" name="update">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php' ?>

</html>