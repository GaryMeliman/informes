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

Hola



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
<script type="text/javascript">

//NOTIFICACION EN PANTALLA	
	$.pnotify({
	    title: 'Notificación',
	    text: 'Esta es una notificación que aparecera por un tiempo limitado',
	    icon: 'fa fa-file-image-o',
//	    addclass: 'custom',	    
		addclass: "stack-custom",
		stack: {"dir1":"down", "dir2":"right", "push":"top"},	    
	    nonblock: {
	        nonblock: true
	    },
	    buttons: {
	        show_on_nonblock: true
	    },
	    desktop: {
	        desktop: true
	    }
	});	

	setTimeout(function() {
	    $.pnotify({
	        type: 'info',
	        text: 'Now I\'m an info box!'
	    });
	}, 9000);	

var notice = $.pnotify({
    text: "Formulario",
    icon: true,
    width: 'auto',
    hide: false,
    insert_brs: true
});
$(".ui-pnotify-text").append("formula 1");


//_______________________________
dyn_notice();
function dyn_notice() {
    var percent = 0;
    var notice = new PNotify({
        text: "Please Wait",
        type: 'info',
        icon: 'fa fa-spinner fa-spin',
        hide: false,
        buttons: {
            closer: false,
            sticker: false
        },
        shadow: false,
        width: "170px"
    });

    setTimeout(function() {
        notice.update({
            title: false
        });
        var interval = setInterval(function() {
            percent += 2;
            var options = {
                text: percent + "% complete."
            };
            if (percent == 80) options.title = "Almost There";
            if (percent >= 100) {
                window.clearInterval(interval);
                options.title = "Done!";
                options.type = "success";
                options.hide = true;
                options.buttons = {
                    closer: true,
                    sticker: true
                };
                options.icon = 'fa fa-check';
                options.shadow = true;
                options.width = PNotify.prototype.options.width;
            }
            notice.update(options);
        }, 120);
    }, 2000);
}
//________________________________
(new PNotify({
    title: 'Confirmation Needed',
    text: 'Are you sure?',
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
    alert('Ok, cool.');
}).on('pnotify.cancel', function() {
    alert('Oh ok. Chicken, I see.');
});
//___________________________________________


//NOTIFICACION DEL NAVEGADOR
	PNotify.desktop.permission();
	var noticia = (new PNotify({
	        title: 'Título de la notificacón',
	        text: 'Texto de la notificación, no permite <b>HTML</b>',		
		    desktop: {
		        desktop: true,
		        icon: 'includes/le_happy_face_by_luchocas-32.png'
		    }
	})).get().click(function(e) {
	    if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
	    alert('Has hecho un click sobre la notificación');
	});

	setTimeout(function() {
		var noticia = (new PNotify({
	        title: 'Otra notificacion desde el navegador',
	        text: 'Texto de la notificación, no permite <b>HTML</b>',		
		    desktop: {
		        desktop: true
		    }
		}));
	}, 4000);






</script>


</body>
</html>
<!-- @include _footer