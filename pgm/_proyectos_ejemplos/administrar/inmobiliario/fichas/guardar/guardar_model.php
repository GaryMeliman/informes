<?php

	require_once('../../../../../inc_conexion.php');

   
	$db = new MySQL();

	$data = json_decode(file_get_contents('php://input'), true);

/*
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
	exit();
*/	


	$accion	  		= xps_desencriptar($data[0]['accion']);
	$HdIdFichaIn	= xps_desencriptar($data[2]['HdIdFichaIn']);	
	$id_inm			= xps_desencriptar($data[1]['HdIdInmobiliario']);
	$HdIdFicha   	= xps_desencriptar($data[3]['HdIdFicha']);

		$insertar = array();
//		$insertar['ver'] 				= 1;
		$insertar['HdIdFichaIn']		= 0;					
		$insertar['HdIdInmobiliario'] 	= 0;
		$insertar['HdIdFicha'] 			= 1;
		$insertar['datos1']				= xps_encriptar($accion.",".$HdIdFichaIn.",".$id_inm.",".$HdIdFicha);//
		$insertar['accion']				= 6;

/*
	echo "<pre>";
	var_dump($insertar);
	echo "</pre>";

exit();	

	*/	

		if($consulta = $db->comentario('fichas_inmobiliarios','', $insertar , 2)){
			echo '<pre>1';
			echo '<pre>Correctamente';
		}
		else{
			echo '<pre>0';
			echo "<pre>NO SE GUARDO";				
		}


	exit();

  
?>