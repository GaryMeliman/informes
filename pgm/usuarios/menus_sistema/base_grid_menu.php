<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>ADMINISTRACI&Oacute;N GENERAL MENUS</title>

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php 
	require_once('../../inc_base.php');
?>

</head>
<body>

<br /><br />
<table width="100"><tr><td>
<?php


$ruta_envio		= "administrar_menu.php";//ruta que direccionara el formulario
//$parametro  	= $_SESSION['valida']['id_cont'];

if($_SESSION['valida']['categoria'] > 0){
	cuadro_mensaje($tipo='RESTRINGIDO',"SIN PERMISOS SUFICIENTE",'No tiene permisos suficientes para ingresar',1,0);
}
else{
	redirecionar_xps($ruta_envio,"");
}
exit();

$metodo_envio	= "GET";
$ver_campos		= '0,0,0';
$titulo			= "ADMINISTRAR MENUS";
$restriccion	= 0;
$parametro		= NULL;//requiere un valor, el cual se encrita dentro de la funcion y se envia a la otra página en la variable r


		busca_contratista2($ruta_envio,$metodo_envio,$ver_campos,$titulo,$restriccion,$parametro);


?>



</td></tr></table>
