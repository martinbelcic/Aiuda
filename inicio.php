<?php
    include('encabezado.php');
?>
<section class="bg-primary">
    <div class="text-center text-white">
        <h1>Bienvenido <?=$nombre ?></h1>
        <hr>
        <h4><?=$vista;?></h4>
    </div>
    <div class="container">
        <div class="row">
            <?=$opciones;?>
        </div>
    </div>
</section>
<?php
    include ('footer_user.php');
?>