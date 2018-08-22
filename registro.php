<?php
    
    session_start();//inicializa la sesion
    
  $db_host = 'localhost';
  $db_user = 'martin';
  $db_pas = 'admin';
  $db_db = 'aiuda';
    
  $db = mysqli_connect($db_host, $db_user, $db_pas, $db_db); //esta es mi db
    
    if(!empty($_POST)){
      $tipo = 0;
      $nombre = $_REQUEST['nombre'];
      $apellido = $_REQUEST['apellido'];
      $email = $_REQUEST['email'];
      
      $result = mysqli_query($db, "SELECT * FROM usuarios WHERE email = '$email';");
      
      if($result){ // verifica email repetido
        $email_repetido = mysqli_fetch_assoc($result);
        if($email_repetido){ // mail repetido
          $email_repetido = 1;
        } else { // mail vlaido
          $contra1 = $_POST['contra'];
          $contra2 = $_POST['contra2'];
      
          if($contra1 == $contra2){ //contraseñas iguales
            $contra = md5 ($_REQUEST['contra'] . 'misalt');
            $result = mysqli_query($db, "SELECT * FROM usuarios WHERE contrasena = '$contra';");
            
            if($result){
              $contrasena_rep = mysqli_fetch_assoc($result);
              if($contrasena_rep){//contraseña repetida
                $contrasena_rep = 1;
              } else { // contraseña valida
                
                $result = mysqli_query($db, "INSERT INTO usuarios (nombre, apellido, email, contrasena, tipo) VALUES ('$nombre', '$apellido', '$email', '$contra', '$tipo');");
                
                if($result){//se registro el usuario
                  $result = mysqli_query($db, "SELECT * FROM usuarios WHERE email = '$email';");
                  $usuario_db = mysqli_fetch_assoc($result);
                  $_SESSION['id_usuario'] = $usuario_db['id_usuario'];
                  header("location: inicio.php");
                } else {//algo salio mal
                  //header("header: error_registro.php");
                  echo 'No se registro';
                }
              }
            }
          } else {//contraseñas distintas
            $distintas_claves = 1;
          }
        }
      }
    } else {
      $nombre = '';
      $apellido = '';
      $email = '';
      $email_repetido = '';
      $distintas_claves = '';
      $contrasena_rep = '';
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

	<title>Auida</title>

	 <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/creative.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css" type="text/css" />
    
</head>
<body id="page-top">
	<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-shrink" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.php">Aiuda</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#page-top">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">Ingresar</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="bg-primary" id="registro">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-8 mx-auto text-center">
		            <h2 class="section-heading text-white">Registrate!</h2>
           			<hr class="my-4">
		         </div>	
    		</div>
    		
      	<form class="form-horizontal" method="POST">
            <div class="form-group row">
              <label for="nombre" class="control-label col-4 text-white text-right">Nombre</label>
              <div class="col-6">
                <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre" required="" value="<?=$nombre?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="apellido" class="control-label col-4 text-white text-right">Apellido</label>
              <div class="col-6">
                <input type="text" class="form-control" id="apellido" placeholder="Apellido" name="apellido" required="" value="<?=$apellido?>">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="control-label col-4 text-white text-right">Email</label>
              <div class="col-6">
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" required="" value="<?=$email?>">
              </div>
            </div>
            <div class="row text-center">
              <div class="col-12">
                <?php if($email_repetido == 1){ ?>
                <p class="text-warning">El email elegido ya existe.</p>
                <?php } ?>
              </div>
            </div>
            <div class="form-group row">
              <label for="password" class="control-label col-4 text-white text-right">Contraseña</label>
              <div class="col-6">
                <input type="password" class="form-control" id="password" placeholder="Contraseña" name="contra" required="">
              </div>
            </div>
            <div class="form-group row">
            	<label for="password-2" class="control-label col-4 text-white text-right"> Repetir Contraseña</label>
            	<div class="col-6">
            		<input type="password" class="form-control"id="password-2" placeholder="Repetir Contraseña" name="contra2" required="">
            	</div>
            </div>
            <div class="row text-center">
              <div class="col-12">
                <?php 
              	if($distintas_claves == 1){	?>
                <p class="text-warning">Las contraseñas no coinciden</p>
                <?php } else {
                  if($contrasena_rep == 1) {?>
                <p class="text-warning">La contraseña ya existe</p>
                <?php } } ?>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-lg-8 mx-auto text-center">
                <button type="submit" class="btn btn-light btn-xl js-scroll-trigger">Registrarse</button>
              </div>
            </div>
          </form>
    	</div>
    </section>
    
   
<?php
  include('footer.php');
?>