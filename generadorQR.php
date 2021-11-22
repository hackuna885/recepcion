<?php
error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');


    include('phpqrcode.php');
    // $param = (isset($_GET['id'])) ? $_GET['id'] : '';
    
    // ob_start("callback");
    // $debugLog = ob_get_contents();
    // ob_end_clean();

    // QRcode::png($param);

    $codeText = (isset($_GET['id'])) ? $_GET['id'] : '';
	$outfile = false;
	$level = 'h';
	$size = 10;
	$margin = 1;
	$saveandprint = false;
    $back_color = 0xFFFFFF;
	$fore_color = 0x000000;
	QRcode::png($codeText, $outfile, $level, $size, $margin, $saveandprint, $back_color, $fore_color);

?>