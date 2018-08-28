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
    
    $query = mysqli_query($db, "SELECT * FROM usuarios WHERE id_usuario = '$id';");
    if($query){
        $usuario = mysqli_fetch_assoc($query);
        
        switch($usuario['tipo']){
            case 0: $nombre = $usuario['nombre'].' '.$usuario['apellido'];
            break;
            case 1: $nombre = $usuario['nombreong'];
            break;
            case 2: $nombre = $usuario['nombre'].' '.$usuario['apellido'];
            break;
        }
        if($confirma != ''){
            switch ($usuario['tipo']) {
                case 0:
                    $busco_ofre = mysqli_query($db, "SELECT id_tag FROM ofrecimientos INNER JOIN tag_ofrecimiento WHERE id_usuario = '$id' and ofrecimientos.id_ofrecimiento = tag_ofrecimiento.id_ofrecimiento;");
                    if($busco_ofre){
                        while($tag = mysqli_fetch_assoc($busco_ofre)){
                            $id_tag = $tag['id_tag'];
                            $borro_tag = mysqli_query($db, "DELETE FROM tag_ofrecimiento WHERE id_tag = '$id_tag';");
                        }
                    }
                    $busco_pos = mysqli_query($db, "SELECT * FROM ofrecimientos WHERE id_usuario = '$id';");
                    while($ofer = mysqli_fetch_assoc($busco_pos)){
                        $id_ofer = $ofer['id_ofrecimiento'];
                    }
                    $busco_com = mysqli_query($db, "SELECT id_com_of FROM ofrecimientos INNER JOIN comentario_ofrecimiento WHERE ofrecimientos.id_usuario = '$id' and ofrecimientos.id_ofrecimiento = comentario_ofrecimiento.id_ofrecimiento;");
                    if($busco_com){
                        while($coment = mysqli_fetch_assoc($busco_com)){
                            $id_com = $coment['id_com_of'];
                            $borro_com = mysqli_query($db, "DELETE FROM comentario_ofrecimiento WHERE id_com_of = '$id_com';");
                        }
                    }
                    $borro_com_ped= mysqli_query($db, "DELETE FROM comentario_pedido WHERE id_usuario = '$id';");
                    $borro_donacion = mysqli_query($db, "DELETE FROM ofrecimientos WHERE id_usuario = '$id';");
                    break;
                case 1:
                    $busco_ped = mysqli_query($db, "SELECT id_tag FROM pedidos INNER JOIN tag_pedido WHERE pedidos.id_usuario = '$id' and pedidos.id_pedido = tag_pedido.id_pedido;");
                    if($busco_ped){
                        while($tag = mysqli_fetch_assoc($busco_ped)){
                            $id_tag = $tag['id_tag'];
                            $borro_tag = mysqli_query($db, "DELETE FROM tag_ofrecimiento WHERE id_tag = '$id_tag';");
                        }
                    }
                    $busco_com = mysqli_query($db, "SELECT id_com_ped FROM ofrecimientos INNER JOIN comentario_pedido WHERE id_usuario = '$id' and pedidos.id_pedido = comentario_pedido.id_pedido;");
                    if($busco_ofre){
                        while($coment = mysqli_fetch_assoc($busco_com)){
                            $id_com = $coment['id_com_ped'];
                            $borro_comx = mysqli_query($db, "DELETE FROM comentario_pedido WHERE id_com_ped = '$id_com';");
                        }
                    }
                    $borro_com_of= mysqli_query($db, "DELETE FROM comentario_ofrecimiento WHERE id_usuario = '$id';");
                    $borro_pedido = mysqli_query($db, "DELETE FROM pedidos WHERE id_usuario = '$id';");
                    break;
            }
            $borrado = mysqli_query($db, "DELETE FROM usuarios WHERE id_usuario = '$id';");
            //no borra los pedidos/ ofrecimientos conviene un delete de inner join
            if($borrado)
                $borrado_msg = "Registro eliminado con exito.";
            else
                echo "DELETE FROM usuarios WHERE id_usuario = '$id';";
        }
    }
?>
<section class="bg-primary text-white text-center">
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">
                <?php
                if($borrado_msg == ''){?>
                
                <p>¿Confirma que desea eliminar este usuario?</p>
                <p><?=$nombre;?></p>
                <a href="usuarios_borrar.php?id=<?=$id;?>&confirma=si" class="btn btn-danger">Confirmar</a>
                <a href="usuarios_listado.php" class="btn btn-secondary">Cancelar</a>
                
                <?php }else{ ?>
                
                <p>El usuario <?=$nombre;?> fue eliminado con exito. <a href="usuarios_listado.php" class="btn btn-secondary">Continuar</a></p> 
                
                <?php } ?>
            </div>
        </div>
    </div>
</section>
    
<?php
    include('footer_user.php');
?>