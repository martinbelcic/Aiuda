<?php
  $esta_en_login = true;
  require('conect.php');
  $msg_error = '';

  if(!empty($_SESSION)){
    header('location: inicio.php');
  } else {
    if(!empty($_POST)){
      $email = $_POST['email'];
      $contra = $_POST['contra'];
      
      $contra = md5($contra . 'misalt');
      echo $contra;
      $usuario = mysqli_query($db, "SELECT * FROM usuarios WHERE email = '$email' AND contrasena = '$contra';");
      
      if($usuario){
        $usuario_db = mysqli_fetch_assoc($usuario);
        if($usuario_db){
          $_SESSION['id_usuario'] = $usuario_db['id_usuario'];
          session_write_close();
          header("location: inicio.php");
        } else {
          $msg_error = 1;
        }
      }
    }
  }
    
?>

<!DOCTYPE html>
<!-- saved from url=(0051)https://getbootstrap.com/docs/4.0/examples/sign-in/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--
    <link rel="icon" href="https://getbootstrap.com/favicon.ico">
    -->
    <title>Aiuda</title>

    <!-- Bootstrap core CSS -->
    <link href="./ingreso_files/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./ingreso_files/signin.css" rel="stylesheet">
    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
  </head>

  <body>
    <form class="form-signin" method="POST">
      <div class="text-center">
        <img class="mb-4" src="img/logo.png" alt="" width="" height="">
        <h1 class="h3 mb-3 font-weight-normal">Por favor ingrese</h1>
      </div>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" name="contra" id="inputPassword" class="form-control" placeholder="Contraseña" required="">
      <div class="custom-control custom-checkbox mb-3">
        <input type="checkbox" class="custom-control-input" value="remember-me" id="remember-me"> 
        <label class="custom-control-label" for="remember-me">Recordarme</label>
      </div>
      <button class="btn btn-lg btn-block text-white" type="submit">Entrar</button>
      <?php
      if($msg_error == 1){?>
        <div class="alert alert-warning">
          Nombre se usuario o contraseña incorrectos.
        </div>
      <?php } ?>
      <p class="mt-5 mb-3 text-muted text-center">© 2017-2018</p>
    </form>
  </body>
</html>