<?php

    include "conexion.php";
    $message = "";

    // Comprobar si existe una peticion POST
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Comprobar si existen las variables en la peticion
        if (isset($_POST['nombre']) &&
            isset($_POST['alias']) &&
            isset($_POST['region']) &&
            isset($_POST['comuna']) &&
            isset($_POST['candidato']) &&
            isset($_POST['email']) &&
            isset($_POST['rut']) &&
            isset($_POST['web']) &&
            isset($_POST['tv']) &&
            isset($_POST['social']) &&
            isset($_POST['amigo'])) {

                // Asignar variables
                $nombre = $_POST['nombre'];
                $alias = $_POST['alias'];
                $region = $_POST['region'];
                $comuna = $_POST['comuna'];
                $candidato = $_POST['candidato'];
                $email = $_POST['email'];
                $rut = $_POST['rut'];
                $web = ($_POST['web'] == 'true') ? 1 : 0;
                $tv = ($_POST['tv'] == 'true') ? 1 : 0;
                $social = ($_POST['social'] == 'true') ? 1 : 0;
                $amigo = ($_POST['amigo'] == 'true') ? 1 : 0;
    
                // Insertar datos en table
                $query_registro = "INSERT INTO registro (nombre, alias, region, comuna, candidato, email, rut, web, tv, social, amigo)
                VALUES ('$nombre',
                        '$alias',
                        '$region',
                        '$comuna',
                        '$candidato',
                        '$email',
                        '$rut',
                        '$web',
                        '$tv',
                        '$social',
                        '$amigo')";
    
                // Esperar resultado
                $resultado_registro = mysqli_query($connection, $query_registro);

                // Si hay un resultado positivo, se devuelve mensaje en formato json, sino se generar error
                if ($resultado_registro) {
                    $message = ['success' => 'Tu registro se ha completado'];
                    echo json_encode($message);
                }else {
                    $message = ['error' => 'Hubo un error en el registro'];
                    echo json_encode($message);
                };

        }else {
            $message = ['error' => 'Debes llenar los campos'];
            echo json_encode($message);
        };
 
    } else {
        $message = ['error' => 'Only allow post method'];
        echo json_encode($message);
    };

?>