<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('inc_base.php');	
?>

<!--//############   AQUI NUEVOS JS O CSS   ######################//
		ojo que todo los js de jquery estan al final de la página
					BORRAR SI NO SE OCUPA

    //############ FIN AQUI NUEVOS JS O CSS ######################//-->

</head>

<body class="glossed">

<?php
	$xps_titulo_barra = "DASHBOARD";
	$xps_ver_submenu  = 0;
	require_once('barra_usuario.php');	
	
//############## MENU ######################//
	echo $_SESSION['valida']['menu'];
	echo isset($_GET['a']) ? (isset($_SESSION[$_GET['a']]) ? $_SESSION[$_GET['a']] : "") : "";
//############## MENU ######################//	
?>


	<div class="main-content">

 <!-- *********** INICIO ************ -->
    <div class="col-md-12">

        <div class="widget-content">
<!-- INICIO CONTENIDO -->


<div class="mantencion-page-wrapper">
      <div class="picture-w">
        <i class="fa fa-exclamation-circle"></i>
      </div>
      <h1>Sistema en desarrollo</h1>
      <h3>Estamos trabajando para usted!</h3>
</div>

<!--  FIN CONTENIDO   -->
        </div>                

    </div>  

  <!-- *********** FIN ************ -->

	</div>
	<div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>

<script src="<?=xps_ruteador()?>js/jquery-1.11.1.min.js"></script>
<script src="<?=xps_ruteador()?>js/jquery-ui.min.js"></script>
<script src='<?=xps_ruteador()?>js/notificacion_ac6.js'></script>

<!-- @include _footer