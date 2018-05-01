<?php

	require_once('../../../inc_conexion.php');

	$_POST['TxtFInicioProy'] = xps_fecha(6,$_POST['TxtFInicioProy']);
	$_POST['TxtFTerminoProy'] = xps_fecha(6,$_POST['TxtFTerminoProy']);
   
	$db = new MySQL();

		if($consulta = $db->comentario('proyectos','', $_POST , 2)){
			echo '<pre>detalle_pla.php';
			echo '<pre>Proyecto ingresado Correctamente';
		}
		else{
			echo '<pre>detalle_pla.php';
			echo "<pre>NO SE GUARDO";				
		}


	exit();

  
?>