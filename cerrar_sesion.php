<?php
    require('conect.php');
    session_destroy();
    session_write_close();
    header("location: ingreso.php");
?>