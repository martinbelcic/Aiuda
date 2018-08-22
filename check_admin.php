<?php
    require('conect.php');
    
    $id = $_SESSION['id_usuario'];
    
    $query = mysqli_query($db, "SELECT * FROM usuarios WHERE id_usuario = '$id';");
    
    if($query){
        $usuario = mysqli_fetch_assoc($query);
        if($usuario['tipo'] != 2){
            header("location: inicio.php");
        }
    }
?>