<?php

	require_once('../../../inc_conexion_base.php');

session_start();
if($_SESSION['valida']['categoria'] > 0){
	cuadro_mensaje($tipo='RESTRINGIDO',"SIN PERMISOS SUFICIENTE",'No tiene permisos suficientes para ingresar',1,0);
}


//	echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>ok<BR>";
	
	$id_menu 	 = xps_desencriptar($_GET['id']);
	$dependencia = xps_desencriptar($_GET['d']);
//	$dependencia = explode(",",$dependencia);
	$accion		 = $_GET['op'];
	$nivel		 = $_GET['l'];
	

	if($accion == 2){//INSERTAR
		echo "<pre>INSERTAR nuevo menu\n\nPresione si para continuar...";
		echo "<pre>new_menu.php?id=".$_GET['id']."&d=".$_GET['d']."&op=".xps_encriptar($_GET['op'])."&l=".xps_encriptar($_GET['l']);
	}

	if($accion == 3){//EDITAR
		echo "<pre>EDITAR menu\n\nPresione si para continuar...";
		echo "<pre>edit_menu.php?id=".$_GET['id']."&d=".$_GET['d']."&op=".xps_encriptar($_GET['op'])."&l=".xps_encriptar($_GET['l']);
	}

	if($accion == 4){//ELIMINAR
		echo "<pre>Esta seguro que desea ELIMINAR este menu\n\nPresione si para continuar...";
		echo "<pre>del_menu.php?id=".$_GET['id']."&d=".$_GET['d']."&op=".xps_encriptar($_GET['op'])."&l=".xps_encriptar($_GET['l']);
	}
	
				

	exit();
?>
