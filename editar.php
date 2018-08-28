<?php
    include('encabezado.php');
    require('funciones_img.php');

      $tipo = $_REQUEST['tipo'];
      $id_esto = $_REQUEST['id']; 
      switch($tipo){
          case 0:{
              $string = "SELECT * FROM ofrecimientos WHERE id_ofrecimiento = '$id_esto';";
              $string2 = "SELECT * FROM tag_ofrecimiento WHERE id_ofrecimiento = '$id_esto';"; 
              $carpeta = "ofrecimientos";
          }break;
          case 1:{
              $string = "SELECT * FROM pedidos WHERE id_pedido = '$id_esto';";
              $string2 = "SELECT * FROM tag_pedido WHERE id_pedido = '$id_esto';"; 
              $carpeta = "pedidos";
          }break;
      }
    
      $query = mysqli_query($db, $string);
      
      if($query){
          $cosa = mysqli_fetch_assoc($query);
          
          if($cosa['envio'] == 'si'){
              $si = 'checked';
              $no = '';
          } else {
              $si = '';
              $no = 'checked';
          }
          
          $query2 = mysqli_query($db, $string2);
          if($query2){
              $checked = array(); 
              for($i = 1; $i < 6; $i++){
                $checked[$i]  = '';
              }
              while($tag = mysqli_fetch_assoc($query2)){
                  $checked[$tag['id_tag']] = 'checked';
              }
          }
          
          $query3 = mysqli_query($db, "SELECT * FROM tags;");
          $check = '';
          if($query3){
              $i = 1;
              while($tag = mysqli_fetch_assoc($query3)){
                  $check .= '
                      <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheck'.$tag['id_tag'].'" value="'.$tag['id_tag'].'" name="tag[]" '.$checked[$i].'>
                          <label class="custom-control-label" for="customCheck'.$tag['id_tag'].'">'.$tag['nombre'].'</label>
                      </div>
                  ';
                  $i++;
              }
          }
      }
    
    if(!empty($_POST)){
      $id = $_POST['id'];
      $des = $_POST['descripcion'];
      if(isset($_POST['tag']))
        $tags = $_POST['tag'];
      $envio = $_POST['envio'];
      $titulo = $_POST['titulo'];
      
      switch($tipo){
        case 0:{
              $elimino = "DELETE FROM tag_ofrecimiento WHERE id_ofrecimiento = '$id_esto';";
              $string4 = "UPDATE ofrecimientos SET descripcion = '$des', envio = '$envio', titulo = '$titulo' WHERE id_ofrecimiento = '$id_esto';";
              $elimino_posible = "DELETE FROM posibles WHERE id_ofrecimiento = '$id_esto';";
              $busco_posible = "SELECT id_pedido FROM tag_ofrecimiento INNER JOIN tag_pedido WHERE id_ofrecimiento = '$id_esto' AND tag_ofrecimiento.id_tag = tag_pedido.id_tag;";
        }break;
        case 1:{
              $elimino = "DELETE FROM tag_pedido WHERE id_pedido = '$id_esto';";
              $string4 = "UPDATE pedidos SET descripcion = '$des', busca = '$envio', titulo = '$titulo' WHERE id_pedido = '$id_esto';";
              $elimino_posible = "DELETE FROM posibles WHERE id_pedido = '$id_esto';";
              $busco_posible = "SELECT id_ofrecimiento FROM tag_ofrecimiento INNER JOIN tag_pedido WHERE id_pedido = '$id_esto' AND tag_ofrecimiento.id_tag = tag_pedido.id_tag;";
        }break;
      }
      
      
      $elim = mysqli_query($db, $elimino);
      
      $query4 = mysqli_query($db, $string4);

      if (is_uploaded_file($_FILES['archivos']['tmp_name']))
            subirImagen($id, $carpeta);

      if($query4 and isset($_POST['tag'])){
        foreach($tags as $id_tag){
          switch($tipo){
            case 0: $string5 = "INSERT INTO tag_ofrecimiento (id_tag, id_ofrecimiento) VALUES ('$id_tag', '$id_esto');";
            break;
            case 1: $string5 = "INSERT INTO tag_pedido (id_tag, id_pedido) VALUES ('$id_tag', '$id_esto');";
            break;
          }
          $query5 = mysqli_query($db, $string5);
        }
      }
      
      //actualizo posibles
      $elim_posible = mysqli_query($db, $elimino_posible);
      //busco
      $query_busco = mysqli_query($db, $busco_posible);
      if($query_busco){
        while($posible = mysqli_fetch_assoc($query_busco)){
          if($tipo == 0){
            $id_pedido = $posible['id_pedido'];
            $guardo_posible = mysqli_query($db, "INSERT INTO posibles (id_pedido, id_ofrecimiento) VALUES ('$id_pedido', '$id_esto');");
          } else {
            $id_ofrecimiento = $posible['id_ofrecimiento'];
            $guardo_posible = mysqli_query($db, "INSERT INTO posibles (id_pedido, id_ofrecimiento) VALUES ('$id_esto', '$id_ofrecimiento');");
          }
        }
      }
      
      $actualizado = 'si';
    } else {
      $actualizado = '';
      /*
      $query = mysqli_query($db, $string);
      
      if($query){
          $cosa = mysqli_fetch_assoc($query);
          
          if($cosa['envio'] == 'si'){
              $si = 'checked';
              $no = '';
          } else {
              $si = '';
              $no = 'checked';
          }
          
          $query2 = mysqli_query($db, $string2);
          if($query2){
              $checked = array(); 
              for($i = 1; $i < 5; $i++){
                $checked[$i]  = '';
              }
              while($tag = mysqli_fetch_assoc($query2)){
                  $checked[$tag['id_tag']] = 'checked';
              }
          }
          
          $query3 = mysqli_query($db, "SELECT * FROM tags;");
          $check = '';
          if($query3){
              $i = 1;
              while($tag = mysqli_fetch_assoc($query3)){
                  $check .= '
                      <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheck'.$tag['id_tag'].'" value="'.$tag['id_tag'].'" name="tag[]" '.$checked[$i].'>
                          <label class="custom-control-label" for="customCheck'.$tag['id_tag'].'">'.$tag['nombre'].'</label>
                      </div>
                  ';
                  $i++;
              }
          }
      }
      */
    }
?>
    <section class="bg-primary">
      <?php
        if($actualizado == 'si'){
      ?>
      <div class="container mt-1">
        <div class="col-12 text-center text-white">
          <p>El registro se actualizo correctamiente.</p>
           <a href="inicio.php" class="btn btn-secondary">Continuar</a>
        </div>
      </div>
      <?php 
        } else {
      ?>
      <div class="container">
        <form method="POST" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group row text-white">
                <input type="hidden" name="id" value="<?=$id_esto; ?>">
              <div class="col-10 mx-auto">
                <div class="row container">
                    <div class="col-3 text-right">
                      <label for="titulo">Titulo</label>
                    </div>
                    <div class="col-8">
                      <input type="text" name="titulo" class="form-control" value="<?=$cosa['titulo']; ?>"/>
                    </div>
                </div>
                <div class="row container mt-2">
                  <div class="col-3 text-right">
                    <label for="comment">Descripcion</label>
                  </div>
                  <div class="col-8">
                    <textarea class="form-control" rows="5" id="comment" name="descripcion"><?=$cosa['descripcion']; ?></textarea>
                  </div>  
                </div>
                
                <div class="row container">
                  <div class="col-3 mr-1 text-right">
                    <label>Tipo</label>
                  </div>
                  <div class="col-8">
                    <?=$check; ?>
                  </div>
                </div>
                <div class="row container">
                  <div class="col-12">
                    <div class="row">
                      <label class="control-label col-3 text-white text-right">Zona de residencia</label>
                      <div class="col-8">
                        <select class="form-control">
                          
                        </select>
                      </div>
                    </div>                    
                  </div>
                </div>
                <div class="row container">
                  <div class="col-12">
                    <div class="row">
                      <label class="control-label col-3 text-white text-right mt-2">¿Realiza envio?</label>
                      <div class="col-9 container">
                        <div class="custom-control custom-radio">
                          <input type="radio" name="envio" id="si" class="custom-control-input" value="si" <?=$si; ?>>
                          <label for="si" class="custom-control-label">Si</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input type="radio" name="envio" id="no" class="custom-control-input" value="no"<?=$no; ?>>
                          <label for="no" class="custom-control-label">No</label> 
                        </div>                
                      </div>
                    </div>
                  </div> 
                </div>
                <div class="row container">
                  <div class="col-12">
                    <div class="row">
                      <label class="control-label col-3 text-white text-right">Imagen</label>
                      <div class="col-8">
                        <div class="custom-file">
                          <input type="file" name="archivos" class="custom-file-input" id="archivos" enctype="multipart/form-data"/>
                          <label class="custom-file-label" for="archivos">Elegir Archivo</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>                           
            </div>
            <div class="form-group row">
              <div class="col-lg-8 mx-auto text-center">
                <button type="submit" class="btn btn-light btn-xl js-scroll-trigger boton">Actualizar</button>
              </div>
            </div>
        </form>
      </div>
        
      <?php } ?>
    </section>
<?php
    include('footer_user.php');
?>