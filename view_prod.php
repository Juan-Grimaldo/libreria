<?php
include 'header.php';
include 'global/conexion.php';
include 'global/config.php';
include 'carro.php';

$id_libro = $_REQUEST['id_libro'];
$stmt = $conn->prepare("SELECT * FROM libro WHERE id_libro = ?");
$stmt->bindParam(1, $id_libro, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $precio_bd = $row['precio'];
    $precio_formateado = number_format($precio_bd, 0, ',', '.');
    $genero = $row['genero'];
} else {
    echo "No se encontró el libro con ID: $id_libro";
    exit;
}
?>

<html>

<head>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .product-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #f9f9f9;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .left-column {
            text-align: center;
            width: 100%;
            padding: 20px;
        }

        .left-column img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .right-column {
            width: 100%;
            padding: 20px;
        }

        .tittle {
            margin-top: 0;
            font-size: 30px;
        }

        h3 {
            margin-bottom: 5px;
            font-size: 24px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .product-related {
            width: 95%;
            padding: 10px;
            display: flex;
            justify-content: center;
        }

        @media only screen and (min-width: 768px) {

            .product-details {
                flex-wrap: nowrap;
            }

            .left-column {
                width: 35%;
            }

            .right-column {
                width: 60%;
            }
        }

        @media only screen and (max-width: 768px) {
            .left-column img {
                width: 100%;
                max-width: 250px;
                height: auto;
            }
        }
    </style>
</head>
<main>
    <hr>
    <div class="product-details">
        <div class="left-column">
            <img src="<?php echo $row['imagen_url']; ?>" alt="Imagen del Producto" style="width: 350px; height: auto;">
        </div>
        <div class="right-column">
            <h3 class="tittle"><?php echo $row['titulo'] ?></h3>
            <h3>Autor</h3>
            <p><?php echo $row['autor'] ?></p>
            <h3>Genero</h3>
            <p><?php echo $row['genero'] ?></p>
            <h3>Sinopsis</h3>
            <p><?php echo $row['sinopsis'] ?></p>
            <h3>Precio</h3>
            <p>$<?php echo $precio_formateado ?></p>
            <form action="" method="post">
                <input type="hidden" name="id" id="id" value="<?php echo $id_libro; ?>">
                <input type="hidden" name="nombre" id="nombre" value="<?php echo $row['titulo']; ?>">
                <input type="hidden" name="precio" id="precio" value="<?php echo $precio_formateado ?>">
                <input type="hidden" name="cantidad" id="cantidad" value="<?php echo 1; ?>">
                <button class="btn btn-primary" name="btnAccion" value="Agregar" type="submit">
                    Agregar al carrito
                </button>
            </form>
        </div>
    </div>
    <div class="product-details">
        <div class="product-related">
            <div class="novedades">
                <h3 class="tittle" style="text-align: center;">Titulos relacionados</h3><br>
                <div class="libros">
                    <?php
                    $query = "SELECT * FROM libro WHERE genero = ? ORDER BY RAND() LIMIT 5";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(1, $genero, PDO::PARAM_STR);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $precio_bd = $row['precio'];
                        $precio_formateado = number_format($precio_bd, 0, ',', '.');
                    ?>
                        <div class="libro">
                            <div class="imagen-libro">
                                <img height="100px" src="<?php echo $row['imagen_url']; ?>">
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
</main>

</html>