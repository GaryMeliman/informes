<?php

	require_once('../../../../../../inc_conexion.php');

	$data = json_decode(file_get_contents('php://input'), true);

//	echo "<pre>";
//	var_dump($data);
//	echo "</pre>";

$db = new MySQL();


$campos = array();
$off	= array();
$excel  = array();
foreach($data as $libro => $hoja ){
 	foreach($hoja as $celda => $datos){
	 	foreach($datos as $key => $value){//inicio de array();
	 		if($celda == 1){
	 			$campos[$key] = trim($value);
	 		}
	 		if($celda > 1){
	 			$excel[$campos[$key]] = trim($value);//inserta
	 			if($campos[$key] == 'HdIdUnidad') $off[$campos[$key]] = trim($value);//actualiza
	 		}
	 	}

	 	$update 			  = array();
//	 	$update['ver'] 		  = 1;
	 	$update['HdIdUnidad'] = 0;
	 	$update['INTEstado']  = 1;
	 	$update['datos1'] 	  = xps_encriptar("0,".$off['HdIdUnidad'].",0");
	 	$update['accion'] 	  = 9;

	 	var_dump($off);
	 	echo "__________________________________________________________________";
	 	var_dump($excel);
	 	echo "__________________________________________________________________";
	 	echo "__________________________________________________________________Excel :";	 	

		if($consulta = $db->comentario('unidades_valores','', $update , 2)){
			if($consulta = $db->comentario('unidades_valores',true, $excel , 2)){
				echo '<pre>Ingresado Correctamente';
			}
			else{
				echo "<pre>NO SE GUARDO";
			}
		}
		else{
			echo "<pre>NO SE ACTUALIZO";
		}
/**/
 	}
}

	exit();
  
?>