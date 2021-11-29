<?php
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');

$archivoQr = !empty($archivoQr) ? $archivoQr : '';
$nomCompleto = !empty($nomCompleto) ? $nomCompleto : '';

?>

<html>
    <head>
        <link rel="stylesheet" href="../../css/style.css">
    </head>
    <body>
        <div class="hoja">
            <div class="codigoQr">
                <img src="<?php echo $archivoQr; ?>">
            </div>
            <div class="nomInvitado">
                <h2><?php echo $nomCompleto;?></h2>
            </div>
            <img src="../../img/invita.jpg">
        </div>
    </body>
</html>