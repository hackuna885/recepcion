<?php 

error_reporting(E_ALL ^ E_DEPRECATED);
header("Content-Type: text/html; Charset=UTF-8");
date_default_timezone_set('America/Mexico_City');
session_start();

$_POST = json_decode(file_get_contents("php://input"), true);

// Entradas Form
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$nEmpleado = (isset($_POST['nEmpleado'])) ? $_POST['nEmpleado'] : '';

if ($opcion === 1) {
// Conexion a DB
	$con = new SQLite3("../data/data.db");
	$cs = $con -> query("SELECT * FROM empleados WHERE md5ClaveUno = '31839b036f63806cba3f47b93af8ccb5'");
	
		while ($resul = $cs -> fetchArray()) {
			$claveUno = $resul['claveUno'];
			$asistencia = $resul['asistencia'];
			$comodin = $resul['comodin'];
		}
		
		$claveUno = (isset($claveUno)) ?  $claveUno : '';

		if($asistencia == ''){

			$cs = $con -> query("UPDATE empleados SET asistencia = '1' WHERE md5ClaveUno = '31839b036f63806cba3f47b93af8ccb5'");

			echo json_encode('correcto');

		}else{
			echo json_encode('
			<div class="alert alert-success text-center animate__animated animate__fadeIn" role="alert">
				Usuario registrado
			</div>
			');		
		}
	$con -> close();
}else{
	echo json_encode('');
}



 ?>