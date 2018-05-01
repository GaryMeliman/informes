<!DOCTYPE html>
<html>

<head>

<?php
		require_once('../inc_base.php');	
?>


  <title>Sistema MNK</title>

</head>

<body class="glossed" onload="tipo_societario(document.getElementById('cboTipoSocietariado'))">

<?php
	$xps_titulo_barra = "COLABORADORES";
	$xps_ver_submenu  = 1;
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Colaboradores'];
//############## MENU ######################//	
?>

	<div class="main-content">
	<!-- *********** INICIO ************ -->
<?php	
	$db	= new MySQL();

	$principal   = xps_desencriptar($_GET['p']);
	$contratista = xps_desencriptar($_GET['c']);

	$sql = "SELECT 
			  `e`.`id_emp`,
			  `e`.`id_tipo_societario`,
			   e.`id_clasificacion`,
			  `e`.`razon_social_emp`,
			  `e`.`nom_fantasia_emp`,
			  `e`.`nombre_emp`,
			  `e`.`paterno_emp`,
			  `e`.`materno_emp`,
			  `e`.`rut_emp`,
			  `e`.`giro_emp`
			FROM
			  `empresas` `e`
			WHERE
			  `e`.`id_emp` = " . $contratista;

	$consulta = $db->consulta($sql);
	$accion = 3;//Actualizar

	if($db->num_rows($consulta)>0){
		$rs = $db->fetch_array($consulta);
	
		$idEmp			= $rs['id_emp'];
		$id_tipo 		= $rs['id_tipo_societario'];
		$id_class		= $rs['id_clasificacion'];
		$razon_social 	= $rs['razon_social_emp'];
		$nom_fantasia	= $rs['nom_fantasia_emp'];
		$nombre_emp 	= $rs['nombre_emp'];
		$paterno_emp 	= $rs['paterno_emp'];
		$materno_emp 	= $rs['materno_emp'];
		$rut_emp 		= $rs['rut_emp'];
		$giro_emp 		= $rs['giro_emp'];
?>		
		<div class="col-md-8 col-md-offset-2">
			<div class="widget widget-blue">
				<?php
					$xps_titulo		="Editar Empresa colaboradora";//<-- MODIFICABLE					
					$xps_volver		="detalle_empresa.php?p=". $_GET['p'] . "&c=" . $_GET['c'];//<-- MODIFICABLE ruta de la página, vacio = sin botón
					$xps_fullscreen	=0;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
					$xps_color		=0;//<-- MODIFICABLE
					$xps_actualizar	=0;//<-- MODIFICABLE
					$xps_minimizar	=0;//<-- MODIFICABLE
					$xps_cerrar		=0;//<-- MODIFICABLE

					widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
				?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->

					<form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">
						<input type="hidden" name="HdIdEmpresa" value="<?=xps_encriptar($idEmp)?>">
						<input type="hidden" name="accion" value="<?=xps_encriptar($accion)?>">
					
						<div class="row">
							<div class="col-md-6">					
								<div class="form-group">
									<label>RUT</label>
									<input class="form-control" disabled="disabled" placeholder="rut" value="<?=$rut_emp?>">
								</div>
							</div>
							<div class="col-md-6">							
								<div class="form-group">
									<label>Tipo de empresa</label>
									<select class="form-control" id="cboTipoSocietariado" name="cboTipoSocietariado" onchange="tipo_societario(this);" >
										<?=crea_cbo('empresas_tipo_societario','id_tipo_societario','nombre_tipo_societario','id_tipo_societario',$id_tipo,'',0)?>
									</select>		
								</div>
							</div>
						</div>
						
						<div id="Natural" class="row" style="background:#ececec">
							<div class="col-md-12" style="margin-top:20px">
								<h4 class="widget-header">Persona Natural</h4>
								<div class="col-md-4">
									<div class="form-group">
										<label>Nombre</label>
										<input name="txtNombre" id="txtNombre" class="form-control" placeholder="Nombre" type="text" value="<?=$nombre_emp?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Apellido Paterno</label>
										<input name="txtApellidoPaterno" id="txtApellidoPaterno" class="form-control" placeholder="Paterno" type="text" value="<?=$paterno_emp?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Apellido Materno</label>
										<input name="txtApellidoMaterno" id="txtApellidoMaterno" class="form-control" placeholder="Materno" type="text" value="<?=$materno_emp?>" onchange="copiarnombrefantasia(txtNombre.value+' '+txtApellidoPaterno.value+' '+this.value,2);">
									</div>
								</div>
							</div>
						</div>
						
						<div id="Sintetico" class="row" style="background:#cecece; display:none">
							<div class="col-md-12" style="margin-top:20px">
								<h4 class="widget-header">Empresa</h4>
								<div class="form-group">
									<label>Razón Social</label>
									<input name="txtRazonSocial" id="txtRazonSocial" class="form-control" placeholder="Nombre" type="text" value="<?=$razon_social?>" onchange="copiarnombrefantasia(this.value,1);">
								</div>								
							</div>
						</div>						
						
						<div class="form-group" style="margin-top:10px">
							<label>Nombre de fantasía</label>
							<input name="txtNombreFantasia" id="txtNombreFantasia" class="form-control" placeholder="Nombre de fantasía" value="<?=$nom_fantasia?>">
						</div>						

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Giro</label>
									<textarea name="txtGiro" id="txtGiro" class="form-control" rows="2"><?=$giro_emp?></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label>Clasificación</label>
									<select id="HdIdClasificacion" name="HdIdClasificacion" class="form-control">
										<?=crea_cbo('empresas_clasificacion','id_clasificacion','nombre_class','id_clasificacion',$id_class,'',0)?>
									</select>						
								</div>
							</div>
						</div>
						<div style="text-align:right">
							<button id="submit" class="btn btn-iconed btn-primary"><i class="icon-save"></i>Guardar</button>
							<button type="button" class="btn btn-iconed btn-success" onclick="window.location.href=ruteador(1,'detalle_empresa.php?p=<?=$_GET['p']?>&c=<?=$_GET['c']?>');">
								<i class="icon-reply"></i> Volver
							</button>
						</div>
					</form>

<!-- FIN CONTENIDO -->
				</div>                
			</div>
		</div>
	<?php 		
				}
				else{
	?>
				<div class="alert alert-danger alert-dismissable">
					<i class="icon-remove-sign"></i> <strong>Error !   </strong>No se encontro el registro.
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				</div>	
	<?php
				}
				
		for($i=1;$i<29;$i++){
			echo "<br>";
		}
	?>
	<!-- *********** FIN ************ -->
	</div>
	<!-- *********** PIÉ DE PÁGINA ************ -->
	<div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>
<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>

<script language="javascript1.5">
	function copiarnombrefantasia(nombre,accion){
			document.getElementById("txtNombreFantasia").value = nombre;
		
		if(accion == 1){
			document.getElementById("txtNombre").value = "";
			document.getElementById("txtApellidoPaterno").value = "";
			document.getElementById("txtApellidoMaterno").value = "";
		}
		if(accion == 2){
			document.getElementById("txtRazonSocial").value = nombre;
		}
	}
	
	function tipo_societario(obj){
		
		natural   = document.getElementById("Natural"); 
		sintetico =	document.getElementById("Sintetico");
		
		if(obj.options[obj.selectedIndex].text == "Persona Natural"){
			natural.style.display = ""; //mostrar fila
			sintetico.style.display = "none"; //ocultar fila
		}
		else{
			natural.style.display = "none"; //ocultar fila
			sintetico.style.display = ""; //mostrar fila
			document.getElementById("txtNombre").value = "";
			document.getElementById("txtApellidoPaterno").value = "";
			document.getElementById("txtApellidoMaterno").value = "";			
		}

	}	
	$('#submit').click(function(){
    var dataString = $('#validateForm').serialize();
    $.ajax({
      type: "POST",
//      dataType: 'json',
      url: "guardar_empresa/guardar_model.php",
      data: dataString,
    }).done(function(respuesta){

    	$("#formulario").fadeOut("slow");
    	$('#validateForm').html("<div id='message'></div>");
        $('#message').html("<h2>"+respuesta+"</h2>")
        .fadeIn(1500, function() {
			$('#message').append("<a href='<?=$xps_volver?>'>Volver</a>");
             setTimeout(function () {
                 $("#audiotag1")[0].play();
             }, 0);
             setTimeout(function () {
                 $(location).attr('href','<?=$xps_volver?>');
             }, 5000);
        });

		//
    });
	return false;
});
	
</script> 


<!-- @include _footer