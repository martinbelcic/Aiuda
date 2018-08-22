<?php
    include('encabezado.php');
    include('check_admin.php');
    
    $query = mysqli_query($db, "SELECT * FROM pedidos;");
    
    $listado = '';
    if($query){
        while($pedido = mysqli_fetch_assoc($query)){
            $listado .= '
                <tr>
                    <td>'.$pedido['id_pedido'].'</td>
                    <td>Titulo</td>
                    <td>'.$pedido['descripcion'].'</td>
                    <td>'.$pedido['estado'].'</td>
                    <td>'.$pedido['busca'].'</td>
                    <td>Fecha</td>
                    <td>
                        <a href="editar.php?tipo=1&id='.$pedido['id_pedido'].'" class="btn btn-info">Editar<a/>
                        <a href="pedidos_borrar.php?id='.$pedido['id_pedido'].'" class="btn btn-warning">Borrar<a/>
                    </td>
                </tr>
            ';
        }
    }
?>
<section class="listado bg-primary">
    <div class="container text-white">
        <div class="col-6 text-center">
            <h1>Pedidos</h1>
        </div>
        <div class="row mt-4">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <td>id</td>
                            <td>Titulo</td>
                            <td>Descripcion</td>
                            <td>Estado</td>
                            <td>Envio</td>
                            <td>Fecha</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?=$listado; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php
    include('footer_user.php');
?>