<!DOCTYPE html>
<html lang="en">

<?php include 'header.php'; ?>

<section class="hero">
    <div class="contenido-hero">
        <p>Es el capítulo uno</p>
        <h1>Decides adentrarte en un mar de historias, buscando descubrir tu próximo tesoro literario</h1>
        <div class="btn">
            <a href="#hero2"><button>Embarcate en la aventura</button></a>
        </div>
    </div>
</section>
<section id="hero2" class="hero2">
    <div class="contenido-hero2">
        <h2>¡Bienvenido a tu aventura literaria!</h2>
        <p>Prepárate para embarcarte en un viaje de descubrimiento a través de las páginas de la imaginación. Cada libro
            es un portal hacia nuevos horizontes, donde las palabras son el viento que impulsa tu nave. Deja que la
            curiosidad sea tu brújula mientras exploras mundos desconocidos y te sumerges en historias que te harán
            reír, llorar y soñar.
            En esta travesía, encontrarás personajes inolvidables que te acompañarán en tu viaje, paisajes que te
            transportarán a lugares lejanos y épocas pasadas, y emociones que te envolverán en cada página.
            En esta librería virtual, tú eres el capitán de tu propia odisea literaria. Así que sigue navegando,
            desvelando los secretos que aguardan ser descubiertos en cada giro de página. ¡Tu aventura literaria
            comienza ahora!</p>
        <div class="btn">
            <a href="#descripcion-a"><button>Sigue la travesía</button></a>
        </div>
    </div>
</section>
<div class="contenedor">
    <section class="descripcion-a" id="descripcion-a">
        <div class="novedades">
            <h2>Novedades</h2>
            <div class="libros">
                <?php
                include 'conexion.php';
                $query = "SELECT * FROM libro ORDER BY id_libro DESC LIMIT 5";
                $resultado = $conn->query($query);
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
    </section>
</div>
</main>
</body>
<?php include 'footer.php' ?>
<script src="./scriptmain.js"></script>
<script src="./scriptsearch.js"></script>
</html>