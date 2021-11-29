<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Verificación de Empleado</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="text-center my-3">


<?php
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');

$id = isset($_GET['id']) ? $_GET['id'] : '';

    $con = new SQLite3("../data/data.db");
    $cs = $con -> query("SELECT * FROM vEmpleados2021 WHERE md5ClaveUno = '$id'");
    while ($resul = $cs -> fetchArray()) {
        $id_data = $resul['id'];
        $claveUno = $resul['claveUno'];
        $md5ClaveUno = $resul['md5ClaveUno'];
        $nomCompleto = $resul['nomCompleto'];
    };

    if (isset($id_data)) {

        $archivo = '../../img/buscador/empleados/'.$claveUno.'.jpg';

        if (file_exists($archivo)) {
            $imgPersonal = '../img/buscador/empleados/'.$claveUno.'.jpg';
        }else{
            $imgPersonal = '../img/buscador/usr.svg';
        }


        echo '
            <img src="'.$imgPersonal.'" class="img-fluid rounded" style="width: 150px;">
            </div>
            <p>
                <b>Núm. Empleado: </b>'.$claveUno.'
                <br>
                <b>Nombre: </b>'.$nomCompleto.'
                <br>
            </p>
        ';
    }else{
        echo '
            <img src="../img/buscador/usr.svg" class="img-fluid rounded" style="width: 150px;">
            <h1>No tengo resultados</h1>
            </div>
        ';
    }



    $con -> close();
?>


                
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
</body>
</html>