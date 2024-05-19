<?php
include '../../conexion.php';
$id_libro = $_REQUEST['id_libro'];

$query = "DELETE FROM libro WHERE id_libro='$id_libro'";
$resultado = $conn->query($query);

if($resultado){
    echo "<script>  window.alert('¡Registro ELIMINADO correctamente!😁');
                window.location.href = '../index_admin.php';</script>";
} else {
    echo "<script>  window.alert('¡Ups, ha ocurrido un error!😕');
                window.location.href = '../index_admin.php';</script>";
}
