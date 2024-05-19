<?php
include 'header.php';
include 'global/conexion.php';
include 'global/config.php';
include 'carro.php';

?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

</head>
<?php
if ($_POST) {

    $total = 0;
    $SID = session_id();
    $Correo = $_POST['email'];

    foreach ($_SESSION['CARRO'] as $indice => $producto) {
        $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']);
    }



    $sentencia = $conn->prepare("INSERT INTO `tblventas` (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
VALUES (NULL, :ClaveTransaccion, '', now(), :Correo, :Total, 'Pendiente');");

    $sentencia->bindParam(":ClaveTransaccion", $SID);
    $sentencia->bindParam(":Correo", $Correo);
    $sentencia->bindParam(":Total", $total);
    $sentencia->execute();
    $idVenta = $conn->lastInsertId();






    foreach ($_SESSION['CARRO'] as $indice => $producto) {
        $sentencia = $conn->prepare("INSERT INTO 
    `tbldetalleventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) 
    VALUES (NULL, :IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0')");

        $sentencia->bindParam(":IDVENTA", $idVenta);
        $sentencia->bindParam(":IDPRODUCTO", $producto['ID']);
        $sentencia->bindParam(":PRECIOUNITARIO", $producto['PRECIO']);
        $sentencia->bindParam(":CANTIDAD", $producto['CANTIDAD']);

        $sentencia->execute();
    }
    //echo "<h3>" . $total . "</h3>";
    //https://www.paypal.com/sdk/js?client-id=sb&commit=false
    //https://www.paypalobjects.com/api/checkout.js

}

?>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<style>
    @media screen and (max-width: 400px) {
        #paypal-button-container {
            width: 100%;
        }
    }

    @media screen and (min-width: 400px) {
        #paypal-button-container {
            width: 50%;
            display: inline-block;
        }
    }
</style>


<div class="jumbotron text-center">

    <h1 class="display-4">¡Pagar!</h1>
    <hr class="my-4">
    <p class="lead"> Estás apunto de pagar con PayPal la cantidad de:
    <h4>$<?php echo number_format($total, 3); ?></h4>
    <div id="paypal-button-container"></div>
    </p>
    <p>Los productos podrán ser descargados unas vez que se procese el pago<br /></p>
    <strong>(Para resolver dudas: 'jdevia05@gmail.com')</strong>
</div>



<script>
    paypal.Button.render({
        env: 'sandbox', // sandbox | production
        style: {
            label: 'checkout', // checkout | credit | pay | buynow | generic
            size: 'responsive', // small | medium | large | responsive
            shape: 'pill', // pill | rect
            color: 'gold' // gold | blue | silver | black
        },

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

        client: {
            sandbox: 'AZ_qg1GTeJ9dwdKDpXeW7Wrw305Ql6HQkRMrcoC6ZWzMxdQ4wXSYzBbNWJj5mZH8o2nDecsCqdjtvugW',
            production: ''
        },

        // Wait for the PayPal button to be clicked

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [{
                        amount: {
                            total: '<?php echo $total; ?>',
                            currency: 'USD'
                        },
                        description: "Compra de productos eBook:$<?php echo number_format($total); ?>",
                        custom: "<?php echo $SID; ?>#<?php echo ($idVenta); ?>"
                    }]
                }
            });
        },

        // Wait for the payment to be authorized by the customer

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {

                console.log(data);
                window.location = "verificador.php?paymentToken=" + data.paymentToken + "&paymentID=" + data.paymentID;
            });
        }

    }, '#paypal-button-container');
</script>