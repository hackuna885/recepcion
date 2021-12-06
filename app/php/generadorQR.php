<?php
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');

// Libreria phpqrcode
include('phpqrcode.php');

//Libreria de dompdf
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

// Correo

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';

// Codifica el formato json
$_POST = json_decode(file_get_contents("php://input"), true);


    //Generamos el QR dentro de la Ruta 'img/qr/'

    $con = new SQLite3("../data/data.db");
    // $cs = $con -> query("SELECT * FROM vEmpleados2021 WHERE claveUno = '815' AND (correoUno NOT LIKE '')");
    
    // $cs = $con -> query("SELECT * FROM vEmpleados2021 WHERE id BETWEEN '227' AND '227' AND (correoUno NOT LIKE '')");
    $cs = $con -> query("SELECT * FROM vEmpleados2021 WHERE id BETWEEN '810' AND '810' AND (correoInt NOT LIKE '')");
    while ($resul = $cs -> fetchArray()) {
        $idData = $resul['id'];
        $claveUno = $resul['claveUno'];
        $nomCompleto = $resul['nomCompleto'];
        $correoUno = $resul['correoUno'];
        $correoInt = $resul['correoInt'];

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
            $dompdf->setPaper('letter', 'landscape');
            $dompdf->render();
    
            //Pregunta donde guardar el PDF
            // $pdf = $dompdf->stream($nomPdf);
    
            //Guarda PDF dentro de la ruta
            $output = $dompdf->output();
            file_put_contents($archivoPdf, $output);


			// ##################################
			// Inicia enviar correo
			// ##################################

            if(file_exists($archivoPdf)){

                $mail = new PHPMailer(true);
    
                    //Server settings
                    // $mail->SMTPDebug = 2;    //Sirve como guía para detectar errores de envió
                    $mail->CharSet = 'UTF-8';
            
                    $mail->isSMTP();
            
                    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'eventos1@utfv.edu.mx';                     // SMTP username
                    $mail->Password   = '@123Eventos';                               // SMTP password
                    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port       = 587;                                    // TCP port to connect to
            
                    //PARA PHP 5.6 Y POSTERIOR
                    $mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );
            
                    //Recipients
                    $mail->setFrom('eventos1@utfv.edu.mx');
                    $mail->addAddress($correoInt);     //Correo de Salida - Recuerda cambiar abajo en Correo:
                    // $mail->addBCC('oliver.velazquez@corsec.com.mx');
                    $mail->addAttachment($archivoPdf);  //Archivo Adjunto
            
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    // $mail->msgHTML(file_get_contents('ejemplo.html'), __DIR__);     //Se envio archivo en HTML pero $mail->Body debe estar desactivado
                    $mail->Subject = 'Invitación al Festejo de Fin de Año de la UTFV';
                    $mail->Body    = '
                    <h1>¡Hola,'.$nomCompleto.'!</h1>
                    <br>
                    <p>
                    <h3>Se cordialmente invitado al Festejo de Fin de Año de la UTFV, puedes descargar tu invitación desde el siguiente enlace:</h3>
                    <br>
                    Solo descarga el archivo PDF con el nombre “'.$nomPdf.'” adjunto dentro del correo.
                    <br>
                    <br>
                    ';
            
                    $mail->send();
    
    
                    echo 'id: '.$idData.'- Nombre: '.$nomCompleto .' - Correo: '.$correoInt.' [✔] <br>';
            }
            

            // ##################################
            // Termina enviar correo
            // ##################################

        }else{
            echo 'No es posible Generar PDF, falta qrchivo QR';
        }


    };




    $con -> close();

?>