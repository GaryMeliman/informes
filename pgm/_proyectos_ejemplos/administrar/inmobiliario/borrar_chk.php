<!DOCTYPE html>
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
		<div class="col-md-8 col-md-offset-2"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
	          <?php
	            $xps_titulo   	="Quitar Checklist";//<-- MODIFICABLE         
	            $xps_volver   	="grid_checklist.php?et=".$_GET['et']."&pla=".$_GET['pla']."&n=".$_GET['n'];
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

	$idchk = xps_desencriptar($_GET['chk']);

	$sql = "SELECT 
              `ce`.`id_chk_et`,
              `c`.`nombre_checklist`
            FROM
              `checklist_etapas` `ce`
              LEFT OUTER JOIN `checklist` `c` ON (`ce`.`id_checklist` = `c`.`id_checklist`)
            WHERE
              `ce`.`id_chk_et` = $idchk";	


	//echo $sql;
				  
		  $db = new MySQL();
		  $consulta = $db->consulta($sql);

			if($db->num_rows($consulta)>0){
				$rs = $db->fetch_array($consulta);
				
				$id 	 	= $rs['id_chk_et'];
				$nombre  	= $rs['nombre_checklist'];


	//$accion = 1;//Debug 1 y 5
	//$accion = 2;//insertar
	//$accion = 3;//Actualizar
	$accion = 4;//Borrar
	//$accion = 8;//BUSCAR REGISTROS
	//$accion = 10;//EJECUTA SECUENCIA SQL
	$ruta_guarda_form = "guardar/guardar_model.php";//<--- MODIFICABLE


	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">
				<input type="hidden" name="accion" value="<?=xps_encriptar($accion)?>">
				<input type="hidden" name="HdIdChEt" value="<?=xps_encriptar($id)?>">


          <fieldset>

              <div class="row">
	              <div class="col-md-5">
	                <div class="form-group has-iconed">
	                  <label>Checklist asociada</label>
	                  <div class="iconed-input">
	                  	<h3><?=$nombre?></h3>
	                  </div>
	                </div>
	              </div>
	              <div class="col-md-3">
		            <div class="form-group text-right"><br><br>
		              <button type="submit" class="btn btn-iconed btn-danger" id="submit"><i class="fa fa-save"></i>Quitar</button>
		            </div>
	              </div>

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