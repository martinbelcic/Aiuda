<?php
    require('encabezado.php');
    
    $id = $_REQUEST['id'];
    $tipo = $_REQUEST['tipo'];
    
    if(!empty($_POST)){
        $comentario = $_REQUEST['comentario'];
        $id_usuario = $_SESSION['id_usuario'];
        
        if($tipo == 0){
            $query = mysqli_query($db, "INSERT INTO comentario_ofrecimiento (id_ofrecimiento, id_usuario, comentario, fecha) VALUES ('$id', '$id_usuario', '$comentario', CURDATE());");
            if($query){
                header('location: ofrecimiento.php?id='.$id);
            }
        } else {
            $query = mysqli_query($db, "INSERT INTO comentario_pedido (id_pedido, id_usuario, comentario, fecha) VALUES ('$id', '$id_usuario', '$comentario', CURDATE());");
            if($query){
                header('location: pedido.php?id='.$id);
            }
        }
    }
?>
    <section class="bg-primary">
        <div class="container text-white">
            <div class="row text-white">
                <div class="col-12 text-center">
                    <h1>Deja tu comentario</h1>
                    <hr>    
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <form class="form-horizontal" method="POST">
                        <div class="form-group row">
                            <div class="col-3 text-right">
                                <label for="comentario">Comentario</label>  
                            </div>
                            <div class="col-8">
                                <textarea type="textarea" name="comentario" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark">Comentar</button>    
                            </div>
                        </div>
                    </form>
                </div>
                    
            </div>
        </div>
    </section>
<?php
    include('footer_user.php');
?>