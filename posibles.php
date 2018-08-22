<?php
  include('encabezado.php');
  
  $resultados = '';
  $id_user = $_SESSION['id_usuario'];
  $id_ofrecimiento = $_REQUEST['id'];
  
  $verifico = mysqli_query($db, "SELECT * FROM ofrecimientos WHERE id_ofrecimiento = '$id_ofrecimiento';");
  
  if($verifico){
    $ofer = mysqli_fetch_assoc($verifico);
    if($ofer['id_usuario'] != $id_user || $ofer['estado'] != 'nuevo'){
      header('location: inicio.php');
    } else {
      $query_posible = mysqli_query($db, "SELECT id_posible, posibles.id_pedido, descripcion, titulo, fecha, estado, busca FROM posibles INNER JOIN pedidos WHERE id_ofrecimiento = '$id_ofrecimiento' AND posibles.id_pedido = pedidos.id_pedido AND pedidos.estado <> 'Realizada';");
      $mostrado = array();
      for($i = 1; $i < 6; $i++){
        $mostrado[$i] = '';
      }
      $listado_posible = '';
      while($posible = mysqli_fetch_assoc($query_posible)){
        $indice = $posible['id_pedido'];
        if($mostrado[$indice] != 'check'){
          $mostrado[$indice] = 'check';
          $id_pedido = $posible['id_pedido'];
          $query_tags = mysqli_query($db, "SELECT * FROM tag_pedido WHERE id_pedido = '$id_pedido';");
          if($query_tags){
            $tags = '';
            while($busco_nombre = mysqli_fetch_assoc($query_tags)){
              $id_tag = $busco_nombre['id_tag'];
              $query_nombre = mysqli_query($db, "SELECT nombre FROM tags WHERE id_tag = '$id_tag';");
              if($query_nombre){
                  $tag = mysqli_fetch_assoc($query_nombre);
                  $nombre = $tag['nombre'];
                  $tags .= '
                      <span class="badge badge-secondary">'.$nombre.'</span>
                  ';
              }
            }
          }
          
          $listado_posible .= '
                                  <div class="col-lg-4 col-sm-6 portfolio-item">
                                    <div class="card h-100">
                                      <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                                      <div class="card-body">
                                        <h5>'.$posible['titulo'].'</h5>
                                        <p class="card-text">'.$posible['descripcion'].'</p>
                                        <p class="estado">'.ucfirst($posible['estado']).'</p>
                                        <div class="row p-2">'.$tags.'</div>
                                        <div class="text-center">
                                          <a class="btn btn-primary form-control" href="realizar.php?id='.$posible['id_posible'].'">Elegir</a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
          ';
          
        }
      }
    }
  }
?>
    
    <section class="bg-primary opciones">
       <!-- Page Content -->
      <div class="container">

        <!-- Page Heading -->
        <div class="col-8 text-center mx-auto">
          <h1 class="text-uppercase text-white">Selecciona tu donacion!</h1>
          <hr>
        </div>

        <div class="row">
          <?=$listado_posible; ?>

      </div>
      <!-- /.container -->
    </section>

<?php
  include('footer_user.php');
?>