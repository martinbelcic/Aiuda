<?php
      
    session_start();//inicializa la sesion
        
    $db_host = 'localhost';
    $db_user = 'martin';
    $db_pas = 'admin';
    $db_db = 'aiuda';
    
    $db = mysqli_connect($db_host, $db_user, $db_pas, $db_db); //esta es mi db

      if(!empty($_SESSION)){
        include('encabezado.php');
      } else {
        include('encabezado2.php');
      }
    
    $id_ofrecimiento = $_REQUEST['id'];
    
    $query = mysqli_query($db, "SELECT * FROM ofrecimientos WHERE id_ofrecimiento = '$id_ofrecimiento';");
    $ofrecimiento = '';
    if($query){
        //armo el pedido para mostrar
        $item = mysqli_fetch_assoc($query);
        $query_tag = mysqli_query($db, "SELECT * FROM tag_ofrecimiento WHERE id_ofrecimiento = '$id_ofrecimiento';");
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
        $ofrecimiento .= '
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
            $email = $usuario['email'];
            $telefono = $usuario['telefono'];
            $item_usuario = '
                <h1 class="my-4 text-white">'.$nombre.'</h1>
                    <div class="list-group">
                    <a class="list-group-item">'.$email.'</a>
                </div>
            ';
        }
        //armo comentario
        $query_com = mysqli_query($db, "SELECT * FROM comentario_ofrecimiento WHERE id_ofrecimiento = '$id_ofrecimiento';");
        $comentarios = '';
        
        if($query_com){
            while($coment = mysqli_fetch_assoc($query_com)){
                $id_user_com = $coment['id_usuario'];
                $query_com_user = mysqli_query($db, "SELECT * FROM usuarios WHERE id_usuario = '$id_user_com';");
                if($query_com_user){
                    $usuario_com = mysqli_fetch_assoc($query_com_user);
                    switch($usuario_com['tipo']){
                        case 0: $nombre = ucfirst($usuario_com['nombre']).' '.ucfirst($usuario_com['apellido']);
                        break;
                        case 1: $nombre = ucfirst($usuario_com['nombreong']);
                        break;
                        case 2: $nombre =  ucfirst($usuario_com['nombre']).' '.ucfirst($usuario_com['apellido']);
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
?>
    <section class="bg-primary">
        
        <div class="container">
    
          <div class="row">
    
            <div class="col-lg-3">
              <?=$item_usuario; ?>
            </div>
            <!-- /.col-lg-3 -->
    
            <div class="col-lg-9">
    
              <?=$ofrecimiento; ?>
              <!-- /.card -->
    
              <div class="card card-outline-secondary my-4">
                <div class="card-header">
                  Comentarios
                </div>
                <div class="card-body">
                  <?=$comentarios; ?>
                  <a href="comentar.php?id=<?=$id_ofrecimiento;?>&tipo=0" class="btn btn-success">Dejar un Comentario</a>
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