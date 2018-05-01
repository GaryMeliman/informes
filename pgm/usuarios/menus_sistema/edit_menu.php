<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>EDITAR MENU</title>
<?php 
	
	require_once('../../inc_base.php');

if($_SESSION['valida']['categoria'] > 0){
	cuadro_mensaje($tipo='RESTRINGIDO',"SIN PERMISOS SUFICIENTE",'No tiene permisos suficientes para ingresar',1,0);
}

	xps_js_valida_formulario();

	$id_menu 	 = xps_desencriptar($_GET['id']);
	$dependencia = xps_desencriptar($_GET['d']);
	$dependencia = explode(",",$dependencia);
	$accion		 = xps_desencriptar($_GET['op']);
	$nivel		 = xps_desencriptar($_GET['l']);

	$sql = "SELECT 
			  m.id_menu,
			  m.id_submenu,
			  m.nivel_menu,
			  m.orden_menu,
			  m.nombre_menu,
			  m.link_menu,
			  m.img_menu,
			  m.descripcion_menu,
			  m.separa_menu,
			  m.estado_menu
			FROM
			  `_menu` m
			WHERE
			  m.id_menu = $id_menu";

	$db	= new MySQL();
	
	$consulta = $db->consulta($sql);
				
	if($db->num_rows($consulta)>0){
		while($rs = $db->fetch_array($consulta)){
			  $id_menu			= $rs["id_menu"];
			  $id_submenu		= $rs["id_submenu"];
			  $nivel_menu		= $rs["nivel_menu"];
			  $orden_menu		= $rs["orden_menu"];
			  $nombre_menu		= $rs["nombre_menu"];
			  $link_menu		= $rs["link_menu"];
			  $img_menu			= $rs["img_menu"];
			  $descripcion_menu	= $rs["descripcion_menu"];
			  $separa_menu		= $rs["separa_menu"];
			  $estado_menu		= $rs["estado_menu"];
			  $icon_tamano		= " width='16px' height='16px'";
		}
	}

	if($nivel == 1){
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
	$var_dato = "0";
?>
<div id="msn_valida_xps"></div>


<fieldset id="formulario_campos">
<form method="post"  enctype="multipart/form-data" name="form" id="trab1Form" onSubmit="return valida(this,'<?=$var_dato;?>',3,'editar_menu',1)"  >

<input type="hidden" name="HiMenu" value="<?=$_GET['id']?>" />

<table width="750" border="0">
			<tr>
			  <td colspan="3"><table id="titulo" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        		<tr>
         			 <td align="center" valign="middle">&nbsp;</td>
          			 <td width="80%" align="center" valign="middle"><legend>EDITAR MENU</legend></td>
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
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
	          <td>&nbsp;</td>
      </tr>
	       <tr>
           		<td width="150">
					<label>Nombre</label></td>
                <td width="5">:</td>
				<td width="311">
					<input name="TxtNombre" type="text" id="TxtNombre" title="texto" size="50" maxlength="200" alt="Nombre" value="<?=$nombre_menu?>">
				</td>
          </tr>
<?php
	if($nivel > 1){
?>
           <tr>
             <td><label>Link</label></td>
             <td>:</td>
             <td><input name="TxtLink" type="text" id="TxtLink" title="texto" size="60" maxlength="200" alt="Link" value="<?=$link_menu?>" />
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
             <textarea name="TxtDescripcion" id="TxtDescripcion" cols="30" rows="3"><?=$descripcion_menu?></textarea></td>
           </tr>
	       <tr>
	         <td><label>Orden</label></td>
	         <td>:</td>
	         <td><input name="TxtOrden" type="text" id="TxtOrden" title="texto" size="5" maxlength="11" alt="Nombre Perfil" value="<?=$orden_menu?>" /></td>
      </tr>
<?php
	if($nivel > 1){
?>
	       <tr>
	         <td><label>Insertar separador</label></td>
	         <td>:</td>
	         <td>
             	<select name="CboSeparador" id="CboSeparador" alt="Separador">
                <?php
                	if($separa_menu==1){
						$selectedS = "selected";
						$selectedN = "";
					}
					else{
						$selectedS = "";
						$selectedN = "selected";						
					}
				?>
					<option value="1" <?=$selectedS?>>S&iacute;</option>
                    <option value="0" <?=$selectedN?>>No</option>
	           </select> 
             	<font style="font-family:Cambria; font-size:12px">(se inserta sobre el menu)</font>
             </td>
      </tr>
	       <tr>
	         <td><label>Estado</label></td>
	         <td>:</td>
	         <td>
             	<select name="HiEstado" id="HiEstado" alt="Estado">
                <?php
                	if($estado_menu==1){
						$selectedA = "selected";
						$selectedD = "";
					}
					else{
						$selectedA = "";
						$selectedD = "selected";						
					}
				?>
                	<option value="1" <?=$selectedA?>>Activo</option>
                    <option value="0" <?=$selectedD?>>Desactivado</option>
	           	</select>
             </td>
      </tr>
	       <tr>
	         <td>&nbsp;</td>
	         <td>&nbsp;</td>
	         <td>&nbsp;</td>
      </tr>
<?php
	}
?>
           <tr>
             <td><label>Imagen</label></td>
             <td>:</td>
             <td style="vertical-align:central; background-color:#eee">

<?php
	$ruta_img_xps = "../../../menu/menu.files/img/";
?>
	<img src="<?=$ruta_img_xps.$img_menu?>" id="imagen" <?=$icon_tamano?> />	           
             
<?php

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

echo "</style>";

echo "<select name='TxtImagen' size='1' class='select_imagen' style='width:200px;' onchange=cambia_img('".$ruta_img_xps."',this.value)>\n";

echo "<option value='".$img_menu."' class='img_1' 'selected'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$img_menu."</option>";

/*
$directorio = opendir($ruta_img_xps); //ruta actual
$i=1;
	while ($archivo = readdir($directorio)){ //obtenemos un archivo y luego otro sucesivamente
		if (is_dir($archivo)){//verificamos si es o no un directorio
			$valor=1;//echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
		}
		else{
			$selected_img = "";
			if($img_menu == $archivo) $selected_img = "selected";
			echo "<option value='".$archivo."' class='img_".$i++."' ".$selected_img.">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$archivo."</option>\n";
		}
	}
*/
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
          <td colspan="3" align="right"><input type="submit" id="enviar" name="Enviar" value="Editar Menu" class="button">	</td>
           </tr>
     </table>       
	</form>	
</fieldset>
</body>

</html>