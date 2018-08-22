<?php
    session_start();//inicializa la sesion
        
    $db_host = 'localhost';
    $db_user = 'martin';
    $db_pas = 'admin';
    $db_db = 'aiuda';
    
    $db = mysqli_connect($db_host, $db_user, $db_pas, $db_db); //esta es mi db
    
    $id_pedido = $_REQUEST['id'];
    
    $query = mysqli_query($db, "SELECT * FROM pedidos WHERE id_pedido = '$id_pedido';");
    $pedido = '';
    if($query){
        //armo el pedido para mostrar
        $item = mysqli_fetch_assoc($query);
        $query_tag = mysqli_query($db, "SELECT * FROM tag_pedido WHERE id_pedido = '$id_pedido';");
        if($query_tag){
            while($tags = mysqli_fetch_assoc($query_tag)){
                $id_tag = $tags['id_tag'];
                $query_tag2 = mysqli_query($db, "SELECT nombre FROM tags WHERE id_tag = '$id_tag';");
                if($query_tag2){
                    $item_tag = '';
                    while($nombre = mysqli_fetch_assoc($query_tag2)){
                        $item_tag .= ' <span class="badge badge-secondary">'.$nombre['nombre'].'</span>';   
                    }
                }
            }
        }
        $pedido .= '
            <div class="card mt-4">
                <img class="card-img-top img-fluid" src="http://placehold.it/900x400" alt="">
                <div class="card-body">
                  <h3 class="card-title">'.$item['titulo'].'</h3>
                  <p class="card-text">'.$item['descripcion'].'</p>
                  <div class="row m-1">'.$item_tag.'</div>
                </div>
            </div>
        '; 
        //pedido armado
        //armo display de usario del pedido
        $id_usuario = $item['id_usuario'];
        $query_user = mysqli_query($db, "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario';");
        
        if($query_user){
            $usuario = mysqli_fetch_assoc($query_user);
            $nombre = ucfirst($usuario['nombre']).' '.ucfirst($usuario['apellido']);
            $telefono = $usuario['telefono'];
            $direccion = ucfirst($usuario['direccion_calle']).' '.$usuario['direccion_numero'];
            $item_usuario = '
                <h1 class="my-4 text-white">'.$usuario['nombreong'].'</h1>
                    <div class="list-group">
                        <a class="list-group-item">'.$nombre.'</a>
                        <a class="list-group-item">'.$direccion.'</a>
                    </div>
            ';
        }
        //armo comentario
        $query_ped = mysqli_query($db, "SELECT * FROM comentario_pedido WHERE id_pedido = '$id_pedido';");
        $comentarios = '';
        
        if($query_ped){
            while($coment = mysqli_fetch_assoc($query_ped)){
                $id_user_ped = $coment['id_usuario'];
                $query_ped_user = mysqli_query($db, "SELECT * FROM usuarios WHERE id_usuario = '$id_user_ped';");
                if($query_ped_user){
                    $usuario_ped = mysqli_fetch_assoc($query_ped_user);
                    switch($usuario_ped['tipo']){
                        case 0: $nombre = ucfirst($usuario_ped['nombre']).' '.ucfirst($usuario_ped['apellido']);
                        break;
                        case 1: $nombre = ucfirst($usuario_ped['nombreong']);
                        break;
                        case 2: $nombre =  ucfirst($usuario_ped['nombre']).' '.ucfirst($usuario_ped['apellido']);
                        break;
                    }
                    $comentarios .= '
                        <div class="m-1">
                            <p>'.$coment['comentario'].'</p>
                            <small class="text-muted">'.$nombre.' el '.$coment['fecha'].'</small>
                            <hr class="text-dark">
                        </div>
                    ';
                }
            }
        }
    }
    
      
    if(!empty($_SESSION)){
       include('encabezado.php');
    } else {
        include('encabezado2.php');
    }
?>
    <section class="bg-primary">
        
        <div class="container">
    
          <div class="row">
    
            <div class="col-lg-3">
              <?=$item_usuario; ?>
            </div>
            <!-- /.col-lg-3 -->
    
            <div class="col-lg-9">
    
              <?=$pedido; ?>
              <!-- /.card -->
    
              <div class="card card-outline-secondary my-4">
                <div class="card-header">
                  Comentarios
                </div>
                <div class="card-body">
                    <?=$comentarios; ?>
                  
                  <a href="comentar.php?id=<?=$id_pedido;?>&tipo=1" class="btn btn-success">Dejar un Comentario</a>
                </div>
              </div>
              <!-- /.card -->
    
            </div>
            <!-- /.col-lg-9 -->
    
          </div>
    
        </div>
       
    </section>
<?php
    if(!empty($_SESSION)){
        include('footer_user.php');
      } else {
        include('footer.php');
      }
?>