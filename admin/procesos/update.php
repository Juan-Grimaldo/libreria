<?php
$conn = new mysqli("localhost", "root", "", "libreria");
$id_libro = $_REQUEST['id_libro'];

$imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$genero = $_POST['genero'];
$sinopsis = $_POST['sinopsis'];
$precio = $_POST['precio'];

$query = "UPDATE libro SET imagen='$imagen', titulo='$titulo', autor='$autor', genero='$genero', sinopsis='$sinopsis', precio='$precio' WHERE id_libro = '$id_libro'";
$resultado = $conn->query($query);

if($resultado){
    echo "<script>  window.alert('¡Registro ACTUALIZADO correctamente!😁');
                window.location.href = '../index_admin.php';</script>";
} else {
    echo "<script>  window.alert('¡Ups, ha ocurrido un error!😕');
                window.location.href = '../index_admin.php';</script>";
}