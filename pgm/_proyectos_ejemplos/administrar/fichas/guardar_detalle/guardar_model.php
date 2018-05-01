<?php

	require_once('../../../../inc_conexion.php');

 //  var_dump($_REQUEST);

	$db = new MySQL();

		if($consulta = $db->comentario('fichas_items_proyecto','', $_POST , 2)){
			echo '<pre>detalle_pla.php';
			echo '<pre>Incorporada Correctamente';
		}
		else{
			echo '<pre>detalle_pla.php';
			echo "<pre>NO SE GUARDO";				
		}


	exit();

  
?>