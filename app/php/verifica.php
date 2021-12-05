<?php 

error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');
session_start();

$_POST = json_decode(file_get_contents("php://input"), true);

// Entradas Form
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$nEmpleado = (isset($_POST['nEmpleado'])) ? $_POST['nEmpleado'] : '';

$fechaCap = date('d-m-Y');
$horaCap = date('g:i:s a');
$fechaHoraReg = $fechaCap . ' ' . $horaCap;

$con = new SQLite3("../data/data.db");
	

switch ($opcion) {
	//Mostrar Lista
	case 1:
		$cs = $con -> query("SELECT * FROM vEmpleados2021 WHERE md5ClaveUno = '$nEmpleado'");
		while ($resul = $cs -> fetchArray()) {
				$claveUno = $resul['claveUno'];
				$nomCompleto = $resul['nomCompleto'];
				$depto = $resul['depto'];
				$puesto = $resul['puesto'];
				$asistencia = $resul['asistencia'];
				$comodin = $resul['comodin'];
			}

			if(!empty($comodin)){

				echo json_encode('
				<div class="alert alert-success text-center animate__animated animate__fadeIn" role="alert">
					Invitado registrado a las: <span style="font-size: .7em;">'.$comodin.'</span>
				</div>
				<p>
					<div class="p-2 rounded" style="text-align: left; background-color: rgba(186, 186, 186, 0.5);">

						<b>Núm. Empleado: </b><i>'.$claveUno.'</i>
						<br>
						<b>Nombre: </b><i>'.$nomCompleto.'</i>
						<br>
						<b>Area: </b><i>'.$depto.'</i>
						<br>
						<b>Cargo: </b><i>'.$puesto.'</i>
					</div>
				</p>
				<div class="btn btn-success form-control disabled">Registro</div>
				');

			}else{
				echo json_encode('
				<div class="alert alert-danger text-center animate__animated animate__fadeIn" role="alert">
					Invitado no registrado
				</div>
				<p>
					<div class="p-2 rounded" style="text-align: left; background-color: rgba(186, 186, 186, 0.5);">

						<b>Núm. Empleado: </b><i>'.$claveUno.'</i>
						<br>
						<b>Nombre: </b><i>'.$nomCompleto.'</i>
						<br>
						<b>Area: </b><i>'.$depto.'</i>
						<br>
						<b>Cargo: </b><i>'.$puesto.'</i>
					</div>
				</p>
				<button class="btn btn-success form-control">Registro</button>
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