<!DOCTYPE html>
<html>

<head>

<?php
		require_once('../../inc_base.php');	
?>


  <title>PGM</title>

</head>

<body class="glossed">

<?php
	$xps_titulo_barra = "PARAMETROS";
	$xps_ver_submenu  = 1;
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Parametros'];
//############## MENU ######################//	
?>

	<div class="main-content">
	<!-- *********** INICIO ************ -->
<?php	
	$db	= new MySQL();
     

	
	$id_cargo = xps_desencriptar($_GET['c']);

	

			$sql = "SELECT 
					  `c`.`nombre_cargo`,
					  `c`.`nivel_jerarquico`,
					  `c`.`estado_cargo`
					FROM
					  `cargos` `c`
					WHERE
					  `c`.`id_cargo` = $id_cargo";


					$db = new MySQL();

					$consulta = $db->consulta($sql);
				
					if($db->num_rows($consulta)>0){
               			 $rs = $db->fetch_array($consulta);
				
						$nombre 	= $rs['nombre_cargo'];
						$jerarquia	= $rs['nivel_jerarquico'];
						$estado 	= $rs['estado_cargo'];
					}
					else{
						echo "ERROR...";
						exit();
					}


	
	$var_dato = "-1";
//		
	$var_dato = "0|1|2";
	?>
		<div class="col-md-8 col-md-offset-2">
			<div class="widget widget-blue">

				<?php
					$xps_titulo		="Editar Cargo";//<-- MODIFICABLE					
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
						<div id="Natural" class="row" style="background:#ececec">
							<div class="col-md-12" style="margin-top:20px">
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Nombre</label>
										<input name="txtNombre" id="txtNombre" class="form-control" placeholder="Nombre" type="text" value="<?=$nombre_emp?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Cargo</label>
										<input name="txtApellidoPaterno" id="txtApellidoPaterno" class="form-control" placeholder="Paterno" type="text" value="<?=$paterno_emp?>">
									</div>

									<div class="form-group">
										<label>estado</label>
										<input name="txtNombre" id="txtNombre" class="form-control" placeholder="Nombre" type="text" value="<?=$nombre_emp?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
														
									</div>
								</div>
							</div>
							<div style="text-align:right">
								<button id="submit" class="btn btn-iconed btn-primary"><i class="icon-save"></i>Guardar</button>
								<button type="button" class="btn btn-iconed btn-success" onclick="window.location.href=ruteador(1,'detalle_empresa.php?p=<?=$_GET['p']?>&c=<?=$_GET['c']?>');">
									<i class="icon-reply"></i> Volver
								</button>
							</div>
						</div>
					</form>

<!-- FIN CONTENIDO -->
				</div>                
			</div>
		</div>
	<div>
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