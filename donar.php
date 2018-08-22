<?php
  include('encabezado.php');
  require('funciones_img.php');
  
  $id = $_SESSION['id_usuario'];
  $query = mysqli_query($db, "SELECT tipo FROM usuarios WHERE id_usuario = '$id';");
  $tipo = mysqli_fetch_assoc($query);
  if($tipo['tipo'] == 0){
    $check = '';
    
    if(!empty($_POST)){
      $titulo = $_REQUEST['titulo'];
      $descripcion = $_REQUEST['descripcion'];
      $tag = $_REQUEST['tag'];
      $envio = $_REQUEST['envio'];
      $estado = 'nuevo';
      
      $result = mysqli_query($db, "INSERT INTO ofrecimientos (titulo, descripcion, id_usuario, estado, envio, fecha) VALUES ('$titulo', '$descripcion', '$id', '$estado', '$envio', CURDATE());");

      if($result){
        $last_id = mysqli_insert_id($db);  
      
        if (is_uploaded_file($_FILES['archivos']['tmp_name']))
            subirImagen($last_id, 'ofrecimientos');
        
        foreach ($tag as $id_tag){
          $result = mysqli_query($db, "INSERT INTO tag_ofrecimiento (id_ofrecimiento, id_tag) VALUES ('$last_id', '$id_tag');");
        }
        //busco los posibles
        $busca_posibles = mysqli_query($db, "SELECT id_pedido FROM tag_pedido INNER JOIN tag_ofrecimiento WHERE id_ofrecimiento = '$last_id' AND tag_pedido.id_tag = tag_ofrecimiento.id_tag;");
        //encontre posibles
        if($busca_posibles){
          $marcados = array();
          while($posible = mysqli_fetch_assoc($busca_posibles)){
            $id_pedido = $posible['id_pedido'];
            $guardo_posible = mysqli_query($db, "INSERT INTO posibles (id_pedido, id_ofrecimiento) VALUES ('$id_pedido', '$last_id');");
          }
          header("location: posibles.php?id=".$last_id);
        }
      }
    } else {
      $result = mysqli_query($db, "SELECT * FROM tags;");
      if($result){
        while($tag = mysqli_fetch_assoc($result)){
          $check .= '
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customCheck'.$tag['id_tag'].'" value="'.$tag['id_tag'].'" name="tag[]">
              <label class="custom-control-label" for="customCheck'.$tag['id_tag'].'">'.$tag['nombre'].'</label>
            </div>
          ';
        }
      }
    }
  } else {
    header ("location: inicio.php");
  }
?>

    <section class="bg-primary donar text-white" id="registro">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-8 mx-auto text-center">
		        <h2 class="section-heading text-white">Dona!</h2>
            <p class="text-faded mb-4">Completa el siguente campo explicando lo que deaseas donar.</p>
           	<hr class="my-4">
		      </div>	
    		</div>
    	
      	<form method="POST" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group row text-white">
              <div class="col-10 mx-auto">
                <div class="row container">
                    <div class="col-3 text-right">
                      <label for="titulo">Titulo</label>
                    </div>
                    <div class="col-8">
                      <input type="text" name="titulo" class="form-control"/>
                    </div>
                </div>
                <div class="row container mt-2">
                  <div class="col-3 text-right">
                    <label for="comment">Descripcion</label>
                  </div>
                  <div class="col-8">
                    <textarea class="form-control" rows="5" id="comment" name="descripcion"></textarea>
                  </div>  
                </div>
                
                <div class="row container">
                  <div class="col-3 mr-1 text-right">
                    <label>Por favor, selecciona los tipos de donaciones que incluis.</label>
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
                          <input type="radio" name="envio" id="si" class="custom-control-input" value="si">
                          <label for="si" class="custom-control-label">Si</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input type="radio" name="envio" id="no" class="custom-control-input" value="no">
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
                          <input type="file" name="archivos" class="custom-file-input" id="archivos"/>
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
                <button type="submit" class="btn btn-light btn-xl js-scroll-trigger boton">Donar</button>
              </div>
            </div>
        </form>
    	</div>
    </section>
<?php
  include('footer_user.php');
?>