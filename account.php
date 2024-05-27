<?php
include 'header.php';
include 'conexion.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validar que haya una sesión activa
if (!isset($_SESSION['user_log']) || !$_SESSION['user_log']) {
    echo "<script>
            window.alert('¡Ou, debes iniciar sesión primero!😴');
            window.location.href = 'form.php';
          </script>";
    exit;
}

// Obtener el id del usuario
$id = isset($_SESSION['id']) ? $_SESSION['id'] : (isset($_REQUEST['id']) ? $_REQUEST['id'] : null);
if ($id === null) {
    echo "<script>
            window.alert('ID de usuario no proporcionado');
            window.location.href = 'form.php';
          </script>";
    exit;
}

// Consultas para traer información del usuario
$query = "SELECT * FROM usuario WHERE id='$id'";
$sql = "SELECT imagen FROM usuario WHERE id='$id'";
$resultado = $conn->query($query);
$result = $conn->query($sql);

if (!$resultado || !$result) {
    echo "<script>
            window.alert('Error al obtener datos del usuario');
            window.location.href = 'form.php';
          </script>";
    exit;
}

$row = $resultado->fetch_assoc();

if (!$row) {
    echo "<script>
            window.alert('Usuario no encontrado');
            window.location.href = 'form.php';
          </script>";
    exit;
}

$correo = $row['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./estilos/style2.css">
</head>
<body>
    <main>
        <hr>
        <div class="product-details">
            <div class="left-column">
                <?php if (!empty($row['imagen'])) { ?>
                    <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen de usuario" style="width: 350px; height: auto;">
                <?php } else { ?>
                    <img src="https://cdn-icons-png.freepik.com/512/1077/1077063.png" alt="Imagen de usuario">
                <?php } ?>
            </div>
            <div class="right-column">
                <h3 class="tittle">Datos del usuario</h3>
                <h3>Nombre de usuario</h3>
                <p><?php echo htmlspecialchars($row['name']); ?></p>
                <h3>Email / Correo</h3>
                <p><?php echo htmlspecialchars($row['email']); ?></p><br>
                <a href="./validate.php?id=<?php echo urlencode($id); ?>"><button style="background-color:black">Actualizar información</button></a><br><br>
                <a href="./user/logout1.php"><button style="background-color:#EA4F4F">Cerrar sesión</button></a>
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
                                <td class="align-middle"><?php echo htmlspecialchars($row1['detalleventa_id']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($row1['titulo']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($row1['autor']); ?></td>
                                <td class="align-middle">$<?php echo $precio_formateado; ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($row1['Fecha']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($row1['status']); ?></td>
                                <td class="align-middle"><?php echo htmlspecialchars($row1['ESTADO']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>

<?php include 'footer.php'; ?>