﻿<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../inc_base.php');	
?>

<!--//############   AQUI NUEVOS JS O CSS   ######################//
		ojo que todo los js de jquery estan al final de la página
					BORRAR SI NO SE OCUPA

    //############ FIN AQUI NUEVOS JS O CSS ######################//-->

</head>

<body class="glossed">

<?php
	$xps_titulo_barra = "TÍTULO PLANTILLA";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 1;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Colaboradores'];//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-8 col-md-offset-2"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="Título Plantilla";//<-- MODIFICABLE					
	            	$xps_volver   	="../phpFileTree/";//<-- MODIFICABLE ruta de la página, vacio = sin botón $_SERVER['HTTP_REFERER']
					$xps_fullscreen	=1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
					$xps_color		=0;//<-- MODIFICABLE
					$xps_actualizar	=1;//<-- MODIFICABLE
					$xps_minimizar	=1;//<-- MODIFICABLE
					$xps_cerrar		=0;//<-- MODIFICABLE

					widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
				?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->

<button type="button" class="btn btn-action btn-lg btn-primary"><i class="fa fa-pencil"></i> Edit</button>
<button type="button" class="btn btn-iconed btn-lg btn-primary"><i class="fa fa-pencil"></i> Edit</button>
	<?php
	//BORRAME ESTO ES UN RELLENO__________________________________________________ LOS BOTONES DE ARRIBA SON RELLENO TAMBIEN SE PUEDEN BORRAR
		for($i=1;$i<20;$i++){
			echo "<br>";
		}
	//FIN BORRAME ESTO ES UN RELLENO______________________________________________		
	?>


<!--  FIN CONTENIDO   -->
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

<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>

<!--//############  AQUI NUEVOS JS O CSS   ######################//
		BORRAR SI NO SE OCUPA

    //############ FIN NUEVOS JS O CSS ######################//-->

<!-- @include _footer