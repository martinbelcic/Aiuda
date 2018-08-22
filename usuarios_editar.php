<?php
    include('encabezado.php');

    $confirma = '';
    
    $query = mysqli_query($db, "SELECT *FROM usuarios WHERE id_usuario = '".$_SESSION['id_usuario']."';");
    
    $usuario = mysqli_fetch_assoc($query);
    
    if($id != $_SESSION['id_usuario'] && $usuario['tipo'] != 2){
        header('location: inicio.php');
    } else {
        $usuario_query = mysqli_query($db, "SELECT * FROM usuarios WHERE id_usuario = '$id';");
        
        $usuario = mysqli_fetch_assoc($usuario_query);
        
        if(isset($_REQUEST['confirma'])){
            $confirma = $_REQUEST['confirma'];
        }
        
        $confirma_msg = '';
        
        if($confirma == 'si'){
            $nombre = $_REQUEST['nombre'];
            $apellido = $_REQUEST['apellido'];
            $email = $_REQUEST['email'];
            $nombreong = $_REQUEST['nombreong'];
            $contra = $_REQUEST['contrasena'];
            $telefono = $_REQUEST['telefono'];
            $celular = $_REQUEST['celular'];
            $direccion_calle = $_REQUEST['calle'];
            $direccion_numero = $_REQUEST['dir_numero'];
            $direccion_piso = $_REQUEST['piso'];
            $direccion_dpto =  $_REQUEST['dpto'];
            $direccion_codpos = $_REQUEST['codpos'];
            $fecha_nac = $_REQUEST['fecha_nac'];
            
            if($contra != ''){
                $contra = md5($contra.'misalt');
                $actualiza = mysqli_query($db, "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email', contrasena = '$contra', nombreong = '$nombreong', telefono = '$telefono', celular = '$celular', direccion_calle = '$direccion_calle', direccion_piso = '$direccion_piso', direccion_dpto = '$direccion_dpto', direccion_numero = '$direccion_numero', direccion_codpos = '$direccion_codpos', fecha_nacimiento = '$fecha_nac' WHERE id_usuario = '$id';");
            } else {
                $actualiza = mysqli_query($db, "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email', nombreong = '$nombreong', telefono = '$telefono', celular = '$celular', direccion_calle = '$direccion_calle', direccion_piso = '$direccion_piso', direccion_dpto = '$direccion_dpto', direccion_numero = '$direccion_numero', direccion_codpos = '$direccion_codpos', fecha_nacimiento = '$fecha_nac' WHERE id_usuario = '$id';");
            }
            
            $confirma_msg = 'si';
        }
    }
        
?>


<section class="bg-primary text-white">
    <div class="container">
        <div class="row mt-4">
            <div class="col">
                <?php
                if($confirma_msg==''){
                ?>
                <form action='usuarios_editar.php' method="POST">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <input type="hidden" name="confirma" value="si"/>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?=$usuario['email'];?>">
                        </div>
                        <div class="form-group col-6">
                            <label for="contrasena">Contraseña</label>
                            <input name="contrasena" type="password" class="form-control" id="contrasena" placeholder="Contrseña">
                        </div>
                    </div>
                        
                    <?php
                    if($usuario['tipo'] == 1) {
                    ?>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="nombreong">Nombre ONG</label>
                            <input name="nombreong" type="text" class="form-control" id="nombreong" placeholder="ej: Green Peace" value="<?=$usuario['nombreong'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h5>Datos del representante</h5>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="nombre">Nombre</label>
                            <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre" value="<?=$usuario['nombre'];?>">
                        </div>
                        <div class="form-group col-6">
                            <label for="apellido">Apellido</label>
                            <input name="apellido" type="text" class="form-control" id="apellido" placeholder="Apellido" value="<?=$usuario['apellido'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="fecha_nac">Fecha de Nacimiento</label>
                            <input name="fecha_nac" type="date" class="form-control" id="fecha_nac" placeholder="" value="<?=$usuario['fecha_nacimiento'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="telefono">Telefono</label>
                            <input name="telefono" type="tel" class="form-control" id="telefono" placeholder="4782792" value="<?=$usuario['telefono'];?>">
                        </div>
                        <div class="form-group col-6">
                            <label for="celular">Celular</label>
                            <input name="celular" type="tel" class="form-control" id="celular" placeholder="154553806" value="<?=$usuario['celular'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-white">Direccion</h5>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="calle">Calle</label>
                                <input name="calle" type="text" class="form-control" id="calle" placeholder="Av. Siempre Viva" value="<?=$usuario['direccion_calle'];?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dir_numero">Numero</label>
                                <input name="dir_numero" type="number" class="form-control" id="dir_numero" placeholder="748" value="<?=$usuario['direccion_numero'];?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dpto">Departamento</label>
                                <input name="dpto" type="text" class="form-control" id="dpto" placeholder="A" value="<?=$usuario['direccion_dpto'];?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="piso">Piso</label>
                                <input name="piso" type="text" class="form-control" id="piso" placeholder="15" value="<?=$usuario['direccion_piso'];?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="codpos">Codigo Postal</label>
                                <input name="codpos" type="text" class="form-control" id="codpos" placeholder="7600" value="<?=$usuario['direccion_codpos'];?>">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
                <?php }
                else { ?>
                    <div class="col-8 text-center m-auto">
                        <p>El registro se actualizo correctamiente. <a href="usuarios_listado.php" class="btn btn-secondary">Continuar</a></p>
                    </div>                
                <?php } ?>
            </div>
        </div>
    </div>
</section>
    
<?php
    include('footer_user.php');
?>