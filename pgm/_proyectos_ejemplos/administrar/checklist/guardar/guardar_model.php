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
	$id_ChPro = xps_desencriptar($data[2]['HdIdChPro']);	
	$id_proy  = xps_desencriptar($data[1]['HdIdProyecto']);
	$id_chk   = xps_desencriptar($data[3]['HiIdChecklist']);

		$insertar = array();
//		$insertar['ver'] 			= 1;
		$insertar['HdIdChPro']		= 0;					
		$insertar['HdIdProyecto'] 	= 0;
		$insertar['HiIdChecklist'] 	= 1;
		$insertar['datos1']			= xps_encriptar($accion.",".$id_ChPro.",".$id_proy.",".$id_chk);//
		$insertar['accion']			= 6;

/*
	echo "<pre>";
	var_dump($insertar);
	echo "</pre>";

exit();	

	*/	

		if($consulta = $db->comentario('checklist_proyectos','', $insertar , 2)){
			echo '<pre>1';
			echo '<pre>Correctamente';
		}
		else{
			echo '<pre>0';
			echo "<pre>NO SE GUARDO";				
		}


	exit();

  
?>