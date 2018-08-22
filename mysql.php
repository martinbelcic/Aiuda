<?php
    
    define ('db_host', getenv('IP'));
    define ('db_user', getenv('C9_USER'));
    define ('db_pas', '');
    define ('db_db', 'c9');
    
    $db = mysqli_connect(db_host, db_user, db_pas, db_db); //esta es mi db
    
   if(!$db){
       echo 'Esto no funciona wachin.';
       echo 'fuck the police.';
   }
   else{
       $sql = 'SELECT * FROM usuarios';
       
       $rs = mysqli_query($db, $sql); //guardo el resultado de la query
       
       if($rs){
           
           while ($rec = mysqli_fetch_array($rs)){
               echo 'Nombre: '.$rec['nombre']. '<br>';
               echo 'Apellido: '.$rec['apellido']. '<br>';
               echo '<br>';
           }
           
       }
       else{
           echo 'No se encontraron resultados.';
       }
   }
?>