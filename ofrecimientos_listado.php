<?php
    $esta_en_login = false;
    include('encabezado.php');
    include('check_admin.php');
    
    $query = mysqli_query($db, "SELECT * FROM ofrecimientos;");
    
    $listado = '';
    if($query){
        while($ofrecimiento = mysqli_fetch_assoc($query)){
            $listado .= '
                <tr>
                    <td>'.$ofrecimiento['id_ofrecimiento'].'</td>
                    <td>Titulo</td>
                    <td>'.$ofrecimiento['descripcion'].'</td>
                    <td>'.$ofrecimiento['estado'].'</td>
                    <td>'.$ofrecimiento['envio'].'</td>
                    <td>'.$ofrecimiento['fecha'].'</td>
                    <td>
                        <a href="editar.php?tipo=0&id='.$ofrecimiento['id_ofrecimiento'].'" class="btn btn-info">Editar<a/>
                        <a href="ofrecimientos_borrar.php?id='.$ofrecimiento['id_ofrecimiento'].'" class="btn btn-warning">Borrar<a/>
                    </td>
                </tr>
            ';
        }
    }
?>
<section class="listado bg-primary">
    <div class="container text-white">
        <div class="col-6 text-center">
                <h1>Ofrecimientos</h1>
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