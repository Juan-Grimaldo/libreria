<?php
/*if (!isset($_SESSION['user_log']) || !$_SESSION['user_log']) {
    echo "<script>window.alert('¡Ou, debes iniciar sesión primero!😴');
          window.location.href = 'form.php';</script>";
    exit;
}*/
$mensaje = "";

if (isset($_POST['btnAccion'])) {
    switch ($_POST['btnAccion']) {

        case 'Agregar':

            if (is_numeric($_POST['id'])) {
                $ID = ($_POST['id']);
                $mensaje .= "id correcto " . $ID . "<br/>";
            } else {
                $mensaje .= "Upss... ID incorrecto";
                break;
            }

            if (is_string(($_POST['nombre']))) {
                $NOMBRE = ($_POST['nombre']);
                $mensaje .= "NOMBRE " . $NOMBRE . "<br/>";
            } else {
                $mensaje .= "Upss... algo pasa con el nombre";
                break;
            }

            if (is_numeric($_POST['cantidad'])) {
                $CANTIDAD = $_POST['cantidad'];
                $mensaje .= "CANTIDAD " . $CANTIDAD . "<br/>";
            } else {
                $mensaje .= "Upss... algo pasa con la cantidad";
                break;
            }

            if (is_numeric($_POST['precio'])) {
                $PRECIO = ($_POST['precio']);
                $mensaje .= "PRECIO " . $PRECIO . "<br/>";
            } else {
                $mensaje .= "Upss... algo pasa con el precio";
                break;
            }

            if (!isset($_SESSION['CARRO'])) {
                $producto = array(
                    'ID' => $ID,
                    'NOMBRE' => $NOMBRE,
                    'CANTIDAD' => $CANTIDAD,
                    'PRECIO' => $PRECIO
                );
                $_SESSION['CARRO'][0] = $producto;
                echo "<script>alert('¡Producto agregado al carrito de compra!😁');</script>";
            } else {
                $idProductos = array_column($_SESSION['CARRO'], "ID");
                if (in_array($ID, $idProductos)) {
                    echo "<script>alert('Este producto ya ha sido seleccionado');</script>";
                } else {
                    $NumeroProductos = count($_SESSION['CARRO']);
                    $producto = array(
                        'ID' => $ID,
                        'NOMBRE' => $NOMBRE,
                        'CANTIDAD' => $CANTIDAD,
                        'PRECIO' => $PRECIO
                    );
                    $_SESSION['CARRO'][$NumeroProductos] = $producto;
                    echo "<script>alert('¡Producto agregado al carrito de compra!😁');</script>";
                }
            }
            break;

        case "Eliminar":
            if (is_numeric(($_POST['id']))) {
                $ID = ($_POST['id']);
                foreach ($_SESSION['CARRO'] as $indice => $producto) {
                    if ($producto['ID'] == $ID) {
                        unset($_SESSION['CARRO'][$indice]);
                        echo "<script>alert('¡Producto eliminado!😉');</script>";
                    }
                }
            } else {
                $mensaje .= "Upss... ID incorrecto" . $ID;
            }
            break;
    }
}
?>