<?php 

error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');
session_start();

$_POST = json_decode(file_get_contents("php://input"), true);

// Entradas Form
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$nEmpleado = (isset($_POST['nEmpleado'])) ? $_POST['nEmpleado'] : '';
$nEmpleado = (isset($_GET['id'])) ? $_GET['id'] : $nEmpleado';


$fechaCap = date('d-m-Y');
$horaCap = date('g:i:s a');
$fechaHoraReg = $fechaCap . ' ' . $horaCap;

$con = new SQLite3("../data/data.db");
	

switch ($opcion) {
	//Mostrar Lista
	case 1:
		$cs = $con -> query("SELECT * FROM empleados WHERE md5ClaveUno = '$nEmpleado'");
		while ($resul = $cs -> fetchArray()) {
				$claveUno = $resul['claveUno'];
				$asistencia = $resul['asistencia'];
				$comodin = $resul['comodin'];
			}

			if(!empty($comodin)){

				echo json_encode('
				<div class="alert alert-success text-center animate__animated animate__fadeIn" role="alert">
					Invitado registrado a las: <span style="font-size: .7em;">'.$comodin.'</span>
				</div>
				');

			}else{
				echo json_encode('
				<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
					Invitado no registrado
				</div>
				');
			}

			

		break;
	//Actualizar	
	case 2:
		$cs = $con -> query("UPDATE empleados SET asistencia = 1, comodin = '$fechaHoraReg' WHERE md5ClaveUno = '$nEmpleado'");
		echo json_encode('correcto');

		break;
}



 ?>