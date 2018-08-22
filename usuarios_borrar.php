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
    }
    
    if($confirma != ''){
        $borrado = mysqli_query($db, "DELETE FROM usuarios WHERE id_usuario = '$id';");
        $borrado_msg = "Registro eliminado con exito.";
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