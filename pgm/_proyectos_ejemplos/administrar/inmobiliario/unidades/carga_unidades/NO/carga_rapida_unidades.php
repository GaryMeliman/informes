<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../../../../../inc_base.php');	
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
		<div class="col-md-8 col-md-offset-2"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="Carga Rápida Unidades";//<-- MODIFICABLE					
		            $xps_volver   	="grid_unidades.php?cl=".$_GET['cl']."&pro=".$_GET['pro']."&n=".$_GET['n']."&pi=".$_GET['pi'];
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
	$ruta_guarda_form = "leer_excel.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>
        <form class="bottom-margin" id="export_excel" method="get" onSubmit="return false">
				<input type="hidden" name="accion" value="<?=xps_encriptar($accion)?>">
          <fieldset>
            <legend>Carga rápida de unidades.</legend>

            <div class="row">
              <div class="col-md-8">
                <div class="form-group has-iconed">
                  <label>Subir archivo xls o xlsx</label>
                  <div class="iconed-input">
                  	<input type="file" name="excel_file" id="excel_file" class="btn btn-success"   /> 
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group has-iconed">
                  <label><br></label>
		            <div class="form-group text-center">
		              <button type="submit" class="btn btn-primary" id="submit"><i class="fa fa-save"></i> Subir Archivo</button>
		            </div>
                </div>
              </div>
            </div>

          </fieldset>
        </form>
		<div class="row">
			<div class="col-md-12">
				<div id="resultado">
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
           $('#export_excel').submit();  
      	});

   	    $('#export_excel').on('submit', function(event){

   	    	console.log("_____________-");

   	    	event.preventDefault();

//	        var dataString = $('#validateForm').serialize();
		    $.ajax({
		      	url: "<?=$ruta_guarda_form?>",//"guardar/guardar_model.php",		    	
                method:"POST",  
                data:new FormData(this),  
                contentType:false,  
                processData:false,  
                success:function(data){  
                     $('#resultado').html(data);  
                     $('#excel_file').val('');  
                }
		    });
			return false;
	    });
	});
</script>

<!-- @include _footer