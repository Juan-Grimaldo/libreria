<?php

include 'header.php';
include 'carro.php';
include 'global/config.php';
include 'global/conexion.php';
?>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
</head>
<br>

<style>
.margen {
    margin-left: 120px;
    margin-right: 120px;
}

a:hover{
    text-decoration: none;
    color: black;
}

hr {
    margin-top: 0;
    margin-bottom: 15px;
    background-color: gray;
    height: 0.2px;
    border: none;
}
</style>
<hr>
<div class="margen">
    <h3 style="font-size: 40px;">Lista del carrito</h3> <br>
    <?php if (!empty($_SESSION['CARRO'])) { ?>
        <table class="table table-success table-bordered">
            <tbody>
                <tr>
                    <th style="font-size: 20px; width: 40%;">Descripción</th>
                    <th style="font-size: 20px; width: 40%;" class="text-center">Cantidad</th>
                    <th style="font-size: 20px; width: 40%;" class="text-center">Precio</th>
                    <th style="font-size: 20px; width: 40%;" class="text-center">Total</th>
                    <th width="5%">--</th>
                </tr>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['CARRO'] as $indice => $producto) { ?> 
                    <tr>
                        <td style="font-size: 15px; width: 40%;"><?php echo $producto['NOMBRE'] ?></td>
                        <td style="font-size: 15px; width: 40%;" class="text-center"><?php echo $producto['CANTIDAD'] ?></td>
                        <td style="font-size: 15px; width: 40%;" class="text-center"><?php echo $producto['PRECIO'] ?></td>
                        <td style="font-size: 15px; width: 40%;" class="text-center"><?php echo ($producto['PRECIO']); ?></td>
                        <td width="5%">
                            <form method="post" action="">
                                <input type="hidden" name="id" id="id" value="<?php echo $producto['ID']; ?>">
                                <button style="font-size: 13px;" class="btn btn-danger" type="submit" name="btnAccion" value="Eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php $total = $total + ($producto['PRECIO']); ?>
                <?php } ?>
                <tr>
                    <td colspan="3" text-align="right">
                        <h3>Total</h3>
                    </td>
                    <td text-align="right">
                        <h3>$<?php echo number_format($total, 3) ?></h3>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <form action="pagar.php" method="post" onsubmit="return validarCorreo()">
                            <div class="alert alert-success">
                                <div class="form-group">
                                    <label style="font-size: 15px;" for="email">Correo de contacto:</label>
                                    <input style="font-size: 15px;" id="email" name="email" class="form-control" type="email" placeholder="Por favor, escribe tu correo" required>
                                </div>
                            </div>
                            <button style="font-size: 15px;" class="btn btn-primary btn-lg btn-block" type="submit" value="proceder" name="btnAccion">Proceder a pagar >></button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    <?php } else { ?>
        <div style="font-size: 22px;" class="alert alert-success">
            No hay productos en el carrito...
        </div>
    <?php } ?>
</div>

<script>
function validarCorreo() {
    var emailIngresado = document.getElementById('email').value;
    var emailSesion = '<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>';
    if (emailIngresado !== emailSesion) {
        alert('¡El correo ingresado no coincide con el correo de la sesión! 😕');
        return false;
    }
    return true;
}
</script>
