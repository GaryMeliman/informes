<!DOCTYPE html>
<html>

<head>
  <title>Sistema MNK</title><?php //<-- MODIFICABLE, título de la página ?>
<?php
		require_once('../../../../inc_base.php');	
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
	            $xps_titulo   	="Editar Unidad en Proyecto <b>".xps_desencriptar($_GET['n'])."</b>";//<-- MODIFICABLE         
	            $xps_volver   	="grid_unidades.php?cl=".$_GET['cl']."&pro=".$_GET['pro']."&n=".$_GET['n']."&pi=".$_GET['pi'];
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
	$ruta_guarda_form = "guardar_unidad/guardar_model.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax


	$idu = xps_desencriptar($_GET['u']);
	$db	= new MySQL();

	$sql = "SELECT 
            `u`.`id_unidad`,
            `u`.`tipologia_unidad`,
            `u`.`id_unidad_tipo`,
            `u`.`mts_cuadrados`
          FROM
            `unidades` `u`
          WHERE
            `u`.`id_unidad` = $idu			
			";	

// 			echo $sql;

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$i = 1;
    $subarea = "";
		$rs = $db->fetch_array($consulta);
			
?>
	<div class="row">
		<div class="col-md-12">
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">
				<input type="hidden" name="accion" value="<?=xps_encriptar($accion)?>">
				<input type="hidden" name="HdIdUnidad" value="<?=$_GET['u']?>">


          <fieldset>



              <div class="row">
              <div class="col-md-6">
                <div class="form-group has-iconed">
                  <label>Tipología Unidad</label>
                  <div class="iconed-input">
					<input name="TxtTipologia" type="text" id="TxtTipologia" size="40" class="form-control" minlength="2" required placeholder="Nombre" value="<?=$rs['tipologia_unidad']?>">
                  </div>
                </div>
              </div>
			  
              <div class="col-md-6">
              	<label></label>
	            <div class="form-group text-center">
	            </div>
              </div>              
            </div>


			<div class="row">
              <div class="col-md-4">
                <div class="form-group has-iconed">
                  <label>Tipo Unidad</label>
                  <div class="iconed-input">
	                  	<select name="HdIdUnidadTipo" id="HdIdUnidadTipo" class="form-control">
							<?=crea_cbo('unidades_tipos','id_unidad_tipo','nombre_tipo','id_unidad_tipo',$rs['id_unidad_tipo'],'',0)?>
				  		</select>
                  </div>
                </div>
              </div>			  
              <div class="col-md-4">
                <div class="form-group has-iconed">
                  <label>Mts2</label>
                  <div class="iconed-input">
	                  	<input name="INTMetros2" type="text" id="INTMetros2" size="40" class="form-control" minlength="2" required placeholder="Mts2" value="<?=$rs['mts_cuadrados']?>">
                  </div>
                </div>
              </div> 
				<div class="col-md-4">
	                <div class="form-group has-iconed">
	                  <label>Plano</label>
	                  <div class="iconed-input">
						<input name="TxTLogo" type="text" id="TxTLogo" size="40" class="form-control" minlength="2" required placeholder="sin_logo.jpg" disabled>
	                  </div>
	                </div>
				</div>
			</div>

			<div class="row">
              <div class="col-md-12">
              	<label></label>
	            <div class="form-group text-center">
	              <button type="submit" class="btn btn-iconed btn-primary" id="submit"><i class="fa fa-save"></i>Guardar</button>
	            </div>
              </div> 
			</div>


          </fieldset>
        </form>		
		</div>

	</div>

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
//						  console.log(dataString);

		    $.ajax({
		      type: "POST",
		//      dataType: 'json',
		      url: '<?=$ruta_guarda_form?>',//"guardar/guardar_model.php",
		      data: dataString
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