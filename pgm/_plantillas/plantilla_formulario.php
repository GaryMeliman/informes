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
					$xps_titulo		="Título Formulario";//<-- MODIFICABLE					
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
<?php
	//************ acciones que puede realizar el controlador segun la accion que se envie **************

	$accion = 1;//Debug 1 y 5, muestra que puedes hacer con la informacion que envias por post al modelo
	//$accion = 2;//insertar
	//$accion = 3;//Actualizar
	//$accion = 4;//Borrar
	//$accion = 8;//BUSCAR REGISTROS
	//$accion = 10;//EJECUTA SECUENCIA SQL
	$ruta_guarda_form = "guardar/guardar_model.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">
				<input type="hidden" name="accion" value="<?=xps_encriptar($accion)?>">
          <fieldset>
            <legend>Form validation example.</legend>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group has-iconed">
                  <label>First Name</label>
                  <div class="iconed-input"><input type="text" name="name" class="form-control" minlength="2" required placeholder="First Name"></div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group has-iconed">
                  <label>Last Name</label>
                  <div class="iconed-input"><input type="text" name="surname" class="form-control" required placeholder="Last Name"></div>
                </div>
              </div>
            </div>
            <div class="form-group has-iconed">
              <label>Email Address</label>
              <div class="iconed-input"><input type="email" name="email" class="form-control" required class="form-control" placeholder="Enter email"></div>
            </div>
            <div class="form-group has-iconed">
              <label>Password</label>
              <div class="iconed-input"><input type="password" name="password" class="form-control" required class="form-control" placeholder="Password"></div>
            </div>
            <div class="form-group has-iconed">
              <label>Description</label>
              <div class="iconed-input"><textarea name="" class="form-control" rows="3"></textarea></div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary"  id="submit"><i class="fa fa-ok"></i> Submit Form</button>
            </div>
          </fieldset>
        </form>


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
<script src='<?=xps_ruteador()?>js/form_validation_339.js'></script>

<!--//############  AQUI NUEVOS JS O CSS   ###################### -->
<script>
	 $(function() {//guardar registros
   	    $('#submit').click(function(){
	        var dataString = $('#validateForm').serialize();
		    $.ajax({
		      type: "POST",
		//      dataType: 'json',
		      url: "<?=$ruta_guarda_form?>",//"guardar/guardar_model.php",
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
	                 	<?php
	                 		if($accion>1){
	                 			echo "$(location).attr('href','$xps_volver');";
	                     	}
	                     ?>
	                 }, 5000);
		        });

				//
		    });
			return false;
	    });
	});
</script>

<!-- @include _footer