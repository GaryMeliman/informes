<?php

	require_once('../../../../inc_conexion.php');


	$data = json_decode(file_get_contents('php://input'), true);

/*
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
	exit();
*/

	$db = new MySQL();
		
		$id_proy = xps_desencriptar($data[0]["HdIdProyecto"]);
		$id_rol  = xps_desencriptar($data[1]["HdIdRol"]);

		$eliminar					= array();
//		$eliminar['ver'] 			= 1;
		$eliminar['HdIdProyecto'] 	= 0;
		$eliminar['dat_1'] 	 		= xps_encriptar('0,'.$id_proy);
		$eliminar['accion']	 		= 6;//9
		
		
		if($db->comentario('proyectos_usuarios','', $eliminar , 2)){
			$insertar = array();
//			$insertar['ver'] 			= 1;
			$insertar['HdIdProyecto'] 	= 0;
			$insertar['HdIdRol'] 		= 0;			
			$insertar['HiUser']			= 0;
			for($i=2;$i<count($data);$i++)
				if($data[$i]['id'])
						$insertar['datos'.$i]	= xps_encriptar("1,".$id_proy.",".$id_rol.",".$data[$i]['id']);//
			$insertar['accion']		= 9;	

			if($consulta = $db->comentario('proyectos_usuarios','', $insertar , 2)){
				echo '<pre>detalle_pla.php';
				echo '<pre>Usuarios ingresados Correctamente';
			}
			else{
				echo '<pre>detalle_pla.php';
				echo "<pre>NO SE GUARDO";				
			}
		}
		else{
				echo '<pre>detalle_pla.php';
				echo "<pre>NO SE BORRO";
		}

exit();
  
?>