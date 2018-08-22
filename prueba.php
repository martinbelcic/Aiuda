<?php

    session_start();//inicializa la sesion
    
    define ('db_host', getenv('IP'));
    define ('db_user', getenv('C9_USER'));
    define ('db_pas', '');
    define ('db_db', 'c9');
    
    $db = mysqli_connect(db_host, db_user, db_pas, db_db); //esta es mi db
    
    if(!empty($_POST)){
        $email = $_POST['email'];
        $contra = md5($_POST['contrasena'] . 'misalt');
        
        $usuario = mysqli_query($db, "SELECT * FROM usuarios WHERE email='$email' AND contrasena='$contra';");
        
        if($usuario){
            $usuario_db = mysqli_fetch_assoc($usuario);
            $_SESSION['id_usuario'] = $usuario_db['id_usuario'];
            //header("location: inicio.php");
            echo 'funciona';
        } else {
            $msg_error = 1;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <?php
        if($msg_error == 1){ ?>
            <div class="alert alert-warning">
              Nombre se usuario o contraseña incorrectos.
            </div>
        <?php } ?>
        <input type="text" name="email"/><br>
        <input type="password" name="contrasena"><br>
        <input type="submit" value="Submit"/>
    </form>
</body>
</html>