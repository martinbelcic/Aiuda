<?php
    require('encabezado.php');
    require('check_admin.php');
    
    $id = $_REQUEST['id'];

    $confirma = '';
    if(isset($_REQUEST['confirma']))
        $confirma = $_REQUEST['confirma'];
    
    $borrado_msg = '';
    
    $query = mysqli_query($db, "SELECT * FROM pedidos WHERE id_pedido = '$id';");
    if($query){
        $pedido = mysqli_fetch_assoc($query);
        
        $titulo = $pedido['titulo'];
    }
    
    if($confirma != ''){
        $com = mysqli_query($db, "DELETE FROM comentario_pedido WHERE id_pedido = '$id';");
        $posible = mysqli_query($db, "DELETE FROM posibles WHERE id_pedido = '$id';");
        $borra_tag = mysqli_query($db, "DELETE FROM tag_pedido WHERE id_pedido = '$id';");
        $borrado = mysqli_query($db, "DELETE FROM pedidos WHERE id_pedido = '$id';");
        $borrado_msg = "Registro eliminado con exito.";
    }
?>
<section class="bg-primary text-white text-center">
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">
                <?php
                if($borrado_msg == ''){?>
                
                <p>¿Confirma que desea eliminar este peidido?</p>
                <p><?=$id;?></p>
                <p><?=$titulo;?></p>
                <a href="pedidos_borrar.php?id=<?=$id;?>&confirma=si" class="btn btn-danger">Confirmar</a>
                <a href="pedidos_listado.php" class="btn btn-secondary">Cancelar</a>
                
                <?php }else{ ?>
                
                <p>El pedido <?=$id.' '.$titulo;?> fue eliminado con exito. <a href="pedidos_listado.php" class="btn btn-secondary">Continuar</a></p> 
                
                <?php } ?>
            </div>
        </div>
    </div>
</section>
    
<?php
    include('footer_user.php');
?>