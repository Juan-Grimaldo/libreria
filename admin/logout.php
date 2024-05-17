<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['admin_log']);
echo "<script>  window.alert('Sesión finalizada, ¡Vuelve pronto!😴');
                window.location.href = '../index.php';</script>";
?>