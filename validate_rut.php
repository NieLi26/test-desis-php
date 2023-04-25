<?php
    // Conexion base
    include "conexion.php";

    // Valor de peticion
    $rut = $_POST['rut'];

    // Generar consulta
    $query_rut = "SELECT rut FROM registro 
                    WHERE rut='$rut'
                    LIMIT 1";

    // Esperar resultado
    $resultado_rut = mysqli_query($connection, $query_rut);

    // Si hay un resultado positivo, se extrae el rut y se devuelve como respuesta
    if ($resultado_rut) {
        $row = mysqli_fetch_assoc($resultado_rut);
        if ($row){
            echo 'Rut: '.$row['rut'].' esta en uso';
        }

    }

?>