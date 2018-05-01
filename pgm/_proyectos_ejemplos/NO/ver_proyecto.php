<!DOCTYPE html>
<html>

<head>

<?php
		require_once('../inc_base.php');	
?>


  <title>Sistema MNK</title>

</head>

<body>

<?php
	$xps_titulo_barra = "PROYECTOS";
	$xps_ver_submenu  = 1;
	require_once('../barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Proyectos'];
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-8 col-md-offset-2">
			<div class="widget widget-blue" style="height:500px">
				<div class="widget-title">
					<div class="widget-controls">
					  <a href="#" class="widget-control widget-control-refresh" data-toggle="tooltip" data-placement="top" title="" data-original-title="Actualizar"><i class="icon-refresh"></i></a>
					  <a href="#" class="widget-control widget-control-minimize" data-toggle="tooltip" data-placement="top" title="" data-original-title="Minimizar"><i class="icon-minus-sign"></i></a>
					</div>
					<h3><i class="icon-pencil"></i>Formulario</h3>
				</div>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->

					<form method="post" action="#" role="form">
					
						<div class="row">
							<div class="col-md-6">					
								<div class="form-group">
									<label>RUT</label>
									<input class="form-control" disabled="disabled" placeholder="rut" value="11.111.111-1">
								</div>
							</div>
							<div class="col-md-6">							
								<div class="form-group">
									<label>Tipo de empresa</label>
									<select class="form-control" id="cboTipoSocietariado" name="cboTipoSocietariado" onchange="tipo_societario(this);" >
										<?=crea_cbo('empresas_tipo_societario','id_tipo_societario','nombre_tipo_societario','id_tipo_societario',1,'',0)?>
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
										<input name="txtNombre" id="txtNombre" class="form-control" placeholder="Nombre" type="text" value="">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Apellido Paterno</label>
										<input name="txtApellidoPaterno" id="txtApellidoPaterno" class="form-control" placeholder="Paterno" type="text" value="">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Apellido Materno</label>
										<input name="txtApellidoMaterno" id="txtApellidoMaterno" class="form-control" placeholder="Materno" type="text" value="" onchange="copiarnombrefantasia(txtNombre.value+' '+txtApellidoPaterno.value+' '+this.value,2);">
									</div>
								</div>
							</div>
						</div>
						
						<div id="Sintetico" class="row" style="background:#cecece; display:none">
							<div class="col-md-12" style="margin-top:20px">
								<h4 class="widget-header">Empresa</h4>
								<div class="form-group">
									<label>Razón Social</label>
									<input name="txtRazonSocial" id="txtRazonSocial" class="form-control" placeholder="Nombre" type="text" value="" onchange="copiarnombrefantasia(this.value,1);">
								</div>								
							</div>
						</div>						
						
						<div class="form-group" style="margin-top:10px">
							<label>Nombre de fantasía</label>
							<input name="txtNombreFantasia" id="txtNombreFantasia" class="form-control" placeholder="Nombre de fantasía" value="">
						</div>						

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Giro</label>
									<textarea name="txtGiro" id="txtGiro" class="form-control" rows="2"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								<label>Clasificación</label>
									<select id="HdIdClasificacion" name="HdIdClasificacion" class="form-control">
										<?=crea_cbo('empresas_clasificacion','id_clasificacion','nombre_class','id_clasificacion',"",'',0)?>
									</select>						
								</div>
							</div>
						</div>
						<div style="text-align:right">
							<button class="btn btn-iconed btn-primary"><i class="icon-save"></i>Guardar</button>
							<button type="button" class="btn btn-iconed btn-success" onclick="window.location.href=ruteador(1,'grid_colaboradores.php');">
								<i class="icon-reply"></i> Volver
							</button>
						</div>
					</form>

<!-- FIN CONTENIDO -->
				</div>                
			</div>
		</div>	
	<?php
		for($i=1;$i<29;$i++){
			echo "<br>";
		}
	?>
	<!-- *********** FIN ************ -->
	</div>
	<!-- *********** PIÉ DE PÁGINA ************ -->
	<div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>

<script src="<?=xps_ruteador()?>js/jquery.min.js"></script>
<script src="<?=xps_ruteador()?>js/jquery-ui.min.js"></script>
<script src='<?=xps_ruteador()?>js/configuracion.js'></script>
<script src='<?=xps_ruteador()?>js/parametros.js'></script>

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

	
</script> 


<!-- @include _footer