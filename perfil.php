<?php
    include('encabezado.php');
    
    $id = $_SESSION['id_usuario'];
    
    $query = mysqli_query($db, "SELECT * FROM usuarios WHERE id_usuario = '$id';");
?>
<section class="bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-3">
                
            </div>
            <div class="col-9">
                
            </div>
        </div>
    </div>
</section>
<?php
    include('footer_user.php');
?>