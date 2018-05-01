<?php

	require_once('../../inc_conexion.php');

//	print_r($_REQUEST);
//	$respuesta = "paso bien";
//	echo json_encode($respuesta);
//	exit();
	   
	$db = new MySQL();

		if($consulta = $db->comentario('empresas','', $_POST , 2)){
			echo '<pre>El proceso se actualizo exitosamente!!!';
		}
		else{
			echo "<pre>NO SE GUARDO";				
		}


	exit();

  
?>