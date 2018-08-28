<?php
    $esta_en_login = false;
    require('encabezado.php');
    require('check_admin.php');
    
    $id = $_REQUEST['id'];
    $confirma = '';
    
    if(isset($_REQUEST['confirma'])){
        $confirma = $_REQUEST['confirma'];
    }
    $borrado_msg = '';
    
    $query = mysqli_query($db, "SELECT * FROM ofrecimientos WHERE id_ofrecimiento = '$id';");
    if($query){
        $ofrecimiento = mysqli_fetch_assoc($query);
        
        $titulo = $ofrecimiento['titulo'];
    }
    
    if($confirma != ''){
        $comentario = mysqli_query($db, "DELETE FROM cometario_ofrecimiento WHERE id_ofrecimiento = '$id';");
        $posible = mysqli_query($db, "DELETE FROM posibles WHERE id_ofrecimiento = '$id';");
        $borra_tag = mysqli_query($db, "DELETE FROM tag_ofrecimiento WHERE id_ofrecimiento = '$id';");
        $borrado = mysqli_query($db, "DELETE FROM ofrecimientos WHERE id_ofrecimiento = '$id';");
        $borrado_msg = "Registro eliminado con exito.";
    }
?>
<section class="bg-primary text-white text-center">
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">
                <?php
                if($borrado_msg == ''){?>
                
                <p>¿Confirma que desea eliminar este ofrecimiento?</p>
                <p><?=$id;?></p>
                <p><?=$titulo;?></p>
                <a href="ofrecimientos_borrar.php?id=<?=$id;?>&confirma=si" class="btn btn-danger">Confirmar</a>
                <a href="ofrecimientos_listado.php" class="btn btn-secondary">Cancelar</a>
                
                <?php }else{ ?>
                
                <p>El ofrecimiento <?=$id.' '.$titulo;?> fue eliminado con exito. <a href="ofrecimientos_listado.php" class="btn btn-secondary">Continuar</a></p> 
                
                <?php } ?>
            </div>
        </div>
    </div>
</section>
    
<?php
    include('footer_user.php');
?>