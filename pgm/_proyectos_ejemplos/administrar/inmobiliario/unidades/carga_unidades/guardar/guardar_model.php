<?php

	require_once('../../../../../../inc_conexion.php');

	$data = json_decode(file_get_contents('php://input'), true);

//	echo "<pre>";
//	var_dump($data);
//	echo "</pre>";

$db = new MySQL();


$campos = array();
$excel  = array();
foreach($data as $libro => $hoja ){
 	foreach($hoja as $celda => $datos){
	 	foreach($datos as $key => $value){//inicio de array();
	 		if($celda == 1){
	 			$campos[$key] = trim($value);
	 		}
	 		if($celda > 1){
	 			$excel[$campos[$key]] = trim($value);
	 		}
	 	}
	 	var_dump($excel);

		if($consulta = $db->comentario('unidades',true, $excel , 2)){
			echo '<pre>Ingresado Correctamente';
		}
		else{
			echo "<pre>NO SE GUARDO";				
		}
/**/
 	}
}

	exit();
  
?>