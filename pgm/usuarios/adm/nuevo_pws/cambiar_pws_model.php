<?php

	require_once('../../../inc_conexion_base.php');

	session_start();
	$_POST['HiUser'] = $_SESSION['valida']['id_usuario'];

		$db = new MySQL();
		if($db->comentario('_usuarios','', $_POST , 2)){
			echo "<pre>informe_password.php";
			echo "<pre>PASSWORD MODIFICADO CORRECTAMENTE";
		}
		else{
			echo "<pre>grid_password.php";
			echo "<pre>NO SE PUDO REALIZAR EL CAMBIO DE PASSWORD";				
		};

	exit();
?>
