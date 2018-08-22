<?php
    $esta_en_login = false;
    include('encabezado.php');
    include('check_admin.php');
    $query = mysqli_query($db, "SELECT * FROM usuarios;");
    
    $listado = '';
    
    if($query){
        while($usuarios = mysqli_fetch_assoc($query)){
            switch($usuarios['tipo']){
                case 0: $nombre = ucfirst($usuarios['nombre']).' '.ucfirst($usuarios['apellido']);
                break;
                case 1: $nombre = $usuarios['nombreong'];
                break;
                case 2: $nombre = ucfirst($usuarios['nombre']).' '.ucfirst($usuarios['apellido']);
                break;
            }
            $listado .= '
                 <tr>
                    <td>'.$usuarios['id_usuario'].'</td>
                    <td>'.$nombre.'</td>
                    <td>'.$usuarios['email'].'</td>
                    <td>'.$usuarios['estado'].'</td>
                    <td>'.$usuarios['tipo'].'</td>
                    <td>
                        <a href="usuarios_editar.php?id='.$usuarios['id_usuario'].'" class="btn btn-info">Editar<a/>
                        <a href="usuarios_borrar.php?id='.$usuarios['id_usuario'].'" class="btn btn-warning">Borrar<a/>
                    </td>
                </tr>
            ';
        }
    }
?>

<section class="listado bg-primary">
    <div class="container text-white">
        <div class="row">
            <div class="col-6 text-center">
                <h1>Usuarios</h1>
            </div>
            <div class="col-6">
                <a href="agregar_usuario.php" class="btn btn-success">Agregar nuevo</a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <td>id</td>
                            <td>Nombre</td>
                            <td>Email</td>
                            <td>Estado</td>
                            <td>Tipo</td>
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