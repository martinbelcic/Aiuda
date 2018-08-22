<?php
    
    session_start();//inicializa la sesion
    
    if(!$esta_en_login && $_SESSION['id_usuario'] ==""){
        header("location: ingreso.php");
        die();
    }
    
    $db_host = 'localhost';
    $db_user = 'martin';
    $db_pas = 'admin';
    $db_db = 'aiuda';
    
    $db = mysqli_connect($db_host, $db_user, $db_pas, $db_db); //esta es mi db    
?>