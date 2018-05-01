<?php

	require_once('../../../../inc_conexion.php');

   
	$db = new MySQL();

	$id_proy = xps_desencriptar($_POST['HdIdProyecto']);
	$id_user = xps_desencriptar($_POST['HiUser']);
	$id_rol  = xps_desencriptar($_POST['HdIdRol']);

			$insertar = array();
//			$insertar['ver'] 			= 1;
			$insertar['HdIdProyecto'] 	= 0;
			$insertar['HiUser']			= 0;			
			$insertar['HdIdRol'] 		= 1;
			$insertar['datos1']			= xps_encriptar("0,".$id_proy.",".$id_user.",".$id_rol);//
			$insertar['accion']			= 9;


		if($consulta = $db->comentario('proyectos_usuarios','', $insertar , 2)){
			echo '<pre>detalle_pla.php';
			echo '<pre>ROL ingresado Correctamente';
		}
		else{
			echo '<pre>detalle_pla.php';
			echo "<pre>NO SE GUARDO";				
		}


	exit();

  
?>