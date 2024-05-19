<?php

include 'global/config.php';
include 'global/conexion.php';
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

$Login = curl_init(LINKAPI."/v1/oauth2/token");

curl_setopt($Login, CURLOPT_RETURNTRANSFER, true);

curl_setopt($Login, CURLOPT_USERPWD, CLIENTID . ":" . SECRET);

curl_setopt($Login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$Respuesta = curl_exec($Login);

$objRespuesta = json_decode($Respuesta);

$AccessToken = $objRespuesta->access_token;


$venta = curl_init(LINKAPI."/v1/payments/payment/" . $_GET['paymentID']);


curl_setopt($venta, CURLOPT_HTTPHEADER, array("Content-Type: aplication/json", "Authorization: Bearer " . $AccessToken));

curl_setopt($venta, CURLOPT_RETURNTRANSFER, true);

$RespuestaVenta = curl_exec($venta);


$objDatosTransaccion = json_decode($RespuestaVenta);

$state = $objDatosTransaccion->state;

$email = $objDatosTransaccion->payer->payer_info->email;
$total = $objDatosTransaccion->transactions[0]->amount->total;
$currency = $objDatosTransaccion->transactions[0]->amount->currency;
$custom = $objDatosTransaccion->transactions[0]->custom;


$clave = explode("#", $custom);

$SID = $clave[0];
$claveVenta = ($clave[1]);

curl_close($venta);
curl_close($Login);


if ($state == "approved") {
    $mensajePaypal = "<h3>Pago aprobado</h3>";

    $sentencia = $conn->prepare("UPDATE `tblventas` 
    SET `PaypalDatos` =:PaypalDatos,
    `status` = 'aprobado' 
    WHERE `tblventas`.`ID` = :ID;");

    $sentencia->bindParam(":ID", $claveVenta);
    $sentencia->bindParam(":PaypalDatos", $RespuestaVenta);
    $sentencia->execute();

    $sentencia = $conn->prepare("UPDATE tblventas SET status='completo'
    where ClaveTransaccion=:ClaveTransaccion
    and Total=:TOTAL
    and ID=:ID");

    $sentencia->bindParam(':ClaveTransaccion', $SID);
    $sentencia->bindParam(':TOTAL', $total);
    $sentencia->bindParam(':ID', $claveVenta);
    $sentencia->execute();

    $completado = $sentencia->rowCount();

//    session_destroy();
} else {
    $mensajePaypal = "<h3>Pago rechazado</h3>";
}



?>

<div class="jumbotron">

    <h1 class="display-4">¡Listo!</h1>

    <hr class="my-4">

    <p class="lead"><?php echo $mensajePaypal; ?></p>

    <p>

        <?php

        if ($completado >= 1) {


            $sentencia = $conn->prepare("SELECT * FROM tbldetalleventa,libro
                WHERE tbldetalleventa.IDPRODUCTO=libro.id_libro 
                AND tbldetalleventa.IDVENTA=:ID");

            $sentencia->bindParam(':ID', $claveVenta);
            $sentencia->execute();

            $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

            //print_r($listaProductos);
        }

        ?>
        <div class="row">
            <?php foreach($listaProductos as $producto){?>
            <div class="col-2">
                <div class="card">
                    
                    <img class="card-img-top" src="data:image/jpg;base64,<?php echo base64_encode($producto['imagen']); ?>" alt="">
                    
                    <div class="card-body">
                    <p class="card-text"><?php echo $producto['titulo'];?></p>
                    
           
                        
                    <input type="hidden" name="IDVENTA" id="" value="<?php echo ($claveVenta);?>">
                    <input type="hidden" name="IDPRODUCTO" id="" value="<?php echo ($producto['IDPRODUCTO']);?>">

                     

                    </form>
                  
                   
                   
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </p>

</div>