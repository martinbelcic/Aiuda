<?php
	// Esta funcion verifica la imagen subida determinada por selector
    function imagenCorrecta($selector){
        if (!is_uploaded_file($_FILES[$selector]['tmp_name']))
            return true;
        else {
            $chequeo = exif_imagetype($_FILES[$selector]['tmp_name']);
            return ($chequeo == IMAGETYPE_JPEG || $chequeo == IMAGETYPE_PNG) && $_FILES[$selector]['size'] <= 5000000;
        }
    }

	function subirImagen($idcosa, $carpeta){
        $directorio = "imagenes/".$carpeta."/";
        $archivo_path = $directorio . $idcosa;
        if (!move_uploaded_file($_FILES['archivos']['tmp_name'], $archivo_path))
            echo '<script language="javascript">alert("Error inesperado al tratar de subir la portada.");</script>'; 
    }

?>