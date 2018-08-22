<?php
    $esta_en_login = false;
    require ('conect.php');
    
    $id = $_SESSION['id_usuario'];
    $usuario = mysqli_query($db, "SELECT * FROM usuarios WHERE id_usuario = '$id';");
    
    if($usuario){
        $user_db = mysqli_fetch_assoc($usuario);
        
        switch($user_db['tipo']){
          case 0:{ $nombre = ucfirst($user_db['nombre']).' '.ucfirst($user_db['apellido']);
                    $accion = 'Donar';
                    $link = 'donar.php';
                    $vista = 'Donaciones';
                    $opciones = '';
                    
                    $query = mysqli_query($db, "SELECT * FROM ofrecimientos WHERE id_usuario = '$id';");
                    if($query){//busco ofrecimietno
                      while($ofrecimiento = mysqli_fetch_assoc($query)){
                        $id_ofrecimiento = $ofrecimiento['id_ofrecimiento'];
                        $query2 = mysqli_query($db, "SELECT * FROM tag_ofrecimiento WHERE id_ofrecimiento = '$id_ofrecimiento';");
                        if($query2){//busco los tags del ofrecimiento
                          while($tag_id = mysqli_fetch_assoc($query2)){
                            $id_tag = $tag_id['id_tag'];
                            $query3 = mysqli_query($db, "SELECT nombre FROM tags WHERE id_tag = '$id_tag';");
                            if($query3){//busco nombres de los tags
                              
                            }
                          }
                          $opciones .= '
                                  <div class="col-lg-4 col-sm-6 portfolio-item">
                                    <div class="card h-100">
                                      <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                                      <div class="card-body">
                                        <h5>'.$ofrecimiento['titulo'].'</h5>
                                        <p class="card-text">'.$ofrecimiento['descripcion'].'</p>
                                        <p class="estado">'.$ofrecimiento['estado'].'</p>
                                        <div class="text-center">
                                          <a class="btn btn-primary form-control" href="editar.php?id='.$ofrecimiento['id_ofrecimiento'].'&tipo='.$user_db['tipo'].'">Editar</a>
                                          <a class="btn btn-danger form-control mt-1" href="eliminar.php?id='.$ofrecimiento['id_ofrecimiento'].'&tipo='.$user_db['tipo'].'">Eliminar</a>
                                          <a class="btn btn-info form-control mt-1" href="posibles.php?id='.$ofrecimiento['id_ofrecimiento'].'">Posibles</a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                          ';
                        }
                      }
                    }
          }
            break;
          case 1:{ $nombre = $user_db['nombreong'];
                    $accion = 'Solicitar';
                    $link = 'solicitar.php';
                    $vista = 'Solicitudes';
                    $opciones = '';
                    
                    $query = mysqli_query($db, "SELECT * FROM pedidos WHERE id_usuario = '$id';");
                    if($query){//busco ofrecimietno
                      while($pedido = mysqli_fetch_assoc($query)){
                        $id_pedido = $pedido['id_pedido'];
                        $query2 = mysqli_query($db, "SELECT * FROM tag_pedido WHERE id_pedido = '$id_pedido';");
                        if($query2){//busco los tags del ofrecimiento
                          while($tag_id = mysqli_fetch_assoc($query2)){
                            $id_tag = $tag_id['id_tag'];
                            $query3 = mysqli_query($db, "SELECT nombre FROM tags WHERE id_tag = '$id_tag';");
                            if($query3){//busco nombres de los tags
                              
                            }
                          }
                          $opciones .= '
                                  <div class="col-lg-4 col-sm-6 portfolio-item">
                                    <div class="card h-100">
                                      <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                                      <div class="card-body">
                                        <h5>'.$pedido['titulo'].'</h5>
                                        <p class="card-text">'.$pedido['descripcion'].'</p>
                                        <p class="estado">'.$pedido['estado'].'</p>
                                        <div class="text-center">
                                          <a class="btn btn-primary form-control" href="editar.php?id='.$pedido['id_pedido'].'&tipo='.$user_db['tipo'].'">Editar</a>
                                          <a class="btn btn-danger form-control mt-1" href="eliminar.php?id='.$pedido['id_pedido'].'&tipo='.$user_db['tipo'].'">Eliminar</a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                          ';
                        }
                      }
                    }
          }
            break;
          case 2:{ $nombre = ucfirst($user_db['nombre']). ' '.ucfirst($user_db['apellido']);
                    $accion = 'Gestionar usuarios';
                    $link = 'usuarios_listado.php';
                    $vista = 'Gestionar';
                    $opciones = '
                    <div class="col-lg-4 col-md-12 text-center">
                      <div class="service-box mt-5 mx-auto">
                        <a href="usuarios_listado.php" class="link-admin"> 
                          <i class="fa fa-4x fa-users mb-3 sr-icons"></i>
                          <h3 class="mb-3">Usuarios</h3>
                          <p class="mb-0">Agregar, Eliminar, Editar.</p>
                        </a>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-12 text-center">
                      <div class="service-box mt-5 mx-auto">
                        <a href="ofrecimientos_listado.php" class="link-admin">
                          <i class="fa fa-4x fa-plus-square mb-3 sr-icons"></i>
                          <h3 class="mb-3">Ofrecimientos</h3>
                          <p class="mb-0">Eliminar, Editar.</p>
                        </a>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-12 text-center">
                      <div class="service-box mt-5 mx-auto">
                        <a href="pedidos_listado.php" class="link-admin">
                          <i class="fa fa-4x fa-address-card mb-3 sr-icons"></i>
                          <h3 class="mb-3">Pedidos</h3>
                          <p class="mb-0">Eliminar, Editar.</p>
                        </a>
                      </div>
                    </div>
                    ';
          }
            break;
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

	<title>Aiuda</title>

	 <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    
    <link  rel="stylesheet" type="text/css" href="css/estilos.css">
    
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap-tagsinput.css">

</head>
<body id="page-top">
	<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <img src="img/logo-mano.png" height="50" width="60" href=""></img>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="inicio.php">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="perfil.php"><i class="fa fa-1x fa-user-circle text-white mb-3 sr-icons"></i><?=$nombre; ?></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Opciones
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="<?=$link; ?>"><?=$accion;?></a>
              <a class="dropdown-item" href="usuarios_editar.php?id=<?=$id;?>">Actualizar informacion</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="cerrar_sesion.php">Cerrar Sesion</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>