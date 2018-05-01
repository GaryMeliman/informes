<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../inc_base.php');

		include("php_file_tree.php");
?>

		<script src="php_file_tree_jquery.js" type="text/javascript"></script>


</head>

<body class="glossed">

<?php
	$xps_titulo_barra = "DIRECTORIO PLANTILLAS";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 0;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo "";//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-8 col-md-offset-2"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="PLANTILLAS Y HERRAMIENTAS DISPONIBLES";//<-- MODIFICABLE					
					$xps_volver		="";//<-- MODIFICABLE ruta de la página, vacio = sin botón
					$xps_fullscreen	=1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
					$xps_color		=0;//<-- MODIFICABLE
					$xps_actualizar	=1;//<-- MODIFICABLE
					$xps_minimizar	=0;//<-- MODIFICABLE
					$xps_cerrar		=0;//<-- MODIFICABLE

					widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
				?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->

	<?php

		echo php_file_tree("../_plantillas/", '../_plantillas/[link]');
		
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

<script src="<?=xps_ruteador()?>js/jquery.min.js"></script>
<script src="<?=xps_ruteador()?>js/jquery-ui.min.js"></script>
<script src='<?=xps_ruteador()?>js/notificacion_ac6.js'></script>

<!--//############  AQUI NUEVOS JS O CSS   ######################//
		BORRAR SI NO SE OCUPA

    //############ FIN NUEVOS JS O CSS ######################//-->

<!-- @include _footer