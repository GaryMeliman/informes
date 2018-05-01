<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>ADMINISTRACI&Oacute;N MENUS</title>

<?php 
	require_once('../../inc_base.php');

if($_SESSION['valida']['categoria'] > 0){
	cuadro_mensaje($tipo='RESTRINGIDO',"SIN PERMISOS SUFICIENTE",'No tiene permisos suficientes para ingresar',1,0);
}

?>


<style type="text/css">
<!--
.Estilo5 {font-family: tahoma; font-size: 12px; }
.Estilo6 {
	font-family: tahoma;
	font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>

<script type="text/javascript" src="treeview.js"></script>

</head>

<body>

<?php

	$db		= new MySQL();
	
	$sql = "SELECT 
			  p.rut_pers,
			  u.login_usuario,
			  u.password_usuario
			FROM
			  personas p
			  RIGHT OUTER JOIN `_usuarios` u ON (p.id_persona = u.id_persona)
			WHERE
			  u.id_usuario = ".$_SESSION['valida']['id_usuario']." AND 
			  u.estado_usuario = 1 AND 
			  u.eliminado_usuario = 0";
			  
			  
	//	echo $sql . "<hr>";
	
	$consulta = $db->consulta($sql);

		if($db->num_rows($consulta)>0){
			$rs = $db->fetch_array($consulta);
				$rut 	= $rs['rut_pers'];
				$login	= $rs['login_usuario'];
				$pass	= $rs['password_usuario'];			
		}

?>

<table id="titulo" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="middle" width="10%">&nbsp;</td>
          <td align="center" valign="middle" width="80%">
          	<legend>ADMINISTRAR MENU</legend>
          </td>
          <td align="center" valign="middle" width="10%">
          	
<a href="javascript:;" onclick="window.location.href='valida.php?rut=<?=$rut?>&login=<?=xps_encriptar($login)?>&pws=<?=xps_encriptar($pass)?>';">
<img src="../../_filtros/datagrid/images/Thumbs_Up.png" width="33" height="33"  alt="Validar Nuevo Menu"/>
</a>
          </td>
        </tr>
      </table>

<?php

	$procedimiento = "CALL `validacion_sistema`('$rut','$login','$pass',0,0)";

//	echo $procedimiento;


	  $consulta = $db->consulta($procedimiento);

		if($db->num_rows($consulta)>0){

			echo "<div>\n";
			echo "<script>\n";
//			echo "treeAdd(1,'<b>.MENU PRINCIPAL</b>','');\n";

			echo "treeAdd(0,'<b>.MENU PRINCIPAL</b>','','','".xps_encriptar(0)."','0','0',0,1,'".xps_encriptar('0,0,0,0')."','0');\n";
			
			while($rs = $db->fetch_array($consulta)){
			  $nivel		= $rs["nivel_menu"];
			  $texto		= str_replace("<br>"," ",$rs["nombre_menu"]) ." <b><font size=1>(".$rs["id_menu"].")</font></b>";
			  $link			= $rs["link_menu"];
			  $img			= $rs["img_menu"];
			  $accion		= 0;
			  $id_menu		= $rs["id_menu"];
			  $parametro	= 1;//1 = edita menus, 10 = administra menu del perfil
  			  $dependencia 	= xps_encriptar($rs["o1"].",".$rs["o2"].",".$rs["o3"].",".$rs["o4"]);

				echo "treeAdd(".$nivel.",'".$texto."','".$link."','".$img."','".xps_encriptar($id_menu)."','0','0',".$accion.",".$parametro.",'".$dependencia."','0');\n";

			}

			echo "\n makeTree();\n";
			echo "</script>\n";
			echo "</div>";

		}	
		else{
			echo "EMPRESA NO ENCONTRADA CON MENU";
		}


?>

</body>
</html>
