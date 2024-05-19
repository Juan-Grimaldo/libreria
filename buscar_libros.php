<?php

include 'conexion.php';

// Verificar si se seleccionó "all" para mostrar todos los libros sin filtrar por género
if (isset($_GET['genero'])) {
    $genero = $_GET['genero'];
    $query = "SELECT * FROM libro WHERE genero = '$genero'";
} else {
    // Si no se pasa ningún género, seleccionar todos los libros
    $query = "SELECT * FROM libro";
    $genero = '';
}
$resultado = $conn->query($query);

if ($resultado->num_rows > 0) {
?>
    <div class="product-details">
        <div class="product-related">
            <div class="novedades">
                <h3 class="tittle" style="text-align: center;">Títulos disponibles <?php echo $genero ?></h3><br>
                <div class="libros">
                    <?php
                    while ($row = $resultado->fetch_assoc()) {
                        $precio_bd = $row['precio'];
                        $precio_formateado = number_format($precio_bd, 0, ',', '.');
                    ?>
                        <div class="libro">
                            <div class="imagen-libro">
                            <img src="<?php echo $row['imagen_url']; ?>" alt="Descripción de la imagen">
                            </div>
                            <div>
                                <p class="título"><?php echo $row['titulo'] ?></p>
                                <p class="autor"><?php echo $row['autor'] ?></p>
                                <p class="valor">$<?php echo $precio_formateado ?></p>
                                <a href="view_prod.php?id_libro=<?php echo $row['id_libro']; ?>" class="detalles">Detalles</a>
                                <br><br>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    echo "No se encontraron libros para este género.";
}
?>

