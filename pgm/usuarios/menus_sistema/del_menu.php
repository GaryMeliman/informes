<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>ELIMINAR MENU</title>
<?php 
	
	require_once('../../inc_base.php');

if($_SESSION['valida']['categoria'] > 0){
	cuadro_mensaje($tipo='RESTRINGIDO',"SIN PERMISOS SUFICIENTE",'No tiene permisos suficientes para ingresar',1,0);
}

	xps_js_valida_formulario();

	$id_menu 	 = xps_desencriptar($_GET['id']);
	$dependencia = xps_desencriptar($_GET['d']);
//	$dependencia = explode(",",$dependencia);
	$accion		 = xps_desencriptar($_GET['op']);
	$nivel		 = (1+xps_desencriptar($_GET['l']));


	$sql = "SELECT 
			  m.nivel_menu,
			  m.orden_menu,
			  m.nombre_menu,
			  m.descripcion_menu,
			  m.link_menu,
			  m.img_menu,
			  m.separa_menu,
			  m.estado_menu,
			  (SELECT COUNT(s.id_menu) AS contar FROM `_menu` s WHERE s.id_submenu = m.id_menu) AS contar
			FROM
			  `_menu` m
			WHERE
			  m.id_menu = $id_menu";

	//echo $sql."<br>";

	$db	= new MySQL();
	
	$consulta = $db->consulta($sql);
				
	if($db->num_rows($consulta)>0){
		while($rs = $db->fetch_array($consulta)){
			  $nivel_menu		= $rs["nivel_menu"];
			  $orden_menu		= $rs["orden_menu"];
			  $nombre_menu		= $rs["nombre_menu"];
			  $link_menu		= $rs["link_menu"];
			  $descripcion		= $rs['descripcion_menu'];
			  $separa_menu		= $rs['separa_menu'] == 1 ? "Si" : "No";
			  $img_menu			= $rs["img_menu"];
			  $submenus			= $rs["contar"];
			  $estado_menu		= $rs['estado_menu'] == 1 ? "Activo" : "Desactivado";
		}
	}
	

?>

</head>
<body>
<?php

	$var_dato = "-1";

//
	$var_dato = "0";
	
?>
<div id="msn_valida_xps"></div>


<fieldset id="formulario_campos">
<form method="post"  enctype="multipart/form-data" name="form" id="trab1Form" onSubmit="return valida(this,'<?=$var_dato;?>',4,'xeditar_menu',1)"  >

<input type="hidden" name="HiMenu" title="Encriptado" value="<?=$_GET['id']?>" />


<table width="750" border="0">
			<tr>
			  <td colspan="3"><table id="titulo" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        		<tr>
         			 <td align="center" valign="middle">&nbsp;</td>
          			 <td width="80%" align="center" valign="middle"><legend>ELIMINAR MENU</legend></td>
          		     <td width="10%" align="center" valign="middle">

<a href="javascript:;" onclick="window.location.href='administrar_menu.php';">
<img src="<?=$img_volver?>" /><br />
<font class="text_blanco_bton">Volver</font></a>
				  
                  
                  </td>
       			</tr>
    		  </table>
      		  </td>
              </tr>
           <tr>
              <td colspan="3" bgcolor="#FFFFFF"><table width="100%" height="105" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                <tr>
                  <td width="13%" rowspan="4"><img src="images/niveles.png" width="97" height="155"  alt=""/></td>
                  <td width="87%">
                  	<?php
                    	if($nivel_menu==1) echo $nombre_menu;
						else if($nivel_menu==0) echo "&raquo;Ra&iacute;z"; else echo "&nbsp;";
					?>
                  </td>
                </tr>
                <tr>
                  <td>
                  	<?php
                    	if($nivel_menu==2) echo "&mdash;".$nombre_menu;
						else if($nivel_menu==1) echo "<font style='color:#C00;font-weight:bold'>&mdash;&mdash;&raquo;Contiene ".$submenus." Submenus</font>"; else echo "&nbsp;";
					?>
                  </td>
                </tr>
                <tr>
                  <td>
                  	<?php
                    	if($nivel_menu==3) echo "&mdash;&mdash;".$nombre_menu;
						else if($nivel_menu==2) echo "<font style='color:#C00;font-weight:bold'>&mdash;&mdash;&mdash;&raquo;Contiene ".$submenus." Submenus</font>"; else echo "&nbsp;";
					?>
                  </td>
                </tr>
                <tr>
                  <td>
                  	<?php
                    	if($nivel_menu==4) echo "&mdash;&mdash;&mdash;".$nombre_menu;
						else if($nivel_menu==3) echo "<font style='color:#C00;font-weight:bold'>&mdash;&mdash;&mdash;&mdash;&raquo;Contiene ".$submenus." Submenus</font>"; else echo "&nbsp;";
					?>
                  </td>
                </tr>
              </table></td>
      </tr>
<?php
	if($submenus == 0){
?>
           <tr>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
      </tr>
	       <tr>
           		<td width="150">
					<label>Nombre</label></td>
                <td width="5">:</td>
				<td width="311">
					<?=$nombre_menu?>
				</td>
          </tr>
           <tr>
             <td><label>Link</label></td>
             <td>:</td>
             <td><?=$link_menu;?></td>
           </tr>
           <tr>
             <td><label>Descripci&oacute;n</label></td>
             <td>:</td>
             <td><?=$descripcion;?></td>
           </tr>
	       <tr>
	         <td><label>Orden</label></td>
	         <td>:</td>
	         <td><?=$orden_menu?></td>
      </tr>
	       <tr>
	         <td><label>Insertar separador</label></td>
	         <td>:</td>
	         <td>
             	<?=$separa_menu?>
             </td>
      </tr>
	       <tr>
	         <td><label>Estado</label></td>
	         <td>:</td>
	         <td>
             	<?=$estado_menu?>
             </td>
      </tr>
	       <tr>
	         <td>&nbsp;</td>
	         <td>&nbsp;</td>
	         <td>&nbsp;</td>
      </tr>
	       <tr>
	         <td><label>Imagen</label></td>
	         <td>:</td>
	         <td>
             <img src="<?="../../../menu/menu.files/img/".$img_menu?>" />
               
             </td>
      </tr>
	       <tr>
	         <td>&nbsp;</td>
	         <td>&nbsp;</td>
	         <td>&nbsp;</td>
      </tr>
	      <tr>
          <td colspan="3" align="right"><input type="submit" id="enviar" name="Enviar" value="Eliminar Menu" class="button">	</td>
           </tr>
	      <tr>
	        <td colspan="3" align="right">&nbsp;</td>
      </tr>
<?php
	}
	else{
?>
		<tr>
	        <td colspan="3" align="right">&nbsp;</td>
      </tr>
          <tr>
	        <td height="46" colspan="3" align="center" style="color:#900; font-weight:bold">NO SE PUEDE ELIMINAR ESTE MENU POR TENER DEPENDENCIA</td>
      </tr>
<?php
	}
?>
     </table>       
	</form>	
</fieldset>
</body>

</html>