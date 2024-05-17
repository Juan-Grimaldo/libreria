<?php
session_start();
if(!isset($_SESSION['admin_log']) || !$_SESSION['admin_log']){
    echo "<script>  window.alert('¡Ou, debes iniciar sesión primero!😴');
                    window.location.href = '../form.php';</script>";
}
?>