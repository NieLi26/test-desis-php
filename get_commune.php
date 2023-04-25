<?php
    // Conexion Base 
    include "conexion.php";

    // Valor de peticion
    $id_region = $_POST['id_region'];

    // Generar consulta
    $query_comuna = "SELECT id, comuna FROM comunas 
                    WHERE region_id='$id_region'
                    ORDER BY comuna ASC";

    // Esperar resultado               
    $resultado_comuna = mysqli_query($connection, $query_comuna) or die(mysqli_error($connection));

    // Si responde con un html
    $html = "<option value=''>Seleccione una opción</option>";

    foreach($resultado_comuna as $options){
        $html .= "<option value='".$options['id']."'>".$options['comuna']."</option>";
    }

    echo $html

?>