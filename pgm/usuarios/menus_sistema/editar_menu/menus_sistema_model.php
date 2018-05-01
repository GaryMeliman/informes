<?php

	require_once('../../../inc_conexion_base.php');

echo $_POST['accion'];


session_start();
if($_SESSION['valida']['categoria'] > 0){
	cuadro_mensaje($tipo='RESTRINGIDO',"SIN PERMISOS SUFICIENTE",'No tiene permisos suficientes para ingresar',1,0);
}

if(isset($_POST['TxtLink']) == false){//LINK VACIO
	$_POST['TxtLink'] = NULL;
}


		$db = new MySQL();
		if($db->comentario('_menu','', $_POST , 2)){
			echo "<pre>administrar_menu.php";
			if($_POST['accion']==3) echo "<pre>MENU MODIFICADO CORRECTAMENTE";
			if($_POST['accion']==2) echo "<pre>NUEVO MENU AGREGADO CORRECTAMENTE";
		}
		else{
			echo "<pre>administrar_menu.php";
			echo "<pre>EL MENU NO SE MODIFICO";
		};

	exit();
?>
