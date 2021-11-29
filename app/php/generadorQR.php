<?php
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');

// Libreria phpqrcode
include('phpqrcode.php');

//Libreria de dompdf
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;


    //Generamos el QR dentro de la Ruta 'img/qr/'

    $con = new SQLite3("../data/data.db");
    $cs = $con -> query("SELECT * FROM vEmpleados2021 WHERE claveUno = '817' ");
    while ($resul = $cs -> fetchArray()) {
        $claveUno = $resul['claveUno'];
        $nomCompleto = $resul['nomCompleto'];

        $md5ClaveUno = md5($claveUno);
        $dirTemp = '../../img/qr/';
        $dirPdf = '../../pdf/';
        $nomQr = $md5ClaveUno.'.png';
        $nomPdf = $md5ClaveUno.'.pdf';
        $archivoQr = $dirTemp.$nomQr;
        $archivoPdf = $dirPdf.$nomPdf;
        $url = 'https://utfv.net/recepcion/buscador/empleado.app?id='.$md5ClaveUno;
        $calida = 'h';
        $tamano = 10;
        $margen = 1;
        QRCode::png($url, $archivoQr, $calida, $tamano, $margen);

        //Si el archivo *.png existe
        
        if(file_exists($archivoQr)){

            //Generamos PDF
            $dompdf = new Dompdf();
            ob_start();
            include "plantilla.php";
            $html = ob_get_clean();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('letter', 'portrait');
            $dompdf->render();
    
            //Pregunta donde guardar el PDF
            // $pdf = $dompdf->stream($nomPdf);
    
            //Guarda PDF dentro de la ruta
            $output = $dompdf->output();
            file_put_contents($archivoPdf, $output);

        }else{
            echo 'No es posible Generar PDF, falta qrchivo QR';
        }


    };




    $con -> close();

?>