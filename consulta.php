<?php
                include 'conexion.php';
                $query = "SELECT * FROM libro ORDER BY RAND() LIMIT 5";
                $resultado = $conn->query($query);
                while ($row = $resultado->fetch_assoc()) {
                    $precio_bd = $row['precio'];
                    $precio_formateado = number_format($precio_bd, 0, ',', '.');
                ?>
                    <div class="libro">
                        <div class="imagen-libro">
                            <img height="100px" src="data:image/jpg;base64,<?php echo base64_encode($row['imagen']); ?>">
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