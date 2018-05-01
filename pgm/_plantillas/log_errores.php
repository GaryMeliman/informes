<!DOCTYPE html>
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
	$xps_titulo_barra = "LOG ERRORES";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 0;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Ayuda'];//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-12"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="LOG ERRORES";//<-- MODIFICABLE					
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
<?=ruta_log()."PHP_errors.log"?>
<table class="table table-bordered table-hover">
<?php

	$archivo = ruta_log()."PHP_errors.log";
	$file = @fopen($archivo, "r") or exit("No se puede abrir el archivo!");

	$i=1;
	while(!feof($file)){

		$color = (($i%2) ? "danger" : "success");
		echo "<tr>";
			echo "<td>".$i++."</td>";
			echo "<td class='".$color."'>";
				echo fgets($file);
			echo "</td>";
		echo "</tr>";

	}
		fclose($file);
?>
</table>


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


<?php

function ruta_log(){
	try{
		@session_start();
			$datos_rnl	= explode("|", $_SESSION['valida']['parametros']);
			$n_ruta		= $datos_rnl[1];

			$name = "php.log";//Carpeta

			$existe		 = 0;//hasta este momento no existe el archivo
			$xps_dominio = "archivos";

			$encontrado = strpos(dirname(__FILE__), "\\");
			if($encontrado === false)
				$img_rute = explode("/", dirname(__FILE__)) ;//linux
			else
				$img_rute = explode("\\", dirname(__FILE__)) ;//windors
			
			$rute = "";
			foreach ($img_rute as $key => $value) {
				if($value != $n_ruta) $rute .= $value."/";
				else break;
			}

		$ruta = $rute."".$n_ruta."_".$xps_dominio."/".$name."/"; //ruta correcta

	      if ( !file_exists($ruta) ) {
	        throw new Exception("Ruta : ".$ruta.", no encontrada");
	      }	

	      return $ruta;
		
	} catch (Exception $e) {
			echo 'Excepcion capturada: ',  $e->getMessage(), "\n";
			return "0";
	}	
}

?>

<!-- @include _footer
