<?php

include 'global/config.php';
include 'global/conexion.php';
include 'carro.php';

session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="stylesheet" href="https://unpkg.com/maplibre-gl/dist/maplibre-gl.css">
    <link rel="stylesheet" href="https://unpkg.com/@maplibre/maplibre-gl-directions/dist/maplibre-gl-directions.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        #map {
            height: 600px;
            /* Define una altura para el contenedor del mapa */
            width: 100%;
            /* Asegúrate de que el mapa ocupe el 100% del ancho del contenedor */
        }
        .smaller-img {
            max-width: 100%;
            height: auto;
        }
        .pago{
            font-size: 30px;
            margin-top: 20px;
            font-weight: 600;
        }
        @media (min-width: 992px) {
            .col-lg-3 {
                -ms-flex: 0 0 25%;
                flex: 0 0 25%;
                max-width: 20%;
                margin-top: 10px;
            }
            .pago{
                font-size: 40px;
                margin-top: 20px;
                font-weight: 600;
            }
            body{
                font-size: 1.5rem;
            }
        }
        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
            position: relative;
            width: 40%;
            padding-right: 15px;
            padding-left: 15px;
            margin-top: 10px;
            flex: 0 0 50%;
        }
        .flex-volver{
            display: flex;
            align-items: center;
            p{
                font-size: 3rem;
                margin-bottom: 0;
                text-decoration: none;
                color: black;
                font-weight: 400;
            }
            a{
                text-decoration: none;
            }
        }
    </style>
</head>

<body>
    <?php

    $Login = curl_init(LINKAPI . "/v1/oauth2/token");

    curl_setopt($Login, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($Login, CURLOPT_USERPWD, CLIENTID . ":" . SECRET);
    curl_setopt($Login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

    $Respuesta = curl_exec($Login);

    $objRespuesta = json_decode($Respuesta);

    $AccessToken = $objRespuesta->access_token;

    $venta = curl_init(LINKAPI . "/v1/payments/payment/" . $_GET['paymentID']);

    curl_setopt($venta, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $AccessToken));
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

        // Vaciar el carrito
        unset($_SESSION['CARRO']);
    } else {
        $mensajePaypal = "<h3>Pago rechazado</h3>";
    }

    ?>
    
    <div class="jumbotron">
        <div class="flex-volver">
            <a class="flex-volver" href="index.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevrons-left" width="100" height="100" viewBox="0 0 24 24" stroke-width="1" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M11 7l-5 5l5 5" />
                <path d="M17 7l-5 5l5 5" />
            </svg>
            <p>Volver a la página</p>
            </a>
            
        </div>
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

                $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            }
            ?>
        </p>
        <div class="row">
            <?php if (isset($listaProductos)) {
                foreach ($listaProductos as $producto) { ?>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card">
                            <img class="card-img-top img-fluid smaller-img" src="<?php echo $producto['imagen_url']; ?>" alt="">
                            <div class="card-body">
                                <p class="card-text"><?php echo $producto['titulo']; ?></p>
                                <input type="hidden" name="IDVENTA" value="<?php echo $claveVenta; ?>">
                                <input type="hidden" name="IDPRODUCTO" value="<?php echo $producto['IDPRODUCTO']; ?>">

                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
        <p class="pago">Total pagado: <?php echo $total .'0 COP'; ?></p>
    </div>
    <div id="map"></div>
    <script src="https://unpkg.com/maplibre-gl/dist/maplibre-gl.js"></script>
    <script src="https://unpkg.com/@maplibre/maplibre-gl-directions/dist/maplibre-gl-directions.min.js"></script>

    <script>
        function initializeMap(center) {
            const map = new maplibregl.Map({
                container: 'map',
                style: 'https://api.maptiler.com/maps/streets/style.json?key=gMYTCpWgkK3hJ1ZKbYdi', // Replace with your MapTiler API key
                center: center,
                zoom: 10
            });

            // Add navigation control (the +/- zoom buttons)
            map.addControl(new maplibregl.NavigationControl(), 'top-right');

            // Add marker for user's location
            new maplibregl.Marker({ color: 'blue' })
                .setLngLat(center)
                .setPopup(new maplibregl.Popup().setHTML("<h3>Tu locación</h3>"))
                .addTo(map);

            // Other locations
            const locations = [
                { coords: [-74.2070772, 4.5886655], name: "Locación 1" },
                { coords: [-74.1756294, 4.6154622], name: "Locación 2" },
                { coords: [-74.1936542, 4.6155101], name: "Locación 3" }
            ];

            locations.forEach(location => {
                new maplibregl.Marker()
                    .setLngLat(location.coords)
                    .setPopup(new maplibregl.Popup().setHTML(`<h3>${location.name}</h3>`))
                    .addTo(map);
            });

            // Add directions
            const directions = new MapLibreDirections({
                accessToken: 'no-token-needed', // MapLibre doesn't require a token for local or custom setups
                unit: 'metric',
                profile: 'mapbox/driving'
            });
            map.addControl(directions, 'top-left');

            // Directions setup
            directions.setOrigin(center);

            locations.forEach(location => {
                directions.addWaypoint(0, {
                    coordinates: center
                });
                directions.addWaypoint(1, {
                    coordinates: location.coords
                });
            });
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const userCoords = [position.coords.longitude, position.coords.latitude];
                initializeMap(userCoords);
            }, error => {
                console.error("Error getting location: ", error);
                // Fallback center if location not available
                initializeMap([4.5764832, -74.2266906]);
            });
        } else {
            console.error("Geolocation is not supported by this browser.");
            // Fallback center if geolocation not supported
            initializeMap([4.5764832, -74.2266906]);
        }
    </script>
</body>
<?php include 'footer.php' ?>

</html>