<?php
	include('encabezado.php');

	$id_cosa = $_REQUEST['id'];
	$tipo = $_REQUEST['tipo'];
	$id_usuario = $_SESSION['id_usuario'];
	$cosa = '';
	if($tipo == 0){
		$string = "SELECT usuarios.id_usuario, descripcion, titulo FROM usuarios INNER JOIN ofrecimientos WHERE usuarios.id_usuario = ofrecimientos.id_usuario AND id_ofrecimiento = '$id_cosa';";
	} else {
		$string = "SELECT usuarios.id_usuario, descripcion, titulo FROM usuarios INNER JOIN pedidos ON usuarios.id_usuario = pedidos.id_usuario AND id_pedido = '$id_cosa';";
	}
	$query = mysqli_query($db, $string);

	if($query){
		$user_cosa = mysqli_fetch_assoc($query);
		if($user_cosa){
			if($user_cosa['id_usuario'] == $id_usuario){
				$cosa = '
					<div class="col-8 text-white m-auto text-center">
						<h5>'.$user_cosa['titulo'].'</h5>
						<p>'.$user_cosa['descripcion'].'</p>
						<a class="btn btn-secondary" href="eliminar.php?id='.$id_cosa.'&tipo='.$tipo.'&confirma=si">Confirmar</a>
						<a class="btn btn-danger" href="inicio.php">Cancelar</a>
					</div>
				';
			} else {
				header('location: inicio.php');
			}				
		} else {
			header('location: inicio.php');
		}
	}

	$confirma = '';
	if(isset($_REQUEST['confirma'])){
		$confirma = $_REQUEST['confirma'];
	}

	if($confirma == 'si'){
		if($tipo == 0){
			$borro_tags = mysqli_query($db, "DELETE FROM tag_ofrecimiento WHERE id_ofrecimiento = '$id_cosa';");
			$borro_posibles = mysqli_query($db, "DELETE FROM posibles WHERE id_ofrecimiento = '$id_cosa';");
			$borro_cosa = mysqli_query($db, "DELETE FROM ofrecimientos WHERE id_ofrecimiento = '$id_cosa';");
		} else {
			$borro_tags = mysqli_query($db, "DELETE FROM tag_pedido WHERE id_pedido = '$id_cosa';");
			$borro_posibles = mysqli_query($db, "DELETE FROM posibles WHERE id_pedido = '$id_cosa';");
			$borro_cosa = mysqli_query($db, "DELETE FROM pedidos WHERE id_pedido = '$id_cosa';");
		}
		header('location: inicio.php');
	}

?>
<section class="bg-primary">
	<?=$cosa; ?>
</section>
<?php
	include('footer_user.php');
?>