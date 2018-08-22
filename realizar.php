<?php
    include('encabezado.php');
    
    $id_posible = $_REQUEST['id'];

    $confirma = '';
    if(isset($_REQUEST['confirma'])){
        $confirma = $_REQUEST['confirma'];
    }
    
    //hacer que no pueda si no es su donacion
    //y que no pueda si la donacion no es nueva
    
    $query = mysqli_query($db, "SELECT titulo, descripcion, id_ofrecimiento, estado, pedidos.id_pedido FROM posibles INNER JOIN pedidos WHERE pedidos.id_pedido = posibles.id_pedido AND id_posible = '$id_posible';");
    
    if($query){
        $donacion = mysqli_fetch_assoc($query);
        $id_ofrecimiento = $donacion['id_ofrecimiento'];
        $id_pedido = $donacion['id_pedido'];
        
        $query_ver_user = mysqli_query($db, "SELECT usuarios.id_usuario, ofrecimientos.estado FROM usuarios INNER JOIN ofrecimientos WHERE usuarios.id_usuario = ofrecimientos.id_usuario AND id_ofrecimiento = '$id_ofrecimiento';");
        if($query_ver_user){
            $usuario = mysqli_fetch_assoc($query_ver_user);
            if($_SESSION['id_usuario'] != $usuario['id_usuario'] || $usuario['estado'] != 'nuevo' || $donacion['estado'] != 'nuevo'){
                //verifico que corresponda el usuari y si la donacion o pedido no este acordado
                header('location: inicio.php');
            } else {
                if($confirma == 'si'){
                    $query_ofer = mysqli_query($db, "UPDATE ofrecimientos SET estado = 'Realizada' WHERE id_ofrecimiento = '$id_ofrecimiento';");
                    $query_ped = mysqli_query($db, "UPDATE pedidos SET estado = 'Realizada' WHERE id_pedido = '$id_pedido';");
                    $query_donacion = mysqli_query($db, "INSERT INTO donaciones (id_ofrecimiento, id_pedido, fecha) VALUES ('$id_ofrecimiento', '$id_pedido', CURDATE());");
                    header('location: inicio.php');
                }
            }
        }
    }
    
?>
<section class="bg-primary">
    <div class="container">
        <div class="row text-white">
            <div class="col-12 text-center">
                <h4><?=$donacion['titulo']; ?></h4>
                <p><?=$donacion['descripcion']; ?></p>
            </div>
            <div class="col-12 text-center">
                <a class="btn btn-info" href="realizar.php?id=<?=$id_posible;?>&confirma=si">Confirmar</a>
                <a class="btn btn-danger" href="inicio.php">Cancelar</a>
            </div>
        </div>
    </div>
</section>
<?php
    include('footer_user.php');
?>