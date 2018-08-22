<?php

    $esta_en_login = false;
    
    include('encabezado.php');
    
    include('check_admin.php');
        
    $confirma = '';

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
        $tipo = $_REQUEST['tipo'];
            
        $contra = md5($contra.'misalt');
        $actualiza = mysqli_query($db, "INSERT INTO usuarios (nombre, apellido, email, contrasena, nombreong, telefono, celular, direccion_calle, direccion_piso, direccion_dpto, direccion_numero, direccion_codpos, fecha_nacimiento, tipo) VALUES ('$nombre', '$apellido', '$email', '$contra', '$nombreong', '$telefono', '$celular', '$direccion_calle', '$direccion_piso', '$direccion_dpto', '$direccion_numero', '$direccion_codpos', '$fecha_nac', '$tipo');");
       
        $confirma_msg = 'si';
    }
    
?>


<section class="bg-primary text-white">
    <div class="container">
        <div class="row mt-4">
            <div class="col">
                <?php
                if($confirma_msg==''){
                ?>
                <form method="POST">
                    <input type="hidden" name="confirma" value="si"/>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="email">Email</label>
                            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="ejemplo@ejemplo.com">
                        </div>
                        <div class="form-group col-6">
                            <label for="contrasena">Contraseña</label>
                            <input name="contrasena" type="password" class="form-control" id="contrasena" placeholder="Contrseña">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="nombreong">Nombre ONG</label>
                            <input name="nombreong" type="text" class="form-control" id="nombreong" placeholder="ej: Green Peace">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h5>Datos del representante</h5>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="nombre">Nombre</label>
                            <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre">
                        </div>
                        <div class="form-group col-6">
                            <label for="apellido">Apellido</label>
                            <input name="apellido" type="text" class="form-control" id="apellido" placeholder="Apellido">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="fecha_nac">Fecha de Nacimiento</label>
                            <input name="fecha_nac" type="date" class="form-control" id="fecha_nac" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="telefono">Telefono</label>
                            <input name="telefono" type="tel" class="form-control" id="telefono" placeholder="4782792">
                        </div>
                        <div class="form-group col-6">
                            <label for="celular">Celular</label>
                            <input name="celular" type="tel" class="form-control" id="celular" placeholder="154553806">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5>Direccion</h5>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="calle">Calle</label>
                                <input name="calle" type="text" class="form-control" id="calle" placeholder="Av. Siempre Viva">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dir_numero">Numero</label>
                                <input name="dir_numero" type="number" class="form-control" id="dir_numero" placeholder="748">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dpto">Departamento</label>
                                <input name="dpto" type="text" class="form-control" id="dpto" placeholder="A">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="piso">Piso</label>
                                <input name="piso" type="text" class="form-control" id="piso" placeholder="15">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="codpos">Codigo Postal</label>
                                <input name="codpos" type="text" class="form-control" id="codpos" placeholder="7600">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select name="tipo" class="form-control">
                                    <option value="0">Donador</option>
                                    <option value="1">ONG</option>
                                    <option value="2">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
                <?php }
                else { ?>
                <div class="text-center">
                    <p>El usuario se agrego correctamiente. <a href="usuarios_listado.php" class="btn btn-secondary">Continuar</a></p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
    
<?php
    include('footer_user.php');
?>