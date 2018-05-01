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
		<div class="col-md-8 col-md-offset-2"><?php //<-- MODIFICABLE, para ver distribucion entrar en http://saturn.pinsupreme.com/grid.html?>
			<div class="widget widget-blue" style="height:500px">
				<?php
					$xps_titulo		="Asignar fichas <b>".xps_desencriptar($_GET['n'])."</b>";//<-- MODIFICABLE
		            $xps_volver   	="grid_fichas.php?cl=".$_GET['cl']."&pro=".$_GET['pro']."&pi=".$_GET['pi']."&n=".$_GET['n'];
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

	//$accion = 1;//Debug 1 y 5, muestra que puedes hacer con la informacion que envias por post al modelo
	//$accion = 2;//insertar
	//$accion = 3;//Actualizar
	//$accion = 4;//Borrar
	//$accion = 8;//BUSCAR REGISTROS
	//$accion = 10;//EJECUTA SECUENCIA SQL
	$ruta_guarda_form = "guardar/guardar_model.php";//<--- MODIFICABLE

	//el metodo en el formulario da lo mismo ya que se guarda por ajax
?>
        <form class="bottom-margin" id="validateForm" method="get" onSubmit="return false">

          <fieldset>
            <legend>FICHAS DISPONIBLES</legend>


        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center">N°</th>
                <th class="text-center">Sel</th>
                <th>Items</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
<?
	$db	= new MySQL();
	$idpi = xps_desencriptar($_GET['pi']);
	
	$sql = "SELECT 
			  `f`.`id_ficha`,
			  `f`.`nombre_ficha`,
			  (SELECT 
				  `fi`.`id_ficha_inm`
				FROM
				  `fichas_inmobiliarios` `fi`
				WHERE
				  `fi`.`id_ficha` = `f`.`id_ficha` AND 
				  `fi`.`id_inmobiliario` = $idpi) AS `id_ficha_inm`
			FROM
			  `fichas` `f`
			ORDER BY
			  `id_ficha_inm` DESC,
			  `f`.`estado_ficha` DESC,
			  `f`.`nombre_ficha`";	

//			  echo $sql;				  

	$consulta = $db->consulta($sql);

	if($db->num_rows($consulta)>0){
		$ii = 1;
		$asignado = "";
		while($rs = $db->fetch_array($consulta)){

//success+check
//danger+times
				$success = '';
				$crear_s = "danger";//0
				$crear_c = "times";//0

			if($rs['id_ficha_inm']!=""){
				$success = 'class="success"';
				$crear_s = "success";//1
				$crear_c = "check";//1
			}

			$id_ficha_inm = is_null($rs['id_ficha_inm']) ? 0 : $rs['id_ficha_inm'];
			$accion = $id_ficha_inm ? 0 : 1;

?>


              <tr id="<?=$rs['id_ficha']?>" <?=$success?>>
                <td class="text-center"><?=$ii++?></td>
                <td class="text-center">
                	<span style="cursor: pointer;" class="label label-<?=$crear_s?>" onclick="seleccionar('<?=xps_encriptar($accion)?>','<?=xps_encriptar($id_ficha_inm)?>','<?=xps_encriptar($rs['id_ficha'])?>')">
                		<i class="fa fa-<?=$crear_c?>"></i>
                	</span>
                </td>                
                 <td><?=$rs['nombre_ficha']?></td>
               <td data-toggle="tooltip" data-placement="right" title="" data-original-title="A:<?=$accion?>,PI:<?=$id_ficha_inm?>,P:<?=$idpi?>,C:<?=$rs['id_ficha']?>"></td>                
              </tr>
<?php
		}
	}
?>
			</tbody>
			<tfoot>
              <tr>
                <th id="respuesta" class="text-left" colspan="4">...</th>
              </tr>
			</tfoot>			
		  </table>

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

	seleccionar = null;

	 $(function() {

	 	//guardar registros____________________________________________________________
   	        function checklist_select(accion,HdIdFichaIn,HdIdFicha){

       //Guardar
		var dataString = [];
			dataString = dataString.concat({'accion':accion});
			dataString = dataString.concat({'HdIdInmobiliario':'<?=$_GET['pi']?>'});
			dataString = dataString.concat({'HdIdFichaIn':HdIdFichaIn});
	       	dataString = dataString.concat({'HdIdFicha':HdIdFicha});

	       	console.log(dataString);

//	    var dataString = $('#validateForm').serialize();
      var dataString = JSON.stringify(dataString);
//          return false;

		    $.ajax({
		      type: "POST",
		//      dataType: 'json',
		      url: "<?=$ruta_guarda_form?>",//"guardar/guardar_model.php",
		      data: dataString,
		    }).done(function(respuesta){

		    	$("#formulario").fadeOut("slow");
		    	$('#respuesta').html("<div id='message'></div>");
		    	acciones  = respuesta.split("<pre>");
		    	if(acciones.length>0){
		    		respuesta = acciones[2];
		    		if(acciones[0].length>0)
		    			respuesta = acciones[0];
		    	}
		        $('#message').html("<h2>"+respuesta+"</h2>")
		        .fadeIn(1500, function() {
					//$('#message').append("<a href='<?=$xps_volver?>'>Volver</a>");
	                 setTimeout(function () {
	                     $("#audiotag1")[0].play();
	                 }, 0);
	                 setTimeout(function () {
	                 	location.reload();
	                 	<?php
	                 		if($accion>1){
//	                 			echo "$(location).attr('href','$xps_volver');";
	                     	}
	                     ?>
	                 }, 500);
		        });

				//
		    });
			return false;
	    };

    	seleccionar = checklist_select;	 	

	});
</script>

<!-- @include _footer