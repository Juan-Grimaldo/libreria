<?php
include '../../conexion.php';

    $imagen=addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    $titulo=$_POST['titulo'];
    $autor=$_POST['autor'];
    $genero=$_POST['genero'];
    $sinopsis=$_POST['sinopsis'];
    $precio=$_POST['precio'];

    $query = "INSERT INTO libro (imagen, titulo, autor, genero, sinopsis, precio) VALUES ('$imagen','$titulo','$autor','$genero','$sinopsis','$precio')";
    $resultado = $conn->query($query);

    if($resultado){
        echo "<script>  window.alert('¡Registro AGREGADO correctamente!😁');
                    window.location.href = '../index_admin.php';</script>";
    } else {
        echo "<script>  window.alert('¡Ups, ha ocurrido un error!😕');
                    window.location.href = '../index_admin.php';</script>";
    }

?>