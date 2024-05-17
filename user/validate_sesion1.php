<?php
session_start();
if(!isset($_SESSION['user_log']) || !$_SESSION['user_log']){
    echo "<script>  window.alert('¡Ou, debes iniciar sesión primero!😴');
                    window.location.href = './form.php';</script>";
}
?>