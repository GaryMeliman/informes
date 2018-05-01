<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../../inc_base.php');	
?>



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
	            $xps_titulo   	="Editar proyecto";//<-- MODIFICABLE         
	            $xps_volver   	="grid_administrar.php?cl=".$_GET['cl']."&pro=".$_GET['pro'];//<-- MODIFICABLE ruta de la página, vacio = sin botón
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
	//$accion = 2;//insertar
	$accion = 3;//Actualizar
	//$accion = 4;//Borrar
	//$accion = 8;//BUSCAR REGISTROS
	//$accion = 10;//EJECUTA SECUENCIA SQL
	$ruta_guarda_form = "guardar/guardar_model.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax


  $db = new MySQL();

  $id_proyecto = xps_desencriptar($_GET['pro']);

  $sql = "SELECT 
			  `p`.`id_emp`,
			  `p`.`id_plantilla_doc`,
			  `p`.`nombre_proyecto`,
			  `p`.`descripcion_proyecto`,
			  `p`.`f_inicio_proyecto`,
			  `p`.`f_termino_proyecto`,
			  `p`.`estado_proyecto`
			FROM
			  `proyectos` `p`
			WHERE
			  `p`.`id_proyecto` = $id_proyecto";  


  $consulta = $db->consulta($sql);
      $r=0;
  if($db->num_rows($consulta)>0){
      $rs = $db->fetch_array($consulta);

?>  
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">
				<input type="hidden" name="accion" value="<?=xps_encriptar($accion)?>">
				<input type="hidden" name="HdIdProyecto" value="<?=$_GET['pro']?>">

          <fieldset>

            <div class="row">
              <div class="col-md-8">
                <div class="form-group has-iconed">
                  <label>Nombre del Proyecto</label>
                  <div class="iconed-input">
                  	<input name="TxtNombreProy" type="text" id="TxtNombreProy" value="<?=$rs['nombre_proyecto']?>" size="40" class="form-control" minlength="2" required placeholder="Nombre">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group has-iconed">
                  <label>Empresa</label>
                  <div class="iconed-input">
                  	<select name="HdIdEmpresa" id="HdIdEmpresa" class="form-control">
						<?=crea_cbo('empresas','id_emp','nom_fantasia_emp','id_emp',$rs['id_emp'],'principal_emp',1)?>
			  		</select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group has-iconed">
              <label>Descripción</label>
              <div class="iconed-input">
              	<textarea name="TxtDescripProy" type="text" id="TxtDescripProy" size="40" class="form-control"><?=$rs['descripcion_proyecto']?></textarea>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group has-iconed">
                  <label>Subárea</label>
                  <div class="iconed-input">
                  	<select name="HiIdPlantilla" id="HiIdPlantilla" class="form-control">
						<?=crea_cbo('plantillas_doc','id_plantilla_doc','nombre_plantilla','id_plantilla_doc',$rs['id_plantilla_doc'],'',0)?>
			  		</select>			  		
			  	</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group has-iconed">
                  <label>Estado</label>
                  <div class="iconed-input">

	                  	<select name="IntEstadoProy" id="IntEstadoProy" class="form-control">
							<?=crea_cbo_estado($rs['estado_proyecto'])?>
				  		</select>
                  </div>
                </div>
              </div>
			</div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group has-iconed">
                  <label>Fecha Inicio</label>
                  <div class="iconed-input">
	                <div class="input-group">
	                  <input name="TxtFInicioProy" value="<?=xps_fecha(1,$rs['f_inicio_proyecto'])?>" type="text" placeholder="06/12/2018" class="form-control input-datepicker">
	                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                  </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group has-iconed">
                  <label>Fecha Termino</label>
                  <div class="iconed-input">
	                <div class="input-group">
	                  <input name="TxtFTerminoProy" value="<?=xps_fecha(1,$rs['f_termino_proyecto'])?>" type="text" placeholder="06/12/2018" class="form-control input-datepicker">
	                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                  </div>
                  </div>
                </div>
              </div>
            </div>
<br>
<br>
<br>
<hr>


<br>
            <div class="form-group text-left">
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
		for($i=1;$i<9;$i++){
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

<!--//############  AQUI NUEVOS JS O CSS   ###################### -->
<script>

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