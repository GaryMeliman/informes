<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>CREAR NUEVO MENU</title>
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
			  m.link_menu,
			  m.img_menu,
			  (SELECT COUNT(s.id_menu) AS contar FROM `_menu` s WHERE s.id_submenu = m.id_menu) AS contar
			FROM
			  `_menu` m
			WHERE
			  m.id_menu = $id_menu";

	$db	= new MySQL();
	
	$consulta = $db->consulta($sql);
				
	if($db->num_rows($consulta)>0){
		$rs = $db->fetch_array($consulta);
			  $nivel_menu		= $rs["nivel_menu"];
			  $orden_menu		= $rs["orden_menu"];
			  $nombre_menu		= $rs["nombre_menu"];
			  $link_menu		= $rs["link_menu"];
			  $img_menu			= $rs["img_menu"];
			  $orden_propuesto	= $rs["contar"]+1;
			  $text 			= "";
			  $icon_tamano		= " width='16px' height='16px'";
	}
	else{
		
		$sql = "SELECT COUNT(s.id_menu) AS contar FROM `_menu` s WHERE s.id_submenu = 0";
		$consulta = $db->consulta($sql);
					
		if($db->num_rows($consulta)>0){
			$rs = $db->fetch_array($consulta);
			$orden_propuesto = $rs['contar'];		
		}
		$nivel_menu		 = 0;
		$orden_menu		 = 0;
		$nombre_menu	 = "";
		$link_menu		 = "";
		$img_menu		 = "";
		$text 			 = "RA&Iacute;Z";
		$icon_tamano	 = " width='35px' height='35px'";
	}
?>

<script>
	function cambia_img(ruta,img){
		document.getElementById('imagen').src = ruta+img;
	}
</script>

</head>
<body>
<?php

	$var_dato = "-1";
//		
$var_dato = "0|1|2|5";
	
?>
<div id="msn_valida_xps"></div>


<fieldset id="formulario_campos">
<form method="post"  enctype="multipart/form-data" name="form" id="trab1Form" onSubmit="return valida(this,'<?=$var_dato;?>',2,'editar_menu',1)"  >

<input type="hidden" name="HiSubMenu" title="Encriptado" value="<?=$_GET['id']?>" />
<input type="hidden" name="HiNivel" title="Encriptado" value="<?=xps_encriptar($nivel)?>" />


<table width="750" border="0">
			<tr>
			  <td colspan="3"><table id="titulo" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        		<tr>
         			 <td align="center" valign="middle">&nbsp;</td>
          			 <td width="80%" align="center" valign="middle"><legend>NUEVO MENU <?=$text?></legend></td>
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
						else if($nivel_menu==0) echo "&raquo;Ra&iacute;z <font style='color:#C00;font-weight:bold'>&mdash;&mdash;&raquo;Nuevo Menu</font>"; else echo "&nbsp;";
					?>
                  </td>
                </tr>
                <tr>
                  <td>
                  	<?php
                    	if($nivel_menu==2) echo "&mdash;".$nombre_menu;
						else if($nivel_menu==1) echo "<font style='color:#C00;font-weight:bold'>&mdash;&mdash;&raquo;Nuevo Menu</font>"; else echo "&nbsp;";
					?>
                  </td>
                </tr>
                <tr>
                  <td>
                  	<?php
                    	if($nivel_menu==3) echo "&mdash;&mdash;".$nombre_menu;
						else if($nivel_menu==2) echo "<font style='color:#C00;font-weight:bold'>&mdash;&mdash;&mdash;&raquo;Nuevo Menu</font>"; else echo "&nbsp;";
					?>
                  </td>
                </tr>
                <tr>
                  <td>
                  	<?php
                    	if($nivel_menu==4) echo "&mdash;&mdash;&mdash;".$nombre_menu;
						else if($nivel_menu==3) echo "<font style='color:#C00;font-weight:bold'>&mdash;&mdash;&mdash;&mdash;&raquo;Nuevo Menu</font>"; else echo "&nbsp;";
					?>
                  </td>
                </tr>
              </table></td>
      </tr>
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
					<input name="TxtNombre" type="text" id="TxtNombre" title="Texto" size="50" maxlength="200" alt="Nombre">
				</td>
          </tr>
<?php
	if($nivel_menu>0){
?>
           <tr>
             <td><label>Link</label></td>
             <td>:</td>
             <td><input name="TxtLink" type="text" id="TxtLink" title="Texto" size="60" maxlength="200" alt="Link" />
             <br />
             <font size="-2" color="#ADA9A9">ruta/ruta/pagina.php</font></td>
           </tr>
<?php
	}
?>
           <tr>
             <td><label>Descripci&oacute;n</label></td>
             <td>:</td>
             <td>
             <textarea name="TxtDescripcion" id="TxtDescripcion" cols="30" rows="3"></textarea></td>
           </tr>
	       <tr>
	         <td><label>Orden</label></td>
	         <td>:</td>
	         <td><input name="TxtOrden" type="text" id="TxtOrden" title="numero" size="5" maxlength="11" alt="Nombre Perfil" value="<?=$orden_propuesto?>" /></td>
      </tr>
<?php
	if($nivel_menu>0){
?>
	       <tr>
	         <td><label>Insertar separador</label></td>
	         <td>:</td>
	         <td>
             	<select name="CboSeparador" id="CboSeparador" alt="Separador">
					<option value="1">S&iacute;</option>
                    <option value="0" selected>No</option>
	           </select>
             </td>
      </tr>
	       <tr>
	         <td><label>Estado</label></td>
	         <td>:</td>
	         <td>
             	<select name="HiEstado" id="HiEstado" alt="Estado">
                	<option value="1">Activo</option>
                    <option value="0">Desactivado</option>
	           	</select>
             </td>
      </tr>
<?php
	}
?>
	       <tr>
	         <td>&nbsp;</td>
	         <td>&nbsp;</td>
	         <td>&nbsp;</td>
      </tr>
	       <tr>
	         <td align="left" valign="middle"><label>Imagen</label></td>
	         <td align="center" valign="middle">:</td>
	         <td align="left" valign="middle">
	
    
<?php
	$ruta_img_xps = "../../../menu/menu.files/img/";
?>
	<img src="<?=$ruta_img_xps?>icon.png" id="imagen" <?=$icon_tamano?> />	           

<?php

/**/

echo "<style>";
echo ".select_imagen{font-size:10px;}\n";
$directorio = opendir($ruta_img_xps); //ruta actual
$i=1;
	while ($archivo = readdir($directorio)){ //obtenemos un archivo y luego otro sucesivamente
		if (is_dir($archivo)){//verificamos si es o no un directorio
			$valor=1;//echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
		}
		else{
			echo ".img_".$i++." {background:url('".$ruta_img_xps."/".$archivo."') no-repeat;height:16px;width:16px;}\n";
		}
	}

echo "</style>\n";

echo "<select name='TxtImagen' size='1' class='select_imagen' style='width:200px' onchange=cambia_img('".$ruta_img_xps."',this.value)>\n";
$directorio = opendir($ruta_img_xps); //ruta actual
$i=1;
	while ($archivo = readdir($directorio)){ //obtenemos un archivo y luego otro sucesivamente
		if (is_dir($archivo)){//verificamos si es o no un directorio
			$valor=1;//echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
		}
		else{
			$selected_img = "";
			if("icon.png" == $archivo) $selected_img = "selected";
			echo "<option value='".$archivo."' class='img_".$i++."' ".$selected_img.">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$archivo."</option>\n";
		}
	}
echo "</select>\n";


?>               
             </td>
      </tr>
	       <tr>
	         <td>&nbsp;</td>
	         <td>&nbsp;</td>
	         <td>&nbsp;</td>
      </tr>
	      <tr>
          <td colspan="3" align="right"><input type="submit" id="enviar" name="Enviar" value="Nuevo Menu" class="button">	</td>
           </tr>
     </table>       
	</form>	
</fieldset>
</body>

</html>