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
	$xps_titulo_barra = "SALIR DEL SISTEMA";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 0;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
	require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo "";//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>
	<div class="main-content">

    <div class="col-md-12">

        <div class="widget-content">
<!-- INICIO CONTENIDO -->

<br><br><br>
<div class="mantencion-page-wrapper">
      <div class="picture-w">
        <i class="fa fa-sign-out"></i>
      </div>
      <h1>Salir del Sistema</h1>
      <h3>Esta seguro que desea salir?</h3>
</div>

<!--  FIN CONTENIDO   -->
        </div>                

    </div>  

	</div>
	<!-- *********** PIÉ DE PÁGINA ************ -->
	<div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>

<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>

<script type="text/javascript">

	(new PNotify({
	    title: 'Es necesaria su confirmación<hr>',
	    text: 'Esta seguro que desea salir del sistema?',
	    icon: 'glyphicon glyphicon-question-sign',
	    hide: false,
	    confirm: {
	        confirm: true
	    },
	    buttons: {
	        closer: false,
	        sticker: false
	    },
	    history: {
	        history: false
	    },
	    addclass: 'stack-modal',
	    stack: {
	        'dir1': 'down',
	        'dir2': 'right',
	        'modal': true
	    }
	})).get().on('pnotify.confirm', function() {
	    $(location).attr('href','logout.php');
	}).on('pnotify.cancel', function(event) {
	        event.preventDefault();
    		history.back(1);
	});

</script>

</body>
</html>
<!-- @include _footer

	


