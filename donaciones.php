<?php
  session_start();//inicializa la sesion
    
  $db_host = 'localhost';
  $db_user = 'martin';
  $db_pas = 'admin';
  $db_db = 'aiuda';
    
  $db = mysqli_connect($db_host, $db_user, $db_pas, $db_db); //esta es mi db
    
  
  $query = mysqli_query($db, "SELECT * FROM ofrecimientos;");
  
  if($query){
    $listado = '';
    while($ofrecimiento = mysqli_fetch_assoc($query)){
      $tags = '';
      $id = $ofrecimiento['id_ofrecimiento'];
      $query_tags = mysqli_query($db, "SELECT * FROM tag_ofrecimiento WHERE id_ofrecimiento = '$id';");
      if($query_tags){
        while($tag = mysqli_fetch_assoc($query_tags)){
          $id_tag = $tag['id_tag'];
          $query_nombre = mysqli_query($db, "SELECT nombre FROM tags WHERE id_tag = '$id_tag';");
          if($query_nombre){
            while($tag = mysqli_fetch_assoc($query_nombre)){
              $nombre = $tag['nombre'];
              $tags .= '
                  <span class="badge badge-secondary">'.$nombre.'</span>
              ';
            }
          }
        }
      }
      $path = "imagenes/ofrecimientos/".$id;
      if(!file_exists($path)){
        $path = "http://placehold.it/700x300";
      }
      $listado .= '
        <div class="row tarjeta">
          <div class="col-md-7">
            <a href="ofrecimiento.php?id='.$ofrecimiento['id_ofrecimiento'].'" class="img-container">
              <img class="img-fluid rounded mb-3 mb-md-0 img" src="'.$path.'" alt="">
            </a>
          </div>
          <div class="col-md-5">
            <h3>'.$ofrecimiento['titulo'].'</h3>
            <p>'.$ofrecimiento['descripcion'].'</p>
            <div class="row m-1">'.$tags.'</div>
            <a class="btn btn-dark" href="ofrecimiento.php?id='.$ofrecimiento['id_ofrecimiento'].'">Ver Donacion</a>
          </div>
        </div>
      '; 
    }
  }
  
    
  if(!empty($_SESSION)){
    include('encabezado.php');
  } else {
    include('encabezado2.php');
  }
?>
    
    <section class="bg-primary">
      <div class="container text-white">
          <!-- Page Heading -->
          <div class="container">
            <h1 class="my-4">Donaciones</h1>
          </div>
        <?=$listado;?>
    </section>
   
<?php
  if(!empty($_SESSION)){
        include('footer_user.php');
      } else {
        include('footer.php');
      }
?>