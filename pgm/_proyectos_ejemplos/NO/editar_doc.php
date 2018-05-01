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
	$xps_titulo_barra = "PROYECTOS";//<--------MODIFICABLE TITULO
	$xps_ver_submenu  = 1;//<-------------------------MODIFICABLE VER SUBMENU=1, NO VER=0
	require_once('../barra_usuario.php');	
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Proyectos'];//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>


	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-8 col-md-offset-2"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
	          <?php
	            $xps_titulo   ="Editar documento";//<-- MODIFICABLE         
	            $xps_volver   ="grid_documentos.php";//<-- MODIFICABLE ruta de la página, vacio = sin botón
	            $xps_fullscreen =1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
	            $xps_color    =0;//<-- MODIFICABLE
	            $xps_actualizar =1;//<-- MODIFICABLE
	            $xps_minimizar  =1;//<-- MODIFICABLE
	            $xps_cerrar   =0;//<-- MODIFICABLE

	            widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
	          ?>
				<div class="widget-content">
<!-- INICIO CONTENIDO -->
<?php

	$idoc = xps_desencriptar($_GET['d']);

	$sql = "SELECT 
			  `d`.`id_documento`,
			  `d`.`nombre_doc`,
			  `d`.`id_tipo_doc`,
			  `d`.`descripcion_doc`,
			  IF(ISNULL(`d`.`ruta_plantilla_doc`), 0, 1) AS `doc_plantilla`,
			  `d`.`ruta_plantilla_doc`,
			  `d`.`estadoDoc`,
			  CONCAT(`d`.`id_tipo_doc`,'|',`dtd`.`extension_tipo_doc`) AS eltipo
			FROM
			  `documentos` `d`
			  LEFT OUTER JOIN `documentos_tipo_doc` `dtd` ON (`d`.`id_tipo_doc` = `dtd`.`id_tipo_doc`)
			WHERE
			  `d`.`id_documento` = $idoc";

	//echo $sql;
				  
		  $db = new MySQL();
		  $consulta = $db->consulta($sql);

			if($db->num_rows($consulta)>0){
				$rs = $db->fetch_array($consulta);
				
				$id 	 = $rs['id_documento'];
				$nombre  = $rs['nombre_doc'];
				$tipo	 = $rs['id_tipo_doc'];
				$eltipo  = $rs['eltipo'];
				$desc 	 = $rs['descripcion_doc'];
				$checked = $rs['doc_plantilla'] == 1 ? "checked" : "";
				$style   = $rs['doc_plantilla'] == 1 ? "" : "style='display:none'";
				$disabled= $rs['doc_plantilla'] == 1 ? "" : "disabled";
				$ruta	 = $rs['ruta_plantilla_doc'];
				$estado  = $rs['estadoDoc'];

		$var_dato = "-1";
	
	//$accion = 1;//Debug 1 y 5
	//$accion = 2;//insertar
	$accion = 3;//Actualizar
	//$accion = 4;//Borrar
	//$accion = 8;//BUSCAR REGISTROS
	//$accion = 10;//EJECUTA SECUENCIA SQL
	$ruta_guarda_form = "guardar/guardar_model.php";//<--- MODIFICABLE


	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">
				<input type="hidden" name="accion" value="<?=xps_encriptar($accion)?>">
				<input type="hidden" name="HdIdDocumentos" value="<?=xps_encriptar($id)?>">


          <fieldset>
            <legend>Form validation example.</legend>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group has-iconed">
                  <label>Nombre</label>
                  <div class="iconed-input">
                  	<input name="TxtNombreDoc" type="text" id="TxtNombreDoc" value="<?=$nombre?>" size="40" class="form-control" minlength="2" required placeholder="Nombre">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group has-iconed">
                  <label>Tipo</label>
                  <div class="iconed-input">
                  	<select name="HdIdTipoDoc_aux" id="HdIdTipoDoc_aux" class="form-control">
						<?=crea_cbo('documentos_tipo_doc','CONCAT(id_tipo_doc,"|",extension_tipo_doc)','CONCAT(nombre_tipo_doc," (",extension_tipo_doc,")")','id_tipo_doc',$eltipo,'',0)?>
			  		</select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group has-iconed">
              <label>Description</label>
              <div class="iconed-input">
              	<textarea name="TxtDescripDoc" type="text" id="TxtDescripDoc" size="40" class="form-control"><?=$desc?></textarea>
              </div>
            </div>            
            <div class="row">
            	<div class="col-md-6">
		            <div class="form-group has-iconed">
		              <label>Requiere una plantilla</label>
		              <div class="iconed-input text-center">
						<label class="checkbox-inline">
							<input type="checkbox" id="requerimiento" name="requerimiento" <?=$checked?> onclick="muestra_upload(this)" value="1" />Si
						</label>              	
		              </div>
		            </div>            		
            	</div>
            	<div class="col-md-6">
		            <div class="form-group has-iconed">
		              <div id="upload" <?=$style?>>		            	
		              	<label>Archivo</label>
						<input type="file" id="archivo_1" name="file[]" <?=$disabled?>/>
		              </div>
		            </div>            		
            	</div>
            </div>

<br>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-iconed btn-primary" id="submit"><i class="fa fa-save"></i>Guardar</button>
            </div>
          </fieldset>
        </form>
<?php

			}

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
<script src='<?=xps_ruteador()?>js/form_validation_339.js'></script>
<script src='<?=xps_ruteador()?>js/pnotify.custom.min.js'></script>

<!--//############  AQUI NUEVOS JS O CSS   ###################### -->
<audio id="audiotag1" src="<?=xps_ruteador()?>js/shimmer.wav" preload="auto"></audio>
<script>

	PNotify.desktop.permission();
	(new PNotify({
	    title: 'Alternate Text Notice - Browser',
	    text: 'This text appears on the <strong>browser</strong>.',
	    desktop: {
	        desktop: true,
	        title: 'Alternate Text Notice - Desktop',
	        text: 'This text appears on the *desktop*.'
	    }
	})).get().click(function(e) {
	    if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
	    alert('Hey! You clicked the desktop notification!');
	});

function muestra_upload(obj){
    
		upload  = document.getElementById("upload");
		campo	= document.getElementById("archivo_1");
		
		if(obj.checked){
			upload.style.display = ""; //mostrar fila
			campo.disabled = false;
		}
		else{
			upload.style.display = "none"; //ocultar fila
			campo.disabled = true;
		}
}


	 $(function() {//guardar registros
   	    $('#submit').click(function(){
	        var dataString = $('#validateForm').serialize();
		    $.ajax({
		      type: "POST",
		//      dataType: 'json',
		      url: '<?=$ruta_guarda_form?>',//"guardar/guardar_model.php",
		      data: dataString,
		    }).done(function(respuesta){

		    	$("#validateForm").fadeOut("slow").html("<div id='message'></div>")
		        .fadeIn("slow", function() {
		        	$('#message').html("<h2>"+respuesta+"</h2>");
					$('#message').append("<a href='<?=$xps_volver?>'>Volver</a>");
	                 setTimeout(function () {
	                     $("#audiotag1")[0].play();
	                 }, 0);
	                 setTimeout(function () {
	                 	<?php
	                 		if($accion>1){
	                 			echo "$(location).attr('href','$xps_volver');";
	                     	}
	                     ?>
	                 }, 4000);
		        });
		    });

			return false;
	    });
	});
</script>

<!-- @include _footer
/*
				$.pnotify({
				    title: 'Custom Styling',
				    text: 'I have an additional class that\'s used to give me special styling. I always wanted to be pretty. I also use the nonblock module.',
				    addclass: 'custom',
				    icon: 'fa fa-file-image-o',
				    nonblock: {
				        nonblock: true
				    }
				});
*/