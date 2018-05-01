<?php

	require_once('../../../../inc_conexion.php');

   
	$db = new MySQL();

	$data = json_decode(file_get_contents('php://input'), true);

/*
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
	exit();
*/

	$accion	  = xps_desencriptar($data[0]['accion']);
	$id_ChPro = xps_desencriptar($data[1]['HdIdChPro']);	
	$id_vchk   = xps_desencriptar($data[2]['HiIdVerificacion']);

		$insertar = array();
//		$insertar['ver'] 				= 1;
		$insertar['HdIdChPro']			= 0;					
		$insertar['HiIdVerificacion'] 	= 1;
		$insertar['datos1']				= xps_encriptar($accion.",".$id_ChPro.",".$id_vchk);//
		$insertar['accion']				= 6;

/*
	echo "<pre>";
	var_dump($insertar);
	echo "</pre>";

exit();	

	*/	

		if($consulta = $db->comentario('checklist_verificacion_proyecto','', $insertar , 2)){
			echo '<pre>1';
			echo '<pre>Correctamente';
		}
		else{
			echo '<pre>0';
			echo "<pre>NO SE GUARDO";				
		}


	exit();

  
?>