﻿<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../../../inc_base.php');	
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
  require_once(xps_ruteador().$xps_ruta_base.'/barra_usuario.php'); 
	
//############## MENU ######################//	
	echo $_SESSION['valida']['menu'];
	echo $_SESSION['Proyectos'];//<---------------MODIFICABLE MENU PRINCIPAL QUE DESEAS VER
//############## MENU ######################//	
?>



	<div class="main-content">
	<!-- *********** INICIO ************ -->
		<div class="col-md-8"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
	          <?php
	            $xps_titulo   	="Nuevo Proyecto Inmobiliario <b>".xps_desencriptar($_GET['n'])."</b>";//<-- MODIFICABLE         
	            $xps_volver   	="grid_inmobiliarios.php?cl=".$_GET['cl']."&pro=".$_GET['pro']."&n=".$_GET['n'];
	            $xps_fullscreen =1;//<-- MODIFICABLE 1=VER, 0=NO VER , igual para todas las opciones
	            $xps_color    	=0;//<-- MODIFICABLE
	            $xps_actualizar =1;//<-- MODIFICABLE
	            $xps_minimizar  =1;//<-- MODIFICABLE
	            $xps_cerrar   	=0;//<-- MODIFICABLE

	            widget_controls($xps_titulo,$xps_volver,$xps_fullscreen,$xps_color,$xps_actualizar,$xps_minimizar,$xps_cerrar);
	          ?>
				<div class="widget-content">
				

<!-- INICIO CONTENIDO -->

<?php

	//$accion = 1;//Debug 1 y 5
	$accion = 2;//insertar
	//$accion = 3;//Actualizar
	//$accion = 4;//Borrar
	//$accion = 8;//BUSCAR REGISTROS
	//$accion = 10;//EJECUTA SECUENCIA SQL
	$ruta_guarda_form = "guardar_inmobiliario/guardar_model.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>	
	<div class="row">
		<div class="col-md-12">
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">
				<input type="hidden" name="accion" value="<?=xps_encriptar($accion)?>">
				<input type="hidden" name="HdIdProyecto" value="<?=$_GET['pro']?>">


          <fieldset>
              <div class="row">
              <div class="col-md-6">
                <div class="form-group has-iconed">
                  <label>Nombre del proyecto inmobiliario</label>
                  <div class="iconed-input">
					<input name="TxTNombreInmobiliario" type="text" id="TxTNombreInmobiliario" size="40" class="form-control" minlength="2" required placeholder="Nombre">
                  </div>
                </div>
              </div>
				<div class="col-md-6">
	                <div class="form-group has-iconed">
	                  <label>Descripcion</label>
	                  <div class="iconed-input">

						<textarea name="TxTDescripcionInm" id="TxTDescripcionInm"  class="form-control" rows="3"></textarea>
	                  </div>
	                </div>
				</div>
            </div>

			<div class="row">
              <div class="col-md-4">
                <div class="form-group has-iconed">
                  <label>Estado</label>
                  <div class="iconed-input">
	                  	<select name="HdIdEstadoProyecto" id="HdIdEstadoProyecto" class="form-control">
							<?=crea_cbo('estados','id_estado_proyecto','nombre_estado','id_estado_proyecto','','',0)?>
				  		</select>
                  </div>
                </div>
              </div>			  
              <div class="col-md-4">
                <div class="form-group has-iconed">
                  <label>Tipo</label>
                  <div class="iconed-input">
	                  	<select name="HdIdTipoInmobiliario" id="HdIdTipoInmobiliario" class="form-control">
							<?=crea_cbo('proyectos_inmobiliarios_tipos','id_tipo_inmobiliario','nombre_tipo_inmobiliario','id_tipo_inmobiliario','','',0)?>
				  		</select>
                  </div>
                </div>
              </div> 
				<div class="col-md-4">
	                <div class="form-group has-iconed">
	                  <label>Logo</label>
	                  <div class="iconed-input">
						<input name="TxTLogo" type="text" id="TxTLogo" size="40" class="form-control" minlength="2" required placeholder="sin_logo.jpg" disabled>
	                  </div>
	                </div>
				</div>
			</div>
			<br><br><br>


			<div class="row">
              <div class="col-md-4">
                <div class="form-group has-iconed">
                  <label>Región</label>
                  <div class="iconed-input">
	                  	<select name="HdId" id="HdId" class="form-control">
							<?=crea_cbo('rg_region','id_region','nombre_region','id_region',8,'',0)?>
				  		</select>
                  </div>
                </div>
              </div> 
              <div class="col-md-4">
                <div class="form-group has-iconed">
                  <label>Comuna</label>
                  <div class="iconed-input">
	                  	<select name="HiIdComuna" id="HiIdComuna" class="form-control">
							<?=crea_cbo('rg_comuna','id_comuna','nombre_comuna','id_comuna',176,'',0)?>
				  		</select>
                  </div>
                </div>
              </div>               

				<div class="col-md-4">
					<label></label>
				<div class="form-group text-center">
				  <button type="submit" class="btn btn-iconed btn-primary" id="submit"><i class="fa fa-save"></i>Guardar</button>
				</div>
				</div>


          </fieldset>
        </form>		
		</div>

	</div>





<!--  FIN CONTENIDO   -->
				</div>
			</div>
		</div>	
	<?php
		for($i=1;$i<29;$i++){
			echo "<br>";
		}
	?>
	</div>
	<!-- *********** PIÉ DE PÁGINA ************ -->
	<div class="page-footer">© <?=date("Y");?> Modulonet.cl</div>
</div>	

<?php
    require_once(xps_ruteador().$xps_ruta_base.'/inc_js.php');  
?>
<script src='<?=xps_ruteador()?>js/form_validation_339.js'></script>

<script type="text/javascript">

$(function () {

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

</body>

</html>