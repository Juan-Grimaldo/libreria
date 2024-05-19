<?php

include '../../conexion.php';
$id = $_REQUEST['ID'];

$query = "UPDATE tbldetalleventa SET ESTADO = 'Entregado' WHERE ID='$id'";
$resultado = $conn->query($query);

if($resultado){
    echo "<script>  window.alert('¡Estado ACTUALIZADO correctamente!😁');
                window.location.href = '../order.php';</script>";
} else {
    echo "<script>  window.alert('¡Ups, ha ocurrido un error!😕');
                window.location.href = '../order.php';</script>";
}


?>