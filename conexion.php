<?php
    // Declaramos variable para usar en MySQL
    $user = "root";
    $pass = "";
    $host = "localhost";
    $datab = "votacion";

    // Tratamos de conectar a la BBDD
    $connection = mysqli_connect($host, $user, $pass, $datab);

?>