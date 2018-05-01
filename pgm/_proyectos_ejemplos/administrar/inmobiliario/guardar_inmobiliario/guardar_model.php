<?php

	require_once('../../../../inc_conexion.php');

	   
	$db = new MySQL();

		if($consulta = $db->comentario('proyectos_inmobiliarios','', $_POST , 2)){
			echo '<pre>detalle_pla.php';
			echo '<pre>Incorporada Correctamente';
		}
		else{
			echo '<pre>detalle_pla.php';
			echo "<pre>NO SE GUARDO";				
		}


	exit();

  
?>