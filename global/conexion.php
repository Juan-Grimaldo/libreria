    
<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "libreria"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Configurar el modo de error para lanzar excepciones
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

    //echo "<script>alert('Conectado...')</script>";

} catch (PDOException $e) {

     //echo "<script>alert('Error...')</script>";
     
}
