<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <title>Formulario</title>
</head>
<body>
    <form action="." novalidate>
      <h1>Formulario de Votación:</h1>
       <fieldset>
            <label for="nombre" >Nombre y Apellido</label>
            <input type="text" id="nombre" name="nombre">
            <br />
            <label for="alias">Alias</label>
            <input type="text" id="alias" name="alias">
            <br />
            <label for="rut">RUT</label>
            <input type="text" id="rut" name="rut" placeholder="9999999-9">
            <br />
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="example@example.com">
            <br />
            <label for="region">Region</label>
            <select name="region" id="region">
                <option value="">Seleccione una opción</option>
                
                <?php
                    include "conexion.php";
                    // query
                    $query_region = "SELECT * FROM regiones";
                    // Ejecutar query
                    $result = mysqli_query($connection,$query_region) or die(mysqli_error($connection));

                ?>
                <!-- Iterar opciones -->
                <?php  foreach ($result as $options):  ?>
                    <option value="<?php echo $options['id'] ?>"><?php echo $options['region'] ?></option>

                <?php endforeach; ?>
            </select>
            <br />
            <label for="comuna">Comuna</label>
            <select name="comuna" id="comuna">
                <option value="">Seleccione una opción</option>

            </select>
            <br />
            <label for="candidato">Candidato</label>
            <select name="candidato" id="candidato">
                <option value="">Seleccione una opción</option>

                <?php
                    include "conexion.php";
                    // query
                    $query_candidato = "SELECT * FROM candidatos";
                    // Ejecutar query
                    $result_candidatos = mysqli_query($connection,$query_candidato) or die(mysqli_error($connection));
                ?>
                    <!-- Iterar opciones -->
                <?php  foreach ($result_candidatos as $cantidatos): ?>
                    <option value="<?php echo $cantidatos['id'] ?>"><?php echo $cantidatos['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
            <br />
            <span style="margin-right: 10px;">Como se enteró de Nosotros</span>
            <span>
                <input type="checkbox" id="web" name="web">
                <label for="web">Web</label>
            </span>
            <span>
                <input type="checkbox" id="tv" name="tv">
                <label for="tv">TV</label>
            </span>
            <span>
                <input type="checkbox" id="social" name="social">
                <label for="social">Redes sociales</label>
            </span>
            <span>
                <input type="checkbox" id="amigo" name="amigo">
                <label for="amigo">Amigo</label>
            </span>
            <br /> <br />
            <button type="submit">Votar</button>
       </fieldset>

       <div id="show-errors"></div>
       <div id="show-success"></div>
    </form>

    <script src="js/script.js"></script>
</body>
</html>
