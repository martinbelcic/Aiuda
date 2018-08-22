<?php
  session_start();//inicializa la sesion
    
  $db_host = 'localhost';
  $db_user = 'martin';
  $db_pas = 'admin';
  $db_db = 'aiuda';
    
  $db = mysqli_connect($db_host, $db_user, $db_pas, $db_db); //esta es mi db
    
  
  $query = mysqli_query($db, "SELECT * FROM pedidos;");
  
  if($query){
    $listado = '';
    while($pedido = mysqli_fetch_assoc($query)){
      $tags = '';
      $id = $pedido['id_pedido'];
      $query_tags = mysqli_query($db, "SELECT * FROM tag_pedido WHERE id_pedido = '$id';");
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
      $listado .= '
        <div class="row tarjeta">
          <div class="col-md-7">
            <a href="#">
              <img class="img-fluid rounded mb-3 mb-md-0" src="http://placehold.it/700x300" alt="">
            </a>
          </div>
          <div class="col-md-5">
            <h3>'.$pedido['titulo'].'</h3>
            <p>'.$pedido['descripcion'].'</p>
            <div class="row m-1">'.$tags.'</div>
            <a class="btn btn-dark" href="pedido.php?id='.$pedido['id_pedido'].'">Ver Pedido</a>
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
        <h1 class="my-4">Pedidos</h1>
        <?=$listado;?>
    </section>
   
<?php
  if(!empty($_SESSION)){
        include('footer_user.php');
      } else {
        include('footer.php');
      }
?>